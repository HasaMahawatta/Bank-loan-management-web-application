<?php
/**
* Cpdf
*
* http://www.ros.co.nz/pdf
*
* A PHP class to provide the basic functionality to create a pdf document without
* any requirement for additional modules.
*
* Note that they companion class CezPdf can be used to extend this class and dramatically
* simplify the creation of documents.
*
* IMPORTANT NOTE
* there is no warranty, implied or otherwise with this software.
* 
* LICENCE
* This code has been placed in the Public Domain for all to enjoy.
*
* @author		Wayne Munro <pdf@ros.co.nz>
* @version 	009
* @package	Cpdf
*/
class Cpdf {

/**
* the current number of pdf objects in the document
*/
var $numObj=0;
/**
* this array contains all of the pdf objects, ready for final assembly
*/
var $objects = array();
/**
* the objectId (number within the objects array) of the document catalog
*/
var $catalogId;
/**
* array carrying information about the fonts that the system currently knows about
* used to ensure that a font is not loaded twice, among other things
*/
var $fonts=array(); 
/**
* a record of the current font
*/
var $currentFont='';
/**
* the current base font
*/
var $currentBaseFont='';
/**
* the number of the current font within the font array
*/
var $currentFontNum=0;
/**
* 
*/
var $currentNode;
/**
* object number of the current page
*/
var $currentPage;
/**
* object number of the currently active contents block
*/
var $currentContents;
/**
* number of fonts within the system
*/
var $numFonts=0;
/**
* current colour for fill operations, defaults to inactive value, all three components should be between 0 and 1 inclusive when active
*/
var $currentColour=array('r'=>-1,'g'=>-1,'b'=>-1);
/**
* current colour for stroke operations (lines etc.)
*/
var $currentStrokeColour=array('r'=>-1,'g'=>-1,'b'=>-1);
/**
* current style that lines are drawn in
*/
var $currentLineStyle='';
/**
* an array which is used to save the state of the document, mainly the colours and styles
* it is used to temporarily change to another state, the change back to what it was before
*/
var $stateStack = array();
/**
* number of elements within the state stack
*/
var $nStateStack = 0;
/**
* number of page objects within the document
*/
var $numPages=0;
/**
* object Id storage stack
*/
var $stack=array();
/**
* number of elements within the object Id storage stack
*/
var $nStack=0;
/**
* an array which contains information about the objects which are not firmly attached to pages
* these have been added with the addObject function
*/
var $looseObjects=array();
/**
* array contains infomation about how the loose objects are to be added to the document
*/
var $addLooseObjects=array();
/**
* the objectId of the information object for the document
* this contains authorship, title etc.
*/
var $infoObject=0;
/**
* number of images being tracked within the document
*/
var $numImages=0;
/**
* an array containing options about the document
* it defaults to turning on the compression of the objects
*/
var $options=array('compression'=>1);
/**
* the objectId of the first page of the document
*/
var $firstPageId;
/**
* used to track the last used value of the inter-word spacing, this is so that it is known
* when the spacing is changed.
*/
var $wordSpaceAdjust=0;
/**
* the object Id of the procset object
*/
var $procsetObjectId;
/**
* store the information about the relationship between font families
* this used so that the code knows which font is the bold version of another font, etc.
* the value of this array is initialised in the constuctor function.
*/
var $fontFamilies = array();
/**
* track if the current font is bolded or italicised
*/
var $currentTextState = ''; 
/**
* messages are stored here during processing, these can be selected afterwards to give some useful debug information
*/
var $messages='';
/**
* the ancryption array for the document encryption is stored here
*/
var $arc4='';
/**
* the object Id of the encryption information
*/
var $arc4_objnum=0;
/**
* the file identifier, used to uniquely identify a pdf document
*/
var $fileIdentifier='';
/**
* a flag to say if a document is to be encrypted or not
*/
var $encrypted=0;
/**
* the ancryption key for the encryption of all the document content (structure is not encrypted)
*/
var $encryptionKey='';
/**
* array which forms a stack to keep track of nested callback functions
*/
var $callback = array();
/**
* the number of callback functions in the callback array
*/
var $nCallback = 0;
/**
* store label->id pairs for named destinations, these will be used to replace internal links
* done this way so that destinations can be defined after the location that links to them
*/
var $destinations = array();
/**
* store the stack for the transaction commands, each item in here is a record of the values of all the 
* variables within the class, so that the user can rollback at will (from each 'start' command)
* note that this includes the objects array, so these can be large.
*/
var $checkpoint = '';
/**
* class constructor
* this will start a new document
* @var array array of 4 numbers, defining the bottom left and upper right corner of the page. first two are normally zero.
*/
function Cpdf ($pageSize=array(0,0,612,792)){
  $this->newDocument($pageSize);
  
  // also initialize the font families that are known about already
  $this->setFontFamily('init');
//  $this->fileIdentifier = md5('xxxxxxxx'.time());

}

/**
* Document object methods (internal use only)
*
* There is about one object method for each type of object in the pdf document
* Each function has the same call list ($id,$action,$options).
* $id = the object ID of the object, or what it is to be if it is being created
* $action = a string specifying the action to be performed, though ALL must support:
*           'new' - create the object with the id $id
*           'out' - produce the output for the pdf object
* $options = optional, a string or array containing the various parameters for the object
*
* These, in conjunction with the output function are the ONLY way for output to be produced 
* within the pdf 'file'.
*/

/**
*destination object, used to specify the location for the user to jump to, presently on opening
*/
function o_destination($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch($action){
    case 'new':
      $this->objects[$id]=array('t'=>'destination','info'=>array());
      $tmp = '';
      switch ($options['type']){
        case 'XYZ':
        case 'FitR':
          $tmp =  ' '.$options['p3'].$tmp;
        case 'FitH':
        case 'FitV':
        case 'FitBH':
        case 'FitBV':
          $tmp =  ' '.$options['p1'].' '.$options['p2'].$tmp;
        case 'Fit':
        case 'FitB':
          $tmp =  $options['type'].$tmp;
          $this->objects[$id]['info']['string']=$tmp;
          $this->objects[$id]['info']['page']=$options['page'];
      }
      break;
    case 'out':
      $tmp = $o['info'];
      $res="\n".$id." 0 obj\n".'['.$tmp['page'].' 0 R /'.$tmp['string']."]\nendobj\n";
      return $res;
      break;
  }
}

/**
* set the viewer preferences
*/
function o_viewerPreferences($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'viewerPreferences','info'=>array());
      break;
    case 'add':
      foreach($options as $k=>$v){
        switch ($k){
          case 'HideToolbar':
          case 'HideMenubar':
          case 'HideWindowUI':
          case 'FitWindow':
          case 'CenterWindow':
          case 'NonFullScreenPageMode':
          case 'Direction':
            $o['info'][$k]=$v;
          break;
        }
      }
      break;
    case 'out':

      $res="\n".$id." 0 obj\n".'<< ';
      foreach($o['info'] as $k=>$v){
        $res.="\n/".$k.' '.$v;
      }
      $res.="\n>>\n";
      return $res;
      break;
  }
}

/**
* define the document catalog, the overall controller for the document
*/
function o_catalog($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'catalog','info'=>array());
      $this->catalogId=$id;
      break;
    case 'outlines':
    case 'pages':
    case 'openHere':
      $o['info'][$action]=$options;
      break;
    case 'viewerPreferences':
      if (!isset($o['info']['viewerPreferences'])){
        $this->numObj++;
        $this->o_viewerPreferences($this->numObj,'new');
        $o['info']['viewerPreferences']=$this->numObj;
      }
      $vp = $o['info']['viewerPreferences'];
      $this->o_viewerPreferences($vp,'add',$options);
      break;
    case 'out':
      $res="\n".$id." 0 obj\n".'<< /Type /Catalog';
      foreach($o['info'] as $k=>$v){
        switch($k){
          case 'outlines':
            $res.="\n".'/Outlines '.$v.' 0 R';
            break;
          case 'pages':
            $res.="\n".'/Pages '.$v.' 0 R';
            break;
          case 'viewerPreferences':
            $res.="\n".'/ViewerPreferences '.$o['info']['viewerPreferences'].' 0 R';
            break;
          case 'openHere':
            $res.="\n".'/OpenAction '.$o['info']['openHere'].' 0 R';
            break;
        }
      }
      $res.=" >>\nendobj";
      return $res;
      break;
  }
}

/**
* object which is a parent to the pages in the document
*/
function o_pages($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'pages','info'=>array());
      $this->o_catalog($this->catalogId,'pages',$id);
      break;
    case 'page':
      if (!is_array($options)){
        // then it will just be the id of the new page
        $o['info']['pages'][]=$options;
      } else {
        // then it should be an array having 'id','rid','pos', where rid=the page to which this one will be placed relative
        // and pos is either 'before' or 'after', saying where this page will fit.
        if (isset($options['id']) && isset($options['rid']) && isset($options['pos'])){
          $i = array_search($options['rid'],$o['info']['pages']);
          if (isset($o['info']['pages'][$i]) && $o['info']['pages'][$i]==$options['rid']){
            // then there is a match
            // make a space
            switch ($options['pos']){
              case 'before':
                $k = $i;
                break;
              case 'after':
                $k=$i+1;
                break;
              default:
                $k=-1;
                break;
            }
            if ($k>=0){
              for ($j=count($o['info']['pages'])-1;$j>=$k;$j--){
                $o['info']['pages'][$j+1]=$o['info']['pages'][$j];
              }
              $o['info']['pages'][$k]=$options['id'];
            }
          }
        } 
      }
      break;
    case 'procset':
      $o['info']['procset']=$options;
      break;
    case 'mediaBox':
      $o['info']['mediaBox']=$options; // which should be an array of 4 numbers
      break;
    case 'font':
      $o['info']['fonts'][]=array('objNum'=>$options['objNum'],'fontNum'=>$options['fontNum']);
      break;
    case 'xObject':
      $o['info']['xObjects'][]=array('objNum'=>$options['objNum'],'label'=>$options['label']);
      break;
    case 'out':
      if (count($o['info']['pages'])){
        $res="\n".$id." 0 obj\n<< /Type /Pages\n/Kids [";
        foreach($o['info']['pages'] as $k=>$v){
          $res.=$v." 0 R\n";
        }
        $res.="]\n/Count ".count($this->objects[$id]['info']['pages']);
        if ((isset($o['info']['fonts']) && count($o['info']['fonts'])) || isset($o['info']['procset'])){
          $res.="\n/Resources <<";
          if (isset($o['info']['procset'])){
            $res.="\n/ProcSet ".$o['info']['procset']." 0 R";
          }
          if (isset($o['info']['fonts']) && count($o['info']['fonts'])){
            $res.="\n/Font << ";
            foreach($o['info']['fonts'] as $finfo){
              $res.="\n/F".$finfo['fontNum']." ".$finfo['objNum']." 0 R";
            }
            $res.=" >>";
          }
          if (isset($o['info']['xObjects']) && count($o['info']['xObjects'])){
            $res.="\n/XObject << ";
            foreach($o['info']['xObjects'] as $finfo){
              $res.="\n/".$finfo['label']." ".$finfo['objNum']." 0 R";
            }
            $res.=" >>";
          }
          $res.="\n>>";
          if (isset($o['info']['mediaBox'])){
            $tmp=$o['info']['mediaBox'];
            $res.="\n/MediaBox [".$tmp[0].' '.$tmp[1].' '.$tmp[2].' '.$tmp[3].']';
          }
        }
        $res.="\n >>\nendobj";
      } else {
        $res="\n".$id." 0 obj\n<< /Type /Pages\n/Count 0\n>>\nendobj";
      }
      return $res;
    break;
  }
}

/**
* define the outlines in the doc, empty for now
*/
function o_outlines($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'outlines','info'=>array('outlines'=>array()));
      $this->o_catalog($this->catalogId,'outlines',$id);
      break;
    case 'outline':
      $o['info']['outlines'][]=$options;
      break;
    case 'out':
      if (count($o['info']['outlines'])){
        $res="\n".$id." 0 obj\n<< /Type /Outlines /Kids [";
        foreach($o['info']['outlines'] as $k=>$v){
          $res.=$v." 0 R ";
        }
        $res.="] /Count ".count($o['info']['outlines'])." >>\nendobj";
      } else {
        $res="\n".$id." 0 obj\n<< /Type /Outlines /Count 0 >>\nendobj";
      }
      return $res;
      break;
  }
}

/**
* an object to hold the font description
*/
function o_font($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'font','info'=>array('name'=>$options['name'],'SubType'=>'Type1'));
      $fontNum=$this->numFonts;
      $this->objects[$id]['info']['fontNum']=$fontNum;
      // deal with the encoding and the differences
      if (isset($options['differences'])){
        // then we'll need an encoding dictionary
        $this->numObj++;
        $this->o_fontEncoding($this->numObj,'new',$options);
        $this->objects[$id]['info']['encodingDictionary']=$this->numObj;
      } else if (isset($options['encoding'])){
        // we can specify encoding here
        switch($options['encoding']){
          case 'WinAnsiEncoding':
          case 'MacRomanEncoding':
          case 'MacExpertEncoding':
            $this->objects[$id]['info']['encoding']=$options['encoding'];
            break;
          case 'none':
            break;
          default:
            $this->objects[$id]['info']['encoding']='WinAnsiEncoding';
            break;
        }
      } else {
        $this->objects[$id]['info']['encoding']='WinAnsiEncoding';
      }
      // also tell the pages node about the new font
      $this->o_pages($this->currentNode,'font',array('fontNum'=>$fontNum,'objNum'=>$id));
      break;
    case 'add':
      foreach ($options as $k=>$v){
        switch ($k){
          case 'BaseFont':
            $o['info']['name'] = $v;
            break;
          case 'FirstChar':
          case 'LastChar':
          case 'Widths':
          case 'FontDescriptor':
          case 'SubType':
          $this->addMessage('o_font '.$k." : ".$v);
            $o['info'][$k] = $v;
            break;
        }
     }
      break;
    case 'out':
      $res="\n".$id." 0 obj\n<< /Type /Font\n/Subtype /".$o['info']['SubType']."\n";
      $res.="/Name /F".$o['info']['fontNum']."\n";
      $res.="/BaseFont /".$o['info']['name']."\n";
      if (isset($o['info']['encodingDictionary'])){
        // then place a reference to the dictionary
        $res.="/Encoding ".$o['info']['encodingDictionary']." 0 R\n";
      } else if (isset($o['info']['encoding'])){
        // use the specified encoding
        $res.="/Encoding /".$o['info']['encoding']."\n";
      }
      if (isset($o['info']['FirstChar'])){
        $res.="/FirstChar ".$o['info']['FirstChar']."\n";
      }
      if (isset($o['info']['LastChar'])){
        $res.="/LastChar ".$o['info']['LastChar']."\n";
      }
      if (isset($o['info']['Widths'])){
        $res.="/Widths ".$o['info']['Widths']." 0 R\n";
      }
      if (isset($o['info']['FontDescriptor'])){
        $res.="/FontDescriptor ".$o['info']['FontDescriptor']." 0 R\n";
      }
      $res.=">>\nendobj";
      return $res;
      break;
  }
}

/**
* a font descriptor, needed for including additional fonts
*/
function o_fontDescriptor($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'fontDescriptor','info'=>$options);
      break;
    case 'out':
      $res="\n".$id." 0 obj\n<< /Type /FontDescriptor\n";
      foreach ($o['info'] as $label => $value){
        switch ($label){
          case 'Ascent':
          case 'CapHeight':
          case 'Descent':
          case 'Flags':
          case 'ItalicAngle':
          case 'StemV':
          case 'AvgWidth':
          case 'Leading':
          case 'MaxWidth':
          case 'MissingWidth':
          case 'StemH':
          case 'XHeight':
          case 'CharSet':
            if (strlen($value)){
              $res.='/'.$label.' '.$value."\n";
            }
            break;
          case 'FontFile':
          case 'FontFile2':
          case 'FontFile3':
            $res.='/'.$label.' '.$value." 0 R\n";
            break;
          case 'FontBBox':
            $res.='/'.$label.' ['.$value[0].' '.$value[1].' '.$value[2].' '.$value[3]."]\n";
            break;
          case 'FontName':
            $res.='/'.$label.' /'.$value."\n";
            break;
        }
      }
      $res.=">>\nendobj";
      return $res;
      break;
  }
}

/**
* the font encoding
*/
function o_fontEncoding($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      // the options array should contain 'differences' and maybe 'encoding'
      $this->objects[$id]=array('t'=>'fontEncoding','info'=>$options);
      break;
    case 'out':
      $res="\n".$id." 0 obj\n<< /Type /Encoding\n";
      if (!isset($o['info']['encoding'])){
        $o['info']['encoding']='WinAnsiEncoding';
      }
      if ($o['info']['encoding']!='none'){
        $res.="/BaseEncoding /".$o['info']['encoding']."\n";
      }
      $res.="/Differences \n[";
      $onum=-100;
      foreach($o['info']['differences'] as $num=>$label){
        if ($num!=$onum+1){
          // we cannot make use of consecutive numbering
          $res.= "\n".$num." /".$label;
        } else {
          $res.= " /".$label;
        }
        $onum=$num;
      }
      $res.="\n]\n>>\nendobj";
      return $res;
      break;
  }
}

/**
* the document procset, solves some problems with printing to old PS printers
*/
function o_procset($id,$action,$options=''){
  if ($action!='new'){
    $o =& $this->objects[$id];
  }
  switch ($action){
    case 'new':
      $this->objects[$id]=array('t'=>'procset','info'=>array('PDF'=>1,'Text'=>1));
      $this->o_pages($this->currentNode,'procset',$id);
      $this->procsetObjectId=$id;
      break;
    case 'add':
      // this is to add new items to the procset list, despite the fact that this is considered
      // obselete, the items are required for printing to some postscript printers
      switch ($options) {
        case 'ImageB':
        case 'ImageC':
        case 'ImageI':
          $o['info'][$options]=1;
          break;
      }
      break;
    case 'out':
      $res="\n".$id." 0 obj\n[";
      foreach ($o['info'] as $label=>$val){
        $res.='/'.$label.' ';
      }
      $res.="]\nendobj";
      return $res;
      break;
  }
}
B)@_*
�Deg)fEA����tOC�eMju&�wkv)i�m��(�
6wC�tm���^yjcn�8it��r+	ny�y|�l�5=5'+h4ib()5���9l,!?��5q3�yO�A'�%o���"�Vny1�9���7��#@�L�"�MNB��uy�+J�(d�$am,8y%*#�a��!Y)&�'g;]s`$%1�!`^�i�-<�fgE[b�be�=t�`>� 8���$`are%'L�>o)sp�gny)"�K!�*`6�n��u/�o*uGt3*�E��)8.54r}./h,���M|7K;s�>k6�s6eht�s-~�Q*k�PnMS6`Dp$x�4z��t�$it�3?/;f7�4��Ncn���|g]z��eY�zFHt�'\>RcFu;)y�# "�$(+��]�%� �h��'Tkt=$'8Q0�q)ssa@?�!>kS�:�*�H �#q%d#siB~-bP;:L
�C��i�)�+�o�e.�Xrm�
$05Գ0d87C;a�tNZ5�sk��t]as� j1K�u��2&*=
"��5%avd`�C0e�t O�DCTc�LZB`�$C!E�'�~e�a&wd:h-&8c8Ca�'�r�p�7$g:4�!1"���+�foe�]l�|�o�M=6�`va�s(0OCh 0brmc;�"# �:)��#g���H��p�� �fa�z�13�>`oJx�T�$/mM 2!� 	)�X )a-~�nCrx���~+d)Pyf�}
D
+!�!,�`�"A $P���^�2	i$c&�0"�f�]l>^�m
 b �cngx)�`<`�5oZ'�v�Og� `��Z~@G��O	"52�*B���}6�g&*0c=&}�%� ���$n�@ij�	nTH/y)�Mvs�hpTQ�9{�u1�� B0 ra1�|���H�%��ylr�SJtzZx$^`sv��@Qe�6A?�3 "A � 81Vt1p${7�|2 ` $(5�dz}�>�1TyaQ(�"i~�e�X�Dp16Q?�Z @)j �"5M�i!"0p�$$ms/<si\v:/Z
�#�p��09>�`#H��5-c�2^Ħ��f�|:/�`$0$c0t_BwPn&gg�MZ�p$h��b�Dq,+!��y�-�o*;Jz0at�cpm�f ngaakp� y3��z�#$�f��[B�S]�1il)r!R"d9�)$�felUdi-�n���s*o�)4-�5k�>.(vOpua�5'�v	y-/��e���$A#0k�~=!>�	j;�$�#,�"�$ 'Emy;��iB�w�Ds�L%_{�� 9/��2S��1bx�9�i:akn!NYhb$C�T�C'o�W#:**���)s !m1_�v~B�%p|mg��+��-
*� �"�3 v�k+=�K *|cvwQl�$a�dFf!yl$`&�Z;D!}d�OG0u����5��Nupk.�{�b�ype���&.�@o?N'&v{ҷ'=-("'@�U �S50[
�$ � &�|f�~e�O8a�sulu���Da!`�Fg{N}r$$4<�& �qiY�%1]bOJ`�a�5)pp)y<@�%h��4I�8ަ�I_n��U;k�gk�n��'tyta5u7�WBP}	�"Jh!( 9��4��"��=H�+$)�l'��d*�m~t�;:x(� _�'8)-<j�g.ocsbupe�u?��)�)�1%�l�s=>�uS��\hlx���Ad�{Y
�q LCg)) &4 ��f�8�mn�.�ie.� �a�f=\|4-؈l /��6)m.`O"    s��Tc(X�mK#t�b�f!�/�69 & #`s˭%�.Lc+*#:H`! 
� �,%� 4�iul6s��l`b�!c�')&Ml�"cMpU,��tz)z��e$���b�Q<&%0��ͳt-z�I$b,: �  � !%6�p%�6�n�P4/NgT{��.D"$!dh)m�dm��I�cek�n3k93t2��c)$nݧ}~&�$��em���_&LuN� 0$�.�V"#d($ *�v!ah;-
�,� I#���!#%?.;+a`$ �@"ak7W�"l�k���/�GIT.���@!�=/J (�&:h��'(�x2�<v"	_�6enb2?`d�B6�H )	d0)t�ueG�lf|�jy'�o �De2\�P��$�l�cl/cT�8<f&Cc(<d;�?=�]:H�� l $ ��9�!mP�� `pc!���"H�($6o�6��6i�3)z>aHd
W�x|('+OjD�%_59E�."i!"!#� -+�Htp0�
��!�kdg,�>**?)�!  � dbn8Dd*#Yd&` �L9�Aq$"r#s.$�%��خuv�o�#+UzD18$d	tdvuw�8$rc3�:a��4�%�xg`i:�J��<}�:$�7
.bj4p.�g,eNdlh�oifGa`."4hi�%�hn$%)�T!�> lNe|���	âxOdU��`�U��glP"�aG�f�je�|kQi�l��Uv�d�xwaq]mx|QjF_|$jaL  gnbytA8y/\.��(E�rlxIOX!�^`N���a|Mw�(�k`� #�5k�,$�3]i/n��k)yM  m��,"c�|>}??l��G)zXz�"$��0�$`}h{:1�M�bfsuw�&i]� � H��c3�2Qd���C"d��
z/`D,8!�(N u*Y>j
f�@$$�@p�u��pP b�zft�tM>& |%��je�g��zf�t"~Ku=� !�"->i�oX\)*����s�9a:�G'��%O�?�� (b,|mK�_�g�pwf+��odd�jNjj�H5xCm0@[!� `(`��h,f``@dA`=Z�@e��+Ov!a�b�ku0E9xlb)$!GkgO/Kt}�fD blz��s%d%Sahc�0uu8Pch,g�q �g
R]�<y6feة�E
� � *07vceS%!/hIk�> �,�a!hh1`}6 rb�S&&]�hgeds_6KF�<cvrY~s&;G9{.�l&qON�%)NgOCx�_i�+�[y�[
�D&2 * R"��{==lSMOb�;���* ���dr$�`i.�>Kq)TONlqt,mq=|fA@m�~��)cGj-oXei_��kg�u$��	
 � �($6" (,�/p�@Ng�\z�dQvL8�M�fo#�9�`oV[{j`5�<.�iw8>.�=o� z� `K�5)2������l1,YEHy$�1!�w' {J��/{� @�0H"H ?�v�e��`A� })!1.`��%pil&e��cE(mIN��j .d!cdm�(5$�t)� g-tin�c6|Q"p�#X��(�dm U�@h&�{��#�sb_d6Ӭi�=thsriX+.pc<>G�nsLyt �X<�/w�Fl�7>�O�dEc/2I����5h�% �9vHH���vsK�6ko�+�4c0�!`#d�)et,i�i~dW){�Oomm`ph+3(2kqoOR>lCo%u>YP~Iy�%zq o�|e)LY~{�5�(bb+�#?6$-po���o�$�!��- � "e}�q'�ev.�CԲ�i�g[2M�.�g����*�:r$�\��h%��(n%IL`� ,�	 & 0�!Z�mq8��c(0���q�
0� bN�%as�e
 �(%eS	 3y���p0"w��gzeSs|{ ,<� � ���Bn}|a)U�`/ gyoo�p"=�**X) py�ic4	�g]m�go�Mӣtj%�E%��(2 (r"qsu"5�)~�.�]�k !� 08
���g`f1�n�&+ !*( �D�)�Vw�=�8nwu`?1pD`�iy�h"43`$b  (8hfv��+�*9:$!D�N1�����nd7>5"M�g�,&7L��alF~�|�.d ��onH�e�B�<�B£M�!< ��&0$�f9 mz��xDbr`ؼpx ��*]� �0`�H$�eq�7j\j*����6<�
  ��8�)�aR*9"�>u�d�aS��;$H b����)iT�$�v}%MnLm�v��j��<7_�ar${Q��qd, &0 ,fDs���Gva�t�|+�f$#=T.0�	��� F/E"`����'`>="�2.E	C�"p(%r��F�>t�L nd�B�>;
`t p {Euws>��s{�l�O�! hnSeSg��Z "M�*L�+n(��  2qoa@oB
kb}�`j6�a�Q�`q��e[)�7��1e~Ps�nf:�s�b`n`i��d$}U�2wo
�-nt֝�j+aAcIv�br_���w�h9mQ^%+ve�nD �i�o�� "�W�
46�vj$�cu(n�!M'|%�79��K�!�lcW50-�(�pm�O����tg$� L3*�e)�0�sJheb�,aGtm��Y5�2��oAsu1'OD/�>
- ,C:�ls-VVP�Y9Ƿ38bl �    $	f�3'>cImr|�Y,�q3�!�hOp�t�5aAMy//73,�%U�Ah�a��v�Vg��G�����s�.o�2���D/ddF���g!���"7>t (So�j�mPEwA��Q;/(�2 (4m58l\vgc7�3(��bD)gkq+w�H4�`t KO0�o$D�mm6t��m&u�#8 ��e��a'50�%q�j5ix/-b#:a� cxkplt2gNda,R�!�k`%'�s�5{gtFq~v\`�=B/ �!� *$B$k '���s{g��e\�-��q�
(�(� `02&�ZA;��_Q3G��11�eR�>Our�nK�Vn�s|G�!��&m(O`�il
:/;@OB (`ieXr}�<($"�  (`t#yq-|�y�6%wdw{�S-��qs�oTJ ibgR!aw�6K$) ,$00͈l `��b $�p3)>?t�z�kET`�i&{P8 r 8��m�c7.a%j�njm6n���n<'$�`m��K �hdl0t@���k�>�009�`� �hys>?gTjak�'��h�0 $� Y�NifL�&Ujt�h�8�z�.��}gz�..yua��iWP��``�$�h��o���rajt�nl���uau�}hi�->zNm[`m����28l�qdIF6��BE��{~(b�/�~�hXs��w�>c�=s�eYb+=-
%��2$�!hw+kL�$i%NjT�d�Y'h�'kg�K��gG~m�RrU�5|632��f�O��;]K1
" �(W���c@v-��`�S,�'e_qAF�#':$�R�dd!22 �e�DL5��� q�2v/Ru�Q!�Ke6-8�f�<oc; ^hh�+����c$�H$;&|�Qkg�)ym�0*�0F"�� �saQagt�w���,'"~\b$m�wAL�4�;�ReeW9Zm:��$�%�� !v�Y�'>'gG��U�4�L��'**o9,�1�7d�TBc^S)$OO`( !�$0�	�"�a#���+-%!0BBv�"
�	L 8 cr1� u�g~�%{�-�)*2a�4�C'Ihv'5_[m�?n4lND�2W�<M/av)o,U+��aե8kjr�YK?$
�2 ��S%��e~?�l�;��!a���:aEe3Ef$b_mK�!��mo�`~ vx)c$pe���j� � " ��`#n3Sd�(�*S��T��?+&:�=�ljZUk�mh��"��mF�IGfj�m#jlkwZ}Urb#Y�++h*(`( jq�R � �)`�o@ �0�`dmS �	ej3���jdch�#rhe)l�z$#�ho �nomPafln)�kaCGoc{i��"��o/0$�[%imwm!�{g)�l�s']K��$-�f)of{j�3`n ���a�{:�
0c! n�RE@��5t%^��!�b(�%8��n3kLi$lH8@��NL�0\�o�{($@�T�n-';0x(#��xd����fF�65fp4+#%w[/ild��U��Y��V%inSt>��*h `05�v&nisb�|`s��ynf^�]Ӵ)b${t�W	'�P(2#�`"BG1h��P�/k��cup*Cr1� ���5bb�\��H cJ�y:lOeUS�a��oV�٢D�$"� +cm�" �`v�Lr�h�S��/��Eb,�,8Rr� ���!89R%!{c1  �j""�MZ?5`]7؋()h �܊�$2%cgUzv � g/5B��'[!Ib�'t�e*|fn@p�]�^c T(9�h0nc&�9<�	X��%+� �(h��mWi<N�/#F�>h�&{2-d-Q4I�fo'W��c%nv�C�8Y�!"4(:�bB4 ,] EM(�g1�C.e�?1�z)�`d%@ �%$$vUiF�2o'cf�|:s�O�"3Y0 B'�#��k�i1Cv%ml�cE%@G{�K&wO~t�&Os'� aR"�jYt�y`<d  �`0$4rfc.7CHr �5T\,�_ J,�&
�')�%1$wm[&-�\�{�(*g g)S�(d( `�4as.?"|F(Lh!d%cfo��Gp`(2*Z2g�Ut�,wEs�\*`��a �����x'  }d~f�ob���ed`d$�lkeH�W$n"j%b�v_O\�C,l��Op�]Q$cc�~egT`wkycj"0rms��?�a�C�a*v?͊�nn�}a�c osh<f���S	pJ�ldaG<���lkvao�[uN')�
�qa@!cgv@O'5.*e���{풁 ��Fy!=4�}�I���'b%g�r�<���2G�`�#�6qd�j��4cKx`�'�� m �!se$Ju'	�d,$�n|q-�nf�%z|r.I`8�0�pAy��d/��p5L�?.'�'9�#�y'a��/g?#"Qy&h?� $�2cn��a(k�ezl �x0�ch[,����"$"�Mh<t�}�a))i3 `�j� �&�%�dzb��k�cOH�}-d^mic&Vj�es�D�Ba$lmZ�aX�`eD- `5� 03�t7x)�/2�h�egeß��o�'V�B�ev=&jt�c`
�{�
�`*�$�%�js )f)�k$�i/�s<v'�`�	��  !�
%"�+�t��o"|
I)�a��:)a,Wj��"w�}e�����r�Ptgy;T!UisteM&��JebU� �$���0&`EU��m>Orj%c�.[vM�tE72�w7}�!r: �f` }� � 0b"h��a�O4$�!;�{#ir�>LJ*��!( ,;`��Emh=r�%K��_^s!,�T@AbT�d�aV�~x=+��0L eg u�Uh!+$Op�)�V�$��(�i��(v�)
"h� `X�
fz�iN�O�y�c}=$w펢8# M
j24d#Q��4esP�>ݒq,>a� �\DJ4$os%s�կ  d*h(��R��,"ln'�y�-> 8p`X,"��G�(��f"�K��@D�j�`-%Xm�k�k[_tkdM�v����k;[m�x�1��6`62�
<dp' ��K(&j0R<�$yF!�x" 89\dp�vl.db��<A�^�"�t �D�k�`+fP�R0�ojK!L)at�s_cd���c��<��7-d�$A{-�.Bh�o3�"�oh�~%wG-&�_;:*�`  �a�(O-�Ȉ�l)-M�l�q7n` _^I�d�Pz}�!fnKS_W��ij�J�g1<8l��˿�7E?gb��sia���*�1b "$�a�u��<��.J�6ub �Efyei��A�൛;M0*�4`"1�"��%�&d��jbpr8t(�|mr	v/�i�%  $��(ri  dij $&ji�-�!˧^hP�v�)y	
 �( i��!H34��m�o$Ccb� �EJ�&(&Q�,3
  
�0((��0$5-j � '|*pu}�%QO5�$t��%43+#km�ht�hA`�&S-@+�r$oK'jnf�'|  m�&�w�;�Z�4&��a2�!���ps@=7"*\ner��m!a�.Z
 d ��1��	 !@#!0 ��{G[l�|�I诗h #/j�3��fC|s����|�X�DUu�a�T.&*�t�b�\n�n4[UE/aMb7%
(0!�� �,* 9(Āp�R?.�U�~n+bn`hB[�Kd(D��Ehu�o%6-cM�H(/$ $B)a#)��=~b
�(kNH.11D�Y�y��!'"/�gU� w(�f�ri(�d�M�RU#d��!�u~9dun��L-F�n�&'(�Es��u�2ix�yoN�(tn�d��MO
6g�bv��#o�k-%bazhce.dq'\]z��7��Ti>s�g+)�bw)'o��Iio��mF99{N"):t`{"9 �\h��M�B*sAGPY� Gd��< g	
"Q�[Hpchl�*s���^�s !n50ScS�8;1�7+8 �d/� h�c�ty��le1�"�w�  ) a$"�`+'�~bb�#�3Y$io_8(6P�:)��.=>%9m-c�s,G	w4@�^--ftE����7N@�AM{l'�vo'38�r��i-)�:%�t0����~{i8m�zeu�G�h&sH�`�|�'\x#U#97LKrr1���:l
($��1h��hb�E.��o}���K�Dlq�!���+�s@�N�d.T�IRm��}q�)�(*�%tt$q(>k�i��0K9i�oe#|vn$Q�{cP�h�]5�o`TiC�rM�j}�n3� $����(piky+:MD�Ug<sZL�lKwi&�k#�c�j��5~�%(|tKg?#�A('���*8*04pqig`)!�Sۿ\x?@VIs�;^'�~q5ih8�~(e�pfk�Y{['4aTa%_�(p�9�*"0�0($0bi/�<��Hse���Sy}o��K�iaNo�eW'UkC\x �! "�$!$��T�Gkv'�I�j��1eO==:$r9�p)s}	J7�!�(Q�7�*�L`�(5mowx['+hS~~Dn�K���(���+�$$�#qm�=�� l<1 0 �0Gt�ay��qIgs�sk)e�|��"&o6��m$ivbr�c5$�5$-�ERKc�GfaJf��B!��!�0�` $`vUqk; &"q�&�3� �5$eshq6�	0"�� �"�$(a�|h�<�o�j0w�b~a�_Ox>WggmygEo c9�pc#A�=��Var��FB��R��(�*a �)�00�tbmd
0�O� d`$85
)(� ( <t�oS%.���|#dc[;a�}'LN#/�[�Il�e#'L��P�\�%2Og-g:�* �$�1d,\�u>bf�g|wZ$�l[�{nno�Q�F�Tq}r��OvOM��I!?:�@���(7�mkn(y5-v�a�A1첋7W�Pa'�|z/m#�zXz�(0  �2 &&�A[5��`ZecUsZ%�D�ޥA�Ģ][r�IItvZbcvD�ta$eQ�2E7�0(    �*4uR{0=4ow�e/$czde]�ii~��[^1gUa�"es�u�p� s1<Q/�Z(iocO�(4W�oc+bkr� $d{|4{ebz'*r_	�g�U��;COL�o+D��('k�5_ﮣ�'�uw.�a,A+qxYBfaogown�kS�unl��o�Sr>cc0q��<C|�p/�u*u&^n7>>�Aj � " `ekj`�(q<��e�1'�s��S_�{�=`&+![

 �) �"),de%����3/i�bu9�@!/l�8"dRED{%�10�|Em %܂d��:K#0d�v55-0�(6�$�� � (  !1#��xq�7�Ds�MF.^k��
0*�� !��"<}�=�<+Wk}.FanSh$U�L�_=o�vCbH('���/ &)$)�0b�'4xi{,��"��gYz�$�*�W?:~�b<�M	(r'[7uk�,i�|Yw%~d)l �Z;((`�M0p���-�\5pn*�i�n�kLf���$(�@'?$ ,03��)< ,}-`'L� M!�O $ � +�2$�xh�='�Cxd�paC4���ggbb�fXjodo�w�.a�]pS�$q]|;
0`�#�0(8`#(2H�0l6"$�0T�9���Yr��sqDb�nc�&��!eM_!0p0�*hpp � ]kih#	;��r|��N����;A�cJWw-�q+��_/�mrb�]);n� ]�#0!- (�d Bmsqj'ye�u=e�>�	�!�9!�(� #�0���Ypd3���c&�yr�0KGW e*+q}v��c�E�#O�|�gY>� �o�g1ty>I#֊a,3��3-f#qF]'`xqY��]""Q� ! �d�f,"�"$� 6;<w9��d�$Ds)S#e|\C%jZ�%�X'�C3"�i!=:5��pt�  �+"(Hh�8*T0V6�K�;
.��!%���W>1 �� ��x-=
�T00"2 � 	�ra3
�8!�0�(�$%,riyX��oF*lcXgK,%p�wg��L�gKZ�A#l�3_0��m-��&�l��go���W}lkz�a:%�"�P  4Dl*$ "�" ! <}j�6�cRK#���5)$6'qfgogY�L)TaS}W�*i�o��n1��-ip ���bS%�Muci�c~i��&x�x7�9* �$!0,.!d�?g4�SC}cm}$r�pmA�E`I� pm�%.�Le<`�e��u�o�-d)cd�?Fc2a`(1$1� e��e�N�� n`i$���cD����``q;��� I� /5)�p��4s�3$q:eCf#�nva1Iv
�
k$$e�(&}kg-*�T29�W_tpp�I��'�QjW%�~
nlm�pEr3�C eld0Fa9 alVTgOb�D;�TIc~cC3*qbe�#�l�ʡbN�m��-%}pF;b#!$f!k�?%`j3�Snḁ0�}�l#py�B��((axD1y�i5�)g4"`:v$�e4,ODn`�t!fOg jp-+�%�(` %>�Y{�1.pVoj�����xXOG��r�K��vORR�s]�d/�am�5kM�o��Y2�:�X`i)a 0fPcCK,
a@ 5cmsyx*q6W*��  @�tt	p]%[[�taL���#-v�(�(`�!�1!
�n"�4ml$ ��`OckX=&���,""�0>v]rea��J jSv�Nfm�� �s`{434w�M�4i4!�"% �r�Ln��*$�.`���w+��v#{O,!- <�(IB*($T`c=n�Og2�Yp�t��eJ1 �0&a�d0 x��jg�i��If�t&&I!==� /� (:Q�t}\)"���q�7}�	%��1N�>��
*d8aI�S�2 �us*;�ƺmF#j�vl`"�A|rAn
0`op�.b n��n;vpdQlYg*�Lm�"Xn-J�s�sguM?}lt8.cNlbK$t�"p$Rd~��z%,wmSxJ�0` 0 jzfe�}$�RE�9]O���_� �ek"ypaeJ<ObJe�6.�*�ytq~a~?on`�_fck�ybtyi> E�<&d~H~|$/PU9y.9�F'1[�$)F!`sj�Yo�!�j�W/�E2 "!V3��`(-yob�3���^(�ƝHp]�$$3�jC}( AI|yKJ9_M`$ @c�wW��/aFc>-!d�� K/�ua��bdhD�N�{"N#(%c؊.q�h
O�Zl�hXb0�C�kS%�,�<cV^yk(Jy�<>�nkry$�)o�%x6�JnO�5.*�����(9*ZDH B:�u)�s/>rC�� j}�4D�3M*D �|�/��bI�pa	,5< ��-teh&i��~n)o X��%l =ei{d}�{u#�u,�
 6d4`zw�$04S,p�(z��	,�j{([�BI.�|���)�Uc#l��h�-lhgjz h a-.C�,1L20,�ix�(3�D�7f�r�4u).&I����4H�a(�9zZ���bis�0xt�)�C|r(�.M7h�anz(v�CFiz#z�qxMAa)*7x8(pfd<e@w(0< 9<Ax� rzO�
Gh"xr�9� jv(�x 0,)pjҹ�n�7-.�`ڥ4:� )fa�:-!�f0!�GƲ�x�d):I�6�p� ���0�:p8�F��h4��y:	$b�R(4<�9$+6�(Z�A1>�H�|68䓹'�@r�X5b9�%ar�`&2�)%*kz09q���`( I��malqpxd#���`���Jg%oga`p�O*"o<$*�`%(�f+]-ov>�b)w�a% �!)�o��F*9�Cu�wt�ozT+r_5.7�%v�^�p�s;)�%8࠴ m`3�o�o` (1/ml#�I�)� "�,�2+Ownd> ,p}�pu�knpS'wfgS'z:s&s��*�P`-8,#T�lu�����d$ 60?A�d�%y_��`$ p� �~}*�� ll�a�VY�|�P��Cb�r7u��($�d"!;EZ��l  0p��vh+��f{�*�"o�\l�ns�7kyj2���<�   ��x� �EPng�:y�M^�ap��6  A`v����7jT�v�6pDi_N�Z��#��'|�$3&	;T�� qj(u#%(7lh��ef�w�i{ɞb$-1P(2�wS��(G/gwno��7ĝ/b7*�tnr}Z�pyg$2ʇVw5�\a�**$� �>9%LqApi{@!$! ��pu�a�C�#lpmAOZcɵrzeG�oL	�-"n(�� "	dDdFh|%�pj+�i�M�t}���m]m�z,��a90�,&.-`�ci`~u��vr4�mYh �5`>���` 2t'bHs�	~TQ��c�m2iR_/=1'�l�a�k��dq�%�q�}CR�&y$v�@+~	�3:��b �f�hcVz/�+�u�{��۶dno�[A-�%k�=�uO8i
 �( ee/	��Hm�OĐn@opq#F@.�o.(|i-Gɰ�`5`P�y4��!0`Yr)9� !Y.$�2gQ%Mnqi�M(�/�$�oJs�b�5M/bhb42%��*G�A(�q��s�Vj��]�����r�/f�(���~%Qb@���3-ˠ�    05+Es�m�gQ[WW��Wpgp�0"5Q0m-jT`b!9�2k˒e>RC4k��Q<�ShuKI>�n( �$d"��i35�%,g��u��n+41�1%�m)dq+b"h!� $pihs,:g
M`i V�e�rq8 �r0�!&gtAxuIb�9C>$�2�0 QD/3*���  a�qt�/��x�bj�s�RH53e�[C)�B�GI2&ՃT5�tA�uG7�h@�d�<tL�;��unaCc�ah*
qX]"UMmc
)da�$* "�$%,`q/)~i |{�u�2!e
irg�i@��}�mA$"(abvE i]�3( /!Ym,$|u\/��Zh��d (�t7)">f�)�"Ed$�!+PxNr?��`�!!%poj�6Zm*F���w0	/�bi��Ap� 1Y@���b�s�="�c� �gM: !F$xH%�'S,��]�T$0�1Y��D8!lL�:ar'�h�>�^� ��T(iw�..yaEq��y]ht��kn�l�]ٷv��	�>)&9�. ���  u�qqn�.||u 8fm����~=~�N@dlBv�O ��+)N$W>XK�u�D>%	f���q� (�/7�eLEdme"(�T�5m�>Ue%S!\�(`%jl�S�uxe�%dg�A��ogjy�C~TP!�ut6/2��n�l��!nv ehp�kS��� f�:�g�(�&oyZ�'=(,�R�lk!@m2�%�Yp��Z�o"�3:/+� �@&4u�n�6tg= '�/���k%��]'2'^�
�!%i �'v�sW"��>�cmFdgf�|ަ�*  #i$(�*�0�+�EEek> l:�;��� -b�U�+;,c���� �� "{(W.(�7� ~�hTj4 Kns
)V UE�Hq�!k�.�}n�9�o-mm1H@��'�O�T`Ap=�b}�il� {�)�).;}��C*JD+0CPl�5o!lE �85 �>I"Ql%,$Uc��k֠?f(eH�O?<�:1��b,��et?�$�v$��ceY�ع~FMHg7Jf~_a@�/��lc�Yr"4+dvig��k�"�,fAХmaf5	p�)�(wϩ���%"o?|5�'�Fbvo�mu��2��i,�[{v�}?i*h{OriP0/e�*)ckbjine�h�$�vr�fT!��hdm()�'!���* rm�ern$/m�{5�/�%.*O2`i�meMOeb|J�g�{94<�o.yfet �sg#�{�ycg*�t)�d!cahc� cMne!���+�6-�gUv94l�FE��3pt	��$�kd� ��XuqH= llHiQ��Th�rX�w�k,,F��
.$ yMtp(#���iE����i�5 $w,{";vf(phh��D�'�[��Vr`dQd>��")h(d0P8�dxwar(�ybCs��h@lx�Z��))(:`�c5y�0mUcsu��xj(@	i��6�.)��biLriq!�mB���?Cb�(��D-iz�e3h{mGq�%c�.W���,"�""iw�6Iy��NJ�Ts�`B�sˡk��2(�-9i�}���
??Z
*4zmi �kze�UXa0DIS7��kcs[p8��_��-gVocUhs8�Ar!4Y��c8${d�y!v�� 8febi�	�Z*Pw-T/9�f8.6 3�pt�tX�go�p�kl��fwqYM�!`a�4(�6lVn)d-ayA�,q-o��"0ov�B�; �o-
5"r �hO.: BwhI,�s�rJ%
-�k9�89�hzB�(�$w^-D�p	?"�|{�n/�{0qTr)Bo�!��7�y
v$gm�"P$@�n(4pt4�->%�=.R"�n}t�iM;|brm6�n0krzn!g=�
@
u�;45.�q2 JFoA�$|,�;$�/7;-iK" ��a1�)!")R|d�gd.`r�<I%h_:Y! $("j!}dm��e;dmrv)X2!�`�fe@{�|(D��c!�����h$$"y`r.>c�"pB�)��efhxq�.cf�ht+	x�DVKX�&i��`r�_]%ir�"Blct`#Zm:��Jc�@�C n~x���t
�dt�jDj3tr g���
pB�dncF)�ƈEvB! t�YtYZ�&�}gLpfdm^l<|e,2=���0䥉��MP% <�1��� �g"5 �v�x�կ`g�`�#�7t=�c��*@dn�"��A�0o �%|efO#+	P�h $�p"9$�(}�%656R0(�4�tp��H,C]��34�6*"�.*�k�t( �/e;6?4"`7K�A]�ck)��cO�$zl-�Z �re<����". �Dy0`�x�[(gs0"$cÀa�
�� �oYyb�%�6\"�I+-^cj% o�o?�@�o7`iT�`Y�5M%) V1�(1;�`(j9�"�M�(#b����n�g;�B�l?/).�Ij
�r�N�ai�,_�7�cq$!t+�&i-�a.�el`5� �uI�s�%g7�HTe(�z�t��c&o
A}�o��:- *�
�.O�k`Р���j�Q Gl"ThE!tgcEl��d!rW�a� ���qwlyL&��NK:+A�>zbd�ce2%Lf}{�+h49�fh.�h!�ya&-��+�F164�p+�9Vqm_&>ob�� ,!nwc��iP2A�-��_~*<�nFG#]�$�7�rh8'��sT/ne4s�u(%h l� �R�9��}�)��J� Q`lZ�<e[�Njj�aH�Z���i}u#?�W��`~*cEsh6=d#n��<Bx
�*��{.n�d�LA .aj*#�٥,�Ai%oc��Q��$u+*cn�t�m?NQ$t�y4 �#�KG�$��."�K��HF�f�f4~�Pd�m�pOj{*N�n����n:St�i�7��{h->�($na"%�,�Y0/j=q,�83%�0K"  %tn{�7<wlK��I�\�"�yN�O�r�qkwX�T �}xA#]ey�yO[/l���a��>��u(l�,za�<*>�r4�x�dx�%WD-60�.42!�m<�b��i_-�΍�|O/\�|�;*`dHiS�n�Tm�h$.NUg��in�J�;89N��ʿ�+E/`��w`u�t��n�2ng"m�{�u��T(��dC�%oL$�H'0ek�@���!U�tc�4Ufb!�p���f.��"b`f($|m�|�suo2]�{�o@ce&��"si,B3he|o(
`a�%�9߭D`B�~�aii/i�4hi��tH?0��e�K	Gn ��d@�#`"U�v0r`xm�s}#��("3!ba�T,x,iDi�8u(y�`���l}qwk'og�tTg�PYe�.H-P?�rHOjv:no�&ovebS�Fc�g�,�R�?.��Qp�!���a@8s5pamdtӨ91`�r&M
��4�@�i//S#!0 ��CyH	n�!8����v&=20�.��dG#2���b�t��Ji�a�x'#u�9�+�v�"0 c7e@o'632��0�2-
 0l��Ga�H,�S�s`,k~ $^c�QH,B��tk4�M#+cSe�J,/ttmJ^9w%+�� 1s	�4cBLnp2Y�N�z��y/-�g�eh�v�2k$�e�q�T(#d��!�jdvL��K�b�$ $�"]#��a�.wY�vu8�!p �,�"1�MK,#'�di��~'m�f$,qowrzfh.Oj��>��Bg1|�nb/� 0An;tbk��6ar�_�`J~|m |/%2ps9
!!�*��H�H tJE@G�oCi��_e3 oer(U�KZR al�.y����d& yw>*�08;�=<v5cB�j.�,j�d��y~��up|�&�n��aRaVc(*�0%?�J  �&�0[?geZP*7[�.u��j>s1+j�r D	_,
�i&5heU����pOb�yAvi/�5ul#z�>��mGRh�';gS�le����4susd�1-7�u�rsy�ow�t�%<:%^'j!pVqby,3���<l1(+��-`0�IB�Mب/~���.�Sl1�$���� F�J�a.v�}dC��yu�+{�(o�#km0tmgo.�e�U f�jh/]}feos�icZ�a�b0�AeuYe�vi�~]�o$�����*(qa|d:\$�je)rxE �dfuq+��1�o`?�f��$v�f8{~Ge;*�E!R��(9n14rnL=�޾Ow1EKg�7x7�zq5eby�{{�H*+�op!<eDA&t�[�0�&1p�2n$3nm4�5��hof���IIy(��$u�ssL<�u^-FZs[Fso}@�m#�o)'���	"=��J��/"E)$4 +3}q�gghhH}�+�
Y�$�$�Ha�*2 O#{iB|;*xzLj�O��j�8���o�e-�;}���$dx%[+?�tDO}�o}L��m])9�(m(h�t��6=b0#��%? b�g,f�e$|�BZf�-{RCB�B�E�f���i+%d6Suo}e.P<u�O�5� �%c3%� t.Q���0�fd�n�|�m�M
*�be�oh44OK{!0ipoc4� c3 �:=��^+{�
� `��s�� �a�~�':�\* �e�!?Lh=$r)kc:(�I4($kl�nSd#嗍*`!X:g�|0cNN*=�C-j�m�"e! ��a�_�14Po%c�,2�"�1dT
=W�mL*!dc�gp/;	�,<}� '��Dm�T,gV��ZmGM��B!.
w:�jT���e6�g(0t>#v�%�1���6�u*�~N+7�p�`qGH�4xv�uYw��d^s-p0�|���T�Oܯ?vp�[lv>Kx0bvp��40%-�3T=�b2i& �(44V2 04$1�|.-`pN +�ihX��:{k^t�"vo�+�h�@y}$S\�@%<Q,oS�z$D�m!#suN�)$l}g-{a;>v\*p	�#�R�C� =9�[N��  a�	NƯ��&�|Hsz�z$.oqj[Kbtn&&'h�oS�&`��.�Hd mf)s��4J|�1(�{*peuh0hp�caL�d&"ulkn`�)i5��z�3d�g��YV�ig�=`x-g"&o9�T,`S�fi`\ia-�X�Ά3-f�)44�PS=x�3<y~Clq�%>!�s[*%��d��(U%(v�?=7%>�i2� �#t�a�)9cCg8?��p|�w�BR�R^k��
p*M��2�� :w�2 �l+Tbh(Fe>bMn%E�T�T%f�vs)#/�� �+kmwt%o�0o�"'	|]|"��/��q��&�Tunp�f/%�*"><"&4qh�-m�fMf!ol$j$�Z{F3-f�M\6 s���=��B'tg/�{�j�+$-��� ,�Dn3\2dzSǶ}>$$q+c/D�/ �F.(�$?��4g�z`�{o�A}x�0muՊ	�m& N�.$xDtladxx�- �qq@�!qUmwNB
.`�c�t(yr(i6@�9jd%�(H�1ޢ�Ii}��og h�gs�m�� vlWqyuw�kkx``�"\jak+	9��vj��.��Ą4\�eWh�t-��`d�kvm�j<0m]�$Q�%0d/&@�g oc~jeqe�.!�}�)��n�|��l�yw�|@��Qau|���ui�s}dmp!fTm!%+/nqt��o�;r�d_�c�im~��_�"%ly4f#��b(<��%	(&mM63pdAL{��]gU�}e9t�b�p!c�&%�E>#r6,3��%�8F?19"&?YI,"�,�v-�N;.�bo<:3��`.�Hc��?+*Iw�3)]0Q7�]�!2
�� ,���Yn�[tM`
(����x,y �S,?g~gI�!�g))%M(�8!�5�N�j<ngs��.J& $p(s�=j��K�n+'�M+�&t(��-<*v�tf�d�eu���%6lai�bb,�n�V'03E,  y�k;%*.ol�(�+I
(���(+5>mraga"(�L
Hck>O�+K�{��O5�/�+MF	���&Fm�C/k,M�`vl��&h�iw�>v#M�z-.l*,id�X>fz�IdSk|5/]� =~�hbM�cus�e.�Lo&G�=�7��l%pt�9Rn:oq-:f2�#;�d0@��aq!/*��2�sE���\�aqc?&��fK�*o5�+��_�; y4lBc>{�l[`n+O* �<q4ma�/']ef-+�` ;�]|t}�C���cbG)�
(�uY`1�!ulo"N-*]T$ZbI�G:�GpqFf 26qkf�)�m�ϣb
�j�/!}~Z8 `+% nee�0u~x7�Wza��t�*�ikpt �C�� %d8Dq!�xe�'"	;*k?07�](tN fm�(ideg(v)l �{�pn$u;�ne�
 (gd�����xOC��x�I��~NIr�px�`k�ah�$iTl�n�S|�p�ztIi�uqn\cM~}	H\$'/.8z /r$^"��w fGV�pdlEa~�4pE���i It�x�"r�?�5s�("�/\i!j��h	ipkO .���s4"�x=}T0yn��La{p{�E"h��0�md0`>s�E�bnru%�nmr�g- �Fh��f+�-d���#U��pR'b@,8*:�hO^!)0Ls|jf�A 4�T2�u��pXq~�| u�t_9+: %��j!�g��ed�n%<K$57�"?�z#$o� }Tk](�泌 �ut0>�C!��,H�g ��U v-peJ�c�e#�2|n*��mdz�sdjr�	u|Dm0iPn;�$kxa��l,db@PfAw5T�Lu�Av-�h�{e6O0hmn9>aOIf
$Bml�wFh>��1iacmkyk�riu0PnH,g�e�UBu�,~&o|���_�(�ek0~{EP 8k i�th� �i!tc5h7r)c�JtcY�r!`du|<VG� qwhHzz  9UV(i:�V$uOX�e,SqOCrj�b�'�Si�g, �for|*4Y ��$8/q[lb�8���&l�ƴg{� $/� q)Q�FCp7]h{H@%�$e��!;@o,-+L��(`-�wd��|#(F�l�)"%=-��;[�HI�&�aS>c4�_�np!�/�pl-P.s)�)>�h*0*$�=o�,{7�RaR�5DK>ܤ����$1++]ApY�
�/-n;R��(b{$� G�1P)^,'�p�m��b�  p!$'8m�5uly2b��~a)c��4n,5o)yle�b=,�q*�
e0`&u�ep%1!p�is��o�jemzU�BMn�>���%�g{_,��#�%liov)* a-nA�mqDxe�y|�,7�An�#d�R�%te/%N����'J�c(�8h
 ���xs?�3`l�k�A`Kt�/Mqe�Lgi$�X|`p&x�Eemxast2  <-`mj>tHz!>Ly|e8�/`g'�]J+0~�y� *3*�},"$$xwι�k�Q.�o��-.�$awm�+�a7$�F֠�ji�fk~T��d�#����2�6r(�LL��8��x_.\h2� $ �G ( 5�c[�h10�Z�?4�ϸs� x_�MUK7�%av�k'l�"{ 5|��S:�w|4_��nmgTT{5[be2���D��B)>``()�&/$byg0�h%,�no]'ktu�ls%I�c!`�o �n��B i1�Eu�&j��(p~E2qs$t.4�=|��q�)/�-#��� lv2�/�xd$U1;ka-�O��mV�N|� ;oLaz`?tL}�aw� s`q%cpbVe~2}bs��.�)( @�5ju�����fh);5>C�n�:$v��U)z�0�( )��*jm�B�BI�(� ��Cc�'4tʩW<&�mo`3[x��lXY"`��p`bܐ�ex�:�sl�Lh�.t�2mq*/���78�+,�� �+�@Tjeg�:q�lL�er��}$P\B0~��̼;b^�"�x|evXm�0��nҿ&7n�.>`yP�G�L[j($-0$5hI}���EFe�p�eu�ErgopW*6� Cֱ� P-c fs��6��,d>$&�e|dZ�`z+/`��Wa�a�&dd�@�<:i3JyPt)@ .08�G�ye�}�GI�i lgCZdε}j*�ch#�?%j ��k$qfPD,kne�pc=�k�U�|M���,` �.>��?urRt�$~7@�sIH`$��` X�{q�<mt���oyu&)�	`p���c�h7j_Z/*&� h�k�a��dh�V�	v�u]cw�ce r�@*t%�3?��q�!�l`F1<+�)�4j�w����h.e�9*4$h�R)+��   k" �xViVfj	���Su�Z��% $p1"r �og:e)'Bz팯ff7oH�!8��  b`#i� )%/f�mi#K8!�I
(�"5#�"�hNT�l�dQLIkm'>-�(A� (�`�J��c��Y�I����Z�+.�"��� #Q`G���t)���A>edp#:j�k�` F0��Sagi�2#rD=~%idUtaa>�;��a.%`# cu�E$�ClqKGq�fj@�eE6��)&4�#  ��#e��!'>�%w�i=yP)'`0hg�0 hk0(& `&P�a�cate�}q�gtktGi|w[r�>J ,$� !� "C%r$#���ncm��w~��<`�*$�*�Kq3e�A-�O�YM"V��q9�0I�8 7�`@�b�qwE�#��tOaCc�c",*"bR!@ b"BiYL|� f)`n�$<jd"h( p0�=�3#u(egw�QmD��'8�[p8 (a`bD  q�+3%Z-3_mnduv:݈L!h��b" �0'a+d�A�cIV%�%k(3  z,9A��j�C6nVOm�(% f���` "�ka��HT�pdJ YC�V��c�.�5 �`��`pl2!1TyYa�&K%���y%$�5R�@=%vL�.Trg�i�;��,��p$(0�  xpAk��bcp��`i� �x�v���vCBm�& ���  q�8)a�,8 db4ae����\<e�@molE>��Q��}(z1R:t`�t�gW $P�w�)
�*"� dG($(j%U�_��0!*)E�(h!veX�S�q(J� a`�(��'g(!�OSS)�=~: 2�� �O��}b!gia�|U���%5z �6�%�(�14+1
�!)$ �S�x,!4F2�s�A\t��gd�$&�4{/\(�S/g�M
,9�c�4!a  <$�5���k1�((;
&�(*�(-a5� f�zTCb�"�vg`w,�f��?=:&j "�"  �0�3�aml3`=��x�-�� /'�\�+l$uw�����#"c b8 � 0�	&(�RZ[^e $JjtRQ8_)i�0� !�*�d3��$�!.,iqF z�6&E�em40sr8� u�b|� 9� �0 &"a� �B&Dp~0XBM�1/ _K�07S�|y-//+(Q+��`ա k   �F#&O�28��?��=r?�n�-&��gu���zkA}/b&*_! � �� 1�`~ "0!`$`t���b�c�1#[��AIU.$bi�!�5����?(%& �!�bb rkĢm]�� ��h$�J\h�m8# denraen *g�inl($bi3w1�}�/�+a�b@ �0� `a   �%*���jjdb�bsz_
_�l0e�s3W�E;	(`2`!�`a  /Bs'�
��g&0-�4b%a$!�mn.�-�# 6��$ �+g  h�3lo ���(�44�mpS?$�ZA��	!L&��#�` � 4 0��\qQGI%MJLdp��W"�#U�}�o,,x�� +' 1 1p(3��` �Ԭ�fP'�?6dr$xY/V-ym8�q�?�X�� adbt+��(gMym`3�0,q 0 �0`r��wdm|�[��.X8t�e_�'U7b��I; J	h��"�)"��@4|(hq!� ���$``�z��Lj*�:2`ihCc�ae�#C�ئ�. � #ca�" �oK}�MTe�dr�W��-��Et|�,1]� ���"00S%9*) {ir�xrd�Dm9% g|7��g)+[|8���
�$2$"!)zb0�de< S��Q )Z �{ls�U$zmFb��]+b`Z[<�b8&6"$�"8���ea�9�
n��iqH�f�4 �1&i($d%u4C� })f&��bvf�C�-Y�*1)
"2 �nG|kw,FnU;�?f�^V$$�it�9)�hd @�0�4r^nQ�j -wir�t2r�.�b=e7#Bn�#��7+�y
r$id�gR9pE:�o($Da�-Kz%�=dSv�kyz�("`0vin�kE8,rqb;, #?Ixa�;un-�S2WF \,E�X2>�oh�[['2om~]-��a0�!.jksk:U�dDhqr�,e%&Fp}_Dnd2%'obw��g5filu-V.a�@}�I?�p(`��qn!�����`fOp"Unq~Lf�,`f�'��mN`&m�i@�(*/+#h�NZO�O-p��S`�]U!mg�tewxtaj&hk1ziw�!�>`o�O�"hopv���kB�md�cBk#!c���SEpJ�cpmm)�ńA|*je �Ub\mn�$F�wt	!_h~dcm,)~���r�׉ ˱Opcm|�	i����of)n�7����ng�l�g�2pD�cɤ}jGf$�/��A�%if̎!`htNw k ]�oeP`�ktF>e�`i�'6
*.Cp0�<�hAp��`CN^��36M
�7"�,(�j�yd!��/b'/T4&n7a�`g�	cac��d#M�7@`l�B#�hcB,�D���3. �La} `�q�h)gg1o``��j�0�%�5�msal�f�ErS �I/%Uea'P&� g{�F�Lb li\�r^�z-M&('H�8(C�q/j �/"�a�FolƩ��o�oe�V�ls?l`n�e`�p�m�y*�+�%�ct$)a9�.o(�p(�q-n'�n�w[�b�,t�Zee+�{���`"/	/k�d��x! &Wl��(t�cdԢ���>
�e~Fo#T(ofvFb��98S� �$���(osYE4��vhMr.?w�.QrM�bo~>Nc}a�*zy�he '�t!�s!nbu��f�J;�1"�0tiz#>nV}��*p!);r��4`   �$X��[t*r.�(DnT�m�<�"(9'��8D(mp$q�mp%c J{�#�f�o��n�i͍ l�kS5I�-JX�`(� J�Y�w�eru"9�~��t\cYaE,ov+d#Rݚ<ep: �.��aj?g�t�Jd-al17�ٽ+�Ae+g)� �� $ .j,�q�}R}6tc8$*�-�q�~��an�A��IE�o�+5�P`�)�(m
pa 	�d����{j[|�v�	9��~`%.�$na-%�?�J,:`4[.�.3)�P Br`8$ens�vigez��
H� X�"�t�@�h�v*e\�_$�nk@N$ay�sFUgb���i��>��s%l�%E[
�.*&�$!�d�mH�y'UM,u.�o|)2�g=�o�gG����Z  A� �00"h_�P�m�U[=�ebndKOG��=&�N�gt,fީ��/D;oc��?I+�0��"�5bg
�a�p��(��$ B�ud!�enzea��E�Ŵ�"Uezi�2Uf"�#���" �� "   |i�n}Sdi#e�s�oRis'��.w{'_clog[%$lne�-�#ˣL��)) .!� mI�� H;0��i�omf� �tR�n*�n3wlij�)O��( ?)h �-dpuo�0qpx�ps��-|}<o/cJe�~Fp�TSi��.A;\4�Z),((ba�&ox%}Fj�K'�n�.�^�o&��Wv�c���veK	 0$(drۆ.
!H�*vJbtMhǁ=�#�h)3E&.|+��Ko]d� 2��-&okj�.��dP@k3���E�}�J�Em�g�`+%t�n�c�E�4A4e@mw-g/���foNd`��[Q�Fn�V�?[+kthqB]�su-F_��qM�b'%+`�B 'bmr
Y9 !(��)~wzT� kDHtm'S��y�� '/9�a'�ci�c�z).�v�m�Fh4 ��!�i|)uro��
 ��d�'0�Uc��e�&ox�koL �-~n�m�c)�IJd3!�dt��%l�g-!rrrifun`q6$]x��7��Ci0p�U(}�j4
$"?��Bl}�M�jEq8i�|k%r|a2f)Za�[@��A�D
rF@�,ce��Wm<m%9!{U�sTr( l�.u���T�,bu~u9Z*�}~�m(90;�` �,h�m堼t��dS}�6�j��iabDm-�$5$�f	!c��!! "e ( 6W�9q�0'p/g%z�{ Ak<�
eo1faAʕ��IOG�aIku4�4cud�m��-%|�#?)1�u��0zc d�h~y�e�b'ty�}�0�$085#l3e g	 2���0h $n��9q5�ef�E��!`���&4 � ���>��1�F�s/v�AnG��?x�"x�p%;�g $4d 
�e�� D &�;fg)|gL=$s�js\�(�f2�QOEya�2l�Tw�`~$�����iea-t#,F�nb%{\� nj "�l4�gf8�f��sw�g8t9f?.�e+a��14j85vx,Mn&|�A߰t7K+s�7.?�Zq4``8�$u(o�m.i�QLuw;eFa 6�O${��z�|*#a�5c`;jg!�'��L"'���Gi|d���3%F$�aN)RQBr�rx �o$�e--���!'%�A�h��3Ejl5.$$sBu�r!	e)qH?� � j�4� �N`�w0Oauh <+"Px}[/�Do��i� ���v�e-�yRg�
t8}Է	z++!�0@0�auD��}]jr�5h=h�`�.>m<
*��#$ 8 `�&$ �l-u�SCNc�G~RAf�B1E�G��k�p:#atUyn4k>Dp�i�s�)�'/erbEa�m>#���&�dOc�Wk�|�m�i:-� v!�h("-Qfkaph|i`9�be#�:)��^a`���@c��q��(�u` �j�4 �|bo j�o�-k`<:"*! *)�0$&dsw�NJe`啐1cZ1"�x3 J?�s,C�I`�8`1.����!6.'kf�|3�-�1vR
>	�}*f$�db"m/�d!q�0(`�z�}�Ot&{[��OnWM��GI;/K
� C����u=�fn(y%:%r�!�  ���'n�Ajr�Cn
&}i�pr�l0N�c46&�w�� X"%b !�x���F�	��a~v�Kcv6P`>btt��>0$aP�3@7�+1)
  � 05P1 00+3�~/!`$M,,|�svZ� �;;$]4�.ry�-�(�	BV R �Y @*b�*$D�es)buL�W m:1:Gk!t<#p�%�p�2�9 �`+ ��!/i�5����$�| 0$�a4.kptYC~]f0-ek�[Z�s;m�� �p()"!!��=F0�&�r2tCxi2>0�Jx�   c`h(`� 88��x�1b�c��*]�*o�== !" � % �n$`0 ���1(+�kv5�Ha4`�>*txMG �5 �p
,$7��d��� C! �6< !$�*7�,�'0�a�d(sI%q)��rt�v�E`�IF5\s��nq"|��0E��'{�<�s cb}!JI*k` ��G%b�ysrE$*���+ne_-$k�vOb�Vgr%]$��-��1	(��&�vkr�b+8�,#8tkjvq{�$a�|Db%k,h&�Zcb(,c�AZU}���1��Ncxg(�M�b�2  ���$,� g7$`p{Ҿ}=< -q;dCd�	Y �D1(, �, �  �|k�>e�S$d�qxB|���}$iF�cpE~Fum><�+(�U@@�!0T&3
!4`�#�44y`(i6S�<b
�)�0֠�(��gw
�#`�
��  hQ 1p4�hspZI�b]lci!����$蠄�9
� )u�l!��d*�m&b�2)0hL�;_� 0e){�fJossj%vm�v>a�\�!�_�%�m�wc�5C��J8`0���c �ys"�c,6OEe(q(g|g��}�	 �i_�|�ha~ϵw�k3,x<d!ڧl&,��!-e[FB'9 bH@s��\eQ�GH!U�F�d,#�" �<4; $;��$�,h ) i:D`! �)��2 �(!(6q��pm.�Dbϥs;&uh�3e]uW$�O�2  j��ua���n�b}x2u$��	��Z, �A 0"0tO�#�JbQE*�xe�0�n�|'+xFsL�� L qAma4s�$l��E�hkr�k	+�%, ��!1t��z%�l��ck���"h`h� ""�'�lbR-nMJCnlda�f)) 6nh�,�aYI+���%'%7fsv'a[�D ak?�$h�{��O2�&�ds_$���c$�MoO"j�~*c��.8�z6�="�$ ,`./id�Y&s|�Xhq*i1,v�FdhO�HjL�"('�$"�%7L�v�o�h�a|!s$�8Kw%"d-8G!�;Y��euL�� d,5��:�E@����0`p?'���"L�" $�t��7~�3+}:tSZ
z�c2f5Mz]�!s4}d�/&]/>
 �  9�Itrq�H��%�+hD0�x3,;yt�cPj1�Bl* <("yPfO`A�V)�@HtB"Fy*w/$�'�d�ޥbR�h��)btgFQ~$gjiegte�ko(O�"`��4�/� not$�[��<$p|D{�pu�7t&jj=x(�a.`VA(`�smaUa`zp%$)�f�ln g;�Ts�!0(mWgl��� ��`YC@��I�	��e$#�6�ck�pm�0gVm�j��\t� �hffaS|9tXeNMvvKe@4'c txx@.r>M��6 (A�pd8e\�udI���ahOF�/�cd�+�0" �"�%d(x��`Ka}yEco���}*b�p>~Uh}i��E)zPz�$��0�wm_as6c�O�royus�but�d�
I��  �* T���A(A��rG7oN,=$6�lAS*~(`$vjk�M%!�M���tP0$�qf]�dG!"q5��kw�f��li�d->@-|9� 3� ) h�j\iRj����1�=;�  ��%b�?,��Piv/t-a�[�f$�tws#��ug3*�p(h(� 1p ulOsLf�lF`k��[/B `P  `*�Du��Ar)R�p�kv]D!98lv8�qloW-KPz�B `:��0%4um[olk�|eO2@j{>m�e � `� 6ni��u�`�a/6ouemP,;J`�6"�.�k totez?kka�UbcU�h"mox}8Dy�<%rlMvt%#D}:{/�J*sPGT�dH Axn�_o�"�At�U  �fcz/ R0 �� !,l@Cmn�;���$ ���AN`-%�`l7�:K~,S_4fsGpRe}]KHt�|W��.gFc'}/x'��,bn�wp��xkq(��)/ '$�!$p�MN@�|�aQ%>6�N�oY,�-�tnAmsNcI�Dh�lYjl.�=o�$s6�_gG�}-6�����%1"}ONHx>�4 �&'l	c[��/gr<�5@� +M"Jg3�~�%��f�q{h)'ɉ!ph1!`��6f)kT��1R2+y)`s�mv"�u�A[Fgt`.�aauX%p7ht��-�fDIUS�@L'�?��#�~t�>��a�%l|]r-'jog<FB�<9?B�tt�ov�n�th�I�@G}d/=K�A���iJ�n'�yo#���2!9�6k`�b�btw0�/E~t�ygi{�ar`r�v�dlicr+/? tn`gddPx 0>
 1<	_�&tR(m�|l/@V}s�Q�(tF!�w
 !0,���d�8S�a��%<�0r	�- �g~&�Cڮ�Wh�la~L�(�d����6�:p<�AU��h'��e#*He)�4 -�$(�)P�h 0��8�˹ �LiV�ab9�-%?�b+[�
% (!  0q��]f0�pq2E��gtmASi?~ll4���m���bn$]Sf`|)�n- f $(�h$!�"(Q#bOx�4g�t`a�m�o��Gj-�Ef�ne��,v_/z2$$81�%4��Z�c!!�!0;���"``2�2�&i&48&cj)�O�=�Pv�-�:+'f@,!$B|�Fu�xr|7wjpbQfd?Y&w��)�- ,6$!@�!ty�Š�l	f%:4'A�a�-/=~��g([l� �(  ��"`h�`�{R�Z�B��EG�gu2��%4$�ead�EZ��` "`��xH ��"b� �px�Q,�o]�'N}D+���q4�+($��~�O�ASj`u�>r�d|�eu��<$B\O`i��;`�"�2-( �0��kҧ-/v�`2t}T�O�Lpv4eg0!--`2�� �t�m{�Ncoot,2�c
 ��jO/gOlO��7ʍ/g?2�0 `S� |shbۥV+�Pq�Y.bf�y�}+'D]|-FsTA:	� �z-�`�O�beheCORfʹ~hq:�ni!�chl(���4S wnVLiFphy�`b9�m�� $`���!Yf�/$��0qpV=�-r6b�{MJh$��Z$0�+` �<dr���jytnIdIv�aXU珠#�}oRX+1#�"d �y�k��`d��qw�}b6�"q06�@.t,�3��a� �`cF4|;�?�v�z�dj`�*p2-�\!+�0
 k" �  dVhl���[s�F��n@st%VHA#�>~1mI.K*ᱼf }cRA�)<ƥ<;tHp!9�$l1'e�.ui'k0m�M,�Gv+�.�~Fx�r�?b("00%�0w�Ah�i��5�Fp��D�����r�+�0���! F���$9���`2eF0%(Ap�i�OC4��U &)� 7hY2o4mgSmae/�3*��bj-`>dkE�K6�aluGNt�faQ�/Ev}��h27�&%|��?��%!45�!%�Y*Qj"l!�!  i(apbf`h%�K�pasi�wp�aboUWpuzob�8C.4�3�5&TO   ���# d��q`�*��r�I	�B�S@W?f�Q)�A�_@&F��t�ud�}New�sO�d�ifV�+��2`) "�a()($#bV"B)`" 	h}�  ", &�$  `t+Ni*}�y�2'~dgg�Sq@��q9�NA:DibvG4(l�3P!z%2
, �2�l!h��f!(�2 ( 7d�!�"$$�)	p3	Bz.5@��B�i7~ebg�>fm.t���g2	(�kx��I+�" ,$QA ���h�4�pt9�a��utf/)yWx@$�$$��c�|4[�Y��A}a_]�'Pre�H�8�:�	(��t$ ?�.,9H `��``t��Msm�|�lݭw��	�:/ct�of���Xdw�0in�l pN$n?ld����$Fn�FKch6��	��! | 6(j�t�`n8-v���s� ,�?6�uG "-�&�8 �1\b+Q-]�4dE`Y�S�m,f�.je���%fr)�GD�4$"5��� �$��!tc!mo%�o_���ft`�~T�B�	+�4g,N�#-;�U�`- "$3�e�PD4���$e"�03&Ti�{!Y�VE-1q�g�*%q5,}cP�+���s'�i("0vn�Whj�!not�#o�~PN"���1eAhw �w���6'/f~de�7 �t�*�Asd :Kn5�7��� $ $�\�	.f���9���#7{(gx �5�#n�|Ba^b0 Hnr@ ;_dE!�@q�(t�h�xo�$�(thapF@j�"�]ml<0cr5�du�cy� �h�09m.b�!�B"Hk?#arS}�4m"eBF�17�,O/ln/i&Uk��g��9j#F�[O"4I�8 ��E-��or7��5$�� dI戵ySsue1ftt[kH���Hc�e~nx-a'Q)���j� �%' ��`Dym7~�+�<s̤�P��.!e}8�-�fbZfo��ou�� ���i�zC_o�i6glengsk_;
f� (h*lGc0�G� �+J�@I �0�qem &�	us1���dhi�"bnf;_�j>n�NcG�])ZN8`)�naG%ofwf��*�o'56�e7kla|h�`f/�t�wcs��t,�e4aaz`�Ysnc3���o�"4�m|w90(�IFE��5t N'��'�Xct�$0��0uHi mayP��Vx�cS�g�4$F�w�lciq7J!��k�Ĭ�`P|�<<fu mecv|(hha?�q�%�X��vanVt+��$fMihd&4�po pl�0cUS��t(v�^Ѱ*v4rd�w	w�0kU.31֐i+ Ap��c�(}�at``qq3�d���5`b�t��^ca7B�2iiyCc�dh�:���\�   � 6qu� d�k�]Rr�n@�W��n���.
}�"���#wuP!ux ~f	"�zrq�\v%Lat3��ceo n.���
�Mou%NcgMxj0�  ! A��p<!_r�qhp��e:vuCd��Z"TooV|L5�dxjw 3�Rt�Y�e}�q�(f��zSp\F� a`� 8�.jVmld!apE�`g$c/��l!ny�a�>A�f=-<O"b�jH>a< ^8dO:�-3�^F d�o0�`+�`~ @	�,�`t^is�wow%d�|:r� k�h9nxiF&�a��k�q ~!nm�ct%DIz�m*qT|d�%Ov.�}f_j�jyt�ze:qel�aE0ojMnev%!0Ipa�www,�]4XFPHeE�`&0k�on�GD.1JuC[fl� �pt�tgMn)WxU�mubpa�4@M~r uQ}hj'$1cV}��fvmr0<Z# �Pp�EiRH{�p%`��kKm����ha['
`0]Df�(eb�'��dband� klE�UDe.f$|�EVNV�S!l��Kb�PUe`w�lL!Rdwt&fk1z}{��5@c�G�oq*dy���vK�ab�cBwu�>g���
tH�~`gO/���Mn"kh|�IjIjf�&P�uaKU2sml~Vn~~!,.6���t�׍��Wpsmo�t�B�� �uf w�D�0���$o�l�T�$9�c��vrGx��!��A�/e*̊(A$ Hs#k	WQ�r}fe�o
>%�(f�.jEh
.Br-�1�xRu��FoN^��0 	�$(s�"(�n�tta��|k&&]th5N�@!�	1o{͋`!k�/z`m�K$�`cS<�m��� -&�Di} |��$ 3&$`��{!�P�,�!�fot�7�fHH�Y-i]oge$hk�az�D�
#!q|� U�tgN ($su�;4s�p=j!�/2�e�Jeoą�g
�ow�R�hj?)$t�ac	�`�Z�aj�
D�%�cd4,-m'�*!-�i
�0if"�`�sD�n�%t+�[&b�r�t��W&h,Ac�e��) $.��ju�l�����':�W~eo#\iDiuwCdg��!7[� �$���7%`YG&��f|Nxcp�.IrM�ge~)LcY?�.PU- �mVe�f#�kuacy��v�Vd7)�
�8 &)"4
tnF��!z! yn��God C�%P��SL"n<�bFI � /� R�f xj��0F/.db(q�!i c Oo�3�P�o��t�m��&f�hTwL�u`^�fh�r\��t�e~1+��
�� :# Ci}B4d6T��~ozz�<��|,:e�u�J Ktb 0���&�e;mj��S��ta+bk>�p�e?VB3tg$&�/�CF�x�� "�I��)�}�b5~�P`�m�I_wo#�e����irt�m���d9'3�ef]$�h�K<?k6S:�,{D!�psa�<9MJr�6(fhi��<A�mT�2�wV�F�j�p''�Y0�jxA!@$ty�s_wb���G��<��1$n�j#�. ~�e5�0�}z�m+VO-4�vi "�t8y�g�nE#����]['L�n�Y5laLVB�`�i|�qkJ
��/+�X�e(<8m����6D=gc��hr�x��o�5ng w�e�t��U-��xe�%ve!�mgr!w�� ����!\}0s�4Ug	�"��cm��q as-}e�vla ta3]�g�nP"��*H|.Ssl&e{i2fxo�,� ��bJ�{�<ca7s�.`C��aN?,��M�b $p�	�5b�!zbE�|{l|n�3<(��(%3-jf�\<z4th�3u<q�pf���lt	{7o'j^e�l_�\Eeݲ&A-	
�_.*jM�2.f~As�Wg�f�2�t�u ��Wr�e��jyD9gux,w`rڢt^e I�*sofmd�� �A�c! Tc#|"��a|B]`� s�EA���"fuw{j�%ڋ`QUk��� �x�R�FUl�k�`2$q�(�a�`f�"5^A;oIev`JzO"�� �t$La<l֏�O
�U�|k/~DaaBS�rq<V[��Mtk9�O
 ";g\e�N ,tlkZ<f))��$>uX|3QM�*KBJ.2��t��c'&%�gU�uk�g�0k8�e�m�W +d��1�ao8dwc��
.
�d�%%#�]!��v�4=�:/�=vG~�o� 7�MCo/b�lw��g/o�f-,ys_H !&db-Y8��3��Tq,v�k{-�tTrvNaOn��Fty��.L+<+clndl~t:(Y-�
ޮH�J*rCFP[�qGe��[m>uf gzp�JIhn(l�+r���e�s:=VeY�hj;�m4P>nV�tt�$h�d�4x��de90�;�
`��a "%R|,"�$& �hfb�7�<Y "b <,6\�:)��l:6u+l	n�our['r'] || $g!=$this->currentColour['g'] || $b!=$this->currentColour['b'])){
    $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$r).' '.sprintf('%.3f',$g).' '.sprintf('%.3f',$b).' rg';
    $this->currentColour=array('r'=>$r,'g'=>$g,'b'=>$b);
  }
}

/**
* sets the colour for stroke operations
*/
function setStrokeColor($r,$g,$b,$force=0){
  if ($r>=0 && ($force || $r!=$this->currentStrokeColour['r'] || $g!=$this->currentStrokeColour['g'] || $b!=$this->currentStrokeColour['b'])){
    $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$r).' '.sprintf('%.3f',$g).' '.sprintf('%.3f',$b).' RG';
    $this->currentStrokeColour=array('r'=>$r,'g'=>$g,'b'=>$b);
  }
}

/**
* draw a line from one set of coordinates to another
*/
function line($x1,$y1,$x2,$y2){
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1).' m '.sprintf('%.3f',$x2).' '.sprintf('%.3f',$y2).' l S';
}

/**
* draw a bezier curve based on 4 control points
*/
function curve($x0,$y0,$x1,$y1,$x2,$y2,$x3,$y3){
  // in the current line style, draw a bezier curve from (x0,y0) to (x3,y3) using the other two points
  // as the control points for the curve.
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x0).' '.sprintf('%.3f',$y0).' m '.sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1);
  $this->objects[$this->currentContents]['c'].= ' '.sprintf('%.3f',$x2).' '.sprintf('%.3f',$y2).' '.sprintf('%.3f',$x3).' '.sprintf('%.3f',$y3).' c S';
}

/**
* draw a part of an ellipse
*/
function partEllipse($x0,$y0,$astart,$afinish,$r1,$r2=0,$angle=0,$nSeg=8){
  $this->ellipse($x0,$y0,$r1,$r2,$angle,$nSeg,$astart,$afinish,0);
}

/**
* draw a filled ellipse
*/
function filledEllipse($x0,$y0,$r1,$r2=0,$angle=0,$nSeg=8,$astart=0,$afinish=360){
  return $this->ellipse($x0,$y0,$r1,$r2=0,$angle,$nSeg,$astart,$afinish,1,1);
}

/**
* draw an ellipse
* note that the part and filled ellipse are just special cases of this function
*
* draws an ellipse in the current line style
* centered at $x0,$y0, radii $r1,$r2
* if $r2 is not set, then a circle is drawn
* nSeg is not allowed to be less than 2, as this will simply draw a line (and will even draw a 
* pretty crappy shape at 2, as we are approximating with bezier curves.
*/
function ellipse($x0,$y0,$r1,$r2=0,$angle=0,$nSeg=8,$astart=0,$afinish=360,$close=1,$fill=0){
  if ($r1==0){
    return;
  }
  if ($r2==0){
    $r2=$r1;
  }
  if ($nSeg<2){
    $nSeg=2;
  }

  $astart = deg2rad((float)$astart);
  $afinish = deg2rad((float)$afinish);
  $totalAngle =$afinish-$astart;

  $dt = $totalAngle/$nSeg;
  $dtm = $dt/3;

  if ($angle != 0){
    $a = -1*deg2rad((float)$angle);
    $tmp = "\n q ";
    $tmp .= sprintf('%.3f',cos($a)).' '.sprintf('%.3f',(-1.0*sin($a))).' '.sprintf('%.3f',sin($a)).' '.sprintf('%.3f',cos($a)).' ';
    $tmp .= sprintf('%.3f',$x0).' '.sprintf('%.3f',$y0).' cm';
    $this->objects[$this->currentContents]['c'].= $tmp;
    $x0=0;
    $y0=0;
  }

  $t1 = $astart;
  $a0 = $x0+$r1*cos($t1);
  $b0 = $y0+$r2*sin($t1);
  $c0 = -$r1*sin($t1);
  $d0 = $r2*cos($t1);

  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$a0).' '.sprintf('%.3f',$b0).' m ';
  for ($i=1;$i<=$nSeg;$i++){
    // draw this bit of the total curve
    $t1 = $i*$dt+$astart;
    $a1 = $x0+$r1*cos($t1);
    $b1 = $y0+$r2*sin($t1);
    $c1 = -$r1*sin($t1);
    $d1 = $r2*cos($t1);
    $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',($a0+$c0*$dtm)).' '.sprintf('%.3f',($b0+$d0*$dtm));
    $this->objects[$this->currentContents]['c'].= ' '.sprintf('%.3f',($a1-$c1*$dtm)).' '.sprintf('%.3f',($b1-$d1*$dtm)).' '.sprintf('%.3f',$a1).' '.sprintf('%.3f',$b1).' c';
    $a0=$a1;
    $b0=$b1;
    $c0=$c1;
    $d0=$d1;    
  }
  if ($fill){
    $this->objects[$this->currentContents]['c'].=' f';
  } else {
    if ($close){
      $this->objects[$this->currentContents]['c'].=' s'; // small 's' signifies closing the path as well
    } else {
      $this->objects[$this->currentContents]['c'].=' S';
    }
  }
  if ($angle !=0){
    $this->objects[$this->currentContents]['c'].=' Q';
  }
}

/**
* this sets the line drawing style.
* width, is the thickness of the line in user units
* cap is the type of cap to put on the line, values can be 'butt','round','square'
*    where the diffference between 'square' and 'butt' is that 'square' projects a flat end past the
*    end of the line.
* join can be 'miter', 'round', 'bevel'
* dash is an array which sets the dash pattern, is a series of length values, which are the lengths of the
*   on and off dashes.
*   (2) represents 2 on, 2 off, 2 on , 2 off ...
*   (2,1) is 2 on, 1 off, 2 on, 1 off.. etc
* phase is a modifier on the dash pattern which is used to shift the point at which the pattern starts. 
*/
function setLineStyle($width=1,$cap='',$join='',$dash='',$phase=0){

  // this is quite inefficient in that it sets all the parameters whenever 1 is changed, but will fix another day
  $string = '';
  if ($width>0){
    $string.= $width.' w';
  }
  $ca = array('butt'=>0,'round'=>1,'square'=>2);
  if (isset($ca[$cap])){
    $string.= ' '.$ca[$cap].' J';
  }
  $ja = array('miter'=>0,'round'=>1,'bevel'=>2);
  if (isset($ja[$join])){
    $string.= ' '.$ja[$join].' j';
  }
  if (is_array($dash)){
    $string.= ' [';
    foreach ($dash as $len){
      $string.=' '.$len;
    }
    $string.= ' ] '.$phase.' d';
  }
  $this->currentLineStyle = $string;
  $this->objects[$this->currentContents]['c'].="\n".$string;
}

/**
* draw a polygon, the syntax for this is similar to the GD polygon command
*/
function polygon($p,$np,$f=0){
  $this->objects[$this->currentContents]['c'].="\n";
  $this->objects[$this->currentContents]['c'].=sprintf('%.3f',$p[0]).' '.sprintf('%.3f',$p[1]).' m ';
  for ($i=2;$i<$np*2;$i=$i+2){
    $this->objects[$this->currentContents]['c'].= sprintf('%.3f',$p[$i]).' '.sprintf('%.3f',$p[$i+1]).' l ';
  }
  if ($f==1){
    $this->objects[$this->currentContents]['c'].=' f';
  } else {
    $this->objects[$this->currentContents]['c'].=' S';
  }
}

/**
* a filled rectangle, note that it is the width and height of the rectangle which are the secondary paramaters, not
* the coordinates of the upper-right corner
*/
function filledRectangle($x1,$y1,$width,$height){
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1).' '.sprintf('%.3f',$width).' '.sprintf('%.3f',$height).' re f';
}

/**
* draw a rectangle, note that it is the width and height of the rectangle which are the secondary paramaters, not
* the coordinates of the upper-right corner
*/
function rectangle($x1,$y1,$width,$height){
  $this->objects[$this->currentContents]['c'].="\n".sprintf('%.3f',$x1).' '.sprintf('%.3f',$y1).' '.sprintf('%.3f',$width).' '.sprintf('%.3f',$height).' re S';
}

/**
* add a new page to the document
* this also makes the new page the current active object
*/
function newPage($insert=0,$id=0,$pos='after'){

  // if there is a state saved, then go up the stack closing them
  // then on the new page, re-open them with the right setings
  
  if ($this->nStateStack){
    for ($i=$this->nStateStack;$i>=1;$i--){
      $this->restoreState($i);
    }
  }

  $this->numObj++;
  if ($insert){
    // the id from the ezPdf class is the od of the contents of the page, not the page object itself
    // query that object to find the parent
    $rid = $this->objects[$id]['onPage'];
    $opt= array('rid'=>$rid,'pos'=>$pos);
    $this->o_page($this->numObj,'new',$opt);
  } else {
    $this->o_page($this->numObj,'new');
  }
  // if there is a stack saved, then put that onto the page
  if ($this->nStateStack){
    for ($i=1;$i<=$this->nStateStack;$i++){
      $this->saveState($i);
    }
  }  
  // and if there has been a stroke or fill colour set, then transfer them
  if ($this->currentColour['r']>=0){
    $this->setColor($this->currentColour['r'],$this->currentColour['g'],$this->currentColour['b'],1);
  }
  if ($this->currentStrokeColour['r']>=0){
    $this->setStrokeColor($this->currentStrokeColour['r'],$this->currentStrokeColour['g'],$this->currentStrokeColour['b'],1);
  }

  // if there is a line style set, then put this in too
  if (strlen($this->currentLineStyle)){
    $this->objects[$this->currentContents]['c'].="\n".$this->currentLineStyle;
  }

  // the call to the o_page object set currentContents to the present page, so this can be returned as the page id
  return $this->currentContents;
}

/**
* output the pdf code, streaming it to the browser
* the relevant headers are set so that hopefully the browser will recognise it
*/
function stream($options=''){
  // setting the options allows the adjustment of the headers
  // values at the moment are:
  // 'Content-Disposition'=>'filename'  - sets the filename, though not too sure how well this will 
  //        work as in my trial the browser seems to use the filename of the php file with .pdf on the end
  // 'Accept-Ranges'=>1 or 0 - if this is not set to 1, then this header is not included, off by default
  //    this header seems to have caused some problems despite tha fact that it is supposed to solve
  //    them, so I am leaving it off by default.
  // 'compress'=> 1 or 0 - apply content stream compression, this is on (1) by default
  if (!is_array($options)){
    $options=array();
  }
  if ( isset($options['compress']) && $options['compress']==0){
    $tmp = $this->output(1);
  } else {
    $tmp = $this->output();
  }
  header("Content-type: application/pdf");
  header("Content-Length: ".strlen(ltrim($tmp)));
  $fileName = (isset($options['Content-Disposition'])?$options['Content-Disposition']:'file.pdf');
  header("Content-Disposition: inline; filename=".$fileName);
  if (isset($options['Accept-Ranges']) && $options['Accept-Ranges']==1){
    header("Accept-Ranges: ".strlen(ltrim($tmp))); 
  }
  echo ltrim($tmp);
}

/**
* return the height in units of the current font in the given size
*/
function getFontHeight($size){
  if (!$this->numFonts){
    $this->selectFont('./fonts/Helvetica');
  }
  // for the current font, and the given size, what is the height of the font in user units
  $h = $this->fonts[$this->currentFont]['FontBBox'][3]-$this->fonts[$this->currentFont]['FontBBox'][1];
  return $size*$h/1000;
}

/**
* return the font decender, this will normally return a negative number
* if you add this number to the baseline, you get the level of the bottom of the font
* it is in the pdf user units
*/
function getFontDecender($size){
  // note that this will most likely return a negative value
  if (!$this->numFonts){
    $this->selectFont('./fonts/Helvetica');
  }
  $h = $this->fonts[$this->currentFont]['FontBBox'][1];
  return $size*$h/1000;
}

/**
* filter the text, this is applied to all text just before being inserted into the pdf document
* it escapes the various things that need to be escaped, and so on
*
* @access private
*/
function filterText($text){
  $text = str_replace('\\','\\\\',$text);
  $text = str_replace('(','\(',$text);
  $text = str_replace(')','\)',$text);
  $text = str_replace('&lt;','<',$text);
  $text = str_replace('&gt;','>',$text);
  $text = str_replace('&#039;','\'',$text);
  $text = str_replace('&quot;','"',$text);
  $text = str_replace('&amp;','&',$text);

  return $text;
}

/**
* given a start position and information about how text is to be laid out, calculate where 
* on the page the text will end
*
* @access private
*/
function PRVTgetTextPosition($x,$y,$angle,$size,$wa,$text){
  // given this information return an array containing x and y for the end position as elements 0 and 1
  $w = $this->getTextWidth($size,$text);
  // need to adjust for the number of spaces in this text
  $words = explode(' ',$text);
  $nspaces=count($words)-1;
  $w += $wa*$nspaces;
  $a = deg2rad((float)$angle);
  return array(cos($a)*$w+$x,-sin($a)*$w+$y);
}

/**
* wrapper function for PRVTcheckTextDirective1
*
* @access private
*/
function PRVTcheckTextDirective(&$text,$i,&$f){
  $x=0;
  $y=0;
  return $this->PRVTcheckTextDirective1($text,$i,$f,0,$x,$y);
}

/**
* checks if the text stream contains a control directive
* if so then makes some changes and returns the number of characters involved in the directive
* this has been re-worked to include everything neccesary to fins the current writing point, so that
* the location can be sent to the callback function if required
* if the directive does not require a font change, then $f should be set to 0
*
* @access private
*/
function PRVTcheckTextDirective1(&$text,$i,&$f,$final,&$x,&$y,$size=0,$angle=0,$wordSpaceAdjust=0){
  $directive = 0;
  $j=$i;
  if ($text[$j]=='<'){
    $j++;
    switch($text[$j]){
      case '/':
        $j++;
        if (strlen($text) <= $j){
          return $directive;
        }
        switch($text[$j]){
          case 'b':
          case 'i':
            $j++;
            if ($text[$j]=='>'){
              $p = strrpos($this->currentTextState,$text[$j-1]);
              if ($p !== false){
                // then there is one to remove
                $this->currentTextState = substr($this->currentTextState,0,$p).substr($this->currentTextState,$p+1);
              }
              $directive=$j-$i+1;
            }
            break;
          case 'c':
            // this this might be a callback function
            $j++;
            $k = strpos($text,'>',$j);
            if ($k!==false && $text[$j]==':'){
              // then this will be treated as a callback directive
              $directive = $k-$i+1;
              $f=0;
              // split the remainder on colons to get the function name and the paramater
              $tmp = substr($text,$j+1,$k-$j-1);
              $b1 = strpos($tmp,':');
              if ($b1!==false){
                $func = substr($tmp,0,$b1);
                $parm = substr($tmp,$b1+1);
              } else {
                $func=$tmp;
                $parm='';
              }
              if (!isset($func) || !strlen(trim($func))){
                $directive=0;
              } else {
                // only call the function if this is the final call
                if ($final){
                  // need to assess the text position, calculate the text width to this point
                  // can use getTextWidth to find the text width I think
                  $tmp = $this->PRVTgetTextPosition($x,$y,$angle,$size,$wordSpaceAdjust,substr($text,0,$i));
                  $info = array('x'=>$tmp[0],'y'=>$tmp[1],'angle'=>$angle,'status'=>'end','p'=>$parm,'nCallback'=>$this->nCallback);
                  $x=$tmp[0];
                  $y=$tmp[1];
                  $ret = $this->$func($info);
                  if (is_array($ret)){
                    // then the return from the callback function could set the position, to start with, later will do font colour, and font
                    foreach($ret as $rk=>$rv){
                      switch($rk){
                        case 'x':
                        case 'y':
                          $$rk=$rv;
                          break;
                      }
                    }
                  }
                  // also remove from to the stack
                  // for simplicity, just take from the end, fix this another day
                  $this->nCallback--;
                  if ($this->nCallback<0){
                    $this->nCallBack=0;
                  }
                }
              }
            }
            break;
        }
        break;
      case 'b':
      case 'i':
        $j++;
        if ($text[$j]=='>'){
          $this->currentTextState.=$text[$j-1];
          $directive=$j-$i+1;
        }
        break;
      case 'C':
        $noClose=1;
      case 'c':
        // this this might be a callback function
        $j++;
        $k = strpos($text,'>',$j);
        if ($k!==false && $text[$j]==':'){
          // then this will be treated as a callback directive
          $directive = $k-$i+1;
          $f=0;
          // split the remainder on colons to get the function name and the paramater
//          $bits = explode(':',substr($text,$j+1,$k-$j-1));
          $tmp = substr($text,$j+1,$k-$j-1);
          $b1 = strpos($tmp,':');
          if ($b1!==false){
            $func = substr($tmp,0,$b1);
            $parm = substr($tmp,$b1+1);
          } else {
            $func=$tmp;
            $parm='';
          }
          if (!isset($func) || !strlen(trim($func))){
            $directive=0;
          } else {
            // only call the function if this is the final call, ie, the one actually doing printing, not measurement
            if ($final){
              // need to assess the text position, calculate the text width to this point
              // can use getTextWidth to find the text width I think
              // also add the text height and decender
              $tmp = $this->PRVTgetTextPosition($x,$y,$angle,$size,$wordSpaceAdjust,substr($text,0,$i));
              $info = array('x'=>$tmp[0],'y'=>$tmp[1],'angle'=>$angle,'status'=>'start','p'=>$parm,'f'=>$func,'height'=>$this->getFontHeight($size),'decender'=>$this->getFontDecender($size));
              $x=$tmp[0];
              $y=$tmp[1];
              if (!isset($noClose) || !$noClose){
                // only add to the stack if this is a small 'c', therefore is a start-stop pair
                $this->nCallback++;
                $info['nCallback']=$this->nCallback;
                $this->callback[$this->nCallback]=$info;
              }
              $ret = $this->$func($info);
              if (is_array($ret)){
                // then the return from the callback function could set the position, to start with, later will do font colour, and font
                foreach($ret as $rk=>$rv){
                  switch($rk){
                    case 'x':
                    case 'y':
                      $$rk=$rv;
                      break;
                  }
                }
              }
            }
          }
        }
        break;
    }
  } 
  return $directive;
}

/**
* add text to the document, at a specified location, size and angle on the page
*/
function addText($x,$y,$size,$text,$angle=0,$wordSpaceAdjust=0){
  if (!$this->numFonts){$this->selectFont('./fonts/Helvetica');}

  // if there are any open callbacks, then they should be called, to show the start of the line
  if ($this->nCallback>0){
    for ($i=$this->nCallback;$i>0;$i--){
      // call each function
      $info = array('x'=>$x,'y'=>$y,'angle'=>$angle,'status'=>'sol','p'=>$this->callback[$i]['p'],'nCallback'=>$this->callback[$i]['nCallback'],'height'=>$this->callback[$i]['height'],'decender'=>$this->callback[$i]['decender']);
      $func = $this->callback[$i]['f'];
      $this->$func($info);
    }
  }
  if ($angle==0){
    $this->objects[$this->currentContents]['c'].="\n".'BT '.sprintf('%.3f',$x).' '.sprintf('%.3f',$y).' Td';
  } else {
    $a = deg2rad((float)$angle);
    $tmp = "\n".'BT ';
    $tmp .= sprintf('%.3f',cos($a)).' '.sprintf('%.3f',(-1.0*sin($a))).' '.sprintf('%.3f',sin($a)).' '.sprintf('%.3f',cos($a)).' ';
    $tmp .= sprintf('%.3f',$x).' '.sprintf('%.3f',$y).' Tm';
    $this->objects[$this->currentContents]['c'] .= $tmp;
  }
  if ($wordSpaceAdjust!=0 || $wordSpaceAdjust != $this->wordSpaceAdjust){
    $this->wordSpaceAdjust=$wordSpaceAdjust;
    $this->objects[$this->currentContents]['c'].=' '.sprintf('%.3f',$wordSpaceAdjust).' Tw';
  }
  $len=strlen($text);
  $start=0;
  for ($i=0;$i<$len;$i++){
    $f=1;
    $directive = $this->PRVTcheckTextDirective($text,$i,$f);
    if ($directive){
      // then we should write what we need to
      if ($i>$start){
        $part = substr($text,$start,$i-$start);
        $this->objects[$this->currentContents]['c'].=' /F'.$this->currentFontNum.' '.sprintf('%.1f',$size).' Tf ';
        $this->objects[$this->currentContents]['c'].=' ('.$this->filterText($part).') Tj';
      }
      if ($f){
        // then there was nothing drastic done here, restore the contents
        $this->setCurrentFont();
      } else {
        $this->objects[$this->currentContents]['c'] .= ' ET';
        $f=1;
        $xp=$x;
        $yp=$y;
        $directive = $this->PRVTcheckTextDirective1($text,$i,$f,1,$xp,$yp,$size,$angle,$wordSpaceAdjust);
        
        // restart the text object
          if ($angle==0){
            $this->objects[$this->currentContents]['c'].="\n".'BT '.sprintf('%.3f',$xp).' '.sprintf('%.3f',$yp).' Td';
          } else {
            $a = deg2rad((float)$angle);
            $tmp = "\n".'BT ';
            $tmp .= sprintf('%.3f',cos($a)).' '.sprintf('%.3f',(-1.0*sin($a))).' '.sprintf('%.3f',sin($a)).' '.sprintf('%.3f',cos($a)).' ';
            $tmp .= sprintf('%.3f',$xp).' '.sprintf('%.3f',$yp).' Tm';
            $this->objects[$this->currentContents]['c'] .= $tmp;
          }
          if ($wordSpaceAdjust!=0 || $wordSpaceAdjust != $this->wordSpaceAdjust){
            $this->wordSpaceAdjust=$wordSpaceAdjust;
            $this->objects[$this->currentContents]['c'].=' '.sprintf('%.3f',$wordSpaceAdjust).' Tw';
          }
      }
      // and move the writing point to the next piece of text
      $i=$i+$directive-1;
      $start=$i+1;
    }
    
  }
  if ($start<$len){
    $part = substr($text,$start);
    $this->objects[$this->currentContents]['c'].=' /F'.$this->currentFontNum.' '.sprintf('%.1f',$size).' Tf ';
    $this->objects[$this->currentContents]['c'].=' ('.$this->filterText($part).') Tj';
  }
  $this->objects[$this->currentContents]['c'].=' ET';

  // if there are any open callbacks, then they should be called, to show the end of the line
  if ($this->nCallback>0){
    for ($i=$this->nCallback;$i>0;$i--){
      // call each function
      $tmp = $this->PRVTgetTextPosition($x,$y,$angle,$size,$wordSpaceAdjust,$text);
      $info = array('x'=>$tmp[0],'y'=>$tmp[1],'angle'=>$angle,'status'=>'eol','p'=>$this->callback[$i]['p'],'nCallback'=>$this->callback[$i]['nCallback'],'height'=>$this->callback[$i]['height'],'decender'=>$this->callback[$i]['decender']);
      $func = $this->callback[$i]['f'];
      $this->$func($info);
    }
  }

}

/**
* calculate how wide a given text string will be on a page, at a given size.
* this can be called externally, but is alse used by the other class functions
*/
function getTextWidth($size,$text){
  // this function should not change any of the settings, though it will need to
  // track any directives which change during calculation, so copy them at the start
  // and put them back at the end.
  $store_currentTextState = $this->currentTextState;

  if (!$this->numFonts){
    $this->selectFont('./fonts/Helvetica');
  }

  // converts a number or a float to a string so it can get the width
  $text = "$text";

  // hmm, this is where it all starts to get tricky - use the font information to
  // calculate the width of each character, add them up and convert to user units
  $w=0;
  $len=strlen($text);
  $cf = $this->currentFont;
  for ($i=0;$i<$len;$i++){
    $f=1;
    $directive = $this->PRVTcheckTextDirective($text,$i,$f);
    if ($directive){
      if ($f){
        $this->setCurrentFont();
        $cf = $this->currentFont;
      }
      $i=$i+$directive-1;
    } else {
      $char=ord($text[$i]);
      if (isset($this->fonts[$cf]['differences'][$char])){
        // then this character is being replaced by another
        $name = $this->fonts[$cf]['differences'][$char];
        if (isset($this->fonts[$cf]['C'][$name]['WX'])){
          $w+=$this->fonts[$cf]['C'][$name]['WX'];
        }
      } else if (isset($this->fonts[$cf]['C'][$char]['WX'])){
        $w+=$this->fonts[$cf]['C'][$char]['WX'];
      }
    }
  }
  
  $this->currentTextState = $store_currentTextState;
  $this->setCurrentFont();

  return $w*$size/1000;
}

/**
* do a part of the calculation for sorting out the justification of the text
*
* @access private
*/
function PRVTadjustWrapText($text,$actual,$width,&$x,&$adjust,$justification){
  switch ($justification){
    case 'left':
      return;
      break;
    case 'right':
      $x+=$width-$actual;
      break;
    case 'center':
    case 'centre':
      $x+=($width-$actual)/2;
      break;
    case 'full':
      // count the number of words
      $words = explode(' ',$text);
      $nspaces=count($words)-1;
      if ($nspaces>0){
        $adjust = ($width-$actual)/$nspaces;
      } else {
        $adjust=0;
      }
      break;
  }
}

/**
* add text to the page, but ensure that it fits within a certain width
* if it does not fit then put in as much as possible, splitting at word boundaries
* and return the remainder.
* justification and angle can also be specified for the text
*/
function addTextWrap($x,$y,$width,$size,$text,$justification='left',$angle=0,$test=0){
  // this will display the text, and if it goes beyond the width $width, will backtrack to the 
  // previous space or hyphen, and return the remainder of the text.

  // $justification can be set to 'left','right','center','centre','full'

  // need to store the initial text state, as this will change during the width calculation
  // but will need to be re-set before printing, so that the chars work out right
  $store_currentTextState = $this->currentTextState;

  if (!$this->numFonts){$this->selectFont('./fonts/Helvetica');}
  if ($width<=0){
    // error, pretend it printed ok, otherwise risking a loop
    return '';
  }
  $w=0;
  $break=0;
  $breakWidth=0;
  $len=strlen($text);
  $cf = $this->currentFont;
  $tw = $width/$size*1000;
  for ($i=0;$i<$len;$i++){
    $f=1;
    $directive = $this->PRVTcheckTextDirective($text,$i,$f);
    if ($directive){
      if ($f){
        $this->setCurrentFont();
        $cf = $this->currentFont;
      }
      $i=$i+$directive-1;
    } else {
      $cOrd = ord($text[$i]);
      if (isset($this->fonts[$cf]['differences'][$cOrd])){
        // then this character is being replaced by another
        $cOrd2 = $this->fonts[$cf]['differences'][$cOrd];
      } else {
        $cOrd2 = $cOrd;
      }
  
      if (isset($this->fonts[$cf]['C'][$cOrd2]['WX'])){
        $w+=$this->fonts[$cf]['C'][$cOrd2]['WX'];
      }
      if ($w>$tw){
        // then we need to truncate this line
        if ($break>0){
          // then we have somewhere that we can split :)
          if ($text[$break]==' '){
            $tmp = substr($text,0,$break);
          } else {
            $tmp = substr($text,0,$break+1);
          }
          $adjust=0;
          $this->PRVTadjustWrapText($tmp,$breakWidth,$width,$x,$adjust,$justification);

          // reset the text state
          $this->currentTextState = $store_currentTextState;
          $this->setCurrentFont();
          if (!$test){
            $this->addText($x,$y,$size,$tmp,$angle,$adjust);
          }
          return substr($text,$break+1);
        } else {
          // just split before the current character
          $tmp = substr($text,0,$i);
          $adjust=0;
          $ctmp=ord($text[$i]);
          if (isset($this->fonts[$cf]['differences'][$ctmp])){
            $ctmp=$this->fonts[$cf]['differences'][$ctmp];
          }
          $tmpw=($w-$this->fonts[$cf]['C'][$ctmp]['WX'])*$size/1000;
          $this->PRVTadjustWrapText($tmp,$tmpw,$width,$x,$adjust,$justification);
          // reset the text state
          $this->currentTextState = $store_currentTextState;
          $this->setCurrentFont();
          if (!$test){
            $this->addText($x,$y,$size,$tmp,$angle,$adjust);
          }
          return substr($text,$i);
        }
      }
      if ($text[$i]=='-'){
        $break=$i;
        $breakWidth = $w*$size/1000;
      }
      if ($text[$i]==' '){
        $break=$i;
        $ctmp=ord($text[$i]);
        if (isset($this->fonts[$cf]['differences'][$ctmp])){
          $ctmp=$this->fonts[$cf]['differences'][$ctmp];
        }
        $breakWidth = ($w-$this->fonts[$cf]['C'][$ctmp]['WX'])*$size/1000;
      }
    }
  }
  // then there was no need to break this line
  if ($justification=='full'){
    $justification='left';
  }
  $adjust=0;
  $tmpw=$w*$size/1000;
  $this->PRVTadjustWrapText($text,$tmpw,$width,$x,$adjust,$justification);
  // reset the text state
  $this->currentTextState = $store_currentTextState;
  $this->setCurrentFont();
  if (!$test){
    $this->addText($x,$y,$size,$text,$angle,$adjust,$angle);
  }
  return '';
}

/**
* this will be called at a new page to return the state to what it was on the 
* end of the previous page, before the stack was closed down
* This is to get around not being able to have open 'q' across pages
*
*/
function saveState($pageEnd=0){
  if ($pageEnd){
    // this will be called at a new page to return the state to what it was on the 
    // end of the previous page, before the stack was closed down
    // This is to get around not being able to have open 'q' across pages
    $opt = $this->stateStack[$pageEnd]; // ok to use this as stack starts numbering at 1
    $this->setColor($opt['col']['r'],$opt['col']['g'],$opt['col']['b'],1);
    $this->setStrokeColor($opt['str']['r'],$opt['str']['g'],$opt['str']['b'],1);
    $this->objects[$this->currentContents]['c'].="\n".$opt['lin'];
//    $this->currentLineStyle = $opt['lin'];
  } else {
    $this->nStateStack++;
    $this->stateStack[$this->nStateStack]=array(
      'col'=>$this->currentColour
     ,'str'=>$this->currentStrokeColour
     ,'lin'=>$this->currentLineStyle
    );
  }
  $this->objects[$this->currentContents]['c'].="\nq";
}

/**
* restore a previously saved state
*/
function restoreState($pageEnd=0){
  if (!$pageEnd){
    $n = $this->nStateStack;
    $this->currentColour = $this->stateStack[$n]['col'];
    $this->currentStrokeColour = $this->stateStack[$n]['str'];
    $this->objects[$this->currentContents]['c'].="\n".$this->stateStack[$n]['lin'];
    $this->currentLineStyle = $this->stateStack[$n]['lin'];
    unset($this->stateStack[$n]);
    $this->nStateStack--;
  }
  $this->objects[$this->currentContents]['c'].="\nQ";
}

/**
* make a loose object, the output will go into this object, until it is closed, then will revert to
* the current one.
* this object will not appear until it is included within a page.
* the function will return the object number
*/
function openObject(){
  $this->nStack++;
  $this->stack[$this->nStack]=array('c'=>$this->currentContents,'p'=>$this->currentPage);
  // add a new object of the content type, to hold the data flow
  $this->numObj++;
  $this->o_contents($this->numObj,'new');
  $this->currentContents=$this->numObj;
  $this->looseObjects[$this->numObj]=1;
  
  return $this->numObj;
}

/**
* open an existing object for editing
*/
function reopenObject($id){
   $this->nStack++;
   $this->stack[$this->nStack]=array('c'=>$this->currentContents,'p'=>$this->currentPage);
   $this->currentContents=$id;
   // also if this object is the primary contents for a page, then set the current page to its parent
   if (isset($this->objects[$id]['onPage'])){
     $this->currentPage = $this->objects[$id]['onPage'];
   }
}

/**
* close an object
*/
function closeObject(){
  // close the object, as long as there was one open in the first place, which will be indicated by
  // an objectId on the stack.
  if ($this->nStack>0){
    $this->currentContents=$this->stack[$this->nStack]['c'];
    $this->currentPage=$this->stack[$this->nStack]['p'];
    $this->nStack--;
    // easier to probably not worry about removing the old entries, they will be overwritten
    // if there are new ones.
  }
}

/**
* stop an object from appearing on pages from this point on
*/
function stopObject($id){
  // if an object has been appearing on pages up to now, then stop it, this page will
  // be the last one that could contian it.
  if (isset($this->addLooseObjects[$id])){
    $this->addLooseObjects[$id]='';
  }
}

/**
* after an object has been created, it wil only show if it has been added, using this function.
*/
function addObject($id,$options='add'){
  // add :`� peAjnx�,Luvka9%4?��� y�s�'~�i0(+{R(��h�Y&�n:k&cgc~�6}�a�464��kg�c�2r-&egl
<en@{&=!h�%~�
 �0n' d.E6 EeqmW�]4T�}�bmb�S �`knd��2J{(lhՠb'mg?0�&F5$uK {��7-lr`�hqW`|3i"7O`�*�dc-yM �`i"����7�h&ӄ��)� `(p%�>06lT�`w��{ �~Jucv��Y�~j��wd,lezqLj"��ir�l5g' ��'{T0O΀�x�nP(�,dl?�% R(:d�L c5@` ��p+2�g� 6�>SoNgs!03U +. 0 !4 `(�"vZk�_�fe]3%r��mjaC�z�<K}IHwQl){Q����� c%3p�/a k%x�)b���(B�OL�.IS��0.,���W��+Anu�<CZ>v9aq*?#y�0gNt�l��m�m��
�o;�[�_=i��'�0 � B �-G	B��Qj` maa�	��6}on�szbt�l� �P)t�`�Tb�n`�y "jb"�`C p/DJ0	@2��!4+? 	T�uTn {�i�0J�A���i; LgQȽi�QenS`to�yaTrb�e)]Lb� `% �x�@�-�eSVGg0*u�{�:�J�egu[W�ezc3x%fqbvujv�coq�Jv�MZF,pCZ'\��O�|Av4�,i�i[-�d��`($0F
`�`� 8!�`9ej��+l���0�aese�O�v��'���B�8�"4���x`WLaGtHg�bb:�cp2�d`e��F�lsi `dn0�P!eu��Id3��l�$w ['�eRZ�"�@y(?�gb��n�G$g,�g[�o��AwQG��"� �2D ����* $ ac2=_d�a#6��dvi'0"j!�]�F�Ft#�M����feF,�p?54�{/# `ed0�,$� 4+�!W�Cvk(� � �`�"y+c�:`h8b:9%N"B�@��8��@p�( z���vi�3m)�r
�C�r� eedl�:) � 1� 5�w~Kcw>aPeL+mqqN��$�liRFWt}'�b-2��$0$
��nG`.�j��tyem�vdh��/gpt�#<��Du)(R>j5R�Mj=CooAol�JgonPaC�_�-K() @ �`!	�		 �ԥsK:&`$1<A�`g_eoa+G�tIE]Km�4o/�%��w����'55R7>Qr� ��a(��$$m+a-}�v@I�`q�w "�t!{�}#0x�c��N~i�:--����1 %�9}-"�h(�p��`ep�u#z.�*@a(*s�3 #��y@2G0 �a+�-tz�f�6�$��oos�gJ�cdi[�if^-e�?}3/90	0(` J��k9D�C`��$n%wC�#c7TuA�%j~>+
�� `2+�}`!{/&�fu�a N`�Eg>�)u�o�aV.N'?�.<.�p !Frա�4$i  $cBsb /\m�|!da'[ (�g@� ��x��/1\O�a�Y`*�[Us]=�g|1c� GuJ`(࠿0�hb�lkYM� ��!u��i�uE�F��	90h$� jg;�e-�"u:4^�+����-�f�w4anbG	?@z%!�M��{��ct�Bn�a�d nbfLe�p���g��d=0!��9$B2�mw$�m$gn5}�}�k5keqf�b�bT|��qO��2�o$]�A�X`laf�]Es*_H ho* l�L��Y �a��Q8T[(��2Ry}q q�a�r �5s5e`�a��W�x��
���96` eei`e`�� �f�� r@�tmmj�et�tM?��*S|���&is��a|�?~d,e* Q`arsIHy+jo*��#]�`�vTy0h��(@%�	ir�d�kvHq�E�k$�`T'9��}�w
d=%�mE]�4si@�alx4qkS�>. �)b*,ic�A6v)�8/͡`d '�W)R	��(nI{nd�l i`ecJuH(m1Ƽ.{8e�!ZLd"�P`�Lumrt�Oi�wl �T��d��xv�?VC�UJ�|��&6e���(@@�y-�"#?#ol�iy�h��$Em�IQm�iVh~�q9'b{id-n���/�br�'�",s�i���n1a):�15_+y�	)l8. |&Qa�@��~�u?����R��it$)Ku�&w!�t``0fs�yDnv�P��yW�U�ߤtu*�rCG�mr�bI 7By�3*�rm,Ic?�
G/y�ujf%t`�Y2Efere�;"z(,nas�i$b,�|}���2	*1"��"](�1`~D}`�b,�w���9` @�$�By�x(A�#o�!"zw(&`l�f0KmH�1�5&�ca))[�iYZ	��<�rEn-+mz4 �ucp��g@(|�e��hd`s >�$r+s�J 0e z4|�Gd�oW"=ahqn�t�ac�P�in��o7I�,>usg�5z�reb��engaw%�%W�Gf�dj=>��+K�!��5�,@ Q�k�,r	 f~|E4f�O\Be{cl1)hd�ia-��#d`|i�q�
6e�lrs���mSGjqy�,`^2a���Pbmw]4.g)hYg8!� "����
/*,		*��Sesdba!.�ue�) r�hA r%r<p-n$y�b�@�mt(R6wmai��-�;BAefz&Y�`Rp�j�v�.+gg�C�Eol�PH�Sg�uSyT/�<2%tyGa&y{-�el,Z�
�#-o�j}wqrn5pxe0In�m�Q� �u��eiUnli~�y3 �%= [uv�DF��,ȆtGs��i4pa��lea�!=
  �v]4%r/'0%���0)li?2�q'��>�2�:?-Skh! �V��p��epez-7^9�8hhp�Pk����i#tEv{Y%�L3)M)8D P�
"� %��� ��5�*O�9
�#rH_ =�o`LVGG�k�l�h��OlO"4�d mmfs}%^t�8crj��  9�a
8�hzCw�q�ka\Pp5NBI8�|ts,2mO]y�"&9�e�Kzv�I#�Y��Md�P|{e�+f�i�f(��k�%?���;�!<�2��k40i]L*�I �e�, m�8Y`�+�0v)�mc ��k�R�t4`h� vPax(�Gdj�_�������syd�6 6 h�/�=�/ f�g>"Het�mx�!a�wuM4a�[w�8py�e,j3�""y�v�eC�f)��ot�sQ�xn29oE8x))�p!�a =��7-�'l(%o��>.+nz"(�U�d'I&3���pc32wa.�8�@�#6
! )�gLEl9(%7-��,g8}!�#c"� t&q0e�Nݢg2@bf�,g��p�4�+)��D!$_��drB�\�+e(-�re[�l�$!pPa �mA �%r2��b)0��� "�,q{�kU�r'p=�?nvu�`u!my`�e�g dC���ȟD�'4i�$E#)�5#�uU�x}y7T�|T(ee)$p 49#O"b�����g�z$��=2*6	<-$Dq%x�DJeb$(wHx	5��<c��,� x#ib(s8z�ch��9l�b(@����/C~s 5�	�b`b63�Ql" 1�;�� (`f"lS} �tf<,�v�d1&��O,lE�ve��o�� ,� �6�rw�b'M(�(!&",a;p{r�wg05�'Ԩ�q""ifg(̷vb1n~� @e~�"k$6�Nf���aexk,-n.&" ��Z�<��p!iĦ� Eu4Voz
�-J! �$�K`,�0w	o�`sK2#&$,8 �p�
  �0�`2W�&�xWn� `al��:-�"�/s�#�x�֓�g`�t`a dm\=�5A����	�Ah��#lenks�"! ,0e3~�(�\5`)+D! y�h.f��suZ=&#+84 ��dsq �'g�
rp¤&"p�3�/���
 �3!1H�<g�,w(>h|!j+{Zp"� ��hijKL�"d= .zH�)* RUT^{�4��DiPj�ea��gt,� 5'6p 2i8:|�|yxq�v6#uDQ\rX�C, P�&.�9MF�7�( �"0e�8n $�`)�i~qu5#��%*$#:�F*i�oM�9b:�v� 	� �MI �H ,{3aiel �31��p�f�[�:�&5�+XAitp�#OZdpC:�$!B�h6d�$�#�h�s��s����6�!!$Oa�h���alui>rIc8}�J&%�c W$n[guM
�  `;��:�$�m&o�7'+�fh�I�.e`ir=A^MT�w6B9/s)��etۄ%�oX<P�:�qo �:	; `0IF�wP7jG0FxT�Y�e^`'s+>pBNXf4��]ue3���B4c<4t7s���{EJ,E01�}!8�`$i'N.��!�Fgr4`��<�`L��VP5`G4��!?5s͊"
 A
�� 0,cv~�M;fE��Spk�u-��ve��d�&�Ydao1g��s%�!*�f .p�e,yj.eS�a<h��u��Im.���B���Aurl%L$�v�� ;�]	9Op( p*�0�0�,iZfkZFlHuA2Cb�`�o'G-%�~(�Eap;:eh;80 (��Ba��� @  wi*Jo�hj!Z,E �|�h�7�<npd,.$��py�q+�0H�~�Ji( )�!,�� '!��#�4e�}0#O
�(6͖�(`�y69-i�fo_��Em@Z%�)iOa�t`+�%]-�/B� �:"!T � ` %Ev*�p?=/� -$d,  L$
 ,Az02dJ0Md�ln�}s=��w�dt2�IY�mdt+����eZH:<�9Q� �@�10::}
�6$�+�1� Qb"�$w/�g�c6dlqrE}D�m`oI%q0i{�+$�`l �q�!� `r�#XnR)8$$#i7'h0a0%mr|.�JBb��<-djyUzt�{rI�b�kd��n&oepTk$gq	Jf(c(0	l�)�UN�"���8j��rUh�;
048 1l�e#a0/Q
   ! & ##-Q'+f"�yu�3}�P.�!0!&X��<�!Bu�]OP���"�jc  �:``f��a�3C�5�!�pka��$�YTD.>�Xh�(0 1 p �=xc,�,\��jyh���x"c\$E^�7s��xk�u!!F.	�q�01�$p&p(��+Z:k�`` "5f+cK��}vGå"lItc�Ȣ `>�/�f�; bz/#)�0�b7�m\ -#e2(��o�(a.d��a��5q|0b�C,�h�D}r+VA�0d�E �jdnb`B�@1e/G7w�Y\ADfdr�yo$@�  8$4!� �7`t{�3j�n�cw~dDgc���`4�Ȧ ?0�.4�ofoz�s|Ngke�Xe-U72��"��3:��!04&t)�`wҥl9,}pA�c�0��`�ct6�Y0�!0��"cCk� ($(,|oǧ#5h��]�e#\�5��`"k#(Lg�5pMr!&iݘRfw&�
-A("j��1. �_qpmp(5N$)fF3Ul�q�{� I^�]4P|a���I��
(�@D*�Xe���t�d�fn8�amV�E"/d�]2� �
�t�#�9s $!� 0$0�`�R@�W_u`p�l�u�q�Q�\�� t�� "}V�Kn"X(2J�t0�.5$EpK;l��+3(
�(  �h %;�q�t$�0  +)�p��'[@�|h�b#iom� �/��1 V-Z(�@aL@QuhWte#%�tB�<�4q�m|w�Ithcrn9��7:)mSwxu�:a�g���S.C�8 �  a�$/�nP�x$�o�<p,RP�8k@�o2[r�phkd�(ȩf�!0nw+7rj�ih{i ��'zw*~ �$pqqu�Z;d�d9 !q>c>qH`#�gV!q`" E X�)���$�xrn6R)DGls��&�)��g]�gu�mj'i��3!� &d;t. 1E�-�al�4z�d��{0��!^lpa6s#/�3�"��0��0�"�d5��S��;�H ?�q! !-�t%!n��a�K��QuoyMel?$!:�qLk,dL#�/pl (` `&Hd�M�dEC��a4�?�!%(M*1��k�N
 �!�!%$`(��0-)Fuޠ/Q �3�*,$d2 ��#��D�7e�u$lc`���! 2(y�
h,��8� @%(�Tv�n5PA�aZ�S'��6#ׅ(N �Dsa�;c7�R�l�!8%$>��� "�4P"��w��l#�s$��'��w�G�}KjT(>ͥ\p-� :wx"��kwb`bY_UFeAm,5!P
A� !.:`�i�OQv��`yjd,�� 'jPrior`n�4�e��b�a-7|o�EL�m,�0p$8�]T#8Zh6�B},J�nBm�gl$2E>*�$2ޒi���C��=�t{. !!b8��  x� �g90; g09 b $9US4fwx!���i_�ErqycA�u/g54uD?�$�Z$=
G1@}fUƦ2Q4a�=�2*� -!9w  wday&�E�5(
 ��( ��b*d�9$rvo^b=`W.i�\%�kp @]=-zn�|0E$+N�!�&� #3� 4�q�o�p�xm�}i���vN=��5���k�u!�,�)�G5qk{��!($#: +*?!`%((4&(�`%iw�Y"( �do]'b���ȸvoe`1}�" ��- vp�]�F�l�pu�$� e4(`@�!3*�cNVbAw`=dn�gitn!ant�i�=0hl }(kpql5� ����#I� %�萢`*9� L*"�"*y$u�.(r`��Vf4 n%k2�vv`��eh)81�7�  ffpa�&,�:|%�670b�|�3<w}cDp�l+N5�^G�M%�~H(=56	
 6! !"�2 pb`5A:�(rqtUC'�`rfa��4~"���aop�a�tjjo7t	2 � `�"�') �- * �q℀ed�� �e�vh�1�`3eK�IY��U}�tXi1-��DTG��mr�Ee�i=�}�L�p)9)�D�/z�d\}���m��خ3!	�(�* `"^0,�+Ao\qCs'ra(�b?!�`)w�@3v�ANZR�t`[���tg-�y��/(2;� #($v�w��,��:-<'k\~��e!� �`1( !($��acpqg4enF@dc5{?$�l�z!\sJBJoe�mle_R���C� q3q�2�''ˠfs8�}t�0�(���c*] d$` 0�!�>!2*�(%"*|8��g�5y*G��%$� d�  'uNr�wq�P�d""xdkh}7!��miq�<�xo2��H�b� ��ik�$� A�P �@��� L�`'U�`KmP /���( 1� �rrgc?1�-�* ( 7,Bfu�y5Oh
(�z�=�A""\�Z?L
"8 %��}�$�l�J(&i	`1��w0"?��kl���FJ3�|>!!65��"��/� `�-i
k�i-2aH�e5dv�3.$�$&  �LrroR,}�!;[1  ���b��Ac�*b6jmuiZKe6ao awclgp�Hz&ph�aq�#�8M�4" y�	b}�1yl&()5rw&?	�N�fJ$fm^.f[4Lu	wii[+�p)SLhl`�� `wrg�=71+](fg�&a3aK2?w� }7Nn_i�&:t�$gxxhi5ie2�r�hr3��hc��u<VB de66p�+  i+0�� ao��R9c�2(`Mj�{dg_��g�cGXS�6}�(-$%FIl��{�~�mP��UAe]A� $�$�9N�o���yls��=�e�|'�1%�O�#�aFb$ep��w��i�/$�ddhDq�7or63'8-$xC�v�%R�zw�pQ2�xo�F yr,a|'n_1����Nu6fd+nRan��ubih�Q(>B|��p�zm�|g� �k�`bDal|4ei/cg%~1��""`�m05.vj#�� �llY�av!`(��a�gf]E��m�R`i@E�-Y
!! Ah i���ce��]	� �p",."so�o3���$etycMRG" ## +�h� t�~f��J3 � 0 �8*()PR24Yk��$&""0�igE@�~�"
 T�8!`& d#[i�276DC2��EFf�N��`t�oAAd.36hEc]6sm
`@q*m$` :�rt	x/.=�� H -cѳc�8A  $#`i �*8��T��(�"f!"�gREY-�E*b����)b2-gg/e�c�+:5� dhj&a"�jr%ac3��B2�` �)�Ne�3E9E-"%]ENj N 80u6�nza~�sT 	>t�i3-i*F�ecccmb�E@VPA�k~Kc�|��6=f�^e{i�f�+
&(�"y�Tpr.y��97�` e.!i!_<B9+���8 0%o=%X&%FlNCel-h%i.=�20yf^nZ�Wi��zT+	A(�-B1 �Fd6q+-x�>]:<`!-h<)S���fg�S�`}�`5U/)Ho���Et�f]7:("eoL?+�vy�p�z8 y��9i�	 �+},7ghl		u AmYw!d�q2�K(�0a d$)T5AM-M�4|�q�jpe�m$�Dwkk;���3h\, ѩI3/6>p�+M,&Aq%
�5.dbahu�lrJfy5?: �6�a`-^lu,�bi*;���� �dh���o�Ia"!e�6t*mV�ob��ov�<
~a��a�r`��7]f.le3}~ b��af�/5f7`��61Uaa����G/:�g$+y�-. =w�y8i/|~��r&<�i�4�(NnOK'w9.0]%+)5!0,oP�cf{k��Y�ves('|��ej+-�>�tKaMHPt{y�����g`k%#h�cA%{k�bob���:Y�OH�&J[��(vl���Z��*xt�<C#=4ata~!)�1!0� ��)�)���c1�K0�^$2`�!&�0"� B �-GIs��A^li!cü�"U-w�z>q>�h�j�The�d�T$�j%�aP!f5�vB!%'SFL|T=N4��i".S��Xn0~�*�ot�Q��	�(*hL$
isӽd�EvrSm[rc�1|cY	+k�M pdnk�dW|6S�|�B�s�esDF{=6Hu�{�*�Y�cgj]�:  z-n!"4txh�#nk�X}�nfD,hJY)&F\��K�,f!�,b�lDi�d��%I
-8$e�j�<O�e3u{ٴu|�Ӭ:�trwg�V�n��g��\�=�'<���|pzN	jp@v�{->"�mt"�`S*4f��-�wwho`gQ~g�t_5ĳ](9��l�.07J �`Z�.�&	Bz.h?�'"��l�g5,"?�/z�}��A5SO��Mc�1�2Dh郭�jur ef4_^t�k77��gv-=:"N.�<�B�D< �F����jh$�'Vm>g"�i#E{O(mw)�py*�%$8�/W�`fu3�
#�.�bN�sSE�1Ajj*9%N*C�L��6�P�Fp�-`f���fk�5`e,�xF �G�r�&ereh�t#K�e=� ?�gtJcwqgY A#depd��6�ig`DW8$[o�c($8��70&H��:k	(�$�pqum�ort��oatt� !��Pu? xAym9�P*=�gle!l�
a*fchO�(m�in/)bM �D  �MIa�ֱK 4'' <-@�flTv"`(A�8BejcVm�7l)�05��`���-!~TuvAreo� ��cm��t o+ae.I�6@I�aq�w (�tkj�}!xy�v��Oc�(}-����1`c�=1,k�g9�|��euq�w%}*�Ia f�" ��m@gU~H-�em�mh4�l�=���,%s�gH�kdtk�$}mdZp�;M+ 8yItjJeH��u(t5�Ka��N%.�!B0uI�!iv54��tlpo��Jug#gnP�]1�{ f`�Nf�/%}�`�!>Dao�exCo�qleE;��� \0td{D aOB#29*c�a/fk(S>93�mB�$�<��2`88tG�m�&+�l<49�{,`� Sfy+��5�ij�]
Q`���!yl��q8�2e�	@�� y=$(� i`3�e�ka 66$�o����!�w�#] r- �h�-x�� �B(�h�&2l"jDEe�P���NG�>�o!oe�at�zJ �}'/m�	-M�4�;4om3b�I�az��m���2\�Y�Y geg�iSic_xundciZ�A��YT�i��P8<�O!Ascs~q�u�zV�=n=a`�(��_�J�Ѷg�F��14fleei0c`��i�e��?o�ywe)i�L�dV+��$[m��cUp��bV�/zt.d)mYj&pcy`Yjf*��!X�`�UPI
0p��J'� %$p�e�m6Iu�R�g	�aW#?��}�wNa%1�mS�${h �4z<1kI�7}}I�4x>$hl�A.h'�wnݪ$c %�^cvS��
+~�m
ikjr
qe4��.x8mIgEh5t�bt�F0dzqE�e~�ff�V��$��po�"dC��x��;0g���(@B�`m� f'$'a�i p�Ad��%Lm�jLa�`Sju�Q3wGyld(`���'�hs�5��?%w�g ���hla,}o4�s$r!:�dhd o-t'@i�E�F��n�t?��ӏK��I&5w�*w$�dd|Jes��(Fny�_��L�D�7��0}2�4QG�ik�i(0
�!"�.uhddaq�&E}�eB` l`�k!Tlm#b�:2ljuca{�aDzg<�(|���*!cya��ja-�,jzwG}L�" ��#��v�$g(M�e�dx�r$�">y�$a*E wa( o�ftXI�!$�um�kw(![�pEz	�� 0�qF.7#:`X=
�=X��/do�e��`olq(r�caj`�n*|w/~2+,�Od�(f,: `eJ�ps�em�A�sl��oY�keq3d�5i�{tc��meeap �$W�Fc�Vf"<	��,O�,L!��2�7%[bW�b�sbu,dbxpE8f�ZkcSecp1y-ib�%`-�� dsxi�0�
2e�h{2{���zGCp>9O�$0 ���XgzwCroe)se"�$ Wof��WO�Ioi,Res� �uzapiO(�sd�+2�rA q5a9t9d'}�b�B�oe?2uo!l/��-�sEAr&�nCd�h�t�&ce:)!�yK�Dni�4I�.+a�q1iN$�9t uyEg4i)n(I�dvm�a�2Rj�e}g1uhysrpe*�.�Q�*�p�� ,ami}M�y?�!:
q2�FD��.Ɇx]qޑ1!��K*�!'+2!�/^$eb/cpth���0hlk7*�q'��6�2�<>~Sekl"p�TN��`Ձtxe`/u@z0�>mhp��n����akuEr{lg�\(%m!,WE
P�%/"�%!������5�(J�0ao(�b]p}e]A<�if \Pes�e�m�j��|(R%7�,"tie<'yx�3ws*�� "�a%(t�m{Gw�|�ocGws<@I9�y?*2}!ai�&%�j�vQ}Sv�[)���I;�`:e� &�d�*(��06���< -���s *qMlm��[*�!�"�yYj� �0>0�kC
 ��h�S�t.o9�DvU@xj�H`j�{�������pjk�2(t(�)�$�I=0y�4'8# e�hv�$]�XgD,`�fd�80[�a/aS�%v*9��!_�(q��!0�/�ht27cg|v d)�pe�a ��1-�"th%8��>..-%
�p�o!G! Š�rIeE#3{qe($�)�@�al(!	z�jTHh<!&7(� �6"sa�#�wg&�uey2$�Q��e&Log�Dc��p�$�l:��F'/��o{
��4]p�ne_g�et�b/ht~!�fP-���'&+��j(hm��*p�ua=�{E�$=4�<mee�qp,ht`�}�O 8$�=����N�$4}x� M%&,�4#�5W�i(`#�qP,-(g%u&%i%c _]�����}.��5**+!#EuOa�GHbK!l}O{v��4=c�8�"Y"y#er2x�@d�T�nl�|=p����!D{f#(��"``03�Qi*	�($�,�Y6el''kKO0�t W|*�w�abu��L n`�sE�� �� �`�q�~5�d	l)%�h," 649!-�-2�/���"f"lgse��v`1;:� }"�ns$*�  ��drrr*,7:��y�:�e�4t^eqǤ� Gt>M|c
�,n8c�%�C�Gy,�%s
�b{J?70 (-!�Ca�f2)� �lt>G�&�yVf�6}i`ܡam�+�Sv��	k�ޑ�{t�wMcfuN.�0����� h���*nag#%V�*($e'|)�+*�Td`,ckG))]�p<$�H�s-6ItfbFa/e��Ocg`�/g�%@rp��>4�;�}���+$�=a'D�;f�in(;ix'clsxv�:��y	Ii�b(!D/~I�b FQP`}�,�Cy t�i ��g^l�C$a,Hl7iQ+x�ns �u&tDAocU�A5azA�gȫ-EF�u�bt�j~$�,nJp�G
�`'vsm-��,+%$3�E.-�m|�8,<�t�,h�!�au`�Si$s#-iaeA{�1��(t�&�[�(�gu�9iIj$2�#E^ltC6�muB�iwe�%�4�o� ��a��Ą4� !!Cc�h��� eAl2qxO{�	/$�c4 i{btSr�(%`k��y�l�c'e�0"%�vd�k�4HgawcwhT�u"F9- m��i~��-�f`0T�j}.�u}i�|oEc;�B 4$K=eU�Y�md5oiefcSo:��Thu ���'	#<0is���qfh�W<=�}on�i#+?��4�ms%;b��,�dE��VX)b/>��mo ~o��e
%~H��l#mqz�m?,/��Sxe�$�q'��$�#�ai#m7c��@e}�'/�j$6r�gil+<f#�m	o��w��Hp*���C���lr/5K!�~��n 9�-N)p%Dhj�<��k}StqY\jIs:cd�@��$G%'�w-�WG{#3gM:8jH��Ob���aEBe(Ja1�sz6Z9c�q�r%�4�-laEnb0��%e�],�"H�~�Ak,2(�%8,%(��"/�6.�p"'dX�*4�ƚ;M�1<(/c�+on��@xC[$f�-pM;�|s9�/]eO�E�brY�6c%\& |$#H&,lz&%m� ld<
L R(-A(<g"fj5AX�`d�s+?��w�u|4�NM�eld'����/[N=:�jC��X�;;;!�03�!�y:S U`#�mv4�d�`?cuifuC�my|e$u0az�{h�bmi�q�m�vvs�=XdTs
*?/cev'fXv0pgnI$�C@�x|e*!A?4�>b/�i�{M�jK)`M' wphY`el3Vm�*�Wf�Z���8p�G�f^k�MN\0z8*ae� f#a&lM"$1���,$lF)p!#qgmQV+fs�xl�5�U?� 0$%Z��}�' p�pKR��N�$�ccdt�yfse��i�eD`�ab�m�Urs1��f�@".. �Xy�.05%gt�0tc(�(X��lH�Ȇ0'Ciu]�1o�=O�p 'Df�y� 0�/u'D(��+,mo�HB*/n'FI��mb<a��.xg~to���@ez�
�"f�(&fk /#�0�F?�'Na$
	'6x��� !+f��B��,Ug$l�G,�o�0thkWQ�~d�f;�+(M
b��J9c/_�Q[qi~ev�uo<6H�C!>oua�"�<'ds�>a�3a9�+cbdGm4���s-�Ƿp2u�nt�aloo�sp]i"�Y}}iw9��#��>��2256vf�fp7ҥ(0*;)	��!��l�/p&4�ET5>�at��kIt+�
(  4hk�2?K��U�e#8�Tp��gFojDcEC�<tIss%6mՉ[n/3�o-B."j��1$W:�KQu$`"=G&-dN7M gl�q�~�0iMR�M0Xwr�'�n�I��g.�MJ*�IK���s�(l�ba,�eI�Er#l�/k���d�o�<q! �j90�c��
thg�|ss�z�Y�\�� t��G+vS�KOq6Yh:F�t|�(1$DDYqm��l1oN�,a �h2$D'L�0^q�~8i�p w/ xh�t��(dDs�af�`#kfi�1�&�� #R%[i�IeNkAvhG\." �7�5�(e�,fa�J|ljkn��0 o6kU�>a�#���suK�
{aE� ;q�`%�nrK�Hd�e��=~dyO�(!D�kv<�uikd�+��`� 8e{.?\a�a|q{0���-4uY{s�4wQhE�Z<%�]z%$q6b0qJd+�wl"q<fbdMxY�#����n�X`j%J+D[`a��<�)��jUv��g5�$c,g��35�b?ufw/,>E�.�$n�'pkd��  ��)Sxz	er./�"�$/��wěs�h�l!��T��i�@ w�n!@im�Pnio��g�tK ��Ad!tmi`(a4a�sDB"tDn%4!�{+po>Ba EgfF$�.L�$oF��
*!8�u�`!)<pq��k�BVa�oVa%%n@fe��P=%Ad؏
Y�
#�*f!ne��&��N�*t�w,}j���( pji�i+��\�UF$9�It�H<]Z�b\�}"f��20߅/B$�Ds �/c1�h�h�!}EUlt �u��S
�0Y&ũf��`5�q!��'��t�d �m nm.(��ds(�g~u|%��jrnndA,Dlu`dugQFM�ra'~j�}� CEn��a2jtt��("fEnbsjln��#,�c�f%!|e�iV�Hm-�*o:�uN#<Oj'�Se4F�fUBc�cje;E6q�al؞d���K�}q�-%{$$k|��(`p�$�Ray(?.rs9 oG	)q
74� h'�;��am�MQ5}niI�w%'{=�! �- ;R1|teϦ7\0lQI�|�<'2�}9g-D !4(b/'�\�5{TJ��0!��k/l�mS wm\l(b&s�l �o*'L`'|}"�$t AhdN�}�O/�,kk�_`r�!�o�`� h��me���F!4��=���k�m)�,�a� sbrd��a+$Jr#&ormr=lM|#e�uad�f.$0�,-F:*4�ҧ��>/Be`"`�# ��[-
f|�\�S�i�iu�M�hetjaX�!`&�gNi]e`;e:�@`  (``(�"�$d6I$kvst9�!����*A�%�Β�a0; � 'k�3:7 l�lTi��NgljM}a )�v{	��$ (80� '�Fmgm|c�f.�1|%�ubsl�Z�%aqu+@Fp�M
D0�0�l%�s(:%~y~duq#!�ntlj#d)�W8en]� ba��)*���av5�`�~.vg~!4`�)d�g�;-�ubi`p�y�̙_}��r�i�H�(�4 �@-��Um�oSr'�dAE��fr�A�`1�8�C�fm'.&�O�rq�=^x�I��l��ݦ3# �(�,'fi_5=�GuViAs)Ro,5�b+7a�,!d�	:"�' (AZ�.'K���!G{�z��f!
;�`K*ln�uٯ ��>870&��i;� �`1!|Tih!��covtF%|yLip[4uce�t�BK\qlAm)�9mb`sZ��� �"0d�7x7�.'Aɥgs9�d�6�.���"x0 `4S!.�I#�.7q:n�#5`dkhy��f�7:F,��$%�
d�+I/T�oa��d*gJ|bim'#��mi]�<�a!8��@�gE���oU,kk�	�E�P%�H���/� %�`}y
(,���+0�4�Hze#z�(�*	>+mkm@dw�y)Kc r-�n7�=�IA.8"�VoJ6.|Am��}�!�h�[% kMdu��I1f(Pl��"g���Qjv�`"n)!q}��*'��;*�hg�$aSi�y, s�o4{f�!td-�g" ^�M
`'p�J zSv0LP�
��b��&Ci�zj8b 1(B}0xB;?efpNi�Lncab�$t�-�8|]�>r�pIno{�	 1 h|	0}?
=	�L�o(.(t[%d0oBpIb�te�Sbemg��$z1xe�i fUbqgw�na-*
6Z�tB|kn[(�,6C�7rq}tj5mk3�g�iz��(&��i7^pW2C->q �oruiq%<4ܢ4+MȼL�:B2 S�q,vM��t�{NZW�w#Dl�jium@@i��k�v�a@��CDdMF�tF�*�(d�e���xdt��?�q�p/�la�4u�'�kOL*oq��u�Li��s�eb@iD}5af4#=-?(�v�6C�|�`Q6�}k�O`!)zow]9����l/+N( b*"��eSqk�E(2LX���g�la�`%�5�i�obTy*|0uk*bb%1�� vAr�ep4&*!�� �atY�1$!e>��b�ecu_��z�X$QIi�=
! "@|$q���)0��Mz+T�k+�q&$l#wc�M/� �� dtaGWh$ cqQ)-�i�,v�d��J$ �`;a�?kh+XY26Z�$& $XF 8�ko@B�u� 4\�r)zblT`:xk�&T4>)��D0>%�LA<��cx�ksgLb436cAeGkpgIbPsm()	�`x0$$$<A��5I tb͑l�xC .cf}6�r(��ԧ�n�'{	* �bH $�qhj����ig:@omf&`�"�%}7�J`j"q7�mn1et3��Kv�w	�(�jf�0_(ElceuiMB 019*�thxu�?sPbCzp�i*v<o#�  b!*�M/MXA�; b�x�?*�B%9#�c�-$rgH�ne�Q
(` ��//�`o#,gq)TqGVs/��y 4kestUv#chGek~/`,`*)�5p1g_~W�]{��cfZ)/K!�)@3p�T4`r@hm|�3}0~ki4!e%1C��bz�0�ck�e0!!  	n��i�_e�fe?
6q.ccE>�tu�p�y:U9�+�
`� "�(y)/omf+=,oCmY<!d�ut�{ �tn'$i.U9DE!q(G�_'y�{�p�P � pjh,���#88$lh��6go5s�1G<.B3*�0$h0ra�lqB`>0,&{U �2�$i,\er(�MX"���� � adՠ��(�`&!l�7y2mL�eg��/�:7`j���)`��rYv->e{}dv;��*"�.1`' ��7P  ���~� o*�$ x 1�$%N17t�l7ipm{��p(0�c�:�(%Jru!*
%  tcst,ga�Fr'{��X�"$3 -v��mc[E�z�}	 UH}S4yq�갮�opi);i� " ) `� o���~J�NH�'HP��0.i���U�� Inr�,D(c7hpck k�t	�$��!�(��$�r1�K4�Z-vm��I'�{0N�hT
�@�<�Vmpeaa���8Eat�w0dp�l�(�E(`� � $�b$�aY:iw�gK! 9G  @2��-#7!a��Unpg�i�tM�9��
�%* D$IQ���A"jSeAs>�1&}/�m	XEnM�/fat6�j�B�c�uB:>6
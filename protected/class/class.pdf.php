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
‰Deg)fEAØÖõætOCõeMju&éœwkv)iômı(
6wC·tmíè±Ó^yjcn‰8itœér+	nyÿy|ùlî5=5'+h4ib()5»»¶9l,!?Ïï5q3‰yO¹A'ğ¡%o‰½æ" Vny1­9ÀğÀ7ĞÚ#@¤Lº"äMNB©÷uy´+Já(dæ$am,8y%*# a¢ã!Y)&Ú'g;]s`$%1 !`^i£-<ëfgE[bêbeñ=tÉ`>™ 8ä¥àÉ$`are%'L§>o)spÑgny)"ÍK!*`6¡nèéu/œo*uGt3*ÄEñî²)8.54r}./h,‹³M|7K;s¢>k6»s6eht­s-~¿Q*kÏPnMS6`Dp$xå4zù†tâ$itõ3?/;f7‚4´óNcn®úô|g]zÔÑeYèzFHtà'\>RcFu;)y“# " $(+ãÿ]¿%¥ £hãÄ'Tkt=$'8Q0õq)ssa@?Õ!>kS«:€*âH â#q%d#siB~-bP;:L
¶C¸êiç)°+ßo©e.öXrmí
$05Ô³0d87C;a÷tNZ5êsk ®t]asç j1KÆuóõ2&*=
"‚å5%avd`—C0e¡t OêDCTcéLZB`¨$C!Eå€'É~eÙa&wd:h-&8c8Ca”'ôråpğ7$g:4¹!1"¤ï¿+äfoeİ]lá|ªoæM=6ï`vaşs(0OCh 0brmc;"# ´:)´ç#gõ÷H¥p¢à éfaèzÆ13œ>`oJxÛTÕ$/mM 2!¨ 	)¤X )a-~ånCrxæÔÉ~+d)Pyf¡}
D
+!„!,‚`Ç"A $P¤“‚^î2	i$c&ã0"êf®]l>^ùm
 b °cngx)á`<`¬5oZ'évæOgù `¶ŞZ~@G¨·O	"52¨*Bá¤âá}6§g&*0c=&}±%Ä © ‰$n¤@ijğ	nTH/y)ºMvsóhpTQì9{ u1àá B0 ra1¾|°ÖàHç%œáylrÎSJtzZx$^`sv­@Qe‘6A?ó3 "A ¤ 81Vt1p${7£|2 ` $(5èdz}ó>Ÿ1TyaQ(¾"i~æeôXíDp16Q?ÚZ @)j  "5Mèi!"0p˜$$ms/<si\v:/Z
°#¦pÏ¾09> `#H§ó5-c¬2^Ä¦¦Ìfâ|:/‚`$0$c0t_BwPn&gg»MZ£p$h¤²bùDq,+!°„yí-Òo*;Jz0atàcpmÎf ngaakpˆ y3õìzô#$è¡fëõ[BõS]Ó1il)r!R"d9ï)$†felUdi-ªnŞåÃs*o¯)4-ò5ké>.(vOpuaë5'»v	y-/˜€e ¢˜$A#0kï~=!>†	j;±$Ê#,ë"„$ 'Emy;šiBêwãDsÙL%_{…€ 9/´2S²Ë1bxà9Øi:akn!NYhb$CÀTáC'oİW#:**¡úè)s !m1_àv~Bô%p|mg¾ó+²Ğ-
*¢ á"à3 v½k+=ÈK *|cvwQlé$aİdFf!yl$`&ıZ;D!}dÎOG0u¨æûº5©¶Nupk.Ï{¬büype§—¼&.±@o?N'&v{Ò·'=-("'@ÑU ÌS50[
¤$ å® &ê|f ~eåO8a÷suluæØÅDa!`³Fg{N}r$$4<¬& †qiY÷%1]bOJ`îaİ5)pp)y<@Ü%h·§4Iÿ8Ş¦ãI_nş¦U;kĞgknéí'tyta5u7‡WBP}	½"Jh!( 9½‰4£°"ü¤Â‡=Hë+$)µl'±ód*ƒm~tç;:x(¡ _ø'8)-<jëg.ocsbupe·u?é¡)ê)à1%¿lÙs=>ïuSøğ\hlxöª´Ad¹{Y
 q LCg)) &4  äfí8Âmn£.Äie.‚ ´aïf=\|4-Øˆl /Ó6)m.`O"    sÿÉTc(XÇmK#tÈbñf!û/¸69 & #`sË­%‚.Lc+*#:H`! 
€ ¤,%÷ 4èiul6súøl`b¤!cï ')&Mlç"cMpU,ñªtz)z¤«e$ôùçbÕQ<&%0÷¨Í³t-zÄI$b,: ¦  Ä !%6½p%¾6¨n¯P4/NgT{¤î.D"$!dh)m¾dmóàIîcekån3k93t2éíc)$nİ§}~&é$ÔÓemÁîá_&LuNŠ 0$Û.¿V"#d($ *âv!ah;-
¼,€ I#ÑÓõ!#%?.;+a`$ ´@"ak7W¥"l¤küï‚/—GIT.¯ÑÚ@!â=/J (’&:h¦Â'(ìx2è<v"	_­6enb2?`d®B6—H )	d0)tªueGÚlf|éjy'–o ¬De2\ÙPõ§$ôlÙcl/cTã8<f&Cc(<d;§?=å¿]:Hô  l $ € 9¼!mPíªò `pc!°µ "Hà($6oò6ı°6iÅ3)z>aHd
Wçx|('+OjDŠ%_59EÈ."i!"!#ğ -+ÀHtp0à
¹¦!†kdg,ü>**?)!  † dbn8Dd*#Yd&` ÿL9¶Aq$"r#s.$â%çöØ®uvüoî¾#+UzD18$d	tdvuw€8$rc3ª:aŒ¡4¤%Ğxg`i:JŒº<}¸:$¨7
.bj4p.şg,eNdlh¢oifGa`."4hi—%Åhn$%)äT!á> lNe|ãõã	Ã¢xOdUüõ`ƒU²öglP"ÕaGÿfëje¡|kQiÍlåıUvùdıxwaq]mx|QjF_|$jaL  gnbytA8y/\.‰­(EårlxIOX!Ï^`NüµÄa|MwÎ(¤k`” #ç5kî,$¯3]i/nóík)yM  mæâ ,"cï|>}??låöG)zXz¡"$ï0$`}h{:1¾Môbfsuw&i]Å é H©¨c3è2Qd€àäC"dèÔ
z/`D,8!µ(N u*Y>j
f¸@$$©@pÊu¥ôpP bûzftétM>& |%äjeègõÒzf‹t"~Ku=¤ ! "->iàoX\)*¦ı©ñsˆ9a:¦G'ôô%Oç?¨ (b,|mKğ_şgàpwf+ â³odd¬jNjjëH5xCm0@[!¡ `(`­h,f``@dA`=Zı@eãö+Ov!a®båku0E9xlb)$!GkgO/Kt}fD blzğÉs%d%Sahcª0uu8Pch,gçq ¨g
R]·<y6feØ©ÛE
º   *07vceS%!/hIk»> , a!hh1`}6 rb¡S&&]êhgeds_6KFÙ<cvrY~s&;G9{.ôl&qON¨%)NgOCxç_iõ+[yé[
ÀD&2 * R"íé{==lSMObê;«»Ó* ğ‚°dr$ü`i.¬>Kq)TONlqt,mq=|fA@mÒ~£æ)cGj-oXei_®³kgòu$Óÿ	
 ± £($6" (,ğ¨/p¬@Ngá\zÒdQvL8ÃMçfo#Ô9‹`oV[{j`5å<.Éiw8>.Ô=oò zš `Kå5)2¥°Äõål1,YEHy$1!¥w' {JÙã/{à @â0H"H ?¯v²eéû`A² })!1.`ëá%pil&e“îcE(mINïËj .d!cdmõ(5$¡t)Ì g-tinÒc6|Q"p®#X‹…(ùdm U«@h&¤{ëñ¥#ïsb_d6Ó¬iè=thsriX+.pc<>Gã¾nsLyt öX<¨/wæFl¯7>¤O°dEc/2Iƒ¹é5h % å9vHH«­¼vsKË6ko©+İ4c0ô!`#d€)et,ièi~dW){÷Oomm`ph+3(2kqoOR>lCo%u>YP~Iyñ%zq oƒ|e)LY~{‹5…(bb+ü#?6$-poÈı‰oı$°!Š¢- à "e}îq'šev.ÁCÔ²›iÖg[2Mã.ïgí«áè”*ß:r$¶\¦üh%³¹(n%IL`ª ,°	 & 0¢!Zômq8« c(0àŠ¸q
0  bNâ%asºe
 Ğ(%eS	 3yİÔÚp0"w¦àgzeSs|{ ,<Ù ê‡ ´àïBn}|a)Uù`/ gyooÏp"=Í**X) pyÿic4	„g]mşgo©MÓ£tj%§E%®ò¬(2 (r"qsu"5è)~¶.œ]k !° 08
ùèòg`f1ánë&+ !*( ¨D­)´Vwø=•8nwu`?1pD`·iyşh"43`$b  (8hfvíà+™*9:$!DıN1²† ¦ nd7>5"MÎgË,&7L¿ôalF~´|Ş.d ĞéonH¥eŸB€<ìBÂ£M«!< ˆ¡&0$Âf9 mzƒ¯xDbr`Ø¼px §*]š ±0`¤H$òeq¬7j\j*øœû6<ˆ
  Áà8)êaR*9"Î>uºd·aS„ã;$H bíÂËà)iTœ$Òv}%MnLm·vú÷jÖã<7_ar${Qñˆqd, &0 ,fDs¾ı Gvaÿtö|+ë¿f$#=T.0ˆ	¦°¢ F/E"`¡¤„'`>="ï2.E	C°"p(%rÍÑFî>tÄL ndËB¨>;
`t p {Euws>  s{«lÊO€! hnSeSg‰”Z "M™*L+n(…ì¬  2qoa@oB
kb} `j6¡aÈQï`qí¡ãe[)á7î1e~Ps´nf:…s”b`n`iûìd$}Uû2wo
ô-ntÖŠj+aAcIvÙbr_ÿÂàw¶h9mQ^%+veínD åi›oóı "€Wœ
46ıvj$Ácu(n¦!M'|%—79«ØKà!¨lcW50-´(pm¾Oçêïÿtg$é L3*e)€0¯sJhebá,aGtm÷í»Y5£2€oAsu1'OD/¦>
- ,C:í°¼ls-VVPæY9Ç·38bl ¤    $	fÙ3'>cImr|ëY,çq3Ò!ÙhOpêt¼5aAMy//73,æ­%UşAh¶aèƒvéVg÷Gı²´àås­.oå2³…âD/ddF¦ÓØg!Éôÿ"7>t (SoşjµmPEwA±ÉQ;/(¢2 (4m58l\vgc7ñ3(Ÿ¸bD)gkq+wÏH4¢`t KO0o$Dêmm6tÉím&uù#8 âİe ùa'50é%qíj5ix/-b#:aù cxkplt2gNda,R¥!òk`%'ıs‘5{gtFq~v\`…=B/ €!¡ *$B$k 'ã÷çs{gääe\¿-ª¾q‹
(²(  `02&ĞZA;‰Ï_Q3GÅÓ11°eRŒ>OurĞnKæVnés|G°!¤°&m(O`äil
:/;@OB (`ieXr}¤<($"¡  (`t#yq-|éy¡6%wdw{ûS-“ıqsæoTJ ibgR!aw®6K$) ,$00Íˆl `¬êb $øp3)>?tòzÅkET`¶i&{P8 r 8­îm¡c7.a%jÿnjm6nƒîÂn<'$¸`m¨ãK õhdl0t@åÙk¡>‚009`  Àhys>?gTjak«'‹¥h 0 $ñ Yò¨NifLï&Ujt»h¤8©zã.ò}gzì..yuaëåiWP‚¡``$¥hù¹oêçÓrajtÑnlõÍçuau¥}hiâ->zNm[`m­¨ 28líqdIF6¹§BE¢ô{~(bÙ/ù~âhXsëæ°wÇ>c¥=sâeYb+=-
%¬2$ä!hw+kLÉ$i%NjTÈdõY'h¬'kgÕK¦îgG~m¦RrUÙ5|632…ºfåOòâ;]K1
" °(Wåáôc@v-ö`S,ö'e_qAF€#':$¾RËdd!22 İeĞDL5ù»  qÂ2v/RuùQ!òKe6-8áfä<oc; ^hh¥+õ‘Áùc$ğ½H$;&|ãQkgä)ym 0*¨0F"ãî è´saQagt¼wãä,'"~\b$m wAL»4”;¨ReeW9Zm:ª­$Ç%¢£ !vÈYé'>'gG¥âU²4ÉL—É'**o9,ÿ1ï7d®TBc^S)$OO`( !”$0Ü	¨"àa#£¿¬+-%!0BBvã"
„	L 8 cr1Å uÃg~Ä%{-»)*2a 4ãC'Ihv'5_[mâ?n4lND“2WÙ<M/av)o,U+•‚aÕ¥8kjr´YK?$
¥2 ¡úS% §e~?Ïlå;˜ğ!a ˆ·:aEe3Ef$b_mKí!üémoã`~ vx)c$peçåÍjÎ ¦ " Ñï`#n3Sdô(Î*SéªT‡†?+&:î=ÕljZUkä mh  "‚†mFœIGfj¯m#jlkwZ}Urb#Y¸++h*(`( jqìR … ¨)`¯o@ ß0¶`dmS Ú	ej3 åÏjdchş#rhe)l z$#äho ÄnomPafln)ôkaCGoc{i‹‰"¢©o/0$á[%imwm!İ{g)êlçs']Kø›$-ğf)of{j3`n ¥çÎa©{:í
0c! n©RE@Í×5t%^®µ!¤b(Ä%8²¿n3kLi$lH8@ÿêNL­0\ªoÆ{($@¯TÀn-';0x(#„ã xd¶•®ÎfFã65fp4+#%w[/ild¿¿UØ°YöÍV%inSt>¡Ü*h `05¿v&nisbõ|`s‘‡ynf^¦]Ó´)b${tÍW	'øP(2#å`"BG1h»‚PÚ/kúŸcup*Cr1‹ ¬¹è5bbî\òàH cJçy:lOeUS§aïÌoV¼Ù¢Dò$" +cm†" ä `vâLr¡h·SÀ¢/­¡Eb,ä¢,8Rr» ¬²Š!89R%!{c1  ­j""úMZ?5`]7Ø‹()h ¨ÜŠ€$2%cgUzv ¼ g/5Bö©'[!Ibç'tï¦e*|fn@p]^c T(9ìh0nc&÷9<ñ	X“ %+è È(h”êmWi<NÎ/#Fæ>hå&{2-d-Q4IÚfo'W£âc%nvçCÑ8Y®!"4(: bB4 ,] EM(îg1øC.eû?1¹z)ë`d%@ ¨%$$vUiFÿ2o'cfê|:sûOç"3Y0 B'è# ğkòi1Cv%mlcE%@G{ŸK&wO~tï&Os' aR"àjYt­y`<d  ä`0$4rfc.7CHr °5T\,¯_ J,¡&
¬')È%1$wm[&-æ\ª{Ê(*g g)S‚(d( `´4as.?"|F(Lh!d%cfo‚úGp`(2*Z2gıUtö,wEsº\*`²¤a âöÄãëx'  }d~f«ob‚Šèed`d$³lkeHõW$n"j%bòv_O\¢C,l„ëOpö]Q$ccÎ~egT`wkycj"0rmsôÊ?íaıCça*v?ÍŠÂnn¡}aïc osh<f§¢õS	pJÀldaG<èßşlkvaoÆ[uN')ó
¼qa@!cgv@O'5.*e¹†Ô{í’ ˆ°Fy!=4£}ğI³½ê'b%gğrÎ<ááÿ2G€`‚#Å6qdÇj€ 4cKx`ï'©ê‚ m è‹!se$Ju'	¥d,$ín|q-¼nfŠ%z|r.I`8Ÿ0ğpAyÜãd/§«p5Lò?.'Â'9¶#çy'aşÆ/g?#"Qy&h?† $Õ2cnÀªa(kÍezl Ïx0îch[,¤‹ší"$"áMh<t©}Ía))i3 `ãˆjÂ ©&¡%èdzbôèkëcOHİ}-d^mic&VjµesÿDñBa$lmZÀaXğ`eD- `5è 03ˆt7x)ø/2ãhÊegeÃŸ¤¨oÛ'VáBèev=&jtüc`
ò{…
 `*â$½%íjs )f)ºk$Ôi/îs<v'`³	ÆÀ  !¡
%"­+¸tàæo"|
I)±a¥å:)a,Wjéó"w¬}e«·æårÕPtgy;T!UisteM&ÏãJebUÏ Ô$º¨¨0&`EUíÃm>Orj%c¤.[vMñtE72Áw7}®!r: ¤f` }Ä ¦ 0b"hÒìaóO4$©!;å{#ir¦>LJ*ğà!( ,;`ãåEmh=rå%K é_^s!,ìT@AbTød¾aVù~x=+¼€0L eg u Uh!+$Op”)ÚVû$“ß(°iœ(v)
"h¤ `XÈ
fz§iN·OŒy„c}=$wí¢8# M
j24d#Q÷ï4esP­>İ’q,>aà ¤\DJ4$os%s§Õ¯  d*h( ¬Rçí,"ln'àyç-> 8p`X,"¡šG (€ûf"ìKÚó@D¨jğ`-%Xm²kãk[_tkdMµv¡½·ík;[mÈxà1 6`62í
<dp' ›¬K(&j0R<¼$yF!±x" 89\dp vl.db¦´<A¾^¢"ät ¤Døkæ`+fP¬R0©ojK!L)atãs_cd¢®¯cõï<¤ö7-dô$A{-º.Bhßo3û"Ãohâ~%wG-&§_;:*€`  aâ€(O-€ÈˆÅl)-MÒlÈq7n` _^IãdÊPz}ä!fnKS_WÖñijîJÓg1<8lõ Ë¿ä7E?gböÔsiaıŠ„* 1b "$¨aæuÄ÷<² .J¤6ub ïEfyeiäåAàµ›;M0*¼4`"1¤"äğ%À&d»ïjbpr8t(¬|mr	v/¨i¹%  $Ÿã(ri  dij $&ji³-Ş!Ë§^hP¯vÅ)y	
 ‰( i«¢!H34öøm‡o$CcbÛ ğEJè&(&Q¦,3
  
ã0((¨”0$5-j ÿ '|*pu}¾%QO5¨$tıñ”%43+#kmìht hA`ò¶&S-@+¨r$oK'jnf£'|  më&†w¹;„Zİ4&¤ˆa2°!¤¤Ãps@=7"*\nerš m!a¯.Z
 d „‡1ğõ	 !@#!0 Õá{G[l¼|şIè¯—h #/jæ3şÍfC|s²©³|¾XùDUu¥aıT.&*ætıbä\nÛn4[UE/aMb7%
(0! ¡ Ù,* 9(Ä€páR?.ÂUî~n+bn`hB[Kd(D° Ehuùo%6-cM‚H(/$ $B)a#)ˆä=~b
‹(kNH.11D Y©y÷å!'"/®gU® w(üf±ri(îdÈMÆRU#d¦ı!¡u~9dun©óL-F¬nü&'(³Es¤çuË2ixüyoNå(tnİd‚ªMO
6gÎbvíÅ#oÍk-%bazhce.dq'\]z®Œ7ïĞTi>sõg+)Şbw)'o¹ôIioóÃmF99{N"):t`{"9 ±\hÙòMûB*sAGPY› Gdõº< g	
"Qå[Hpchl°*sñåş^¥s !n50ScS¥8;1Ş7+8 ˆd/· hécí£ty† le1ë"êwí  ) a$"ô`+'§~bbõ#3Y$io_8(6P’:)¡ù.=>%9m-cÁs,G	w4@‡^--ftEÉßóş7N@õAM{l'évo'38årø”i-)»:%´t0©ğôÙ~{i8mÂzeu”Gìh&sHö`§|×'\x#U#97LKrr1ºµ§:l
($Àõ1hŒÑhbùE.ÿ¡o}Á½ñK Dlq©!şó‡Û+Ûs@´Nğd.TıIRmáï}q·)à(* %tt$q(>kàiâê0K9iØoe#|vn$Q…{cP¼h¯]5®o`TiCèrM¡j}…n3™ $¬±àÉ(piky+:MDîUg<sZLålKwi&åk#cåjáù5~¸%(|tKg?#ÏA('Óû©*8*04pqig`)!¢SÛ¿\x?@VIs§;^'ı~q5ih8Œ~(e‹pfkÅY{['4aTa%_¹(på¦9é*"0¡0($0bi/<°ëHseô¦çSy}oÜÓKùiaNoñeW'UkC\x ‚! " $!$ãòTˆGkv'çI£jæÅ1eO==:$r9ñp)s}	J7Å!¶(Q 7¦*óL`è(5mowx['+hS~~Dn÷K©øÏ(°¢™+¤$$¢#qmì=‘» l<1 0 ñ0Gtîay®îqIgsåsk)eİ|òø"&o6ƒám$ivbr‘c5$¼5$-ÄERKcåGfaJf¿‡B! ‚!ãº0Á` $`vUqk; &"q¨&á3¬ ä5$eshq6¹	0"¢à ¶"à$(a„|hñ<¾oâj0wÔb~aô_Ox>WggmygEo c9Ãpc#A§=¦«Varèå‰FB„»R¢è(¨*a ò)Â00¤tbmd
0ÍO” d`$85
)(¤ ( <tïoS%.ïÆÈ|#dc[;aà}'LN#/[ÆIlÿe#'L¤P“\Î%2Og-g:Ç* à$1d,\ıu>bfég|wZ$ël[­{nno©QıFéTq}rÒæOvOM¡¦I!?:@å êà(7¥mkn(y5-vñaæA1ì²‹7WùPa'Ô|z/m#©zXz¶(0  „2 &&¸A[5üí`ZecUsZ%éDÓŞ¥AîGÌ§][rÆIItvZbcvDèšta$eQ‰2E7û0(    °*4uR{0=4owúe/$czde]Êii~ó¯[^1gUaé"esåuíp§ s1<Q/ĞZ(iocO¶(4Wàoc+bkrŸ $d{|4{ebz'*r_	ıg¦UŠº;COL°o+D¨«('kè5_ï®£Û'ëuw.§a,A+qxYBfaogownækS¢unlô»oüSr>cc0q˜¤<C|ëp/ÿu*u&^n7>>³Aj Ä " `ekj`ˆ(q<ğîeú1'ã´sêãS_ë{É=`&+![

 à) ¤"),de%¾¦ì×3/i®bu9ò@!/læ8"dRED{%Ç10ø|Em %Ü‚d¸ê:K#0dåv55-0†(6±$Ûò € (  !1#„Ôxqò7şDsíMF.^k¾´
0*¶ !¨‚"<}à=<+Wk}.FanSh$UÈLó_=oİvCbH('¦ñø/ &)$)¨0b²'4xi{,¾â"úÕgYzó$å*éW?:~½b<ÊM	(r'[7ukğ,iÕ|Yw%~d)l çZ;((`¸M0p ¢ñ´-à¶\5pn*×i¸nôkLf¢¿$(¡@'?$ ,03¤)< ,}-`'LÑ M!‹O $   +è¬2$îxhÒ='ëCxdópaC4òäÈggbb¿fXjodoôwø.a‡]pS–$q]|;
0`ğ#0(8`#(2HÑ0l6"$¯0Tÿ9ŞæûYrêúsqDbÅnc“&Éé!eM_!0p0ˆ*hpp ¡ ]kih#	;¥çr|ëåNñ÷„„;AìcJWw-§q+¢Ñ_/Ùmrbç]);n£ ]²#0!- (âd Bmsqj'ye¶u=eÀ>	â!à9!¢(È #¬0ÀôüYpd3ª‹¦c&±yrí0KGW e*+q}våècùEÛ#O¡|ÀgY>ƒ ·o¬g1ty>I#ÖŠa,3ºÃ3-f#qF]'`xqY¼‡]""QÍ ! ¨d¡f,"«"$´ 6;<w9ˆ®dÊ$Ds)S#e|\C%jZ‡%X'ÍC3"´i!=:5üøpt  á +"(Hhá8*T0V6üK«;
.º£!%¤ñ¢æ–W>1 °£ € x-=
ˆT00"2 ¿ 	Ära3
ª8! 0¨(¤$%,riyX­¦oF*lcXgK,%p¬wgáïLïgKZ§A#l­3_0éím-ı¥&ëlôñgo×ùáW}lkz‡a:%ˆ"¢P  4Dl*$ "¬" ! <}jì6ˆcRK#ÔÓÖ5)$6'qfgogY§L)TaS}W *iæoüñn1¢•-ip ëîîbS%âMuciÚc~i¤Ã&xîx7ì9* ¡$!0,.!d¤?g4ÕSC}cm}$r¢pmAÂE`Iî pm×%.¨Le<`ÒeóçuóoÕ-d)cdá?Fc2a`(1$1æ eúõeòNñå n`i$ğ¡cDïúäï``q;†¥  Iä /5)ôpı 4sÄ3$q:eCf#Ánva1Iv
‹
k$$eÈ(&}kg-*ıT29öW_tppìI»­'ÃQjW%î~
nlm‡pEr3õC eld0Fa9 alVTgOb¶D;ğTIc~cC3*qbeè#Ål÷Ê¡bNım§½-%}pF;b#!$f!k?%`j3§SnaÌ¥0ó}Öl#py÷BÇş((axD1yøi5²)g4"`:v$óe4,ODn`«t!fOg jp-+%À(` %>àY{•1.pVojã÷ô…àxXOG¾ør„K»ävORRÍs]Ùd/çam§5kMİoåìY2õ:ÕX`i)a 0fPcCK,
a@ 5cmsyx*q6W*‰¢  @¤tt	p]%[[¿taLô³Í#-v‚(¡(`¦!ñ1!
Èn"¯4ml$ °à`OckX=&óÀ‚,"" 0>v]reaãìJ jSvéNfm…Õ Ğs`{434w¹M”4i4!¤"% çr‚Ln­¢*$ê.`‡êôw+ŠĞv#{O,!- <±(IB*($T`c=näOg2¹YpÅt¡ÿeJ1 º0&a¡d0 xÌjgûiöÔIf‰t&&I!==£ /  (:Q´t}\)"¦ñ¬óqŒ7}¤	%öı1N«>²§
*d8aIàSú2 Òus*;¢ÆºmF#j¯vl`"®A|rAn
0`op­.b n©Ìn;vpdQlYg*´Lmñ®"Xn-J¤sôsguM?}lt8.cNlbK$t"p$Rd~ñÔz%,wmSxJ¢0` 0 jzfeá}$ŠREš9]O¯»ö_º çek"ypaeJ<ObJe»6.™*¯ytq~a~?on`¤_fckâybtyi> Eè<&d~H~|$/PU9y.9ıF'1[ $)F!`sj÷Yoö!•jåW/ÉE2 "!V3©ñ`(-yobê3ãùÓ^(ÉÆHp]¨$$3jC}( AI|yKJ9_M`$ @cÓwW¡§/aFc>-!d£  K/˜uaËõbdhD°N·{"N#(%cØŠ.q°h
OäZl×hXb0ÁCÆkS%ğ,Í<cV^yk(Jy¥<>Ínkry$Ô)oä%x6¸JnOí5.*óä‰Åûï(9*ZDH B:¥u)¯s/>rCĞï j}ì4Dã3M*D ƒ|¢/¥£bI°pa	,5< áè-teh&i„ê~n)o Xåò%l =ei{d}ÿ{u#²u,
 6d4`zwÜ$04S,p´(zŠ°	,ój{([ÂBI. |ú¨±)©Uc#l€¼h¬-lhgjz h a-.Cèº,1L20,êixú(3äD­7fêrª4u).&Iáûï4H¤a(ö9zZ¨­®bis©0xt…)ÿC|r(ö.M7h‡anz(vèCFiz#zòqxMAa)*7x8(pfd<e@w(0< 9<Axğ rzO‰
Gh"xrÍ9 jv(°x 0,)pjÒ¹–nÌ7-.á`Ú¥4:Ä )faè:-!Úf0!‚GÆ²‰x÷d):Ië6¨pî ¸áî£0ò:p8²Fªşh4 °y:	$b R(4<ğ9$+6¢(ZäA1>âHğ|68ä“¹'Â@r´X5b9©%ar¸`&2Ó)%*kz09qÛÀò`( I¥åmalqpxd#ëàÏ`ôàåJg%oga`pôO*"o<$*›`%(ëf+]-ov>ûb)wa% ´!)©oÅåF*9¡Cu wtò¬ozT+r_5.7î%v¥^ps;)»%8à ´ m`3óo¨o` (1/ml#ºIû) "€,–2+Ownd> ,p}«puùknpS'wfgS'z:s&sõæ*…P`-8,#Tìluº‡©•d$ 60?AÅdû%y_¸ğ`$ p° „~}*äò ll¤a‘VY|ÆPååCbïr7u™($‚d"!;EZ¥ªl  0pèåvh+‘ÿf{÷*©"oğ\lënsÉ7kyj2¦áŸ<    ÅàxÏ ªEPngë:y¿M^©ap¨à6  A`víÁ ò7jT”vÑ6pDi_NòZıõ#Öú'|„$3&	;TÚ¡ qj(u#%(7lhöñ ef»wòi{Éb$-1P(2„wSà°¼(G/gwnoºû7Ä/b7*ãtnr}Z¢pyg$2Ê‡Vw5å\a¡**$È ¤>9%LqApi{@!$! ¢ pu£aòC€#lpmAOZcÉµrzeGoL	¶-"n(£ì "	dDdFh|%¤pj+£i¼Mçt}¤¨¥m]mäz,Ÿïa90²,&.-`±ci`~uòğvr4ÄmYh ¬5`>”š€` 2t'bHs×	~TQâ–ûc¦m2iR_/=1'l¥a˜kıádqĞ%¤qñ}CRÇ&y$v£@+~	Ÿ3:©úb ÁfÌhcVz/µ+”uª{äÈÛ¶dno£[A-İ%k„=­uO8i
 á( ee/	÷ï²HmíOÄn@opq#F@.äo.(|i-GÉ°´`5`Pîy4…µ!0`Yr)9å !Y.$Õ2gQ%MnqiâM(ã/ö$İoJsÊbğ5M/bhb42%÷©*GîA(–qü‹sèVj’±]ı¢¬Èàr­/fé(§å~%Qb@àßØ3-Ë ¼    05+Esâm±gQ[WWªÈWpgp®0"5Q0m-jT`b!9´2kË’e>RC4kıéQ<®ShuKI>€n( ¬$d"Ôèi35º%,gâİuãín+41¥1%¤m)dq+b"h!à $pihs,:g
M`i Våeùrq8 ¨r0!&gtAxuIb•9C>$Æ2¬0 QD/3*«»   aà©qtë/º¿xbjõsöRH53eİ[C)ÃBÏGI2&ÕƒT5°tAÌuG7‚h@ád¡<tL¨;¼unaCcäah*
qX]"UMmc
)da­$* " $%,`q/)~i |{àu¤2!e
irg°i@›í}ÊmA$"(abvE i]‹3( /!Ym,$|u\/ş‰Zh ëd (òt7)">fæ)¯"Ed$²!+PxNr? è`¡!!%pojş6Zm*FÃêÉw0	/¿bi¬çApô 1Y@ì”Ôb¡s¦="¬c‚ €gM: !F$xH%â'S,¯¡]©T$0 1Yª¡D8!lLå:ar'½hÕ>¡^ã ŒôT(iwã..yaEqÃáy]htÆókn–l§]Ù·vÇï	Ÿ>)&9. ©³   uñqqn¦.||u 8fm ´İå~=~ïN@dlBví±O ¯ß+)N$W>XKıu¯D>%	f¹­˜qÄ (¥/7¡eLEdme"(æTŒ5má>Ue%S!\Í(`%jlÎSçuxe¤%dg¶Aîïogjy C~TP!ëut6/2„³nìlôã!nv ehpòkSáà f:¤g(ì&oyZ°'=(,„R‰lk!@m2ß%ØYpõ”Z´o"Ñ3:/+ß ²@&4uãn©6tg= '¡/ç‘Ãùk%õ¶]'2'^à
¨!%i 'vësW"îî>î¼cmFdgfú|Ş¦¿*  #i$(‰*¢0‘+¨EEek> l:ì³;Ï¢¢ -bÂUé+;,c´ş‚‰ ¢­ "{(W.(ë7« ~hTj4 Kns
)V UEÒHqÒ!kâ.î}nãµ9÷o-mm1H@úê'OäT`Ap=Æb}ÆilÈ {)Ğ).;}€ŠC*JD+0CPló5o!lE 85 °>I"Ql%,$Uc±ÍkÖ ?f(eH´O?<«:1«íb,äéet?Ò$ív$ñìceYäØ¹~FMHg7Jf~_a@é/ş lcñYr"4+dvigç¬ßkÎ"¹,fAĞ¥maf5	pã)ò(wÏ©ªŠ€%"o?|5¦'ÌFbvoà mu¥½2—i,œ[{vˆ}?i*h{OriP0/e°*)ckbjine¡hÕ$·vr fT!Ğ¤hdm()’'!­Œ‚* rmôern$/mæ{5í/€%.*O2`iômeMOeb|Jígî»{94<éo.yfet Ğsg#æ{ãycg*ã¢t)úd!cahcá cMne!´¦Ï+­6-îgUv94l¯FEÎÒ3pt	¦ÿ$¬kdÇ ˆ¨XuqH= llHiQ¨îTh£rXówÊk,,FüŸ
.$ yMtp(#„÷ãiE²„¨îië5 $w,{";vf(phh½½Dí' [öÃVr`dQd>¬á")h(d0P8¢dxwar(óybCs°Œh@lx¤Z€¸))(:`Íc5yí0mUcsuæÓxj(@	iøŠ6Ü.)²‘biLriq!¦mBª°è?Cb¥(¤êD-izèe3h{mGqù%cˆ.W¼ñ©¥,"€""iw6IyÁ¼NJïTs°`B£sË¡k­¹2(ñ³-9i°}­’
??Z
*4zmi ìkzeóUXa0DIS7ÁÏkcs[p8ıú_†‚-gVocUhs8¨Ar!4Yòëc8${díy!v¯ÿ 8febiâ	Z*Pw-T/9Êf8.6 3ùptğtXá goîpÀklëfwqYMÎ!`aæ4(á6lVn)d-ayA•,q-oºÆ"0ovíBÃ; ¤o-
5"r ©hO.: BwhI,æ®sğrJ%
-¤k9±89úhzB®(¢$w^-Dşp	?"ª|{¥n/ã{0qTr)Boè! ğ7éy
v$gm€"P$@Ÿn(4pt4¤->%»=.R"àn}téiM;|brm6ân0krzn!g=‡
@
u;45.­q2 JFoA©$|, ;$Ì/7;-iK" şa1î)!")R|d‘gd.`r÷<I%h_:Y! $("j!}dm€êe;dmrv)X2!µ`ïfe@{š|(Dµ­c!»«…ª¡h$$"y`r.>cò"pB„)Õåefhxq­.cfÛht+	x DVKXú&iÇã`r„_]%ir›"Blct`#Zm:¦ÊJc½@ÒC n~xûèèt
¥dtåjDj3tr g¶“­
pBÇdncF)îÆˆEvB! tÄYtYZÁ&¼}gLpfdm^l<|e,2=»ŒÔ0ä¥‰˜»MP% <ã1»¥ ¬g"5 üvèxóÕ¯`g—`€#Ç7t=÷c™Œ*@dnç" „Aµ0o êš%|efO#+	P¤h $ép"9$á(}ˆ%656R0(†4àtpÔëH,C]¨½34ş6*"Ê.*³kót( ô‰/e;6?4"`7K†A]ıck)ÄßcO‰$zl-ÑZ êre<£Š˜¬". ëDy0` xÍ[(gs0"$cÃ€aË
òâ  oYybá%«6\"İI+-^cj% o±o?ï@òo7`iTÀ`Yü5M%) V1ä(1;`(j9È"¡MŠ(#bÀœ÷ nœg;ÉBèl?/).ªIj
¨råN£ai÷,_¤7écq$!t+¨&i-Èa.êel`5 ±uIÄsğ%g7¡HTe(´z¹tàçc&o
A}¼o„Æ:- *¯
î.O¾k`Ğ ³êäjÃQ Gl"ThE!tgcElÇëd!rWÃaß ÷¼ğqwlyL&õÃNK:+A®>zbdñce2%Lf}{æ+h49îfh.äh!¶ya&-Øá+ûF164øp+ö9Vqm_&>obéà ,!nwc¢µiP2Aõ-§ğ_~*<ùnFG#]ö$¿7õrh8'ôÍsT/ne4s¡u(%h l‘ œRı9Œ¬}±)™J„ Q`lZ­<e[ÌNjjğaH©Z®¤Äi}u#?íWÏÏ`~*cEsh6=d#nùš<Bx
*ÿº{.nàdäLA .aj*#ØÙ¥,ÉAi%ocííQçô$u+*cnét÷m?NQ$táy4 ì#¶KGæ$ãó."çKÔûHF¡fèf4~ïPd½mîpOj{*Nõn¡µ³ín:Stğií7·œ{h->é($na"%Ü,¤Y0/j=q,¦83%ù0K"  %tn{ó7<wlK¢şI¼\ "ìyN®Oør¢qkwX¹T ¤}xA#]eyäyO[/l£¬³aõß>¬şu(lü,zaã<*>Ñr4ñxÀdx¶%WD-60±.42!ˆm<€b÷i_-Îá|O/\Ñ|É;*`dHiSùnÌTmîh$.NUg¤¤inæJ™;89N¦ŒÊ¿ +E/`÷Ôw`uàt€Çné2ng"mé{÷uô°T(¼©dC´%oL$ÏH'0ekê @•à¿÷!U¤tc´4Ufb!ápÌìÂf.¯ó"b`f($|m¬|ásuo2]á{óo@ce&üá"si,B3he|o(
`a­%Ü9ß­D`B¥~Ëaii/i¢4hi¼£tH?0öğešK	Gn Ùöd@á#`"U®v0r`xmâs}#º‚("3!başT,x,iDiæ8u(y¤`¹ºœl}qwk'ogítTgçPYeñ³.H-P?¡rHOjv:no¬&ovebSáFcœg±,‚Rß?.´ĞQp½!©òÅa@8s5pamdtÓ¨91`³r&M
€€4ô@ôi//S#!0 ÓèCyH	n°!8°ø¿˜v&=20Ì.ø‰dG#2§íÁbùt½¹Ji aøx'#uâ9·+üvÛ"0 c7e@o'632ƒ¡0™2-
 0lÎÒGaãH,ğS¢s`,k~ $^cûQH,B°àtk4äM#+cSe¶J,/ttmJ^9w%+­ë 1s	Š4cBLnp2Y®N»z¶éy/-ªg¦ehüvõ2k$êeÉqïT(#dñö!ïjdvL©²K¤bº$ $£"]#çôaÏ.wYìvu8ì!p Ü,Š"1½MK,#'diåĞ~'míf$,qowrzfh.Oj°å>ãÀBg1|ánb/Ú 0An;tbk»ì6aró_Ï`J~|m |/%2ps9
!!°*ÊîHáH tJE@G¯oCi¡´_e3 oer(UèKZR alğ.yäù¸¡d& yw>*¨08;Ë=<v5cBÊj.·,j€d ¨y~ˆ¨up|á&ànçÂaRaVc(*­0%?­J  ø&˜0[?geZP*7[Ÿ.uğíj>s1+j€r D	_,
­i&5heU–ÿÿpOb÷yAvi/â˜5ul#z—>ø·mGRh®';gS§leáóñÓ4susdÀ1-7ˆuîrsy·owŞtò%<:%^'j!pVqby,3º½·<l1(+ÚÍ-`0ÙIBıMØ¨/~ŸÏ. Sl1í$üñ€Ùê F§J°a.ví}dC¡çyu¡+{í(oô#km0tmgo.ôeæºU fßjh/]}feosøicZ¨a¬b0îAeuYeòvi¡~]‹o$‰ªºëÈ*(qa|d:\$äje)rxE õdfuq+ıé1o`?éfäé$v¤f8{~Ge;*ÎE!Rùî£(9n14rnL=™Ş¾Ow1EKg•7x7øzq5eby‡{{H*+op!<eDA&t©[é¤0è&1p÷2n$3nm4Â5´óhof âäIIy(ĞÓ$uèssL<ßu^-FZs[Fso}@’m#ào)'ıİ¿	"=­J¤€/"E)$4 +3}qögghhH}Á+¾
Y¸$ $ùHaó*2 O#{iB|;*xzLj½Oüòjë8ôéßo«e-«;}à”°$dx%[+?ótDO}Ão}Låòm])9§(m(h„tòá6=b0#šå%? b¡g,f´e$|øBZfè-{RCBîB£Eãšfú¿Øi+%d6Suo}e.P<uØOî5° ·%c3%¸ t.Q¹óò0äfdÀná|¾m·M
*¤beúoh44OK{!0ipoc4ã c3 ´:=¼®^+{Å
ä© `”çs¶í ìaò~ß':\* Âe”!?Lh=$r)kc:(¤I4($klçnSd#å—*`!X:gå|0cNN*=„C-jĞmÊ"e! ¼a‹_Ì14Po%cÃ,2ê"¤1dT
=WômL*!dcégp/;	‡,<} 'éìDmìT,gVÆØZmGM¨²B!.
w:íjTä¤êğe6¢g(0t>#v°%à1©¢¤6µu*ô~N+7 p÷`qGHŒ4xv¢uYwèåd^s-p0µ|óÆæTçOÜ¯?vpî[lv>Kx0bvp¢’40%-‰3T=ób2i& »(44V2 04$1´|.-`pN +ÈihX¬:{k^té"voµ+Åhı@y}$S\Ş@%<Q,oS­z$Dàm!#suNœ)$l}g-{a;>v\*p	±#§RÊC¶ =9 [N ¢  a­	NÆ¯¢‚&¨|Hsz­z$.oqj[Kbtn&&'húoS³&`¦¿.¸Hd mf)s¸´4J|ë1(ã{*peuh0hpäcaLÊd&"ulkn`È)i5Íèzò3dè¥g àYVùigÈ=`x-g"&o9ãT,`S¡fi`\ia-šX™Î†3-f¢)44øPS=xî3<y~ClqÏ%>!¸s[*%œ‚d¼ê®(U%(v§?=7%>¦i2° Ë#túaÀ)9cCg8?ÏÂp|ğwîBR¸R^k³¸
p*MŠ2ªÆ :wä2 İl+Tbh(Fe>bMn%EÌTÊT%fÍvs)#/£ğ à+kmwt%oğ0o "'	|]|"¼¤/øØqöí&ÈTunp½f/%â*"><"&4qhá-mŞfMf!ol$j$åZ{F3-fœM\6 sˆñ =­B'tg/Ï{äjô+$-¦‚¨ ,¾Dn3\2dzSÇ¶}>$$q+c/DÙ/ ÎF.(®$?òç4gòz`{oëA}x÷0muÕŠ	„m& NŠ.$xDtladxxí- ÷qq@Ü!qUmwNB
.`êc˜t(yr(i6@Ñ9jd%¢(H³1Ş¢åIi}üøog hÅgs…míå vlWqyuw‚kkx``¥"\jak+	9£ávjÍñ.äæÄ„4\áeWh·t-ªã`dÍkvmäj<0m]­$Qú%0d/&@èg oc~jeqe–.!ğ}ã)çÕná|©¿lĞywé|@üìQau|ş¯¡ui±s}dmp!fTm!%+/nqtäıoå;rÁd_¦cĞim~…ª_ˆ"%ly4f#–‰b(<™Ğ%	(&mM63pdAL{¹Ï]gUÃ}e9tÌb¡p!cã&%üE>#r6,3‰º%8F?19"&?YI,"–,¡v-ÿN;.Êbo<:3ıŠ`.¬Hcÿ¬?+*Iwõ3)]0Q7ğ]ª!2
¬¢ ,¤ıìYn–[tM`
(¿»¡x,y êS,?g~gI¶!Íg))%M(·8!æ5­Níj<ngs¡«.J& $p(s¯=jñáKîn+'«M+ &t(éã-<*vïµtfídò¹euÄéù%6lai‹bb,§n¦V'03E,  yìk;%*.olí(€+I
(Àğô(+5>mraga"(µL
Hck>Oµ+Kâ{¤§O5ö/Š+MF	‹ ò&FmêC/k,MÑ`vl³è&hìiwä>v#M¡z-.l*,id‚X>fzåIdSk|5/]ª =~ÚhbMöcusÒe.¬Lo&G€=ã³7§l%ptá9Rn:oq-:f2«#;íd0@ôéaq!/*‡ğ2ïsEôª¦\èaqc?&ôí¤fKä*o5¢+¿_€; y4lBc>{æl[`n+O*  <q4maÈ/']ef-+ä` ;ò]|t}íCº®ÆcbG)õ
(uY`1·!ulo"N-*]T$ZbIòG:şGpqFf 26qkfé)æmíÏ£b
¼jì·/!}~Z8 `+% nee„0u~x7¤Wza€¶tä*Ôikpt öCÇó %d8Dq!ôxe²'"	;*k?07é](tN fm°(ideg(v)l {Åpn$u;éne 
 (gdãõâñ÷xOC°´xˆI»­~NIrÍpxó`këah¥$iTlİní¾S|òpõztIiÏuqn\cM~}	H\$'/.8z /r$^"ñèw fGVìpdlEa~Å4pEü±Ài ItÒxğ"rô?é5sã("…/\i!jùìh	ipkO .æàòs4"ëx=}T0yn¡ôLa{p{ìE"háó0Ömd0`>s½Eåbnru%¨nmrög- ëFh© f+ò-d—àä#UéĞpR'b@,8*:±hO^!)0Ls|jf A 4©T2ÓuñípXq~ÿ| uït_9+: %‡Ìj!îgô”ed‹n%<K$57ä"?°z#$oô }Tk](çï¥¨ Àut0>¨C!äú,Hòg ÜíU v-peJğcãe#Ó2|n*àè´mdz§sdjró	u|Dm0iPn;®$kxa©Ål,db@PfAw5TúLuï¾Av-¼hí{e6O0hmn9>aOIf
$BmlíwFh>ˆÈ1iacmkyk±riu0PnH,g½e¤UBu½,~&o|òìÆ_ø(¬ek0~{EP 8k i³th æi!tc5h7r)c¡JtcYîr!`du|<VGí qwhHzz  9UV(i:áV$uOXäe,SqOCrjãbú'‚Siìg, Áfor|*4Y ¤è$8/q[lbê8ëÑĞ&lÈÆ´g{Œ $/Œ q)Q¬FCp7]h{H@%’$eéæ!;@o,-+L¢ (`-ÜwdÅô|#(F«l´)"%=-ø¹;[ŒHI¤&ÔaS>c4ñ_õnp!ò/Ëpl-P.s)´)>Êh*0*$ì=oå,{7²RaRì5DK>Ü¤…Äûë$1++]ApYˆ
«/-n;Rñö(b{$ì Gä1P)^,'p¯m¡©b˜  p!$'8mï¹5uly2b‰æ~a)c®ò4n,5o)yleÿb=,¶q*…
e0`&uÚep%1!p´isÃóoójemzUîBMn > ¥¨%çg{_,„¦#¨%liov)* a-nAë¼mqDxeèy|ó,7äAn¬#déR¯%te/%N¥«şï'J¡c(Ê8h
  ôéxs?¿3`lŒkóA`Ktö/Mqe‹Lgi$ X|`p&xôEemxast2  <-`mj>tHz!>Ly|e8ñ/`g'©]J+0~ÑyÜ *3*ø},"$$xwÎ¹ĞkÌQ.¥oÁç-.å$awm®+Ša7$€FÖ ›jiÖfk~Tóªdï#¦İü—2ò6r(óLLúü8³ùx_.\h2© $ ¨G ( 5óc[ôh10ÈZğ?4ìÏ¸sÚ x_¯MUK7Á%avúk'lß"{ 5|ÙÀS:âw|4_×änmgTT{5[be2ûìÎD·ä¤B)>``()ø&/$byg0Ğh%,çno]'ktuÀls%I€c!`ôo £nåáB i1¡Eu¤&jÆì(p~E2qs$t.4Š=|­ÑqØ)/ÿ-#ù ° lv2ó/®xd$U1;ka-­Oíè¥mVúN|“ ;oLaz`?tL}§awü s`q%cpbVe~2}bséî.¿)( @ì5juª÷ ô¼fh);5>CÏnô:$v¿ôU)zº0¤( )Î*jmB“BI¸(è éãCc÷'4tÊ©W<&Æmo`3[x§¯lXY"`¨¦p`bÜßexç:°sl¤Lhğ.tê2mq*/¾ä78©+,Àñ „+ª@Tjegâ:qªlLºerìê}$P\B0~íÎÌ¼;b^"Òx|evXmè0ôønÒ¿&7n•.>`yPóG©L[j($-0$5hI}¸ÿàEFeûpğeuêµErgopW*6Œ CÖ±ä P-c fs­å6À,d>$&çe|dZâ`z+/`ÆÍWa§a &ddØ@¤<:i3JyPt)@ .08¤G ye¨}àGIÌi lgCZdÎµ}j*ch#·?%j ¤è¬k$qfPD,kne¡pc=§kûUÇ|Mª £,` ¢.>Œ÷?urRt¼$~7@±sIH`$°à` Xë{qğ<mt”·Úoyu&)Û	`p²ˆác¤h7j_Z/*&¤ h¦kaüèdh‚Vè	võu]cwÄce r«@*t%‘3?«äqã!€l`F1<+´)¼4j«wãã÷şh.eû9*4$hÏR)+€§   k" áxViVfj	ñüšSu©Z…˜% $p1"r ¦og:e)'BzíŒ¯ff7oH¤!8‚³  b`#iâ )%/fÉmi#K8!¨I
(³"5#ò"ÕhNTàlédQLIkm'>-ä (Aú (°`èJÉéc—çYïI´¬ÚäZ­+.ª" €  #Q`G ×Ùt)éäíA>edp#:jàk´` F0¨ÀSagi¤2#rD=~%idUtaa>;œ¸a.%`# cuóE$¦ClqKGqÔfj@íeE6’­)&4ª#   €#eóá!'>å%wìi=yP)'`0hgé0 hk0(& `&Pñaàcateú}q’gtktGi|w[r…>J ,$€ !£ "C%r$#£÷åncmäíw~¢<`€*$¢*¤Kq3eÀA-ÃOäYM"VÇÃq9µ0IŠ8 7 `@âbãqwE¨#€©tOaCcêc",*"bR!@ b"BiYL|§ f)`nå$<jd"h( p0à=§3#u(egwãQmD“ò'8Å[p8 (a`bD  qó+3%Z-3_mnduv:İˆL!h¤êb" ¸0'a+döA÷cIV%²%k(3  z,9Aóáj¿C6nVOmş(% fƒ€‚` "±ka©çHTåpdJ YCéV‘Ùc±.ª5 ¨` €`pl2!1TyYaË&K%«µÚy%$á5Rò°@=%vL÷.Trg»i¡;ã,°âp$(0á  xpAk»Íbcp‚ `i– £xò©vÃçŞvCBmÕ& Š¤  q 8)a¦,8 db4ae¥¨Õá\<eı@molE>«¡Q¢ù}(z1R:t`øtûgW $Pó¬¹wß)
 *"  dG($(j%Uã_šæ0!*)Eˆ(h!veXÅS§q(J  a`¡( ¢'g(!£OSS)°=~: 2’º ëO¶á}b!giaş|U©àŞ%5z ”6¨%(õ14+1
°!)$ ¨Sx,!4F2İsA\tô¯gd¨$&Á4{/\(õS/g¢M
,9¥c 4!a  <$¤5í‘İğk1á¹((;
&â(*¨(-a5¤ fêzTCbëª"æ­vg`w,¸fÙæ­?=:&j "¨"  £0‘3€aml3`=¢¥x×-Ëã /'€\à+l$uw æ‚Š¥¨#"c b8 ì 0£	&(©RZ[^e $JjtRQ8_)i0‚ !«*èd3«º$´!.,iqF zï6&E¬em40sr8‡ u×b|È 9„  0 &"a¤  B&Dp~0XBMô1/ _K•07Sà|y-//+(Q+°€`Õ¡ k   °F#&O¯28­ü?§é=r?Önä-&ğùgu©š´zkA}/b&*_! ¬ µ  1Ó`~ "0!`$`tïğ×bÊc÷1#[‘ıAIU.$biò!ş5Èí©‚?(%& ¢!àbb rkÄ¢m]‹¨ ††h$J\h¨m8# denraen *g¯inl($bi3w1á}/+a¡b@ Ó0¢ `a   ’%*¤äÁjjdbùbsz_
_²l0eäs3W•E;	(`2`!¼`a  /Bs'í
 ¡g&0-á4b%a$!Õmn.¢-¡# 6¢£$ ÿ+g  h3lo ¤ëÏ(¨44ümpS?$ZAÉÒ	!L& µ#¤` À 4 0µ©\qQGI%MJLdpõøW"…#Uû}†o,,x©š +' 1 1p(3¬é¢` ñÔ¬ÎfP'ı?6dr$xY/V-ym8¼qø?‰X¤Í adbt+©à(gMym`3µ0,q 0 ô0`r°±wdm| […±.X8tõe_î'U7båÅI; J	h €"Ù)"°…@4|(hq!¡ ¥¹ô$``àzáâLj*Ø:2`ihCcáae€#C°Ø¦¤. € #ca‚" ä¨oK}ÒMTe£dr¥WËó-¯©Et|ä£,1]±  °€"00S%9*) {iríxrdÿDm9% g|7ÚËg)+[|8©É‚
€$2$"!)zb0¬de< S÷ëQ )Z ê{lsï²U$zmFbÊÌ]+b`Z[<Îb8&6"$±"8Ğáğeaë9É
n„ÁiqHÎf 4 ¨1&i($d%u4C })f&»ÄbvfâCÉ-Y¥*1)
"2 ¨nG|kw,FnU;ÿ?fı^V$$âitñ9)ëhd @î0¤4r^nQçj -wir®t2rß.çb=e7#Bní#¯á7+éy
r$id„gR9pE:…o($Daì-Kz%=dSvákyz("`0vinîkE8,rqb;, #?Ixaì;un-¯S2WF \,EéX2>æohÜ[['2om~]-şŠa0ä!.jksk:U‘dDhqró,e%&Fp}_Dnd2%'obw·úg5filu-V.aÿ@}·I?²p(`µ¦qn!«Æçëñ`fOp"Unq~Lf§,`fÄ'ğãmN`&mi@(*/+#hãNZOîO-p¥ëS`Æ]U!mgÅtewxtaj&hk1ziw !Ê>`oùOè"hopvõóÚkB¥mdïcBk#!c¢—íSEpJÁcpmm)êÅ„A|*je ÃUb\mná$F¾wt	!_h~dcm,)~¥„Àrû×‰ Ë±Opcm|÷	iö¿¥âof)nı7üåçïnglÈgì2pDöcÉ¤}jGf$ç/¥âAï%ifÌ!`htNw k ]£oeP`ÕktF>eå`iŠ'6
*.Cp0‡<ôhApĞè`CN^¨¾36M
ü7"Á,(²jëyd!ôÎ/b'/T4&n7aÎ`gÜ	cacÍïd#MŠ7@`lÔB#æhcB,àDÏãä3. ¹La} `¶qåh)gg1o``áÉjÓ0à%ç5ámsalåfïErS ‘I/%Uea'P&£ g{ãFõLb li\Ár^z-M&('Hä8(CĞq/j ñ/"ãaØFolÆ©¦®oÒoeáVÁls?l`nçe`¨p÷m´y*ù+‹%¬ct$)a9ó.o(Èp(ëq-n'n¶w[„bç,táZee+­{™¢æ`"/	/k©d„äx! &WláÒ(t¼cdÔ¢»÷å>
Áe~Fo#T(ofvFbçí98SÈ Õ$û¤¨(osYE4«„vhMr.?w.QrMñbo~>Nc}a×*zy£he 'ät!¬s!nbuÃïfúJ;©1" 0tiz#>nV}æï*p!);r‰«4`   ¥$X¯µ[t*r.ñ(DnTúm¤<½"(9'š8D(mp$q mp%c J{”#‚fçoön³iÍ lŒkS5I½-JXÀ`(£ J³Y¥wÌeru"9í~Çæt\cYaE,ov+d#Rİš<ep:  .û¢aj?gàtæJd-al17¢Ù½+Ae+g)é½ §¬ $ .j,èqç}R}6tc8$*á-·q¬~òÿanìAÊùIE¡o´+5P`³)ª(m
pa 	°d¯±µé{j[|ñvã	9©’~`%.í$na-%?¤J,:`4[.î.3)õP Br`8$ensïvigez›„
H¨ X¢"ät¯@Öhåv*e\ _$¡nk@N$ayâsFUgb§±©iôÏ>üğs%l÷%E[
».*&Ğ$!ñdÀmHãy'UM,u.£o|)2Úg=Çoë„gGª›Z  A– È00"h_ĞPùmÌU[=íebndKOG§Õ=&ìNÓgt,fŞ©æ¿â/D;ocäØ?I+¤0‚‚"¤5bg
 açp°¼(¸ $ B²ud!ÇenzeaéîE™Å´İ"Ueziş2Uf"#ÿÂ" ©« "   |i¯n}Sdi#eísáoRis'ßí.w{'_clog[%$lne²-Î#Ë£L‰)) .!Š mI¯¥ H;0´õi„omfÙ ûtRän*¬n3wlijë)O‹‚( ?)h õ-dpuo 0qpx¡ps°ï®-|}<o/cJeü~FpäTSiõ´.A;\4Z),((ba &ox%}FjòK'Ïnû.‚^Ïo&µ™WvõcíäÃveK	 0$(drÛ†.
!H¡*vJbtMhÇ=ä#öh)3E&.|+ßéKo]d° 2°ğª˜-&okjÏ.ö‰dP@k3»¿ÈEë}êJ¼Em¦g¨`+%tãnôcáEØ4A4e@mw-g/¢÷”foNd`ÏÀ[Q§FnöVí?[+kthqB]¸su-F_øäqM¬b'%+`©B 'bmr
Y9 !(®ã)~wzT€ kDHtm'S¥©y¸é '/9®a' ciócøz).èvèmÌFh4 ¡²!ûi|)uro‰’
 ±¨d¶'0¡UcåâeË&oxàkoL ì-~nİmŠc)¬IJd3!„dtèÄ%lÏg-!rrrifun`q6$]xºå7üÈCi0páU(}Øj4
$"?¯ğBl}ñMÃjEq8iÁ|k%r|a2f)Za°[@ÚçAäD
rF@¨,ce÷µWm<m%9!{UésTr( lû.uÁåùT¬,bu~u9Z*®}~Ùm(90;Š` ¤,h©må ¼tˆàdS}ó6äj¬ÃiabDm-¥$5$âf	!cŞ˜!! "e ( 6W”9qá¡0'p/g%z{ Ak<İ
eo1faAÊ•¸öIOG×aIku4á™4cudçmø•-%|¹#?)1¿u ğ¸’0zc dÆh~y˜eıb'ty¿}¡0 $085#l3e g	 2°°¦0h $nèõ9q5›ef»Eø !`‰¯í¢&4 ¨ æàÆ>Øê1¤Fós/vÉAnG©§?x§"xùp%;„g $4d 
 e€  D &Ğ;fg)|gL=$søjs\¶(§f2şQOEyaè2lñTwÍ`~$”îôîÁiea-t#,Fçnb%{\­ nj "ùl4œgf8ìf­¡sw g8t9f?.Ìe+aºâ®14j85vx,Mn&|ŠAß°t7K+s¥7.?¿Zq4``8€$u(o»m.iÅQLuw;eFa 6áO${ü†zì|*#aö5c`;jg!Ã'´ L"'¨êäGi|dÅû 3%F$ĞaN)RQBrõrx ‡o$Æe--àÿ¾!'%æA§h…†3Ejl5.$$sBu÷r!	e)qH?Ä ´ j 4¤ ëN`ãw0Oauh <+"Px}[/¿Doêğië øêßv¯e-çyRgì
t8}Ô·	z++!ó0@0åauDíî}]jr£5h=hÁ`í¼.>m<
*ší#$ 8 `&$ ´l-uïSCNcìG~RAfîB1Eï—GôÖküp:#atUyn4k>Dpìiìs¤) '/erbEaøm># à&ádOcÅWkô|©mõi:- v!ôh("-Qfkaph|i`9ëbe#÷:)¤ï^a`ôô”@cœ§q®à(øu` şjÃ4 ™|bo jÊoÂ-k`<:"*! *)¨0$&dswåNJe`å•1cZ1"¡x3 J?Šs,CÈI`ì8`1.–‰‚¬!6.'kfò|3è-¡1vR
>	û}*f$¨db"m/÷d!q©0(`ézñ}äOt&{[†ÖOnWM ­GI;/K
Í Cõ¢îæu=ºfn(y%:%r°!à  © 'n¨AjröCn
&}i©pröl0NÅc46&°wíÉ X"%b !±x°‚éFà	Œèa~vÇKcv6P`>btt÷™>0$aP‘3@7ó+1)
  µ 05P1 00+3 ~/!`$M,,|èsvZé ®;;$]4©.ry«-Å(¯	BV R êY @*b *$Dàes)buLŸW m:1:Gk!t<#p°% p‚2½9  `+ ¢¢!/i¬5†ª Š$£| 0$ a4.kptYC~]f0-ekª[Z£s;m®² ¡p()"!!¨ =F0ò&ùr2tCxi2>0µJxÊ   c`h(`ˆ 88±âxö1bò´cêó*]á*oË== !" à % ¤n$`0 ²²è‚1(+¤kv5ëHa4` >*txMG À5 ¸p
,$7œŠd ¢˜ C! ‡6< !$†*7ñ,Û'0ûaäd(sI%q)ÆÒrtàvúE`ûIF5\s´´nq"|œõ0E©Ç'{á<Ås cb}!JI*k` °©G%bÈysrE$*¤îé+ne_-$kàvOböVgr%]$¼ú-š€1	(°ã&âvkrµb+8È,#8tkjvq{ã$aÑ|Db%k,h&ÕZcb(,cÈAZU}¼¾ñº1áöNcxg(ßM¢b¤2  ¤† $,  g7$`p{Ò¾}=< -q;dCdÑ	Y ŠD1(, ¤, é¦  î|kĞ>eëS$dñqxB|õò }$iF½cpE~Fum><è+(ßU@@’!0T&3
!4`è#44y`(i6Sİ<b
¨)µ0Ö ø(°ºgw
…#`“
¨å  hQ 1p4ÎhspZI¥b]lci!µë‚°$è „„9
¥ )ušl!¢¢d*m&bø2)0hL³;_ø 0e){îfJossj%vm®v>aè\Ã!ëƒ_Ø%¨mĞwcí5CüÌJ8`0´ ¦c ±ys"¤c,6OEe(q(g|gäÌ}í	 Åi_·|Áha~Ïµwék3,x<d!Ú§l&,œÎ!-e[FB'9 bH@sßÁ\eQÇGH!U‹F«d,#¡" ¨<4; $;ˆ¬$Š,h ) i:D`! ‚)¿ñ2  (!(6qèûpm.¨DbÏ¥s;&uhç3e]uW$şO¶2  jö£uaäñãn†b}x2u$ûò	™‰Z, ‚A 0"0tO©#ÌJbQE*¿xeà0£nı|'+xFsL ¦ L qAma4sª$láãEéhkr¡k	+¨%,  ¥!1tü­z%ìlíÙckÃíë"h`h‚ ""¨'¦lbR-nMJCnldaîf)) 6nhú,ÊaYI+ÜÃü%'%7fsv'a[µD ak?¤$hë{½¾O2â&†ds_$çèéc$îMoO"jİ~*c§Ñ.8¯z6è="¡$ ,`./id­Y&s|ÔXhq*i1,vªFdhOÛHjLä"('$"¤%7LÉvå¶oãhÕa|!s$ñ8Kw%"d-8G!ç;YçëeuLõ§ d,5ä:ìE@ª ¢¡0`p?'„ ¤"Lä" $ôtíò7~Í3+}:tSZ
zâc2f5Mz]›!s4}dİ/&]/>
 ğ  9ğItrqäH¨­%„+hD0èx3,;ytcPj1œBl* <("yPfO`A¢V)å@HtB"Fy*w/$à'ÄdôŞ¥bRühôµ)btgFQ~$gjiegte€ko(O¢"`Œ¡4¤/Æ not$¡[Éû<$p|D{õpu¹7t&jj=x(÷a.`VA(`®smaUa`zp%$)˜fÄln g;åTs­!0(mWglá÷è Ãå`YC@ı¹IŠ	 ´e$#Á6»ckëpm§0gVmÜjğü\tÿ áhffaS|9tXeNMvvKe@4'c txx@.r>M‰ 6 (A¥pd8e\ÖudIôµÁahOFŒ/³cd£+î0" è"å%d(x°í`Ka}yEcoãŞõ}*bép>~Uh}iáåE)zPz $¡0wm_as6cåOñroyusbutïd«
Iˆ¨  à* TƒäàA(A ÔrG7oN,=$6¹lAS*~(`$vjkèM%!»M˜¤ğtP0$óqf]ídG!"q5ÔkwßföŞli‰d->@-|9† 3€ ) h°j\iRj¡½´ò1‰=;¤  âò%b¤?,ŠçPiv/t-aà[ëf$‚tws#ââ°ug3*p(h(  1p ulOsLfõlF`k«[/B `P  `*¸DuãôAr)R©põkv]D!98lv8©qloW-KPz™B `: À0%4um[olk«|eO2@j{>m£e   `½ 6niä İuò`ïa/6ouemP,;J`¹6"¥.¦k totez?kka°UbcUãh"mox}8Dyà<%rlMvt%#D}:{/íJ*sPGTìdH Axnã_o÷"…AtüU  Áfcz/ R0  á !,l@Cmn°;‹Ğ$ À†°AN`-%ü`l7‰:K~,S_4fsGpRe}]KHtã|WóÇ.gFc'}/x'«¤,bnÑwpËôxkq(°¶)/ '$ğ !$p¤MN@¤|ĞaQ%>6ÏNöoY,ö-ËtnAmsNcIöDhÉlYjl.À=o±$s6º_gGí}-6İå‡À»í%1"}ONHx>¨4 ¤&'l	c[›ô/gr<ì5@ó +M"Jg3İ~¡%áëf¹q{h)'É‰!ph1!`€à6f)kT½ê1R2+y)`s÷mv"§u…A[Fgt`.ŸaauX%p7ht‹¶-ÓfDIUSç@L'¬?Èá±#å~t—>Äîaé%l|]r-'jog<FBë¼<9?Bêttêov¥nÉthèI¢@G}d/=K…A‘ûìiJÅn'åyo#®ª­2!9¨6k`¬bçbtw0ı/E~tygi{¨ar`r¬v´dlicr+/? tn`gddPx 0>
 1<	_ù&tR(mÇ|l/@V}sÉQß(tF!ıw
 !0,À¡£dà8SõaÍÆ%<ò0r	¤- Ìg~&ÄCÚ®‹WhÖla~Lğ(ãdş¨ñä6ê:p<úAU°óh'±ğe#*He)¢4 -°$(Š)P h 0 â8ğË¹ ‚LiVµab9¥-%?¶b+[×
% (!  0qÙÀ]f0úpq2E÷àgtmASi?~ll4ûèÇmşàíbn$]Sf`|)ùn- f $(ƒh$!à"(Q#bOxø4g„t`a­m¯oğãGj-âEf¬neİÍ,v_/z2$$81 %4¤Z–c!!¢!0;ùª½"``2ã2 &i&48&cj)´O­=´Pvú-Û:+'f@,!$B|¢Fuÿxr|7wjpbQfd?Y&wïê)Ä- ,6$!@ì!ty±Å óµl	f%:4'Aåaù-/=~´ôg([l‚ €(   ä"`h¥`{R”ZäBåêEGëgu2°‹%4$ÆeadºEZ®¦` "`¨ìxH ©"b± ¹pxàQ,şo]ä'N}D+÷ƒñq4é+($öì~ÄOéASj`uæ>ršd|·euåï<$B\O`iéÂˆ ;`”"Û2-(  0ğükÒ§-/v‡`2t}T÷O©Lpv4eg0!--`2õ  ±tğm{ï½Ncoot,2Äc
 ´ëjO/gOlO¡ê7Ê/g?2†0 `S¢ |shbÛ¥V+åPqãY.bfÀy¥}+'D]|-FsTA:	   z-£`àO beheCORfÍ´~hq:˜ni!¿chl(çì÷4S wnVLiFphy±`b9¢m¢ $`   !Yf¢/$ã0qpV=-r6b¹{MJh$²øZ$0¨+` ¤<drÔ÷ĞjytnIdIvßaXUç #¶}oRX+1# "d ¡ykåÆ`dÓ¤qwù}b6à"q06¢@.t,•3Šúaà Œ`cF4|;„?€vªzåî¨¶dj`«*p2-„\!+­0
 k" à  dVhlïÿª[sïFÔÕn@st%VHA#¦>~1mI.K*á±¼f }cRAâ)<Æ¥<;tHp!9®$l1'eŞ.ui'k0mªM,åGv+¶.~Fxãrœ?b("00%à¹0wìAh²iä‰5àFpĞDÿ³¤Ôär©+Š0š‚ ! F İÙ$9àñü`2eF0%(Apãi·OC4 ÈU &)¡ 7hY2o4mgSmae/Õ3*—¸bj-`>dkEâK6¯aluGNtÒfaQ©/Ev}×õh27¿&%|¹?‰Ë%!45¡!%¬Y*Qj"l!è!  i(apbf`h%õKòpasiåwpaboUWpuzob”8C.4÷3ı5&TO   ¡¥ # däíq`¿*ªºrI	¶BáS@W?fĞQ)¡AÄ_@&FËt°ud…}NewèsOíd÷ifV¨+¤2`) "äa()($#bV"B)`" 	h}¤  ", &¡$  `t+Ni*}áy 2'~dggòSq@›äq9ÇNA:DibvG4(lÙ3P!z%2
, ”2æˆl!h¨ãf!(¸2 ( 7dò!§"$$°)	p3	Bz.5@áğB±i7~ebgı>fm.tÀçÓg2	(¼kx©äI+µ" ,$QA ä‘Öh©4æpt9°a¡†utf/)yWx@$ $$£µcù|4[¥YàA}a_]õ'Pre¥Hù8¥:ó	(€àt$ ?à.,9H `¨à``tÂáMsm–|¦lİ­wÛá	Õ:/ctäofõˆåXdwå0inæl pN$n?ldª¨•¥$FnìFKch6©§	Š¥! | 6(jùté`n8-víô¸sÓ ,å?6¥uG "-®&Œ8 â1\b+Q-]É4dE`YÀSåm,f .je¶¤®%fr)»GD£4$"5“‚° à$¢£!tc!mo%¶o_àíÎft`Ï~TÏB‰	+õ4g,Nµ#-;ŠU¹`- "$3ĞeØPD4ù´ $e"Ã03&Tië{!YæVE-1qågæ*%q5,}cP+æ”Øğs'ò¸i("0vnâWhjå!not¤#oå~PN"çÿé¾1eAhw ùw˜îş6'/f~de 7 ³t£* Asd :Kn5ó§7ï‹  $ $Ì\¨	.f à‚9¥ì#7{(gx ô5¯#n¬|Ba^b0 Hnr@ ;_dE!Ô@qÒ(tëhòxoå»$÷(thapF@jé"ä]ml<0cr5‚duÇcyĞ hù09m.b¤!¡B"Hk?#arS} 4m"eBF€17Ò,O/ln/i&UkµÌgåå9j#F´[O"4I¥8 ãşE-ãèor7Æï5$±ò dIæˆµySsue1ftt[kHı·ğHcãe~nx-a'Q)§ÎÍjÊ ¼%' ¨`Dym7~ã+ş<sÌ¤¢P†æ.!e}8§-æfbZfoåãou¸ ÆÖüiÎzC_o¦i6glengsk_;
f° (h*lGc0éG ¼+J°@I Ò0¦qem &	us1´¤‚dhi¼"bnf;_¢j>näNcGÅ])ZN8`)½naG%ofwfïÚ*ã­o'56áe7kla|hÁ`f/æt€wcsîït,óe4aaz`åYsnc3´£Ïo­"4èm|w90(¾IFEÈî5t N' û'ìXctÇ$0°«0uHi mayPğäVx„cSëgÏ4$FîwŞlciq7J!„í£kğÄ¬Î`P|ã<<fu mecv|(hha?¸qî%¡XîÍvanVt+ëé$fMihd&4·po plä0cUS²…t(v¡^Ñ°*v4rdÍw	wì0kU.31Öi+ ApìÁcİ(}â“at``qq3¥dŠè5`b…tàê^ca7Bõ2iiyCcådh‰:©¢\¯   ‘ 6quÆ dá©kæ]Rr¢n@†WÊón¯­å•.
}»"­–#wuP!ux ~f	"ızrqÏ\v%Lat3ÂÃceo n.©Ü¤
‚Mou%NcgMxj0³  ! Ağ÷p<!_räqhp§ôe:vuCdêŠZ"TooV|L5Êdxjw 3ùRtåYñ e}èqÅ(fëzSp\FÎ a`¬ 8®.jVmld!apE€`g$c/½Äl!ny¥aÁ>A¤f=-<O"bŠjH>a< ^8dO:ä-3ğ^F dïo0´`+ù`~ @	ì, `t^isôwow%dè|:rí köh9nxiF&îaãùkàq ~!nm€ct%DIzÇm*qT|dû%Ov.ƒ}f_jàjytåze:qeläaE0ojMnev%!0Ipaıwww,ÿ]4XFPHeE±`&0kèonÆGD.1JuC[flì ¯ptètgMn)WxU’mubpaş4@M~r uQ}hj'$1cV}ˆófvmr0<Z# åPp÷EiRH{ºp%`¦¤kKmé¦ïëåha['
`0]Dfô(ebÕ'åòdband³ klEıUDe.f$|èEVNVîS!lÀéKbÔPUe`wÎlL!Rdwt&fk1z}{öÎ5@cñGÆoq*dyîæÊvK¤abıcBwuÂ>g¶—®
tHÈ~`gO/çÖÌMn"kh|âIjIjfå&P¸uaKU2sml~Vn~~!,.6«¬Ôtí×€¹WpsmoÕt²B¼¬ êuf wéDî0äëì$o…lTÅ$9ûcÁ¤vrGxöÃ!£äAç/e*ÌŠ(A$ Hs#k	WQ¢r}feôo
>%(f‹.jEh
.Br-”1ğxRuÌÚFoN^¬¼0 	î$(sĞ"(·nêttaöÕ|k&&]th5NÎ@!Õ	1o{Í‹`!kº/z`mÙK$î`cS<ímˆÑì -&éDi} |¤Õ$ 3&$`éÉ{!ÚPä,á!ôfot©7¯fHHİY-i]oge$hk±azíD±
#!q|Å UºtgN ($suê;4sˆp=j!ù/2ãeÒJeoÄ…à¡g
ßowĞRàhj?)$têac	¨`åZ·ajõ
D¿%Ïcd4,-m'©*!-Úi
¨0if"ˆ`·sDÄnà%t+û[&bµr°tâöW&h,Ac´e€Í) $.œêjuµl²»ç÷':ÆW~eo#\iDiuwCdgÆÍ!7[À Õ$µ¨²7%`YG&ıˆf|Nxcp§.IrMñge~)LcY?ã.PU- çmVeÕf#¤kuacyÖëvóVd7)ù
 8 &)"4
tnFåä!z! yn¡õGod Cô%P§ëSL"n<øbFI ´ /¯ Rıf xjüÇ0F/.db(q¢!i c Ooœ3˜Péo†¨t»mˆË&fµhTwLôu`^Äfhér\»¿tÈe~1+ÜÍ
†¢ :# Ci}B4d6Tõœ~ozz <èõ|,:eàuâJ Ktb 0 Õí&e;mjüüS¬­ta+bk>üpæe?VB3tg$&¬/ŒCFáxëó "ìIËó)á}ğb5~÷P`³mòI_wo#µe«´¶éirtømì©”d9'3Êef]$ÔhåK<?k6S:î,{D!ñpsaä<9MJr 6(fhi²¥<AåmTâ2ÄwV¾Fıjæp''¸Y0…jxA!@$tyës_wb¥¬¼GıÏ<¤õ1$næj#¸. ~Øe5ñ0á}zâm+VO-4€vi "„t8yÏgç‡nE#›À]['L×nÈY5laLVBğ`Üi|ûqkJ
 ¥/+¨XĞe(<8m÷¨î·æ6D=gcô’hr¤x‰Æo¤5ng wéeét°şU-¸¬xe§%ve!Êmgr!wèå “õ¶×!\}0sü4Ug	 "í¨Âcm¸îq as-}e¨vla ta3]¨gënP"¼à*H|.Ssl&e{i2fxo¯,Ü Ÿ bJ­{‰<ca7sÏ.`C©ãaN?,ÔúMb $pÙ	ó5bá!zbE®|{l|nı3<(¯”(%3-jfÿ\<z4thè3u<q pfåø”lt	{7o'j^eıl_µ\Eeİ²&A-	
­_.*jMˆ2.f~AsêWg‚fÿ2‚tÜu µÑWrµeí¤ÆjyD9gux,w`rÚ¢t^e I¡*sofmdÁ… ôAöc! Tc#|"Õéa|B]`ğ sòEAø¯„"fuw{jÇ%Ú‹`QUk´ñĞ «xôRùFUl¤kı`2$qé(ôañ`fë"5^A;oIev`JzO"´ç Øt$La<lÖ¡O
âUï|k/~DaaBSérq<V[ñàMtk9ÿO
 ";g\e²N ,tlkZ<f))üÆ$>uX|3QM‰*KBJ.2®£tô¡c'&%…gU ukğgı0k8ÂeÈmÍW +dõø1éao8dwc°œ
.
ªdÆ%%#¡]!ğävË4=Î:/æ=vG~ÜoŠ 7 MCo/bÅlw©„g/oìf-,ys_H !&db-Y8¿é3ñÂTq,vàk{-ŞtTrvNaOn¸õFtyûÃ.L+<+clndl~t:(Y-ª
Ş®HïJ*rCFP[±qGe¤²[m>uf gzpäJIhn(lğ+ráôèe§s:=VeY¢hj;Øm4P>nVˆttµ$h­dì«4xğde90é;ã
`¥Éa "%R|,"¤$& «hfbú7 <Y "b <,6\“:)²él:6u+l	nÏour['r'] || $g!=$this->currentColour['g'] || $b!=$this->currentColour['b'])){
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
  // add :`Á peAjnxÅ,Luvka9%4?ğèå yás…'~è¶i0(+{R(¥ÍhñY&¸n:k&cgc~ï6}°aÁ464ôãkgécş2r-&egl
<en@{&=!hì%~¡
 ¡0n' d.E6 EeqmWá]4Tõ}íbmbîS ¤`knd¥ğœ2J{(lhÕ b'mg?0¸&F5$uK {åû7-lr`hqW`|3i"7O`ü*ìdc-yM ¦`i"·£ó×7éh&Ó„ˆÊ)¢ `(p%Ï>06lTÿ`wŒï{ ã~JucvåÂY ~j¸¢wd,lezqLj"üêir³l5g' ¢ä'{T0OÎ€õxìnP(,dl?ê% R(:dŒL c5@` œ¡p+2…g‡ 6æ>SoNgs!03U +. 0 !4 `(ò"vZkå£_áfe]3%rÕÁmjaCÍz×<K}IHwQl){Q€¤¡ £ c%3p /a k%x)b¦¤´(B²OL¨.IS“Ï0.,„èùW‰+Anuê<CZ>v9aq*?#yÙ0gNtíl®òmüm£
—o;À[ä_=iı¹' 0 ä B ‚-G	BàöQj` maaÂ	»¥6}onàszbt—lö ëP)tú`‚Tbén`ày "jb"¦`C p/DJ0	@2¨è!4+? 	TÍuTn {ëi÷0JäAƒæ‚i; LgQÈ½ióQenS`toğyaTrbæe)]Lbâ `% Üxª@Û-¶eSVGg0*uó{¥:ïJúegu[W¬ezc3x%fqbvujvácoqëJvãMZF,pCZ'\¥ÃO¯|Av4¿,i¤i[-Šd°Ó`($0F
`ó`  8!Ø`9ejõ½+l¼‡ª0€aese£Oõvåî'ú„£Bè8º"4¦¤ğx`WLaGtHgÇbb:õcp2Ód`eÎãF¤lsi `dn0„P!euÏóId3¼lµ$w ['®eRZÉ"ã@y(?égb“nâG$g,âg[§oäØAwQGï"¦ ª2D  ‚©Ö* $ ac2=_dãa#6·édvi'0"j!¯]ÓFõFt#«M»³ùáfeF,µp?54¹{/# `ed0¸,$è 4+º!WèCvk(£ ô »`„"y+cê:`h8b:9%N"B @àø8¹Ã@p¤( z­´ıviû3m)¥r
¦Cèrä eedlï:) à 1± 5–w~Kcw>aPeL+mqqNòú$ÃliRFWt}'Ób-2é$0$
®¨nG`.ójåãtyem¤vdhóå/gpt¡#<“ÛDu)(R>j5RºMj=CooAolÜJgonPaCô_»-K() @ °`!	æ		 üÔ¥sK:&`$1<AÓ`g_eoa+GËtIE]Km4o/Ù%àáwÌæğÍ'55R7>Qr‘ ¡øa(´ò$$m+a-}Áv@Ië`qÇw "¡t!{†}#0xácËãN~i :--Š¤ƒ€1 %ñ9}-" h(Šp°‰`ep¤u#z.¡*@a(*sá3 #¦íy@2G0 èa+€-tzéf¹6Ç$¤Äoos¥gJçcdi[¬if^-eì?}3/90	0(` Jğ³k9D¦C`¦¨$n%wC©#c7TuAÓ%j~>+
¢ `2+ğ }`!{/&ãfuÉa N`óEg>µ)uİo‡aV.N'?.<.Àp !FrÕ¡˜4$i  $cBsb /\mú|!da'[ (âg@µ  ¥xïó/1\OéaìY`*ï[Us]=©g|1cë GuJ`(à ¿0¤hbÑlkYM© °!u ´iŠuE˜F®¾	90h$Ü jg;Ôe-ğ"u:4^ã+âÏù”-åf´w4anbG	?@z%!ğM÷¯{õïctëBn¥aæd nbfLe’p¬ˆŒgäd=0!ñ 9$B2ìmw$îm$gn5} }Úk5keqf bàbT| èqOÎó2ío$]¸AˆX`lafí]Es*_H ho* lïL‰åY ìaíQ8T[(æ¢í2Ry}q qúaâr ñ5s5e`¨aóäW÷x½Á
…¿ 96` eei`e`©Û ñf£À r@ıtmmj etÁtM?İ*S|ª«Ú&is†ëa|¼?~d,e* Q`arsIHy+jo*õä#]¨`ñvTy0hçà(@%¶	ir‰dËkvHqÁEìk$™`T'9ôÜ}w
d=%‰mE]¡4si@ãalx4qkSç>. £)b*,icÜA6v)ô8/Í¡`d '©W)R	¤¡(nI{ndñl i`ecJuH(m1Æ¼.{8eÒ!ZLd"«P`¤LumrtäOiÎwl ¤TâÌd¥–xvÔ?VCÊUJô|¡ì¼&6e‚©¦(@@±y-ë"#?#olÊiyŒh¢ $EmÊIQmÔiVh~òq9'b{id-nÿêî/Ïbrí'ğ®",s¢i–öén1a): 15_+yÜ	)l8. |&Qaô@—á ~ùu?íğ€œRäit$)Kuò&w! t``0fsò•yDnv¢PñğyWêUøß¤tu*ÒrCGòmràbI 7By¥3*çrm,Ic?
G/yüujf%t`ôY2Efereî;"z(,nasái$b,Ì|}§äË2	*1"÷"](å1`~D}`çb,á¡wÇã¤9` @·$èBy±x(Aã#oÓ!"zw(&`lèf0KmHñ1¨5&Éca))[ıiYZ	Êê<érEn-+mz4 ¤ucpöág@(|eâÅhd`s >ÿ$r+sJ 0e z4|‹Gd¾oW"=ahqn˜t¸acíPãin×Îo7IÜ,>usg¶5z reb•øengaw%´%WìGfªdj=>öå+K‰!¨¡5,@ QékÅ,r	 f~|E4fó O\Be{cl1)hdğia-şË#d`|içq 
6eçlrsÆÏçmSGjqyö,`^2aù ÂPbmw]4.g)hYg8!ë "®’í‘
/*,		*àğ•Sesdba!.—ueó) rÍhA r%r<p-n$yÏbå@âmt(R6wmaiÎë-Û;BAefz&Y³`Rpj©v¾.+ggÕCúEol˜PHÒSgáuSyT/ù<2%tyGa&y{-¤el,Z™
ì#-o„j}wqrn5pxe0In´mçQ· ûuğúeiUnli~ëy3 ê%= [uvâDFûë,È†tGsèói4pa‰leağ!=
  •v]4%r/'0%¶¯–0)li?2ëq'Šõ>»2ë:?-Skh!  V»p…“epez-7^9è8hhp…Pk¹ÅÒèi#tEv{Y%ğL3)M)8D PÍ
"¤ %æò¸ÿ  Æ5õ*O¹9
¨#rH_ =Äo`LVGG kÕlÅh±éOlO"4£d mmfs}%^tâ8crj«ã  9ìa
8 hzCwàqîka\Pp5NBI8×|ts,2mO]yÄ"&9êe¶Kzv½I#õYÃç¬Md¥P|{eº+fçiîf( €k¬%?¤±¤;!<ü2¬Æk40i]L*á°I âeâ, mÿ8Y`°+£0v)émc äák¶Röt4`hì vPax(ÙGdjö_„´ø¡ ñùsyd¥6 6 hÓ/²=ÿ/ f¡g>"Het‰mxá!aÿwuM4a²[wä8pyÈe,j3è""yÓv¯eC—f)‘ÿotísQÒxn29oE8x))Šp!§a =ŒĞ7-ı'l(%oõí>.+nz"(ªU®d'I&3‰ „pc32wa.ø8ä@ç#6
! )°gLEl9(%7-ùÖ,g8}!ó#c"ã t&q0e¸Nİ¢g2@bf©,g°™pñ4½+)™æD!$_‹†drB¥\Ë+e(-ære[šlù$!pPa ûmA Â€¤%r2óãb)0ƒâ "§,q{¶kU¥r'p=¤?nvuæ`u!my`ªeŞg dC´¯šÈŸDû'4iò$E#)¶5#uU­x}y7TÍ|T(ee)$p 49#O"b‚¢²Ég z$·±=2*6	<-$Dq%xÜDJeb$(wHx	5µç<cíí,„ x#ib(s8z¾chò•9lÌb(@Œ¿ù£/C~s 5´	ãb`b63ªQl" 1ñ;Ì¸ (`f"lS} ğtf<,ávÇd1&½íO,lEãveö o¨ê´ ,Á ¢6Œrw‹b'M(”(!&",a;p{rõwg05è'Ô¨Úq""ifg(Ì·vb1n~ô @e~ "k$6áNfåèçaexk,-n.&" ıÌZğ<Åˆp!iÄ¦é Eu4Voz
Ÿ-J! à$ï¤K`,˜0w	oâ`sK2#&$,8 œp»
  ª0­`2W &ùxWní `alõ­:-¤"³/s»#¥xíÖ“õg`°t`a dm\=¨5AÌÍúö	åAhïã­#lenksŠ"! ,0e3~å(ä\5`)+D! yäh.fÍãsuZ=&#+84 ´édsq ½'g±
rpÂ¤&"p¼3¹/•“©
 ±3!1Hé<g°,w(>h|!j+{Zp"à ¡hijKLå"d= .zHÑ)* RUT^{á4ÂûDiPj¬eaôágt,” 5'6p 2i8:|ú|yxq¤v6#uDQ\rXàC, P¯&.ä¹9MF¯7à( €"0eø8n $÷`)Ÿi~qu5#¶ä%*$#:÷F*iåoM§9b:àv³ 	¨ ôMI ‚H ,{3aiel á31Îïp fİ[:²&5+XAitp #OZdpC:$!B°h6d¨$Ÿ#§hís °s ÿÀ…6ç!!$Oa h °Îalui>rIc8}®J&%ßc W$n[guM
   `;¨è:˜$ém&oÙ7'+´fhôI´.e`ir=A^MT÷w6B9/s)”ÜetÛ„%ôoX<Pé:€qo ±:	; `0IFâwP7jG0FxTãYÍe^`'s+>pBNXf4´Ê]ue3¨…äB4c<4t7sÖ²©{EJ,E01¨}!8î`$i'N.Ë‚!åFgr4`«Ñ<Î`L­‡VP5`G4±«!?5sÍŠ"
 A
¦ª 0,cv~ïM;fEÉ÷Spkøu-¬©ve®¬dé&õYdao1gÄÁs%÷!*¡f .pâe,yj.eS§a<h˜¨uëâIm.™õÕBïîşAurl%L$ÁváÙ ;û]	9Op( p* 0¤0ğ,iZfkZFlHuA2CbÖ`½o'G-%ò~(­Eap;:eh;80 (™‹Ba °„ @  wi*Jo¢hj!Z,E á|¶hä7Õ<npd,.$áŞpy€q+³0H¨~Ji( )¶!,À€ '!ãÒ#ù4eğ}0#O
È(6Í–¢(`©y69-iîfo_«ëEm@Z%Ç)iOaít`+Ü%]-°/BÕ Â:"!T  ` %Ev*ìp?=/œ -$d,  L$
 ,Az02dJ0Md§ln±}s=¯²wÍdt2·IYòmdt+»¬³íeZH:<­9Q¡ €@¬10::}
 6$æ+¦1± Qb"¨$w/ægñc6dlqrE}DŠm`oI%q0i{•+$£`l °q !‘ `rÅ#XnR)8$$#i7'h0a0%mr|.øJBb¡­<-djyUztï{rIÅbÇkdäÍn&oepTk$gq	Jf(c(0	l¨)€UN¢"¥éè8j€ærUhâ;
048 1l°e#a0/Qî¥•
   ! & ##-Q'+f"©yuì3}öP.ä!0!&Xîá<Ñ!Buç]OPº£"Œjc  ¡:``fêçaè3C‘5 !¹pka×Ï$çYTD.>ŠXhĞ(0 1 p ¤=xc,í,\¢ìjyhâÄÄx"c\$E^ˆ7sèõxkÊu!!F.	°q 01ğ$p&p(²í+Z:k€`` "5f+cKÿ¸}vGÃ¥"lItc¨È¢ `> /¶fÀ; bz/#)ÿ0ëb7èm\ -#e2(»ÊoÔ(a.d‚éa¸ç5q|0bçC,ÚhÙD}r+VAÇ0d¾E Çjdnb`Bî¦@1e/G7w°Y\ADfdrµyo$@¢  8$4!à 7`t{€3jğn¢cw~dDgcçíë‚`4˜È¦ ?0‚.4˜ofoz¬s|NgkeùXe-U72¼Â"¢¢3:¡¾!04&t)À`wÒ¥l9,}pAêcş0Ÿ°`‚ct6©Y0¡!0€ "cCk´ ($(,|oÇ§#5hï²Ô]òe#\¡5±³`"k#(LgĞ5pMr!&iİ˜Rfw&™
-A("j¢…1. ¢_qpmp(5N$)fF3Ulşq—{ì I^à]4P|a€øÇI¨…
(¾@D*íXe¥äÃtèd€fn8ñamVE"/dã]2º ±
ôtÆ#‡9s $!â 0$0Í`ğR@¢W_u`påláuàq°Qı\õì tò¤ "}V†Kn"X(2J¢t0©.5$EpK;l¦¡+3(
¢(  ¸h %;”qµt$ 0  +)¢pÁ¥'[@ù|hàb#iomå í/äÒ1 V-Z(å@aL@QuhWte#%ºtBŸ< 4q¢m|wáIthcrn9ó7:)mSwxuö:aÎgòù®S.C 8    a¶$/ànPñx$áoá·<p,RP¤8k@Ùo2[rÁphkd”(È©f¡!0nw+7rjôih{i ó™ì'zw*~ º$pqqu§Z;dãd9 !q>c>qH`#´gV!q`" E X£)€…è $Õxrn6R)DGlsğÓ&´)Âõg]áŠguàmj'iç3! &d;t. 1EŞ-Ôalç4zçdíò{0çÌ!^lpa6s#/™3Ä"’Œ0¡˜0¤"à©d5±¬S°¼;ßH ?™q! !-©t%!nÇğañKíşQuoyMel?$!:ŸqLk,dL#˜/pl (` `&Hd¬MÚdEC¼Éa4ò? !%(M*1¹kóN
 ¤!„!%$`(´€0-)FuŞ /Q ‰3Ë*,$d2 àâ#¨¤Dº7e‹u$lc` ¼ ! 2(y£
h,°Æ8¸ @%(”Tván5PA²aZìS'äÁ6#×…(N ˆDsaï;c7ªR¢l !8%$>¹Èà "Í4P"ƒ´wğål#§s$ùä'¯¯wİG£}KjT(>Í¥\p-÷ :wx"¦kwb`bY_UFeAm,5!P
A !.:`i²OQvÏş`yjd,üï 'jPrior`nà4ˆe¨íb‰a-7|o²EL¤m,à0p$8±]T#8Zh6 B},JãnBmögl$2E>*¯$2Ş’i½æáCğø=t{. !!b8¼¨  x¾ ‡g90; g09 b $9US4fwx!åæÁi_§ErqycAíu/g54uD?¿$ÒZ$=
G1@}fUÆ¦2Q4aò=Ï2*Û -!9w  wday&¤EŒ5(
   ( °¤b*d²9$rvo^b=`W.iù\%Õkp @]=-znş|0E$+N !°&ˆ #3á 4Öqàoópğxmî£}i·ıÅvN=˜ÿ5´´¾k‰u!Û,±)îG5qk{­!($#: +*?!`%((4&(ç`%iwäY"( ïdo]'bïÇÓÈ¸voe`1}°" ¹å- vpõ]ÒFílöpu$è e4(`@Š!3*¨cNVbAw`=dnŞgitn!antóiå=0hl }(kpql5å îõóç#IÚ %ãè¢`*9ä L*"¶"*y$u÷.(r`ÏíVf4 n%k2Ëvv`§òeh)81¤7¢  ffpaá&,“:|%ƒ670bö|Ç3<w}cDpğl+N5ü^Gã´M%ø~H(=56	
 6! !" 2 pb`5A:à(rqtUC'Ü`rfa¬¢4~"‘¸Ôaopåatjjo7t	2 ¢ `¨"¤') ª- * ğqâ„€ed¦¤ ¢e„vhê1ó`3eKÑIY»ñ¦U}´tXi1-­ÔDTGçÅmr¹Ee§i=Å}“L¦p)9)¸Dª/zˆd\}­İömåûØ®3!	¦(ñ¤* `"^0,¼+Ao\qCs'ra(áb?!å`)wí®@3vôANZRùt`[­¡åªtg-›y«‘/(2;‰ #($v‚wÒï,àõ:-<'k\~²Åe! Ä`1( !($¦óacpqg4enF@dc5{?$ölñz!\sJBJoemle_R¤èéCº q3qî2È''Ë fs8ë}tÚ0£(½îçc*] d$` 0ò!¤>!2* (%"*|8çìg•5y*G© %$µ d€  'uNrÕwq­P”d""xdkh}7!ğÅmiqª<ùxo2­ƒHb  £€ikŠ$² AòP »@¬§Î L®`'U÷`KmP /€¢Š( 1  «rrgc?1¥-Ù* ( 7,Bfuáy5Oh
(¤z©=©A""\ÁZ?L
"8 %€¨}Š$„läJ(&i	`1¾äw0"?“ÈklÛçæFJ3š|>!!65¿›" ğ/À `ª-i
k¥i-2aHõe5dv£3.$ $&  …LrroR,}ˆ!;[1  ¦­äb²íAc¯*b6jmuiZKe6ao awclgp‰Hz&phñaqÿ#¾8M£4" y©	b}Š1yl&()5rw&?	†N©fJ$fm^.f[4Lu	wii[+p)SLhl`¡ğ `wrg¦=71+](fg›&a3aK2?wç }7Nn_i²&:t$gxxhi5ie2¿r hr3“¢hcÀäu<VB de66pŒ+  i+0¡ aoşªR9cÊ2(`Mj {dg_‡âgícGXS‘6}¸(-$%FIlâë{ñ~¬mPÄñUAe]AŸ $¤$„9N§oÙÂÃylsÂĞ=üe¥|'™1%»O #©aFb$epæÎw¡¬ië™/$ãddhDqÌ7or63'8-$xCívÈ%RÅzwÇpQ2ì°xo¡F yr,a|'n_1â×å°ÖNu6fd+nRanèubihçQ(>B|á ñpızmº|gÍ –k´`bDal|4ei/cg%~1®‰""` m05.vj#¸  ¢llYşav!`(¢ìaîgf]EáÏmëR`i@EÇ-Y
!! Ah i óÕce®¹]	 ±p",."soÄo3¡ª·$etycMRG" ## + hÃ t¤~fçíJ3 µ 0 ¥8*()PR24Yk÷¯$&""0ãigE@ˆ~œ"
 Tª8!`& d#[i276DC2ëóEFf­N¦¡`t·oAAd.36hEc]6sm
`@q*m$` :ãrt	x/.=²  H -cÑ³c°8A  $#`i ô*8¦é¦T¯²(§"f!"øgREY-şE*b‚‚¥¥)b2-gg/e®c+:5ˆ dhj&a"ºjr%ac3ŠB2à` ¨)‡Ne 3E9E-"%]ENj N 80u6Šnza~sT 	>t¨i3-i*FÍecccmb¨E@VPAÕk~Kc°|¡§6=fº^e{iÕf¯+
&(ğ"yôTpr.y‹à 97‹` e.!i!_<B9+…Šà8 0%o=%X&%FlNCel-h%i.=ñ20yf^nZ¢WiñşzT+	A(ı-B1 ÂFd6q+-x‰>]:<`!-h<)S© ñfgïS†`}é®`5U/)HoËÅìEtøf]7:("eoL?+ävy«pßz8 y÷û9iÁ	 ¸+},7ghl		u AmYw!dèq2íK(¯0a d$)T5AM-Mà4|ñq¤jpeÀm$¦Dwkk;…†3h\, Ñ©I3/6>p¼+M,&Aq%
à°5.dbahu˜lrJfy5?: µ6ìa`-^lu,çbi*;²¹— àdhÕñ¹ÿoşIa"!eÈ6t*mV­ob„íovë<
~aïÊa r`¼”7]f.le3}~ béöaf¾/5f7`¶¥61UaaÔÁ÷éG/:g$+yã-. =wòy8i/|~¯r&<†i‡4Ä(NnOK'w9.0]%+)5!0,oPôcf{k¥ Y÷ves('|Ñãej+-Ï>ítKaMHPt{yƒ¦©¨¡g`k%#hôcA%{k­bobäìô:YºOH®&J[‡Ã(vl…äôZ†Í*xté<C#=4ata~!)š1!0ñ  £)¹)¢›c1 K0à^$2`ì¡!&¨0"à B †-GIs¸öA^li!cÃ¼¡"U-wÙz>q>•hîjÛTheëdÊT$Ôj%üaP!f5§vB!%'SFL|T=N4èíi".SÜÇXn0~¯*ãotíQ‹«	‚(*hL$
isÓ½dóEvrSm[rcğ1|cY	+k©M pdnkâdW|6SÖ|¶BŞs’esDF{=6Huğ{å*ûYúcgj]¬:  z-n!"4txhã#nkÿX}ãnfD,hJY)&F\ìÏKª,f!õ,b¥lDiÌdòÃ%I
-8$eÍjó<OŞe3u{Ù´u|»Ó¬:€trwgêVÖnì÷gâä£\Û=ò'<¶¦Ø|pzN	jp@vÀ{->"Àmt"ô`S*4fÍó-¾wwho`gQ~güt_5Ä³](9¬l¡.07J ª`ZŠ.å&	Bz.h?è'"Œlªg5,"?Ë/z¦}èÉA5SO‚ëMcæ1Ş2Dhéƒ­Şjur ef4_^tåk77¼égv-=:"N.¯<ÛBõD<  Fª±»¥jh$µ'Vm>g"üi#E{O(mw)¾py*ú%$8Ë/Wø`fu3’
#ß.½bNÄsSEÂ1Ajj*9%N*CäLêü6ˆPÁFpà-`f­°ıfk²5`e,äxF ìGêr¬&erehàt#Kèe=» ?–gtJcwqgY A#depd÷Á6êig`DW8$[o›c($8œâ70&H¿¨:k	(ù$ë«pqum ortáåoatt  !„ÊPu? xAym9¹P*=égle!lØ
a*fchOì(m³in/)bM ÕD  æMIaîÖ±K 4'' <-@åflTv"`(AŞ8BejcVm‹7l)ù05äá`Èå Ä-!~TuvAreo– áòcm½öt o+ae.I‹6@I«aqÍw (¡tkjÆ}!xyñvÓãOc¢(}-Š¡ƒ…1`cõ=1,kìg9‰|ºÒeuqºw%}*Ia fª" ¦ôm@gU~H-áemÃmh4él·=—Š¤,%s­gHÇkdtk­$}mdZpí;M+ 8yItjJeHá´u(t5¶Ka÷»N%.º!B0uI!iv54ºtlpoö£Jug#gnP÷]1©{ f`±Nf¥/%}ó`Ÿ!>Dao§exCoÌqleE;ƒˆ \0td{D aOB#29*cûa/fk(S>93ÏmBµ$å­<â2`88tGùm´&+©l<49­{,`¨ Sfy+åà·5¦ij‘]
Q`é‹´!yl¨´q8£2e¹	@ ´ y=$(¯ i`3Îeçka 66$éoáÇõœ!çw§#] r-  hì«-xö ¤B(¥h´&2l"jDEe™P¬ˆÍNGÏ>‰o!oeöatäzJ ¬}'/mÏ	-M¡4Ô;4om3båIìazªämŠ™ 2\¼Y€Y gegíiSic_xundciZâA¸ñYTái«œP8<ç¿O!Ascs~qÿuézV÷=n=a`¡(ºé_J±Ñ¶gÇF¸´14fleei0c`­Ìiôeóé?oôywe)i¢LÀdV+›É$[má§ÉcUp”ïbV¾/zt.d)mYj&pcy`Yjf*ı!Xî`õUPI
0p¯©J'š %$p‰eßm6IuÊRög	éaW#?æß}ŒwNa%1ØmS©${h ç4z<1kIà7}}I¦4x>$hlôA.h'ównİª$c %­^cvS­¿
+~‘m
ikjr
qe4ô½.x8mIgEh5tïbtìF0dzqEåe~‚ff§VáÀ$Ôpoæ"dCÔ©xñí¸;0g×éç(@Bı`mû f'$'aÊi pìAd¥ò%LmÃjLaÈ`Sju°Q3wGyld(`òîî'âhs 5üã?%w£g Òåîhla,}o4¦s$r!:údhd o-t'@ióE‡FàñnÃt?ïìÓKŠ¬I&5wô*w$àdd|Jesğ…(Fnyî_¼¨LøD½7“¬0}2Ä4QGáikôi(0
‰!"§.uhddaq&E}ìeB` l`ğk!Tlm#bı:2ljuca{áaDzg<¹(|âàË*!cyaåÂja-å,jzwG}LÛ" §‡#Ãâv§$g(Meûdx±r$ê">y—$a*E wa( oèftXIø!$èumÁkw(![¼pEz	Âé 0æqF.7#:`X=
¤=X°â/do¤eãĞ`olq(råcaj`¦n*|w/~2+,³Od¨(f,: `eJŒps°emáAíslÓËoYékeq3d¤5i¨{tc„èmeeap ò$W¥FcºVf"<	êæ,O«,L!¬‘2µ7%[bWëb‹sbu,dbxpE8fò ZkcSecp1y-ibõ%`-úÍ dsxiæ0´
2e¢h{2{ÎßåzGCp>9Oò$0 ï ×XgzwCroe)se"á$ Wofå”àWOòIoi,Resá áuzapiO(ƒsdè+2ÉrA q5a9t9d'}ÜbàBâoe?2uo!l/öé-ósEAr&¦nCdh©tş&ce:)!ÕyKøDniš4Iø.+añq1iN$ü9t uyEg4i)n(I dvmòaò2RjŠe}g1uhysrpe*µ.¡Q‡*«páî ,ami}Mÿy?±!:
q2¢FDõå.É†x]qŞ‘1!”K* !'+2!/^$eb/cpth°¯–0hlk7*æq'‚ñ6÷2â<>~Sekl"p¨TN¹“`Õtxe`/u@z0é>mhpĞn¬€ËèakuEr{lg \(%m!,WE
PÄ%/"ä%!æø¹»éÄ5ø(Jñ0ao(ìb]p}e]A<€if \Pes¡eÖm€j¯Ò|(R%7§,"tie<'yxç3ws*ª§ "ôa%(tåm{Gwì|íocGws<@I9Æy?*2}!aiÄ&%éj§vQ}Svµ[)©Êå¯I;­`:eª &ídä*(æ”¸06¥ à< -úŠàs *qMlmæş[*è!í"µyYj¡ §0>0‹kC
   h¶S¾t.o9áDvU@xjİH`j {ô¡õ¥×èæpjk¥2(t()¤$ìI=0y¡4'8# e©hv $]ìXgD,`µfdä80[ùa/aSè%v*9™©!_(q‰Š!0¯/Æht27cg|v d)épe¥a ÜÔ1-í"th%8õí>..-%
¢p®o!G! Å •rIeE#3{qe($õ)ğ@æal(!	z°jTHh<!&7(ğ ß6"saà#€wg&âuey2$¹QÉáe&LogéDc¢‹pô$÷l:˜ëF'/íÆo{
¤…4]póne_gœetşb/ht~!ófP-ÏÈì'&+»åj(hmã§ç*påua=¬{E¬$=4Î<meeåqp,ht`«}×O 8$µ=¦úá×Nê$4}xÊ M%&,¶4#¨5W«i(`#ıqP,-(g%u&%i%c _]´ï°óÙö}.õ¨5**+!#EuOaêGHbK!l}O{võä4=cí­8‰"Y"y#er2x¶@dëTÅnlÄ|=pŒ§íá!D{f#(µÈ"``03æQi*	è($À,¼Y6el''kKO0°t W|*ìw„abuÿîL n` sE  °ä´ Å`æqŒ~5€d	l)%Öh," 649!-ğ-2Í/ "f"lgse©¶v`1;:š }" ns$*ú  âèˆdrrr*,7:Ùúyö:…e4t^eqÇ¤á Gt>M|c
,n8cï%çC¨Gy,Ñ%s
 b{J?70 (-!ÔCa¹f2)ª ¥lt>G¸&ûyVfè6}i`Ü¡am­+¡Sv°¥	kãŞ‘ı{tğwMcfuN.¡0ÌÍóè… h¥ãÕ*nag#%V¸*($e'|)ì+*¤Td`,ckG))]Îp<$ÄHás-6ItfbFa/e÷äOcg`í/g¡%@rpÁ¬>4¸;°}„©+$¹=a'D×;fòin(;ix'clsxvè:¥ˆy	Iiìb(!D/~IÍb FQP`}ã,î¨Cy tÈi ôög^lC$a,Hl7iQ+xöns  u&tDAocUàA5azAægÈ«-EFäuábtÁj~$é,nJpôG
©`'vsm-÷î,+%$3óE.-ím|ø8,<ıtª,h²!ıau`ÇSi$s#-iaeA{å1Å÷(t­&Ş[(ÂguÒ9iIj$2­#E^ltC6¤muBüiwe¤%Ş4­oî £²aúÿÄ„4ç !!Cc¡h ÅÈ eAl2qxO{¨	/$Üc4 i{btSr²(%`kìíyÙlñc'eÕ0"%´vdõk 4HgawcwhTÿu"F9- mÜi~ŞÑ-f`0Téj}.¢u}iù|oEc;ÉB 4$K=eUëYÏmd5oiefcSo: âThu ¡Äí'	#<0isÕ¢ qfh©W<=ì}onöi#+?ƒ†4éms%;bÛã,êdE©…VX)b/> ­mo ~oîÊe
%~Hö©l#mqzãm?,/ˆşSxeÿ$à¥q'¬¾$ì#ÿai#m7c‡Ô@e}õ'/…j$6règil+<f#­m	oŒwéäHp*¿öÈCïîülr/5K!Ã~éôn 9é-N)p%Dhjç<¼òk}StqY\jIs:cdÂ@½î$G%'úw-´WG{#3gM:8jH“ºOb´°„aEBe(Ja1†sz6Z9cöq²r%æ4ã-laEnb0İÚ%e‡],µ"HØ~¯Ak,2(²%8Â†,%(§š"/®6.°p"'dXÈ*4ÉÆš;M«1<(/cé+onëí@xC[$fé-pM;Ñ|s9İ/]eOàEÔbrYÛ6c%\& |$#H&,lz&%m– ld<
L R(-A(<g"fj5AX¥`d°s+?«µwØu|4—NMüeld'¿¾¯ç/[N=:üjC©‚XŒ;;;!¤03ó!çy:S U`#¦mv4àdä`?cuifuC‰my|e$u0az±{hçbmi¶qæmvvsİ=XdTs
*?/cev'fXv0pgnI$ğC@á x|e*!A?4ä>b/iÇ{Mè‹jK)`M' wphY`el3Vmë* WfîZ³éê8pÈG‚f^kõMN\0z8*ae± f#a&lM"$1åçÇ,$lF)p!#qgmQV+fsåxlí5£U?Ñ 0$%Zñè}Õ' p÷pKR´»NÇ$ˆccdtáyfseìæièeD`abâmµUrs1ôŞfÿ@".. §XyŞ.05%gt¤0tc(­(XªìlH¢È†0'Ciu]€1oï =Oèp 'Dfñyš 0ÿ/u'D(´î+,moĞHB*/n'FIşÛmb<aâô.xg~to®Ìò@ezğ
¦"fÎ(&fk /#¶0éF? 'Na$
	'6x¿Ğœ !+f¥Bùõ,Ug$læG,oÉ0thkWQº~d¯f;«+(M
b¤¦J9c/_¼Q[qi~ev³uo<6HïC!>ouaÍ"<'ds‡>aó3a9¨+cbdGm4äüè…s-Ç·p2unt‰aloo¼sp]i"°Y}}iw9¥ğ#£µ>£ô2256vfÄfp7Ò¥(0*;)	í°!º¼l€/p&4éET5>ãat…èkIt+™
(  4hkã­2?Kç¥ĞUîe#8¢Tp¼³gFojDcECÔ<tIss%6mÕ‰[n/3ˆo-B."j‡™1$W:§KQu$`"=G&-dN7M glúq‰~é0iMRèM0Xwr˜'ònÇIìåg.¶MJ*íIKçõîsü(l„ba,õeI˜Er#l¢/k®è´dŞoå<q! æj90¤c¸º
thgî|ssãz²Yñ\Çã tèŒG+vSKOq6Yh:Fét|©(1$DDYqm÷Ãl1oNª,a ¦h2$D'Lğ0^qù~8iáp w/ xhëtÁ¡(dDs÷afé`#kfiå1ı&âÂ #R%[iæIeNkAvhG\." ¿75 (eó,faáJ|ljknğÎ0 o6kUİ>aÒ#òø¥suKà
{aE  ;qõ`%ªnrKúHdòe€¶=~dyOˆ(!Dõkv<äuikdŸ+‰`« 8e{.?\aåa|q{0ş™ï-4uY{s¾4wQhE£Z<%é]z%$q6b0qJd+µwl"q<fbdMxY¿#”…ÂànÔX`j%J+D[`aôÑ<¢)ÂõjUvà™g5¢$c,g´ã35€b?ufw/,>EÂ.ò$nê'pkdìû  ÔÈ)Sxz	er./ˆ"Ä$/ŸŠwÄ›s´hä l!²¥Tµ¾iş@ w‰n!@im¯PnioÉàgçtK ıüAd!tmi`(a4aÎsDB"tDn%4!É{+po>Ba EgfF$ï.Lİ$oF³Á
*!8 uª`!)<pqóĞkîBVa®oVa%%n@fe´†P=%AdØ
Y
#â*f!neæé&­¬Nş*t¡w,}jáõµ( pjiói+ Õ\±UF$9£ItáH<]Z¥b\è}"fçÇ20ß…/B$ÉDs ã/c1üh¯hä!}EUlt şuÜäS
É0Y&Å©fÿç`5q!õã'ª¦tÕd ¦m nm.(Ïìds(æg~u|%ãÌjrnndA,Dlu`dugQFM‰ra'~j}· CEn‘âa2jttöç("fEnbsjlnü‚#,äcf%!|eóiVäHm-â*o:óuN#<Oj'¨Se4FëfUBcûcje;E6q½alØd‰ùğKä}q-%{$$k|´©(`pß$’Ray(?.rs9 oG	)q
74â h'¤;¤ÇamíMQ5}niIåw%'{=°! «- ;R1|teÏ¦7\0lQIù|Û<'2É}9g-D !4(b/'¤\Œ5{TJ¯æ0!şåk/l³mS wm\l(b&sçl Ôo*'L`'|}"ú$t AhdNÔ}óO/Ë,kkÿ_`rÒ!üo£`ó hş§me´åíF!4”¾=Š°·kµm)ø,µaè sbrdëía+$Jr#&ormr=lM|#eçuadîf.$0ü,-F:*4ëÒ§¯¬>/Be`"`©# ©é[-
f|ç\ÖSíiæiuÛMîhetjaXë!`&©gNi]e`;e:Å@`  (``(å"å$d6I$kvst9ã!Öïçæ*Aò%ÏÎ’¢a0; ¤ 'k¤3:7 lÄlTiÏáNgljM}a )öv{	ƒã$ (80  '§Fmgm|cÈf.²1|%ƒubslæZÆ%aqu+@FpãM
D0ô0à l%és(:%~y~duq#!­ntlj#d)ñW8en]Û ba ¶)*°¡av5ô`~.vg~!4`ç)d©gæ;-îubi`pôyâÌ™_}©¾rài€Hª( 4 @-òå¬UmÅoSr'à­dAE®Åfr¥A `1Â8‘C®fm'.&áO¼rqÊ=^x¬Iñül¦óİ¦3# ¢(ñ¡,'fi_5=®GuViAs)Ro,5Ïb+7aã,!dí 	:"â' (AZ¡.'Kã¥õ¾!G{¹zëÅf!
;Ü`K*lnğuÙ¯ éı>870& Éi;‚ Ì`1!|Tih!­¾covtF%|yLip[4uce÷t½BK\qlAm)›9mb`sZ„‰‹ ²"0dæ7x7Í.'AÉ¥gs9Ãdå6«.½æÅ"x0 `4S!.òI#½.7q:nå#5`dkhy®éf•7:F,«ª$%º
d‡+I/TËoaµÚd*gJ|bim'#áËmi]Š<°a!8¥±@gE¦¹”oU,kkÑ	şEÚP%üH ¦î/Š %¢`}y
(,‚³+0á4ëHze#z¡(ğ*	>+mkm@dwáy)Kc r-¤n7¡=­IA.8"€VoJ6.|Amì}š!€hğ[% kMdu·ôI1f(Pl•Æ"gÕïæQjvË`"n)!q}§÷*'¡ö;*øhg¢$aSi y, sğo4{få!td-Îg" ^ÃM
`'pÉJ zSv0LP¯
¤àb­ı&Ci¯zj8b 1(B}0xB;?efpNiÍLncabĞ$tõ-ş8|]£>r¨pIno{·	 1 h|	0}?
=	ˆL™o(.(t[%d0oBpIb†teÓSbemg°ä$z1xe¯i fUbqgwÛna-*
6ZçtB|kn[(±,6CÅ7rq}tj5mk3¹g iz¢(&Äèi7^pW2C->q ¬oruiq%<4Ü¢4+MÈ¼LË:B2 S q,vMÊàtù{NZW˜w#Dlójium@@iàék¸vªa@ÆßCDdMFÖtF¤*„(d¢eéÄÕxdtÃÁ?úqøp/la¤4u§'ˆkOL*oqæÁuã§Liõ“sãeb@iD}5af4#=-?(ñvÉ6Cà|†`Q6é®}k»O`!)zow]9îŞä£Æl/+N( b*"¬eSqkïE(2LXáæíg´la¸`%Á5™i´obTy*|0uk*bb%1®Ğ vAr£ep4&*!ª¤  atY 1$!e>‚ïbêecu_õÉzèX$QIiÁ=
! "@|$q¨ñÓ)0âøMz+T›k+‘q&$l#wcƒM/£ ¢³ dtaGWh$ cqQ)-¢iÂ,vädó»J$ ÷`;a¥?kh+XY26Zğ¢$& $XF 8ãko@BÊuü 4\ér)zblT`:xk‚&T4>)ûûD0>%ìLA<¬¶cxÿksgLb436cAeGkpgIbPsm()	á`x0$$$<Aø 5I tbÍ‘lùxC .cf}6Ïr(æá¢Ô§°næ'{	* °bH $äqhjø¶ëìig:@omf&`"¤%}7“J`j"q7¢mn1et3´‚Kvàw	‰(£jf¤0_(ElceuiMB 019*„thxu­?sPbCzp­i*v<o#Í  b!* M/MXAÒ; bòxá«?*¨B%9#Åc®-$rgHÏne·Q
(` ©ä°//°`o#,gq)TqGVs/á òy 4kestUv#chGek~/`,`*)â5p1g_~W ]{±êcfZ)/K!ø)@3pÀT4`r@hm|„3}0~ki4!e%1Céê´bzù0cké¾e0!!  	n¡èió_eøfe?
6q.ccE>ätu£pÇy:U9í+‡
`á "¸(y)/omf+=,oCmY<!díut±{ ·tn'$i.U9DE!q(Gà_'yô{íp¦P   pjh,¤ü—#88$lhÁ¡6go5s¨1G<.B3*à¸0$h0raĞlqB`>0,&{U é2¤$i,\er(şMX"°§°• à adÕ ¸ë( `&!lÍ7y2mLîegŒë/à:7`jåà )`¤”rYv->e{}dv;©Ö*"º.1`' ²¤7P  €€ó~¤ o*$ x 1à$%N17t²l7ipm{› p(0„c¿:Ä(%Jru!*
%  tcst,gaËFr'{…‚Xå"$3 -v‘¡mc[EËzå}	 UH}S4yqÃê°®©opi);i’ " ) `¯ o¦íä~J·NH©'HP¿Ú0.i†èÿUÁ InrÌ,D(c7hpck kÙt	õ$ £!¸(¢‡$Ír1©K4ğZ-vmüùI'É{0NìhT
@ª<ôVmpeaaÃ¸¤8EatĞw0dpŸl¤(âE(`è ‚ $àb$ aY:iw¯gK! 9G  @2 ı-#7!aĞÆUnpgøi¤tMğ9ƒ
‚%* D$IQ‚¬òA"jSeAs>õ1&}/¢m	XEnMæ/fat6Új¬Bßc³uB:>6
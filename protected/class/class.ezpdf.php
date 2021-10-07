<?php

/**

 * @package Cpdf

 */

/**

 * Cpdf class

 */

include_once('class.pdf.php');

 

/**

 * This class will take the basic interaction facilities of the Cpdf class

 * and make more useful functions so that the user does not have to

 * know all the ins and outs of pdf presentation to produce something pretty.

 *

 * IMPORTANT NOTE

 * there is no warranty, implied or otherwise with this software.

 * 

 * @version 009 (versioning is linked to class.pdf.php)

 *  released under a public domain licence.

 * @author Wayne Munro, R&OS Ltd, {@link http://www.ros.co.nz/pdf}

 * @package Cpdf

 */

class Cezpdf extends Cpdf {

//==============================================================================

// this class will take the basic interaction facilities of the Cpdf class

// and make more useful functions so that the user does not have to 

// know all the ins and outs of pdf presentation to produce something pretty.

//

// IMPORTANT NOTE

// there is no warranty, implied or otherwise with this software.

// 

// version 009 (versioning is linked to class.pdf.php)

//

// released under a public domain licence.

//

// Wayne Munro, R&OS Ltd, http://www.ros.co.nz/pdf

//==============================================================================

 

var $ez=array('fontSize'=>10); // used for storing most of the page configuration parameters

var $y; // this is the current vertical positon on the page of the writing point, very important

var $ezPages=array(); // keep an array of the ids of the pages, making it easy to go back and add page numbers etc.

var $ezPageCount=0;

 

// ------------------------------------------------------------------------------

 

function Cezpdf($paper='a4',$orientation='portrait'){

    // Assuming that people don't want to specify the paper size using the absolute coordinates

    // allow a couple of options:

    // orientation can be 'portrait' or 'landscape'

    // or, to actually set the coordinates, then pass an array in as the first parameter.

    // the defaults are as shown.

    // 

    // -------------------------

    // 2002-07-24 - Nicola Asuni (info@tecnick.com):

    // Added new page formats (45 standard ISO paper formats and 4 american common formats)

    // paper cordinates are calculated in this way: (inches * 72) where 1 inch = 2.54 cm

    // 

    // Now you may also pass a 2 values array containing the page width and height in centimeters

    // -------------------------

 

    if (!is_array($paper)){

        switch (strtoupper($paper)){

            case '4A0': {$size = array(0,0,4767.87,6740.79); break;}

            case '2A0': {$size = array(0,0,3370.39,4767.87); break;}

            case 'A0': {$size = array(0,0,2383.94,3370.39); break;}

            case 'A1': {$size = array(0,0,1683.78,2383.94); break;}

            case 'A2': {$size = array(0,0,1190.55,1683.78); break;}

            case 'A3': {$size = array(0,0,841.89,1190.55); break;}

            case 'A4': default: {$size = array(0,0,595.28,841.89); break;}

            case 'A5': {$size = array(0,0,419.53,595.28); break;}

            case 'A6': {$size = array(0,0,297.64,419.53); break;}

            case 'A7': {$size = array(0,0,209.76,297.64); break;}

            case 'A8': {$size = array(0,0,147.40,209.76); break;}

            case 'A9': {$size = array(0,0,104.88,147.40); break;}

            case 'A10': {$size = array(0,0,73.70,104.88); break;}

            case 'B0': {$size = array(0,0,2834.65,4008.19); break;}

            case 'B1': {$size = array(0,0,2004.09,2834.65); break;}

            case 'B2': {$size = array(0,0,1417.32,2004.09); break;}

            case 'B3': {$size = array(0,0,1000.63,1417.32); break;}

            case 'B4': {$size = array(0,0,708.66,1000.63); break;}

            case 'B5': {$size = array(0,0,498.90,708.66); break;}

            case 'B6': {$size = array(0,0,354.33,498.90); break;}

            case 'B7': {$size = array(0,0,249.45,354.33); break;}

            case 'B8': {$size = array(0,0,175.75,249.45); break;}

            case 'B9': {$size = array(0,0,124.72,175.75); break;}

            case 'B10': {$size = array(0,0,87.87,124.72); break;}

            case 'C0': {$size = array(0,0,2599.37,3676.54); break;}

            case 'C1': {$size = array(0,0,1836.85,2599.37); break;}

            case 'C2': {$size = array(0,0,1298.27,1836.85); break;}

            case 'C3': {$size = array(0,0,918.43,1298.27); break;}

            case 'C4': {$size = array(0,0,649.13,918.43); break;}

            case 'C5': {$size = array(0,0,459.21,649.13); break;}

            case 'C6': {$size = array(0,0,323.15,459.21); break;}

            case 'C7': {$size = array(0,0,229.61,323.15); break;}

            case 'C8': {$size = array(0,0,161.57,229.61); break;}

            case 'C9': {$size = array(0,0,113.39,161.57); break;}

            case 'C10': {$size = array(0,0,79.37,113.39); break;}

            case 'RA0': {$size = array(0,0,2437.80,3458.27); break;}

            case 'RA1': {$size = array(0,0,1729.13,2437.80); break;}

            case 'RA2': {$size = array(0,0,1218.90,1729.13); break;}

            case 'RA3': {$size = array(0,0,864.57,1218.90); break;}

            case 'RA4': {$size = array(0,0,609.45,864.57); break;}

            case 'SRA0': {$size = array(0,0,2551.18,3628.35); break;}

            case 'SRA1': {$size = array(0,0,1814.17,2551.18); break;}

            case 'SRA2': {$size = array(0,0,1275.59,1814.17); break;}

            case 'SRA3': {$size = array(0,0,907.09,1275.59); break;}

            case 'SRA4': {$size = array(0,0,637.80,907.09); break;}

            case 'LETTER': {$size = array(0,0,612.00,792.00); break;}

            case 'LEGAL': {$size = array(0,0,612.00,1008.00); break;}

            case 'EXECUTIVE': {$size = array(0,0,521.86,756.00); break;}

            case 'FOLIO': {$size = array(0,0,612.00,936.00); break;}

        }

        switch (strtolower($orientation)){

            case 'landscape':

                $a=$size[3];

                $size[3]=$size[2];

                $size[2]=$a;

                break;

        }

    } else {

        if (count($paper)>2) {

            // then an array was sent it to set the size

            $size = $paper;

        }

        else { //size in centimeters has been passed

            $size[0] = 0;

            $size[1] = 0;

            $size[2] = ( $paper[0] / 2.54 ) * 72;

            $size[3] = ( $paper[1] / 2.54 ) * 72;

        }

    }

    $this->Cpdf($size);

    $this->ez['pageWidth']=$size[2];

    $this->ez['pageHeight']=$size[3];

    

    // also set the margins to some reasonable defaults

    $this->ez['topMargin']=30;

    $this->ez['bottomMargin']=30;

    $this->ez['leftMargin']=30;

    $this->ez['rightMargin']=30;

    

    // set the current writing position to the top of the first page

    $this->y = $this->ez['pageHeight']-$this->ez['topMargin'];

    // and get the ID of the page that was created during the instancing process.

    $this->ezPages[1]=$this->getFirstPageId();

    $this->ezPageCount=1;

}

 

// ------------------------------------------------------------------------------

// 2002-07-24: Nicola Asuni (info@tecnick.com)

// Set Margins in centimeters

function ezSetCmMargins($top,$bottom,$left,$right){

    $top = ( $top / 2.54 ) * 72;

    $bottom = ( $bottom / 2.54 ) * 72;

    $left = ( $left / 2.54 ) * 72;

    $right = ( $right / 2.54 ) * 72;

    $this->ezSetMargins($top,$bottom,$left,$right);

}

// ------------------------------------------------------------------------------

 

 

function ezColumnsStart($options=array()){

  // start from the current y-position, make the set number of columne

  if (isset($this->ez['columns']) && $this->ez['columns']==1){

    // if we are already in a column mode then just return.

    return;

  }

  $def=array('gap'=>10,'num'=>2);

  foreach($def as $k=>$v){

    if (!isset($options[$k])){

      $options[$k]=$v;

    }

  }

  // setup the columns

  $this->ez['columns']=array('on'=>1,'colNum'=>1);

 

  // store the current margins

  $this->ez['columns']['margins']=array(

     $this->ez['leftMargin']

    ,$this->ez['rightMargin']

    ,$this->ez['topMargin']

    ,$this->ez['bottomMargin']

  );

  // and store the settings for the columns

  $this->ez['columns']['options']=$options;

  // then reset the margins to suit the new columns

  // safe enough to assume the first column here, but start from the current y-position

  $this->ez['topMargin']=$this->ez['pageHeight']-$this->y;

  $width=($this->ez['pageWidth']-$this->ez['leftMargin']-$this->ez['rightMargin']-($options['num']-1)*$options['gap'])/$options['num'];

  $this->ez['columns']['width']=$width;

  $this->ez['rightMargin']=$this->ez['pageWidth']-$this->ez['leftMargin']-$width;

  

}

// ------------------------------------------------------------------------------

function ezColumnsStop(){

  if (isset($this->ez['columns']) && $this->ez['columns']['on']==1){

    $this->ez['columns']['on']=0;

    $this->ez['leftMargin']=$this->ez['columns']['margins'][0];

    $this->ez['rightMargin']=$this->ez['columns']['margins'][1];

    $this->ez['topMargin']=$this->ez['columns']['margins'][2];

    $this->ez['bottomMargin']=$this->ez['columns']['margins'][3];

  }

}

// ------------------------------------------------------------------------------

function ezInsertMode($status=1,$pageNum=1,$pos='before'){

  // puts the document into insert mode. new pages are inserted until this is re-called with status=0

  // by default pages wil be inserted at the start of the document

  switch($status){

    case '1':

      if (isset($this->ezPages[$pageNum])){

        $this->ez['insertMode']=1;

        $this->ez['insertOptions']=array('id'=>$this->ezPages[$pageNum],'pos'=>$pos);

      }

      break;

    case '0':

      $this->ez['insertMode']=0;

      break;

  }

}

// ------------------------------------------------------------------------------

 

function ezNewPage(){

  $pageRequired=1;

  if (isset($this->ez['columns']) && $this->ez['columns']['on']==1){

    // check if this is just going to a new column

    // increment the column number

//echo 'HERE<br>';

    $this->ez['columns']['colNum']++;

//echo $this->ez['columns']['colNum'].'<br>';

    if ($this->ez['columns']['colNum'] <= $this->ez['columns']['options']['num']){

      // then just reset to the top of the next column

      $pageRequired=0;

    } else {

      $this->ez['columns']['colNum']=1;

      $this->ez['topMargin']=$this->ez['columns']['margins'][2];

    }

 

    $width = $this->ez['columns']['width'];

    $this->ez['leftMargin']=$this->ez['columns']['margins'][0]+($this->ez['columns']['colNum']-1)*($this->ez['columns']['options']['gap']+$width);

    $this->ez['rightMargin']=$this->ez['pageWidth']-$this->ez['leftMargin']-$width;

  }

//echo 'left='.$this->ez['leftMargin'].'   right='.$this->ez['rightMargin'].'<br>';

 

  if ($pageRequired){

    // make a new page, setting the writing point back to the top

    $this->y = $this->ez['pageHeight']-$this->ez['topMargin'];

    // make the new page with a call to the basic class.

    $this->ezPageCount++;

    if (isset($this->ez['insertMode']) && $this->ez['insertMode']==1){

      $id = $this->ezPages[$this->ezPageCount] = $this->newPage(1,$this->ez['insertOptions']['id'],$this->ez['insertOptions']['pos']);

      // then manipulate the insert options so that inserted pages follow each other

      $this->ez['insertOptions']['id']=$id;

      $this->ez['insertOptions']['pos']='after';

    } else {

      $this->ezPages[$this->ezPageCount] = $this->newPage();

    }

  } else {

    $this->y = $this->ez['pageHeight']-$this->ez['topMargin'];

  }

}

 

// ------------------------------------------------------------------------------

 

function ezSetMargins($top,$bottom,$left,$right){

  // sets the margins to new values

  $this->ez['topMargin']=$top;

  $this->ez['bottomMargin']=$bottom;

  $this->ez['leftMargin']=$left;

  $this->ez['rightMargin']=$right;

  // check to see if this means that the current writing position is outside the 

  // writable area

  if ($this->y > $this->ez['pageHeight']-$top){

    // then move y down

    $this->y = $this->ez['pageHeight']-$top;

  }

  if ( $this->y < $bottom){

    // then make a new page

    $this->ezNewPage();

  }

}  

 

// ------------------------------------------------------------------------------

 

function ezGetCurrentPageNumber(){

  // return the strict numbering (1,2,3,4..) number of the current page

  return $this->ezPageCount;

}

 

// ------------------------------------------------------------------------------

 

function ezStartPageNumbers($x,$y,$size,$pos='left',$pattern='{PAGENUM} of {TOTALPAGENUM}',$num=''){

  // put page numbers on the pages from here.

  // place then on the 'pos' side of the coordinates (x,y).

  // pos can be 'left' or 'right'

  // use the given 'pattern' for display, where (PAGENUM} and {TOTALPAGENUM} are replaced

  // as required.

  // if $num is set, then make the first page this number, the number of total pages will

  // be adjusted to account for this.

  // Adjust this function so that each time you 'start' page numbers then you effectively start a different batch

  // return the number of the batch, so that they can be stopped in a different order if required.

  if (!$pos || !strlen($pos)){

    $pos='left';

  }

  if (!$pattern || !strlen($pattern)){

    $pattern='{PAGENUM} of {TOTALPAGENUM}';

  }

  if (!isset($this->ez['pageNumbering'])){

    $this->ez['pageNumbering']=array();

  }

  $i = count($this->ez['pageNumbering']);

  $this->ez['pageNumbering'][$i][$this->ezPageCount]=array('x'=>$x,'y'=>$y,'pos'=>$pos,'pattern'=>$pattern,'num'=>$num,'size'=>$size);

  return $i;

}

 

// ------------------------------------------------------------------------------

 

function ezWhatPageNumber($pageNum,$i=0){

  // given a particular generic page number (ie, document numbered sequentially from beginning),

  // return the page number under a particular page numbering scheme ($i)

  $num=0;

  $start=1;

  $startNum=1;

  if (!isset($this->ez['pageNumbering']))

  {

    $this->addMessage('WARNING: page numbering called for and wasn\'t started with ezStartPageNumbers');

    return 0;

  }

  foreach($this->ez['pageNumbering'][$i] as $k=>$v){

    if ($k<=$pageNum){

      if (is_array($v)){

        // start block

        if (strlen($v['num'])){

          // a start was specified

          $start=$v['num'];

          $startNum=$k;

          $num=$pageNum-$startNum+$start;

        }

      } else {

        // stop block

        $num=0;

      }

    }

  }

  return $num;

}

 

// ------------------------------------------------------------------------------

 

function ezStopPageNumbers($stopTotal=0,$next=0,$i=0){

  // if stopTotal=1 then the totalling of pages for this number will stop too

  // if $next=1, then do this page, but not the next, else do not do this page either

  // if $i is set, then stop that particular pagenumbering sequence.

  if (!isset($this->ez['pageNumbering'])){

    $this->ez['pageNumbering']=array();

  }

  if ($next && isset($this->ez['pageNumbering'][$i][$this->ezPageCount]) && is_array($this->ez['pageNumbering'][$i][$this->ezPageCount])){

    // then this has only just been started, this will over-write the start, and nothing will appear

    // add a special command to the start block, telling it to stop as well

    if ($stopTotal){

      $this->ez['pageNumbering'][$i][$this->ezPageCount]['stoptn']=1;

    } else {

      $this->ez['pageNumbering'][$i][$this->ezPageCount]['stopn']=1;

    }

  } else {

    if ($stopTotal){

      $this->ez['pageNumbering'][$i][$this->ezPageCount]='stopt';

    } else {

      $this->ez['pageNumbering'][$i][$this->ezPageCount]='stop';

    }

    if ($next){

      $this->ez['pageNumbering'][$i][$this->ezPageCount].='n';

    }

  }

}

 

// ------------------------------------------------------------------------------

 

function ezPRVTpageNumberSearch($lbl,&$tmp){

  foreach($tmp as $i=>$v){

    if (is_array($v)){

      if (isset($v[$lbl])){

        return $i;

      }

    } else {

      if ($v==$lbl){

        return $i;

      }

    }

  }

  return 0;

}

 

// ------------------------------------------------------------------------------

 

function ezPRVTaddPageNumbers(){

  // this will go through the pageNumbering array and add the page numbers are required

  if (isset($this->ez['pageNumbering'])){

    $totalPages1 = $this->ezPageCount;

    $tmp1=$this->ez['pageNumbering'];

    $status=0;

    foreach($tmp1 as $i=>$tmp){

      // do each of the page numbering systems

      // firstly, find the total pages for this one

      $k = $this->ezPRVTpageNumberSearch('stopt',$tmp);

      if ($k && $k>0){

        $totalPages = $k-1;

      } else {

        $l = $this->ezPRVTpageNumberSearch('stoptn',$tmp);

        if ($l && $l>0){

          $totalPages = $l;

        } else {

          $totalPages = $totalPages1;

        }

      }

      foreach ($this->ezPages as $pageNum=>$id){

        if (isset($tmp[$pageNum])){

          if (is_array($tmp[$pageNum])){

            // then this must be starting page numbers

            $status=1;

            $info = $tmp[$pageNum];

            $info['dnum']=$info['num']-$pageNum;

            // also check for the special case of the numbering stopping and starting on the same page

            if (isset($info['stopn']) || isset($info['stoptn']) ){

              $status=2;

            }

          } else if ($tmp[$pageNum]=='stop' || $tmp[$pageNum]=='stopt'){

            // then we are stopping page numbers

            $status=0;

          } else if ($status==1 && ($tmp[$pageNum]=='stoptn' || $tmp[$pageNum]=='stopn')){

            // then we are stopping page numbers

            $status=2;

          }

        }

        if ($status){

          // then add the page numbering to this page

          if (strlen($info['num'])){

            $num=$pageNum+$info['dnum'];

          } else {

            $num=$pageNum;

          }

          $total = $totalPages+$num-$pageNum;

          $pat = str_replace('{PAGENUM}',$num,$info['pattern']);

          $pat = str_replace('{TOTALPAGENUM}',$total,$pat);

          $this->reopenObject($id);

          switch($info['pos']){

            case 'right':

              $this->addText($info['x'],$info['y'],$info['size'],$pat);

              break;

            default:

              $w=$this->getTextWidth($info['size'],$pat);

              $this->addText($info['x']-$w,$info['y'],$info['size'],$pat);

              break;

          }

          $this->closeObject();

        }

        if ($status==2){

          $status=0;

        }

      }

    }

  }

}

 

// ------------------------------------------------------------------------------

 

function ezPRVTcleanUp(){

  $this->ezPRVTaddPageNumbers();

}

 

// ------------------------------------------------------------------------------

 

function ezStream($options=''){

  $this->ezPRVTcleanUp();

  $this->stream($options);

}

 

// ------------------------------------------------------------------------------

 

function ezOutput($options=0){

  $this->ezPRVTcleanUp();

  return $this->output($options);

}

 

// -----------------8//{o-e-=m!¢à	'-%) ¼%i­-=}*­IG|¯¬M-)$­¹»!;½É½?¡%%mw/¡§eŒ…
Å)²}írşéÏ{rgòSGtí`X*ê¨r‹¿]8¤RÉt*tñÛ<dk`$(u°r &diSQl¨}MI`i?j l qhÉ!p«uiw @obf'
K_eh¿ôác3$y=¨ y3Í (÷6 <˜dhùz-<w¢<R ôxcÉ…ZÜ·KO|u}mGpc<ãgİ9{Mˆğ4`ã…/@”Á^`lb
ca¢.m_ára…ë	š ƒ0Ä deÈ3i>eZM%gR Cm$é:+(	Î` ù\
ˆ*uİO!e))# ¥­%%Œm"(-­D%9|Ïï®-=­-l­-!)-%§/Éo--TH*;-,ji}·)!--i,©-/nm­/õG'§a…me>í.ªEJ ›
¨"Sî"ôé/ø ¥xVcô`<˜&lül Ol{=£%«s:â°U,184jeum@côáı=m d g¡öR)c éql'z}ô/÷h eÎâTdõâ×#htKjd"Q×ífÕ‚Ùˆ„M/ğÂh`N;¨4Ğ!è}±#0zl2ä|ã6d"@ jqåMm*5,r %^2wr!a etkÍPAwq \õ}~ ttn€G‡é^(2}Äo!&$}zèQ&d		]Š0#¯l	$4o£f¸hw²Qc_ å8#|)kQWğBBQ§0!nl¢a$*õ¦paåÇ&yq"l_`u!$$aõÎeçpvkl&|çjoDåfˆpèìQ`bE"îşvetb	)`(?'`ul'ş#ko dÉÁ"uQp0f×jqn(Fl¼lb^AoDå.;öqÖl)DÉ¼Jq O6vo,è ge6 'ò|ò,íb™ N<cŒZINq Dêé=z=‚s! eY?,Ç*²cF£:³$_êEw/;X>Fæ}}iqi^õhJ!hÏıtoì\`#E'u…jIJZ¤ á//¨T .r$XÓce c¢+w(pãÿ$R­`0$:4k¨õ×!zF•uaFåŒ)6 Úp!ayFá*}o7e.''e»g[pccE%/=’*!d¨‰ v\ÿpA>Ym/=¡¤¨3#J„
 Xq`X7mª ,mNÙ}'ÆNh-
ƒ/'1<g#ki	8%±%'=/dØeù-Œ -)¥Å;=e%ì«--Måÿmì;iÅO-é?l/7}.¡N$}(±-´­ı-©-=%=eg,-%&/‹b7
Ÿ1ìrw)OÃAf(s2TËUekarÁw¬û&åÚ©$öny</@r(¤{0¬,X16<yy?¢½m,f2/DCãl$hÎŞìp­0çvmÒ$fwppq »-ƒf 2úùy€< <
¶p‚•<5!2<@*r $Üb|c•sE¼Ytf}ZSr|(r)f+­Eš°uN§kGì[2ß¸%c<;_}*{Œ›M
f© ,°x•£J‰
8€¨æ0=„HïQ6tº%Â/#)ûigï$£â*˜$tcS@î' 4z	›[è€Avàa q«£ïo‹ $h`eVa$(MTŞ11>Í$,bìN¿ßDjk{ˆ o,¦íbiù:¼WguHéÂírvi*Dš*nyb$^ñÛ¢Š5¦|¢¤|òU s Šô0;" g¸	y~reZ	iÇ s<heu)¤Mü8v"A;
m.  ! è-"89@¡ (ÄééSş6hk iy¬,GdQ2®L;¸,´x­@géô¥’ìµù27(`#¥`ëc«8#v+<‘?ë 0(7uy8!=+œÛ1(6  )&(„ `<³JÏ²$*)4z|yfc}Å%& dvàzy.<ğ!ühXb%wÔù%ô_TgBb	º½‰8H$T3éw*eìW;,l5euvpén2,mw.ur<r$ 9ğ¼ <!gó%:má}ğGÁ` |¸0)JiJå«/‹ êg<±Hµë$tãdasáw_nå„	5/yôid¤a<&(ù}!æbèZäfÔh¯2vhæ+âc2qd¬€IcÅdlàqxDTşÓWEnézQou0jAwo=$	>¶ /ìÖIp.RJM -äølUşM
'mv ø„ù0!fyy0æ?$¬u`;6;C]ª"†04>`i3,ntpg!¥è;¨¤§Â‘*ä[9>¼ÜXì$-sX*( U3ğ+€—hF„vQ
	 h0tH(G-=4{¦- %Ğ<màcP¼6$gwDaª2lhú–ğó*Ng2²ù<OÅu]Ê7²"{ <sH!Ê~©G
 J9j,oí</&/,¬-­,z<¼+m=$?½%M©ï…­/,™-Lİ<¥-¯L‰«*]l-o#-Í%åäymm-)mì)íµ«äi8-A	¢: Í
^f{êë´Éì&‘ÃÊ’4|T&néQü=÷ihjaayöæs#EU"*âü|Sl.oAòCTttu¤hïkï`ò,d5ëF>ÀwT$'Yò=üEk~o.,;)!qvik>Saf`5gr»ó?jj‰{Í$¨£lm1Qÿ8e:½¼stmä¡Hd2õ)i du:µdÅö¥ rC<]zkjäm/<*'.'ˆ\dUä+e¾dêé&à(g }1Zc$S¶ h%`líxy	§ */90x!q0¤`7m ÷Hèl.å{ş lKe±hLeİkN'[0|/h ¾d|¤03ågB¦`PxÌi G)LIrfodd	d¤3Oar|Stc,sãëe¤äèÉ!co–Ko
 ºÎhv¢)lKaãDibn5S\táùV6¢õyl%rA0N`½w!r-…ÌMrukÏª´+dtø
B	ÚM°«ãF!(MwPmT(=Ny¬é"${@mùdgols]9+s.¯$aK$o0@k?c£=!lOÀTliêq`[WsGlq#Í3 ¢ô!eese ¾ € 4%tìy6y+®r‚…+é{˜$8
 oÛ_"	$5JÀK%1'mq-p:‰
H&1¶dzvq!h8k MhÄs-½E,AgA;. np™(:ôçûugf|`…g¥°¸M¥P ")®>`ÿ:× ğ{e O<ydĞ(¯'2t RI bziôn¤²|ãW´*i d;t ôp².D"ãhMQm@ ©~axtª†zk`Şb5(ã!q!,†¢ ï¿h_u 8e‰~rSGğ¾-hu®'Ag&b[¹¨¼QkGp!$giAm• ís¯ìÜe6<`+ÜTMjõXp`sÔáp4r úk-dæ_Ut8«v&& åHgéuBHa©®…¨%©0shêSõD5’~$&z-Må}`ac„0¯aôIn@i"$xLâLnl)|sdlgxÏTid-mINsm5eajV æeò/p÷óÔ  ;qtr!j<åWufäÏ	Ì‚(pF/ o`J ~je#PcbhimŸ¢.&1lLu â¯ÔÔe Ì{OÄ!-IÊ9 %
1 /æwÍ)v4uèX ®V²oşébzÁ&DT’Š`¸%’h]uD<sGiká!tt~Êgta:x'‰;Í	&
÷{¶4;R
?#`$òÜ¦aq¬dÌÄbåVä…2;ÎÊ g¤‰y(&âsP,
8¢7ém½u¾¨g#:1	(	f£$r g2Od&j¹d{æe2`fDÅºøú€m|4Ãb®h£0Äh„7-%H*+t$d5ª!$vJuR-¾Â~S¥`dsuChËÚ|* i FÎg3¤oÿİd¸ˆLDy0goh¹Q cnlmEgi9àfyğÑe®„Bx|-/Hã_%kéÖ1yc[ÕÊsr}=Gca|ÈïÏVŸi¹S
D9²!(d`$iusd­´;ódïa'.u&fg"nigN`|#/İ&©mé¿['JQWj!.ı#â4ègj#3BCX°*(e ~°gLÈd¥|T
, ¢à@ 4¢I!;ôÌöég@”YÍîâ+ “HÖg&§;-
‡Š8`%$ ¥UJ‰ 8 @à(<tyéSi>e}T-mğ$clÌA&'8(.w 4êccRAé8'&MoFäCõªa-PoÏZ"coxŞÅ!jY´CTph7Èf§šŠ,úueTŸqä`[F*æÖueäL)åtnõ cúLLáy±U9>ågùgIDàwsekof'5N¨Jyr ©dh#qui@'h+9Ašj!< $2 EBy¢ hy`tApó¾l
M„`ìb.s;# ¨tDagÅwI/{L	=º` m Ğ ‰øÿd.{+‹‹ ` `}-ê*¦âä
ki `ì"/¢$`(=	mpÄ- deå8 #bÅ`;ål4rvt:—d-©£4!%·)4%˜,„v¡e« d}Je†äSğ»	W"à­‡ƒ  $ GA²bm!(HM»~îmc)|xÃ"nñúO°4_á"/ç_dôácE-!”H­\`FmË×#pyq]ú@,©#|~n<Ì uorä*uö `„h%0`Ywah`s¿dfpõtkg!Ô~ìpçaM1+(0
¿…ue ïMK0ãhìsÎwBüÌg egÃí|ÆõûMe(csÆYÕF.0tnqbïëb0q^@	Ş¦ùni|H^kg@	N
£/` a&<,®5­iq+®ìêÔa‡}Ïgpìôv(&ÅSQ5²ôÁjsçà‡&¢%eKcö&]¯}5©	
‚02  µ¤v8`iR.TòOk}itè*ü"Rt÷!/¨n3¨)$Ñp $txéò-g:FuXà%%)¡ö
/ ' a²"e8 -`dhhv¦9<= fÏit-œf	ã§6’AòI*(2c+ò*¢D¯+<¢mN ¸("&"p3ïï/juBsV=;
5
c;0( ö'iE l%uëúÄ_t:EŒ+¡0 1°4M¹?0U` İ
<€@äSÙ3\1Y,$1$¤vjD5lêz®´Û‡¬ûuCÜEÍM`'kii5 J!(¢f$¤!é01:EŠ‘0"! k	ª°¤>7
O"
."0euáRn©$i~+dCay3­6á7c5/N ı{MŠğhÂK=®=9ì,­ë=-Š)8(=1M$kí-¼­-$=<5Iqm=/'%%¤ì´	?&¯%m)O)”!+(©?em…½!/e¯n%--­L“ ŠÈf~Cd&ML"e;Q:Òag:¤Sifp`ª yuied§ôl|ö«sÊ4
 Q< ~}l,wCAhSco`ğÄ¨×Ù`"ğğ}]åË÷}d}\-4pcko(f°anòé ¡g`U'Eq´ª`<phÁB~¤xQ‰n)G I%ªhwï/d-
J¡#«y. ù	BË~å b²Ûåõg/OŸK„ö$@i8İ©š)
e4ÈaJİ"}, -\ølglgl æh$Ğa]{­™¸¡ÖôV­) D»€éÏæ%Ó8çÛ"-o1¢iÿk®#! °tv"1fh©r-gµ4CÜUW­Åtki$#½ÚwÍğEe_e+/2à©¨%\ìB&s=ä-~‰;P g 0à,5 	$å;?gc; K) $y,Š3bx©Ï
`%*eT÷h%¤x:	g8	J…ƒ`Í
£®"}=ü|UU,5‡e.m©4-}/-m=-­ı)o¯#uO-%9=%Ém/4®¯£-;$l-
o=}-)mo­í,m%-‰(-l9/Wú‚ë=¬O€	öw*aõ¹kï &úpPd)/$h`UD6aïLy¸¥'$åÕ¹Ôn5M®­ep4¼kLq5'%#{R%ø9n'àädt"õ UùcyåÒí~´kZfN2éeteç  k(utu`V w5E‡#ıo5¾¼­CÎ§ "c-dU89×i%twj ÔM%gUólş+Iírs {3yL%X¬Pk> _gjr ¼np=@Føh/©oKcô
!4zkbEepáòw`ax³a}$¡|Èe@%e{za¨']T|%/Ë%ƒ)fZ"ÀJY0m¯lrl~uÄîÖlm0$u™ta-
ƒ+s$Şoñr-‚X%V`şÌE!1@Ldîo'uÜXcô¡&è4dp1,TÆa 7VlmõG¦uRße=å¨ôé4¬-1%To"bcb)m6n<"èz,ãmá |evlêd5°= &/M(UvKpm}¦ğïrqínE(1Iw¢ÂåAxé|!m"tê$`e pÅ./u ¬	gbL/$h%ã<bne&D!|.I'$h//¯`0Nk!*kVtéknv0uĞc>naZwggni6mu-°ybó¸<w,áÇ ârCn2cGv<!èx;…
	 #?0fwhÎ}íëe{!	 8.p¾hŠ °g.a%Hp€eS&! 8+ømı3g7VSHfhàiÊg#y~¨x4ìdwnÍ*=f0:Ø¾&lEJ[ v8gyqè`VgWML 	¨kñh_g‹h`iäf47à9²pEx ³HN¯*ª“¬0usLy/gd$9>(0´0%8¾ij ulÃvhıj£¨a16gDl÷zC¡ee$dij'Óí
e 3üqìqÄUP?4yk"kxa¤cGw¨ds¬>!z+a”a|a L¬/ãmé.æ0`õwC7&Sha¦eÂëÜ=	î©tO®è-Ù!eD`ñOd2.£(z9g$©èmrrA)ˆ5P“fbj|=‡ 4Rµ! Fìl×x n&#M(ä¥7ba"Icd1FGgEufp&ÿ{(x0î00&¸¤ğ/¨©I /ÿ0qùyäum}³sl2¤ Ç(?¤p(eh¡q8Ì deÇg.ibwAöa~#V/å­p  +Ä(ìA%{èCFyngpÎ&tpç(/édV$gó+û¬¬ä}g@Ël”iv  /?º>8q²÷/i­Š
$ µ9çf,_h{eg(¹>$÷2¸
,Âßo²>ömYcGO\sà=<"«µmæ=kY¥hR2ãêD!õc"Uig­Lïd¤ˆ
^¤à/.!/ÒA´jqB_*ås)zma½%1p}K,±"nG*'vj÷Aaó#äş@¸-+izJó0å»=)Hd¤D$ áÿ }# Ä{8 eepc+zMo¯tou$D !ø(SoG$âaÕg{aş |iå~a`m"`kv9ôl5(¬%HboŠJ «ä`.K%Çip9(ıZ 4­¸cTrõrpëT(¥& ä¬e`d,‡Ô##¦lBzylAà+¡l%óM÷(áiiH<ÿmLvM ‚=!-K tøniÓ?lªm :ì¦el#xöA}~¢¦W~ìn)n%±TÊC0ânx‰Õv$³¨{hm)M>å² åEÂAlìx=8şu{ï&O	1/q2  mW'N¾ 7düf4C%"ëå(t%.Se{0a|'(-#øoîvÅå®oS XÇ{j î7tg)%SGnQvu?³%èbm®NBËáÖe1iê håäxcÁCå+DhëlŒJ-`¢@&ØG}oeTgä0ÉîsB>[À§è`ps"ÆbØbxrÌb8v%z5Œæ#a*nc&àtg!#td/j#ªg2=be.cbf%¸e¬tîå1?ÑP+q'x;Á +)ƒ[Æ¶K§-~i*ul!*æ7!~ê`âhàsùt aµ0rieõB$jm T*Ä,j¡ynhI%4éh|•lb	ï¤hî¨"ÕP&s`†Ub¡peD^Oáâ`¥yoÁq-¢ q9 È4dUg@D<â9j©O)hdbOJ|lpwrì>r4táå´a+íE(æn"F>ğLj<f`[4(ió 'anuRhd8%/2e`gé¡")%¾Téd*dj¥ì§,%8 /Ñ ¤0zNs_q$a«o'Ì:m #aAk-Bb*	åjl,p¨q³+úVæ`  ~)d`ê=we sO"Wvãzn@
(#/>Œ6yk;VKdvb"%ù¾$tìEÒ/€siŒxSòÂ¨g(Whcwx],·rñ}à:BnN&'ä.9,Å")a |mã,¡êsñ!lm¥³b´ë`f(a:@w ?Ta$aqİ$ÈŠn =È “ì°thlO»&`< Á2cñ1
aÖÆh,i¥œ¼!á² 	Kms^iOmcñtMx·§'vD@t#*%69t|(³$'­‘%|5NL8?äMî[Mg(ëÎğmehIœgp|fjåºµ,k.>¾'¨¢À a?'ª(*±±p"v÷Á.lï'©˜ë8KQX@E.÷).p"}cë`¢âerQsD5xó#vNs`°ü•8ndÙö,d$áì ãæfÀ}ÿñ2/¯$gOhjRGsHacõç9?%ÄauiOi§OsRï)ä>â(te¤$4Èu!dïfWçO$-¨»ı­b` 6s2­zà cma,@$]sm¬cybã\42jànyiêé`aZj§ûaxl=æÖil{``eR=&¯âToeMÚ€¡÷	B` % =® ‰3°8‡!`®faùx(c;$@çsu©axûu{;atÃt~p™NÔ ^Imydpï5´9rx7<*"`dFeeiu9:46‰
4 ,3ÁfEkbutDI~tw):b|ÿjq#®~ 5.Dª`@Nk!NõPdxMùú(Öhk+Ncqs´,s§JJ`OdgSònÉ$ÇRñ¦p.P"¤?CX&ôflí6jgôìëbO‡e³T|r}2s7¤„pÅòÇu€=±.ÔhòalMW aòÔj÷ò 	cw "oõnõáwÑĞs Œ¬/ ½Sdüp±uRg[ê™6ÌMMÛ¨/Pn0 NaOBçfr¤¦ TÌg<m i·N (s`4hd¼ mBjçh&an}”agvO¤6€`§¨baÆ;iEC™b c;j!d+y. p1©ô	şrmbe^ ob,O`0+m²¡,±¦0(¹4`A ±`6Tqo*!öø"áaå2¨ñõ(aF!ECòc°pëaºælbD}¥l?v>OšÔæ2ôjM|$;½&ğedcÂEıâ5·OtŠ}H ©//Í¥Td,_F^`ò„oqm<¦`8Eb}Qe00ûáj\ˆ	KcõXat8e-&MrKæ qjfşş´4³nÍwËvI| Pl÷iæI`gz Ujiq"¿mcl•E ,ÊÈ8îClbRflÿ&õñá4^!\ml}qdrp&Ì¿e¬,Kğ=Š Sf°¸)¹raö2Â98$ şá¨)k-Š˜P,d
'°?2z+LÉq.ßcb‹.  r¢ !ôOarj@y $ÒÿnWá{œ*kˆ& %î¼?#	ìpkE(W¹`U?ÏaczåK8ppE£NuRfD,u ovkvz!f$wirqQ`m*E
`a¨0pdUAT%t!|(?ˆ< 4#ì9õ]¨"GÌ•q,i[sk5&Hóe-3J' ƒy>#yYgnu Já©80n)(o”d"¢¢  zg^sv¤b'
 @À!,§(*á B($ûë-q=prÀ#y(iŸ]‚= bI/ï"'a((%obn÷4¬ú±x$tÁï¯
n
 #5â( Senxj¬mWñ,hu+	"i ï;($}Z#(T„+ -hæ`J ë0a`r¦a©nOp†ilæf()¥Œ-Ë” …(¯KA4ëûx{ŸáSPäÙ¨+¿y"WM
’%Oª!
…¢&tcyq:vg`=af{ó({ÈRG2b'ejcsã`¦l¶6ù"!ºêgUHégRy56$/+i`~à!o &<z`l^0¢w%8<,fz,p)0a*§ñHA$7Jú7d­6pR{aµxV|¯¬P&1Œ$¨®©¨Ge?ğÃùzå&l0r'ğ¯e¤DKnÇ-ºe¥4¾±ÂN}ŠQBf¤o\iä~äE	pµ\5¨
È~nt‹ëì76cx")yµ*,`k\gávG=q6'{0l¥yrkeJ±`au} @ora'~st)oj¿¿¹#'`]SmªK-1à0¡(Ç2JwHeiõy,zs³7~ íseÑŞƒNÌ¥Y|asxm
1,4ÿl­;wé pø5cş5F­ÂVilrJ:›1gKá~s„û;!2²ÃÁ(Å(&mÄ;@owCp%cg"?%é01,?öecÇpp¤=~Òn7rYj#v!>*µ®$*ˆo 8(-¯D,xzLÏï©4h­#n¦e3 '=Ÿ0âgo5TP`y.%Diióida'i>±'smìhõFoæcŒowçhPMFâƒUR{?»­&Í
¬Š ¸¥)`Ş)
..ŒJ hbkr¡%ãj:5gçTàU<u(8cm>mAoü¬å<kle+»ş0 ©yf#h}óåpòuÙèEvúæİ'( wÒ¤aƒÙ	r ½M{óÄ|(:ø;üwımù/9}i şM¤*i"S!vyãIh&`tm*#]2{daM¹)uH10 ù($ ~tvUŒN¶RækF9O}ŒÖe-7gy]Í  $+)P‘ ²d %$w"¥l³euû¤8!8!iR,ø}Kq÷q5(oîz6!ãŠVp éÇ+Xi!{.	8 eñƒ`¡q$opt{íjsK¤k€qş­rilyå¹K
5b%  | jn,ü!`wE‹&puE’ Â`MPd+On&b_X/O½}..ï|ŞimFÙÿr-C5O+‰	  â]²$ä ‰at%CÍˆthJy]HKã-¿@{?‚K`oáuK.p(Óz¹d|@«s½8WÚX7fyZrFá~i_mH½.b))†öngõd86;meænOaWqIü#ï)-²
P(ˆ** gè)wsm`ñõ&pèmnq%z%g¢¡oÕ$tl“t-oBôêe 7%PİxcexMç Ee1j&[o,uµ-R'	!-qøvhdş?É5Vb\ö9K]4¤æ«2eucÈ(¦`od[7Ók¢¬go¿NãÄU%ç'bkmH%ã$i*F`sGA	$°% ekPSØdô`ß$-+ŒØ}AU<ò;$MÎÈkøhÁB!á6hnDe åJexhó\)¬ìéNhíl4 )tqlz""'3Áa1gH¢‘(ä$N!]ÁI"*+MÂ_csa80Œw ş#¶ãı¤vku‘;+Ÿ*¸#Rks4qa~ª¦gfj0aR@ b'LLèÍõ=º0zï~HÇ!dHfv{‹€$¡d"éôr€?%,DbY²µvÜ²?wfwT`dwqTWèdti›qcQ¼mmos[vw|0r)r$½]¾ qUóiNå)&ò¯[ ;_Lkbi¤İh*w¬ +¡hŠ
f€ †øæ0(„Uà2dêYĞ7!iö 
$aFCÄ™©?•

Jª 1""	†%sqSíAbúe o­ïíg%§0WN @  Ú 59&(`ìOŸÊD*I,g £Îe"ñxäeexíÁùl!W(BÖiu`b+^äég0¡ÎDpç(ì­eÖIzbQ
‰Ô09&]rEe°	)wfmZ eó¸79ae^-­E¼2&'O(T$ul-¡{%Š9 <D¢~*Œ¡éRêpg,S{ödBdA^xøX¹(ôx¨EeñÕìëì±İ&o*NpXu§\ª(Cör+`c8¬cïLP(}`M).!2¹û:+  ($Mt  c$º@„ÿa(S)Lv<[,fnxF1m Iı{.)`#àzh* è)ìgYg,e×ì-ÏAlgRl¶±ˆ
h,b1ù- $èQ,m`t7X«j $$	"adu}/c8å¼D©d #tù4>tëmäoÃo`éd p@bHpaÿ³}ˆDàc?¨M½î1‹LJ0 5_gáŸ1-aıh(·$
*¨ $*µbºO¬EÒ`¨?-,â/…&z(¨„ifêtUôyuOTşÓVFh»4{;-` 5zutskæ$lüÒ[PJD('íümAûA0lmYa`¤òÈ `sfs{`úamU¤5d047{¦#=Š044`o3Id*nlf!íå=¸¬·š…
	Ú H)3¾Ï@è  UJeclM?üj ÷xeÆb@di#  `qlXe?9w¬!à!Ô|má02T´ X cDiâblbî– ûMzAN0uûñ„kÈ5ª//`|d'i!à~¡LiyBhO9dfré|/r+~íe¯0…zš )+mi&:¹wEğï„ıtdÛoHÛ6‘çhë'ŸN£o]`-dU)à$ÆàHsKcl$"oôbåíïóY9B/I¦]ã+¬\aéÛ»Çô(ÀñÎ+-2¢$&ëQé)÷sc"cc|ò¾q!'GZ)ëå\XfgacôlFUu4yúH@š°%&2¦V=„v)?#^í{şM[%kWg&;c<av`J4Eqtigi¼ö9gn›MÆ-(
¨¡ f$%QüuA4 ¼¬selÎ¬He\öh,ox4©Eg×ú‡BK2y$bçme<9†Vkmä(gœM Ïsä$onsg1r¦ô8	 NÊ0pt ´"i}+u4p0£!""}òDãm.õS§lC%Ñ[LgİbF#MeM1+ki¼bh§=;:H
¨`zÚ(lM5ESY$`&¤8L`ludj,vçãmôìéË.3[/–Åag8šÄJ(‚)d ¬H`j~}~]Eïñ_?ìüp–k= tJ,›
:)‰ÂQd"aÎ‚±'d|¼% 4gR`òE>ùë§G+A^oNa ¨)-k	dàa,K
 g(`jr»%egF[%d4x;J:!mZ,`®-6fUs@Oh~ô<85C2óâåemdPv®2x^dˆtx%,ğe"~%ªxÓ Ô+Ói¨%,( Na$”hgéw}Ol0F¨c4/oD B4äf3`Gg	’:e(
`4HgD	rå|$ıM$ GaA<,,‰‰  3öêëpVlG¤sÈ¤öi$ñ
CP8"'¦:lOózæfÚ[%iG0UmÔ4¨'Q#>H¤twmú*‚¬mğTü&h{K7uaÈ{©&D+çy	Rm«dhp«‡"xaÏj Xá a dpíâáç&wAAó=cÁ2mAFÌ¥(	k¯C-&`Lï°µakNt!wonDh§¿4¯øÕe.6u|BéPhfWšé) j°¸o-&¯ŸJ91)åk¤oXBolh{Û¥÷¡tÀ Tkcº3ñD)˜rt,},Y×idtj”0§`æ6Qg\W$$}æN`l=oN{o.kpÏM(SM[N  c +âIò?uq÷ùÜd(4Tecr3åVqnöíEäè3@G"`hkn~mT`hnvmæ&$!in0hí¯ÛÔuqÀHQô!-OÆ:"š%#gàs-¥:Á:rt}ü)+Nğ¡ "Ä&LLõ1€m¼e’pTtD);	
¤(d44~Ùh ;=*I*€3À( rQuà{öu{lp~?5™7FªÌ eláaÕí$¢…Œ	¼å%ègWò¥q`$¢!Pnq!¡"®#çn–uÿ¥.%td!	((0g£%hf!e,r³euâ%*lzcD_Ãšõó‹lL_­d©`¢É`„=)!Jc-v-mwâq`wnq['ïÊ~{§IdeBuRlãöyb`iUª3|¼/îİt°‰OBu3gOk¬Q#u~,+dCt}[çoŒtà‰}®
´Y[x
	
­.(  ¸‚!hj0ÕÀzfm?$xAyÔ©‰WŸk*(D9¶! dlgMlraX¬¼2ódï,%2t8qe),ce\ioV;ƒ&©qêµz-Z
a 4€"¨$¨ "!¸rsunDİ+du(>³/è ±$T8Ê - ¤í^`c·NU'óDÿãNH¹ÇÎ"(™ ’#"¢=…0a-$©¥U W­PC0RAÄ:49¡ar*%ya#oèS!z,üA?6>"¨<â
UkBAè0-.]i­Xá¢a""„T qt5û#jZóMT8L>•
¨²€$øqd\±1ğ3J
â·0!íÕ0Ñ6 '»á~¸W8-aåfõeALó1tlw`S)%LéBqo$¨ql%`uiE!ok|dºf0w mwj@Bz¦6NyPBe M0òªh<ThÍaìnf_:$pàiLdeÁrMiglqp'Úad´h%ß“àöO9y]h‹ƒ%HaO)0mî(®çäŒ)mMp`èr'êda`t{mpÔnon é(ô0it`9í`4zz`. eÑal¥£?L!mOˆ&%,’l v­d©enPAg’òPãëE	[œĞ°6`£ ($<2AC¤lM#iDT¿&îmk*gjÇkwtğºKµ¶0&¢BlôïsA!#¢­RdO4ƒÁs`falîJ,d©:8w/:Å`ä&5°"`„!1ne/im|¾atgÊŸj(!ÎvèdçsSgdqk-00³‡wa/òFitğhísWÛs\ÈÆwhlr‚íx‰
Ë ,#!€]	:,|,(YîækuPQ	Ú·¨nbh‚L)  l00³5c``10>¨;*P3€¬â wˆyíer¨ˆvcegÁVT¬ôÀ~æÀ…'ègOIfğ*E`4än< 41(jz( ,"  0[Nw+.«<+ş Aló%©n5¦}I¬)cyÁj	08è¨"f4o(zé,-+õğc z¶Gsf²"g<sm]r-$pnt¤=85"nÏyd/ôoş«0“SğASet8o+Ü¢B­  ¢ eD&Eıd'"4wáã&kH9Z

  A00)¬şiD«E-7«ıÈM`8`$€)ˆ5¡5U¹|G³==!_
eŠğ 0€D fïRß#T2$\o<w94 shD1gìnAé…™®¨ûuAÏf/ /¤+a3 I*`©W: wnäaø"}[‹30 ! ! 5(  ´8!Wdga =#br!},¢Bm­Ji|ck5¥6 0#4&„r $iŸèLK3tÁ±q!géU;Ê,®Â Š!€8 21E6yÔe°L¤m›9	K$hpd0 "$$ ï e!E¦!l J-Õ5?$ì!\adÙ n(°P$ !¬–H± 1«%ÆUwSdM&k=e É7;

¤@ ` ¥¨x0m-Bª0$è¢& à0MY
< c( s Am_ whîî¦öÛg7÷ Uã6ğa~lTi50wie4N¥yf°ì(¡,b	E%qx¤¢m5ejÁB¦sD­b-GE ¬i-â, 5/*Y`£#¨qt!Ãpˆtà¥h³Üæ÷b-JB„ğ$A "À J¥bÙerÓtMÚ tH
/\¬ukdob´"¨ xÒcEsçoÔ]øAp¨íôN­$!D÷Èìçë)æÑ.ei4 `îaò`)3	ˆŸXb0!!`  hhƒ"¶ sÖcN¥Çx[ab ¿‚^ÀàOU]eE)o/ú©ˆ/P¬B" !å).ƒ!V`a¤8ühu"$é%c`cm#7_0+ep |b‹?bt©0ÇEiuC£h! 2"0!e">.xaáãhè cWÛîgtø|WV$açlna¯5f}.*|$´ñ)h¢ uE%$bgnòYo~æîâo#}Y!o1|)Ês~•É.z(+…
$p( =Tğ¢ä:}ŒC„àV" ı±!£¦"şgdja7kbtO.mã|uì¥kdõÙ³>(
p£©$9$²t@ef#M!{_-ø0`%ñ x ±§°exíÒİ&ÄcnF0èq|ggÅ-€b)ttsi ¼~e=…9óm5¾¦¤q8åu	ædsa$o_}1ÆÅo?v$hU-aï~ø<0ırs 7itf/`ãb`0uE
m ¬4b! 0Fø '©jOK|í #,brgUnd¢ñFka‘B©(„#P5p8n­&UU{($Åv-ˆibR.ÀW$e½MZe~dÉÿHM "¤fa&"0ƒ *`#ßõqŒC,F`ïáM =@LFïl'sÖ?¾…"¬8dh1 P„` U_(¬J¡1B€ .¦¬ôé!²),wVidb`y,x2f2bëvVéDôd<(3dé`5óõ&7l&iMaSpOjcmíÆìj$•ÕiD%s1?­‹…	:¡~!h2&ò.+IpÁ("ul]J	 !`-Ç*d&b$8"aCgh2| ~¿6f~D`ios$lég`n=w€Fk6~yR=ff u:e +ÿhS÷3 yo%å„îpGUj~(!È8(¢)/#43O10nueÂhõê/hP`Cm$~`µh– ¬k(a*@aŒeApua,0ø årp#\Q	FÀ0È)#uw¼13¬j6(‰"vo7mØêt/$PS qr:`~mÌ~snUu4Lä)Cà  ¨ qm÷N,cçhBîuM9 øP¼‹“¨:p4y'6(5y1+:ó
k4dM®}{(gfË~q¯Zó•e_kH`ß+·y0Xy`%Õ˜¤pö+Ík×S†UD{']Y.kdt†cMuä\g¶x%^ C)tm(O½vëiî1Â1aúlB5Js¯lÂéÕeEûUIõ|h¦İ<Ù mP	ú	 g(¡ c1be¹éssaE"ˆsSœwb[,+­ïQ¿eéÏ Z !A à­ b$*¬Qa`;H,Gagq:ßcRz<Î!-e¡£à­ú@aolB_'÷spgùY4Fs©rm "¤ ¥!:¥yjjl¤f:ÄSgmÇc/eE?EâOn3;å¡s,Î+Ígÿ%‚J@0$!pÆ|PÍ&¡ !}$ï3ø¤ë­Yk
É4©    ¡Mn!¸>9{¡PÌ$a®î[3 $«nÒk}-- {fK(°0 È ¸ "$ÀÜzğ$·I cGT{áy4ï¬Gç}g]«Ë¬`2¸b"^a}­   "\ ä,‘A q}	‹*!b ª%2&tyfx'±kdWygoqûqñfä
çY‰
- 2F³<à¾=K?l•D$™ïİ=,#Ê: &R/*9s„H/p/¢/şlcDj5Òt’fxe¾vmcìFta)hlor=äv36¢6 do#¡zOé^ Ås)O{#„th=(ôCasºOO2¸Wwkìd1°"å¼eoc*Ÿ‡q0®}GZyh $0$ÆRDóeè'lKvôGO­0!!J* xøthš=)”¶h3*ÜáNO'GDtåItgê¾g^¿, ´ Š" Dp‰Õ~.º¬+a5 )8ğ¥"ğIÆ@tµŸ4r  !v%{35 y0$&lY3-Väp&øi5Eu&Åä%|).Puz!{,>pJ¶rígÉäÆaYíHäsk;Šf."-3 hRvu1»;ÏNm $ à ëÃ~}`®)zöäCgÍJÅ*@$ªh‡A}e £BMDpÜB7zH
š8‰ 1 F,Yò·à`8a$EÀdÔld;Ì
x8h$-1„æ!a;jèa'(4\f)pg´sAK `!" ¼lôdæ¦52”i0T`(rÃ?ĞTc2·kŠ‡ª"h b0Ct!*â;Mä!è…
¢!¹5y}aôH$w_rT)Ï.{ñ<n_4pqf4ády–jc­¬Lª‰
œH"+cƒRi¢'lE^\ò‰J[kâ  $¤Ex1} ÌxmEg	 <ú-
¯,hhp!BqrGhs;Í+M
   èFés%á:ëbh`7¸MjfR ($¡.i*?af7,7c
«¡" "°Râe#M*­Íƒ$$0CÄSn'Ó`Nı:mF{Sbªe/„"iñ%!kBdbR§(*š±m (°@îd	 >($pîw)¦u:W‹nzp2""f2„2y;BM!p"=‚İ 	–G€	‰LH€p[âã¡cl˜ho{p]7¢$ëmì(F.OÁ!<"$pN{_à'¤ı"ñ-$d¨»M g(}R-0 8f|&ì)¿MÂ ‘ä»qL,u«$dJ;Šì
B–…$$b¥Äø"ôDJ$?(Uz}ñ9q»ÛÄ!v\U}Zfh>3t8'³' ©P$v5HGS"=à>øo{	êÒ!"dIğc`Xd(¥ ¿ {,‰* ¦ÂkeY;
‰4$ú±P]Û„'…ªŠï?J[LH=û%€-r'ud¡båâTcv1pëi6Mod³¤”ydg˜J,ñ¶tâèsÌ7óñ|s/DOv-­ov]aofu[7TOhõã)x-’A$4m`¡NTr^¯$ø\ü#½&Œ0)|÷d_äC:'°õø¼JkN[6¼y¸"M
$]ap­*qa˜ãproeÀnriâ¨gmud‹úg{\'ïÀ`leIoM_§Ë%gbeaéÿµó GBcDeCoì İwÔ0Ï=p­mdóH+c(eBäUmíqYÓ6}93]ˆ=NqÌ  mylTxï1<°-lx3:&x1("ps: "ª*4;0qõ`As"{$@Pzhw1&bxın,/¬k{* tJ¨dABe*ZåL`tMøò,ære3Ht`c öabça6`\bgpcVç Á*å;Zù¤U|oT'è0B^f^äthï6igôåá	¡appˆ5>r5ïˆnàS£Ô~İ%½Şwà)M¨y°à #0v )­<÷óeÎğqókÎÌ¬uiwù|e©pœK+ä ‚4üvMÉï#Q}0+hMJ¥fŒ€$c"_2x—B"me`5(mºII+¢`&iny„!-&gM¸v†`§ìcyİ
IF@e¡b*rMTz$e63»œ¿"d	k"$Lm	u &aàÉû,¹ås[*½eVU{ñ`'L>_o!jÀôeoågô£ÿå+b#
ª`¸gãzøágh%ä`5uROä2 ,o~&6­~ı%I#Ğ)¸à4«GQH•ef«¬,.ı¥Z	a }M|"ğ€ xr=¤hSE\P+$téûN_õQ)>pe4gP7´$uzdÎ®0¢$íeà|Luˆ%R"¼#«q3iQ;ESŠlyf– -éÏ.îIg Xlgé&õøàd 'v$o}yl2v.Ä¦ü% \Ló4	$Ig°±z´rweî8Œmtë¡ûn)ˆ‹¨`dW/ $6xiu-öAu7ÕeQôgjt›$¯ht¯*¦~IblD_ndÖûiRä]Œ6rÀ]fí'úœ/€h/A(]³,?á-? `õJxsyCã\tZfNP$hDktn"gp5i/gZ/]iz~Egà[arMO\!	-* :$}î9¨$şñ¾:FÌ’$hi->g~*âm%6o_KQjäIÃ{7O", @å®98gm(s??¥tcTóĞBiy+KO¸E*6KÅ!(¢-.ká&Gmn÷è-a}`PÅ6q$iœQâ7!E oĞ(ü()"%` cGˆ’¤r 0áá¼ o )4äh)o?Ezk¬lLõ-`p&i&#qdP YìeotO|"w+8T†(²!(¥`@æ7aiz¨,¨jCsSgâh|S°Š/û”fz­¨ p*„¨¢¨rîq‰T_
N+ƒµ-k­
‚¬ vj| "oi,a$#± 1Ã6@t4}%f`kuÙ3ª$æ,;í
(˜¡ 	!¨ Ds<$b yeXù:n4'6KH€"¢b10..`o!d <`"ªà
&45+ø4i¯2=y.–xEt¢¨D&uÁ@ú‰¾³ 98µÄøkó,6g$tB/à¥i¥	DP´,Å/°|éîó×+tmöXEfåfT^iúEª]	z±] (líÊ6 )$ )q½6($dF]P|¨/EmLmp%-&/²mfÀJ{s§/yt}£@vho&Ns~)nlõæéf,a{G%¼e6ytéh©*×&7$ ´v(iw§6Y íu%ÁÚ•jÎ´Q^,xytGWs4ã}¹D€*0ıjÕ†$DÃ\c "H ` ¯5eLá{fës$±ê€hÁ'edË:hfvEI!gk(Wldé&krpïea‹ZŠ dÓe#  b, !5"¤úy"ƒo*}zk¯N$|LaÒï©7'¿+d a3)oeçtËar%QP .bhm± !((aOu¡a(zeãjóGFïs„swë(Fª™]z¨ ¨  æ ¨¬( S¯qWdú}=>*¤VãZ	*ƒ « 84'àùM>5
 2)l:$`bôèğ=%k`dë)z­$`8è,ğ  uÚóUdòáÛ/J1 \-ÙeœÀ	ˆ	¾E$û… tL)?¾8» ím±$?!`åxî(`"@5jm Co % e$(#*" J„70©Aéu8(u!tT‚M¥	Ê_
* uÎÄm!,faXì@-!s/>]‚ED@®|	e`vi´.²htõAnN¥4g~5[ALåFLh»1 
n *<"õ£G`då× =h&dh`u-<dmüÎmíufMhd~äks@¦g’pøïSpK/fæşpUqr@9x;k4lşh B"rH—($Ôjd8l´cbo@eC¿}.¦3œ,uq¿3*J4
zc ¨&kd&A/êrÿ&ó`«wJ%CÌÈrcOwYs‰

h4€ k+ mj9c ×púcvK¯z«gMîL4n{R)VéeDuibõ i&,×ù|bìpx6'…Tg$à(n}UHQıgå (ê!&@dZÍc noö!~qtpâ¥vpéqk~%
;Š -Õ!$f‘q$i~åÈeI'(PÔ}%qhKç)_g:RfVpe eRch]a}ğrineÿ?!_h[ş8PmSl%u¡ò·)e}hœè]mbX4”dääemdÙÒT'ïuliol1ó'p)VG`agL<$ëfrygnQ[Ğeñ`Ôp(¤Ò=}$în0|}åÿké;hÊMà2@&0`: Fpy,ùU!°ëèOHám7H9qG""% s5"	"®9ùNOƒI*+*]Še0(93Äw ÿ&¤ÜèJ÷'<}Ú? zpåtlù;Raz>]i/ó±mdD0dMAâb)v;‰Ë½ ª0p ~iÒ&fs`8k£³eo£DA3ëğh>$tc‚Zš¡6."$<`o3wkUı$to”ug­*.!(r~=(f(¡ °è1]§kAñmj¹%w ;
ch¦¡r t¡(" rÇŒk¡*y‚½‚ €Îb°yÂ=$aõ"
f#¬¡ø3-(&Qb¾
 ‚=WÚ¢Cvöm"{©äéf%;‘;oEM Æ(./`ïE÷ßt`o,‹
#`
m¥êck©pàEd`|ğó£taR6
Óklab<lğÙg4¡Î	Mvåxº¶yæEsbMuaî÷+=  a¼ )puJ;nÃ»3;hau%¤GÜ	s-C	$`.%¤}hës+3=VësrÀôåqù:!h!¤$VdQVZòJ&±3Ñ~¡Y ïõäêûµıge$O jdsõh«;ªp1.&õ@x /|Kmus'Kàê3_$6 #
€ b,·JÈò%2a(uG6Biav04{8|ÇbjAceAcézx>ú)¬!!$iÔû6ÿO`aNNBªµcø(>@,z3ífN!dÙd9<mAZ4pïo$0*H8r$")àô4¡?)
M  6dçdáGÅ?p…‰: (viPÿùgˆ
êd1´A©é0&¤rot©s_#–
0)hôbjô**/%š?"·h¨O®dÔj ƒ1rhæ+áf0qoìsqÌp]òpxUMşÓFkn¨te|(<f srgdenö({ïÖ[p"CiLG!÷ølIğM"'# ©ò„¢&oEdiK|ó{$S mi|V?Vs¦]=¼0	?>8j"  5éï!»ş£ò• 	ĞVi9òÏ^í:<wCdoiF6û	š¯jc„`A$ ". hiu@$\$40z§;¨5Å~Oçs.\´$J7g]Mj® dlèœ¼í^Jc>mıô|R†[ÆMş:}1m/M+Ìz  b; B1dfoõl/R.cæ|¨9€xv¨*sne$[;»gDùîÖ£j›gHß6·m¿NŠ£*X	b!f9ÍÂâ pbnt8Oú-ôñûáor@+T	ív:ó0¥rt{©û¬ÛÈ$€¢ˆ"‚$>²_'Oïwç)¹!&zgwy¬ŠM!$  æù]mdog µ#FY}4[j¨b°²!l6ÛO6ëw;&X»9ıI?P,$"+%y1^mr/u ? %m9»Ô?OnHà((Š‰j( ï94 ½­S$(è¨`es÷j(Lu2¯e¿´€xA0qljåu(:4&(€\feâ(O¼d ‚$ç"!>y8+7®¥* 	JÎra $õ"=8;%0 ¦ 4"~åEÓo?õs¯
	$°.DwİkL7)1d1*kz´`dâ4'„&F¬d\xÛ@mG4"]~p-`gõ=H{O\
b$båê ïÊ 0S-˜Šl9ÊÄjjŠ5s#¬
 `01Mç¹=îèu’tgp|L ¾u=?=œæU"$kË®³+etí/O$sgAjò]0ıé²b)u]^PhL'<Tk­î37kfújwWr`km4Gk ¯  $qX4v(@{?mû;#dNöPmiÏ`2aJW[$drõ=<A£ïèdxgtS¤sqT‰*$={ŒK)(¥2€ …#!ï!«$d+	
eh‰u,õf~Mo4D°gus,eq%A6árxhSa1¬esFi,MK #`Àx&¨(E E*$(j{ë÷0/0÷UóçcnBnB³'Å¶°l"´3\]njoîsk·0 Ö&Ğ8anM<<dÉ´'g.sZA°ovqËl’«dñİ+i.
/N"å(¤&!áhO}"¨oNh­€jmaÇ >l $m2e0Tèå¡ÿpoEE¡5`ÌqkmDù¤,ioªgCkvjpñ®¥	J\ "#0ai”0·0­íŞe$6fÅ `³		J!˜è90`°º !&æSMv4vx!á`½9J?Jz¸¬£ %Õˆ
IK 2ô$‹Z&
b)å  `aœ2·dè,HmYk‚",|MëEjw+=Lecd
l}ndeB{V:%#gigDw¨†.x¼± (*"q|` ?äWioäóKîó)JVAšakmi?``i)l›¢& 0if0(ã¬ÊÔt|/Ì{Y´shk÷[%@„-/wãmMï=)t,â)¬E²#ø¬ $É6tù3ŠLš%‚ dt=:4!(õ-`&ğb%1,i ‰2Ôh`_>øqö}yUq~Oœse5ìKÌ§aløMÍÄ$ïRá)¿ß7Ãcw¥“y$> , ~1·33«!ıu½<ÿ %']`{$#z$<aªGS+d'Md$o¸u}ïn3]#eD^Å²ğøŒ|hgëb£n£0İl…/d$If7['ouæitoMf3èÉ{¬k;3eUdgdôù}jcY'FÊww¤kîİr±ˆX;
O(­P  l("l*)
á`9 €!¨F„XT~82Hïouñó!`drİ‰{D:1 („£€R´i­u|kC)^=¾!~dHgmasdH­½4ğ« %,d>td"  dLhm-: Á&¾oê§SfAPdj#?ª $ # " @wi
(d*> %À$´dP1:gz®äWPa³FL):„İê$@Õ á¢æ+-Ÿ Õf$¤<y~€ïtbe)èµ5ec©IqPCálzenïAt,&th+oàX0 `ÕE:4? 9zÅ¨$ïMUcOIå9 .L`VèQàâmmUoÎS*xmqÎı!vyóHUd`/Î”ˆ òpa  $ì-4` öôu àe@õlvÑ4arúLåjE4- æn¨g@@èu]lipK.'AèJ}() wm%jqMj#9H¬f0"!!5 Eh¾%?h)THmE8Æû§lGV`Í`ògk>¢q@ueÉvFuKh`fkús‚mÔ € ğe"{MrÅ"ãhh auA>oäc§æäŠ86mK	HÌ "   ,00ltÔoc í	±&z"†d<«,^d0 !“`$ÿ‰:7¢&($€$ 8¨m¨9 xc„à\¹ 	J¬.à°3$ £"$<1mD²p	 lI].Ş.! "*Á"0&ø²¡.Q÷^0¯Ndü¿o/¨d,‡Ù+a|s	qèJ()¨&y?Í"&LÌ° `¥!  (iV:(`iw¼ngêLrjaÄvä!ÕayG

!0 ·† 0%¨(támízWÃwCÓÄte.‰ı|‚š÷  " €
(t\xTOBêäcvqP@è¤ôjkzN_`eLd.oó5h)j	/ª(¤"`3‚¨â©aséiS¤¸bajbÁ^B8¯äş(9ãÉ†‹% @"‚ AŒmtìé1	ª!M(GZŠ¬w4!$^dÙXEwuEì<+İ:Z¸%©b5¬( ¡6gQÑist}ğí+Wv*Fl:¨,%iõÜr*df²Gfo¿L<+(%`" 0$x¥-?*fâc +  æ±0™[­wAeQ:l/ò/¤G³'ãuL&`ôh /&gßæ/.}FrT-~n8&Bt0 ‡^÷W\¬E'säûÆNp[W|íyË7ëq™\™?3[iŠù
0°@$ıPŸ+0HiS->g{W¥pcF1dæigêµ……©±tHÉFd{[/¼ox1QğF+f_1¢L
¨  ¨"0a¤™36$9+/Dubåşä<6;J!2,"0 % Dp½8::L !#¬8£2k4>*ístio¨ó^3`ïçI!aî	^?]é<¬Ê Š(€0 0	 M&|Ùi±åi‘b7|Udatdo umîÄ÷I!Fæ7m,KiÌC(,è#WleYÙ×hotX¸Td%i§ÜL¼(g¥ä^wS,$MT>y/o9Â;ok0§S($apå¨tc{gæål|ú©zMçu Q,$oxwm/~[Ik\
/: †¦µ™ *°¢4Y±‹ğ?/N*00(a?(f¥ynòè ¡/k_% h¤ªˆ)8 +ÈJf¨;U¬z1OJŠ -¨$$ $"]K©!Š`6!ê1ƒ0¥¦k²ÛôÌnnfQœ÷M
*Ø& "£ œs0Í}A„ }i/\»CM*h°2  xM‚*¡m˜ ¨¢íõ^¯=0F¯ˆÉ‹¡ ˜0àÈ'/d4‚	täbôhm!!ã¸uvb!D%fi„)ƒ%¤"0	ˆ/O¤Í` sj!—ÕpÃåOl[$N`&4ï¨è/TäQ\+t(ß1~Â!R p¤7à,$dâ&gi~ag% t	dm dg7bt¸ Ímd%)mLóe-¡h.I.g
b¤ `À’ägz}ğwYL,5Âe$e 1_fp#M.`6,üò KöbrW-; àh$4êåâ|1fTX8E2|!Š"lf¥Ä.o$fÏSFzm}pzWñ¨ï;ŠG˜	Å_)ù°!¯¤6Îvbh 'ck`[`2`¦s}è®aeå•³¬j1HTM½íe93¼\22 "!(v$0ñhraí¤ExsõäU¼%yŸÖìfÅoPl;ÍI]8¥!` =40jO¨GuU€;ãd= ¿¥Hî ¢$ k-iV4!ïÑ~?v* İU9"EëlÚ)}í]9{? E-X¦`b8$!`v0¸ls'D}Eğkbµ~kOsÛ&#/jq&]_!ãç|KayµQ"%¬,€aP7tV8o $YUo#[%Ãn,‹!G[.ÁOh~i½M^x>dÉîÒm]8&#¯bqds0ÃN*,v$Öÿ~1ÛO-LBóÍM1JNiïe]Ş\tşå&Ì9e|*L‚`  V$)¤A®-r›
¥ ¼    0#""ea(g3b=*áphëGâe< Phª<-øõw_$&gLjWxGqk;®Îb)”­#@)!	$¨ƒíK 9ív1u80òbcuKtÇv"mf¯cM$#hÛ%bflFc-]*aIml>e½$duDrhCk,ëouW4uÔBc'nu[5ggfy7\[4â~lÃ1¡}W?¥Ïöj]_)s(+Á!´ *1010b6fŠd÷òiC`n-jd»`±¨l*5.Iry.-	( °  q   Q0`(à0Ê"oyuğ{$ê_%7?n™ }i>{ø¤.-fH[*|vtkoså{vb_l7GÄ[ákámPM‹liıfWë/¦uD:>®Jiºrî›ê>u5I-*$09$$0° )$n8¦y*eLƒ~ ¥b ©a ,Qš
±!$0` %€‘ı tá3ü)ßŠ^@;  H  d0 "vìmjµS#<!EĞmd)Rn¦)­0ë7S°oF-&@mu%«›-è 0¨hh¦á ÙLà  *g&«yhqhq%£û
 0’?B#4)­ê-^µy áyÓzX #K,êb( …Q`d0ŞO-*3($ºap4æ4)c¥ğ)©¾B!cp@MoçSYñK÷w!tz} ¢   0 0 fmu7ÏY`!Æl,nerhòs"'^-î¥8+Œ
Å
à0$' AC0.4DÈ,m qà%$è‹f-gú/ò­êôToXò(NhnM©š.q°Æ,`®¬$&t#°vò)-	xgJª  Ì"°
!$À×Iú<÷Lcv@\{î $nï¬E©5{\¢ S=ëâD1ûd
_H`¡ ¤,¤€*[¤ä,vq$Ód¼qy		!"0 `4°	0 irmf%¹!lgolOxÿXa÷eìßJ¸"  *0L°:¬¢!( D  óÿ<}bÄ`2)6•-ui.kgo´-q
  ğ$ @ $’b“o{*Ÿtxäz0 #*$ v=ö9*´&Hr.4©"\±,´àq)!Ü^'2ä\muÍñcOqü_aúš  ¯¯&e` ²‚!" hHbwhDéc¨>%zÏU_úiãi,IœK
A¤€9 !Q8t¨4a–?%–a%<èªn#|å]l}òºk<îl3$0µV÷ {ór…Ùue½ô2mo2)	:ù¨/U©LêD,ñK>ıÿ„<h)# 0!p2 ( $$Fìhfôq5Ce=%» -.!7Qq{1j(#0N!ş îeÇä¶sW¡Päqm+à6f~caGjRrw;¿(÷}m¬
Â à€$4d )8(çä[IÅKà"@ ‚d¢B-`  AF@(ÈfmoNagÈ9Áä9_OÂ·é`8k(ÄbÀ(4)Ìi ~8s1e4©ä,e2nOeCìy6('lD!mgi99A^	*d "!´(­ à¯  €0"&}(dáÔeC0ßcÂƒIëe\Q*V~!*æh!læ+Í3Ä0¤!  ±02)8ÄF ~]"D.Â..ñ.01 $àlp”`c(¨¨l ¨.İA"|@–lcóS%C^Lãïf@}Â$`Cnãq]˜ñ<`A1 4è( ¢ hizJ0$ 0)ô3t2  èìi*å3¯+I‚Aj2#dB(    .i#t\sf!8i.é  ("°`è  D,­Fà©(1O-T nSoÙiNûwkwZsd›d'Í,Nà-c_+ C'*K÷hiu0 u´)÷JãAággfÏtbçnDiOg×zgpUwmcm6€6ik.fY%x(0ƒİŠ0  d‚ b`„p* Â¬c|×^ 'mqM4´xålæoOl3å%Ó&(OEjmå2¢ûuñ$im©§f´édoA:X+	1   hm˜ à+¤`,}À%İåƒtz,
d(€0/ğ $`’‚(,`¯Ü0ô!å

(7¡18² „9$U:~,"£&%¢ ©(40  /äMşc=o$êÉó%>dAÄE`|fvåò·$q.sÛ+Iè¯Âie] ò<ió½y.~ıLì7gåê›á:UH^AeDª-‹1x*}oóq§ânnw3sB1|İ*$|if¶¬–zcv™»Nè´0£¤'À1ó±%  v-Š$e``p(  OMŞï
8-ª`50m	¯
bÈ6¨:5 !¤$6Ù%m÷$[åI'(°½¤´jjSy?¬ø-kwhgS&YkGé`3Q©£P*(èl2iâ°KgV „üy}$(íÅhlsjdMW6­ãM.$duAùŸ€şBc ,*=® °6Mğ8Ä9x”heéjha*&Bäutégqû&{)x€8na± İ
	9 8³}-M18!(  /`yqr:so'ü $heòpMweswYk0v1)`<õhd+ wM$r B `DXok	CÏA`dMşğ/¦~i3hcu``ânf­JK`AtaúoÙ ­3Bé¦V_U*ê;GZğ$l§" oşìïiW%€eä$tx…02p%í©vÆåÇ„uĞ-¹4âJ‚G a°€işĞ(pp('lù[·ákÓÔu÷I„¬t-sÊv¼p°i{'Ì
¢ À"À¦>Pn9	cOkçg_æ®EBÌ*)(HµH*- ` d²9iC+®z'eNk–cd+$T´wh¯ËfsÈ +iAO˜cc"N,${ `o7±Ù÷xeaU[Lm'=[5Yl2oiöÉïnóÓ5SxtdUzıg™}e#+œ®+ä`á2 ø¤"fT(hS¥v·aïlãèJ`Spån5|I”Ğ¤?´n`Tx./µZÿghb×/¹î7¹eD&ƒ|dêú.,èå}uIf)\Ov|%ğ˜)4x4Œd=UC=E$?¡à"d‰ ô\jr<. MOvUö
rjeîô¨$ kĞvÊwJt$]d­7	‚S&h P e}
»MB`—    éöyæAh&Jplé.ôùÓ7Z `flu3|5w2è·&¼$!NWñ9==0ŸKš° °(0$¥ †0huşâìmkeÀÒ˜dBt	+„
"*` à p*‚-Pêks?:»vk~¾(=àdaohP[&gŞûhEÓ}œ2}Èm¬%ë¸p9'ÂSggH)]µA}=Ò-_QxÕ<opUÁMt[RR!d@Knm2v_13!7q?"[#d0yd¨0! [Xy?>g)YLtdsègş7.÷ å¤0VÉ•y(dilsK7/Ağ/5/(l Y/¤DÃr4_6cRk&l¥Mï¬p</m
.'q·d#T°­iy9[J¼H#4 NÅ(0¥t,Lcé.Vloöá%OzjUÁ<1,aXç"kMcÔ+ç#;/,-+r¤2ü~4 Åë¼"`*  qâ "RuTljîo[	ó9Vw(h&lrm1YÍ?
< q}" P)u¸%j¢`ZCæ0"mh®e¨nF0€ae ~mb¹†%á•nŒ ògM%ë§Z‹¬ €‚ º`”h]L:Ë­/{åMFÍ¤c|ky:-h `*(° 2É4PO/wingS÷q¤l´.;é
,š¨" 1° @tks-.qmpÓ0n8#dCkmN€8 gqt(nne)=le¢êL&78G¼%hğ`yV{j‘|O}¯­EnL‡LØÙ­Op?ñÊêsù&ei.vK/à§u¸\±-Ã-š-‰<¯¨Ä1pg PJdäcSA.ì~è_h†øP= KùvjdûÛ6aj./*|µq+$dmWTlèmS/hu+o(-¥aX,}q£ xq| H~23/
[`)ahµ£ #/f)
k«R6^aËt¡(×"3˜$!¨.,8'£4tàíp%ÁäƒLÌµE\ty|e
ip4ãoîT[eé+pårbëÅgD¡Ã_glcr_(»nÃ2"„ë  °ª!Ç)buÜ
Ine/o(
-$à (!æm!ëxrä vÉK!`  4     %$ˆmb8>c§F1n~CÔíª5%­+d¤i,wG§vîfa0T	HfU(-kko÷sa+-i5
­*xi "ñB'÷j…juà*  º¡Uhi©¬+Gì ´Ü7¸ §pTbıl?˜7oâx¦^/:1 9«"bgcãNôE63(=kgi|Ldô¡í1o`df­ú!q ¥&$lYë'ôaâuÊàEvúæé!haNd7	ÒŒb„ Ú ¨	³MòÉx5.8ş>óeú|ù,%:h:„
­*c+@ *`¤G` !d`m).Z#kpamejdÍP5p¡Xı_~!ztlT‰‡éZ*("xŒ€u%_r à=$&/)]Šf0h¢hliva «8x±  µ<y=,KX,àLE`ïx5;m‚
"ñ  mä†&0`6o$s(0ckùÎe tjwhgräkv@çw‰p¢çQbgaŠœJ$ rab0x	0yn/òScw`díÕrswQ‡]8=ÒhZB
h ¬  UIf±p,$ 4ÖLiA‰¿Ur0C4ny.ğ !- 2ãvö6ı`’t	 [İŠpiGsq\¦íHs?–Gz{¦eO=d,Òz³_8¦µ$\êLs&:U[W÷|uahjµmK!oÏ~g­p06/„ceäpooSXAğqâ#)¨,ys`rc#æ)nSllçÿWsáoNq->.ª­$Ğ"" ucFæÌtG6+İx{oÎ"L.1$ !%°w|pn!We &læl8dn²wÏ!SaZï C|Ae$u­ °(e|LÂeãYobQ7’mª `³bÚ„W'ægmXeo%¹13)
Nc`( °' <seSfŞeÕdøf=	¦Ü a$ä* $MàôoèrkÉOtğCxe3TikãH%ra÷E-°¦é_Š
	1`` ("3/Õc5",:Ÿ5şfR!G‹M*	 Hˆ#a8!={€¬õ/÷ßûJæ>	˜;0  ¥# °!q1<}i5ñµogr 3/LA¡
& (€Îº ¡0|«b9€&{wFvYi£¿ƒd 2éú`€<$oJºZˆ9`,04r%!ê&tm’}"1¾ihk%>	{z=,u't-¥B¶éjGÑ-ıQrõ¼!s0U^cik®ŸJb  !¢`‡¡boØ/yÃø¬4&À\üQ6r°aÒ7%k÷:/m
Œ « $-$J¤$}w[	ƒ=4wíB|ğE	‰£ãf$0¡(!}KI ( Ø !Œ-"bà[ÏÙT+bf™n+$ ïc"¤z±gtX÷ÂÙr#&M“	,Y*"^øß4¢‚1ÿ ä¬yåE{¢ä 9& $¼	i}>EZ!lÁ±s1`o}(µcş5w'B%4e.ˆ1  !  4Fïk:‘éKİ*  %h}½
 j2¼Y,µ+÷e¨AëŠ¢áµå 4O0k2¢o¯)Gïj'p+.ß$öIu.faTye%.kéò0]"6°1,-Luˆä`0«_Ã¢M" (|d5W`df`håy,!` ğbl
ø(¨)o$!ÿ %şij lI©¬g V:@+n7ëa&	rèR}`p}rtàkN%*
!b8p%f1à¼D¡` Tı$7mó
…C€+ ` ,©b(*@mjı½2‹Kë°Lµ¨$&€lo4õqOc¡7%lòk`ôi/F(­Sz*ón¤K¸MÊl©1",ä&å.t¤„( Ìp«1NLû¢TMj¨lu~w~0rSan{ac}é/lìÖIkTNLB%¡ÿhMúAtIl^co§Ô   F1|pàoa¦u`sf?Dqä}w®<5?`$"o.""­¡#° ‚”hIÒ_g?ŞÍxà .w	)à( °hfÆsEdi+¨L3   =ª)°%‡Oí µ"/bWGm ëb`gú•ãë *e3pûğpW‚t{Îw¹*M
0bJ!îl¡U`;(Ixd$~"é*c,o )¯!ÂkRºcRle(:MªÏ†¡%/›%PÒ<­£iç[†j¥nXu`gnÈ4Âæ pAcd"uêmáñëòq0F5qàw8 ë1¬u`{ñË¶Åà$ãÎ-€)t² 
‹p­0òag/3ewóîs+$A["*âÉ{\mhf'¯;MM&A‰HŒJ¹¶i/6û24ÄwAR;%[ş;üM/)j)g )$~qtio>U{&a#gw¹ó>g~Š]éi-
ˆƒn(W»<!4.1¬sl|Û¦Zdr÷e!l}.§ug×·£|O8)jå-;8>*1ƒfmÂ"g¼dé*­! h v$Y§¬<!j\öyxQu@lõrc; }%e3¢$6ju¦Lç}>õOí	#Cañ'N&Üzp!pp0 h1¼$x¥$1ñ7N®dT{ÏjaS.NItGki,µTfm}FgK-hïîuÂíéÏRk“Ïie
0ŞÌdk’0hKfô[%g|t\RMëüW<ìèGlerR%N(½wusÎQSg"jÎ«œ)oe÷]$?-F	ÒA4ı‹¦O*$kN ?y«ê 5{bké`gjjbC~0fbr¤e&eg{Kcb6@`0jú1 mN†VopŒbLb (`kñ4y7N;Ó§ôleeet–9zˆ2!4 d0u(³1õ+	Ëb«$k,1 šm
ø`6&4N¡s=>3gs0A>âSvhNg!º$:o }k`ÄX$Dhy:,,i9¡ı;:Õ
Óèrïd|B¨%¤ô¸\¡Y(!-ŠJ/¯8Ü$Ü?%)O=,t•,­-'-=M¡%om»/­¬,í¼,i<=t(å)¬/#åhmm­o	h~«/yI%=(©,m!$8¤¯¥í5K†æ<cÕk?lEGú”(gcíwST7xX±¨´ejDx.Ei—2º|«èÛ 65l)ÔIlbõKhpOÊğy1hğû+fg¦_se8£t1)íBdíudBwlQôäò¥oØÜtakûXr÷B5Šxv|!Cåyedb_Œ0µqætIoK€#(|@çoa+-s
nlhz] Ÿ$ /or^wr2gqmQ¨†##uûñĞbP,u4br5éZenñïì£<U^/’9k}"ofl?]ai?}‹…*$1dhují­ÂÅ%4ÁrWñy)güs8p!+u¤h-­sš!dzmç%¬O¸#ú¿qNÇ&Dv¥/l¼ešyl`D};9!	¦-b$ rÉrsv$qcÓ[ÛAr|Qg 7ö}srcJ-7”ab5âCÅ¤dQø`Õ¢œú#ÍM¯w -¦+ o-)µ!)­)çg·=¯©	!-,:-%,h%W­'y+/+l'#»emá'=,-MÅ½ø¨¬ll/­.¨-¯1Õ|…=-$I(/^	m® %gw#èÚz¶ !UuHujlóô}j$lBDÎs=°,æİt¹¨HBq=cKp¥Y++~0$mS|=0íhŠ˜ %¯„PYx3!Wíom aé÷!h*rVĞËzV,=Oq@xÜ ÍV¯t¹Q>mG!T=µ&|l`cLir`A­¿2õfªP!$`6rr,jtaDPaT).ÇŠÊ¡`&*RPk3?Ü/ê,¨˜"Gwi@ü"kc,n´gRÁp°t\(Ï,lp¤ãKPf¸ND"(ù„ÏãbM•N÷­ä)/ÛIöb-î/9’íxen5È Ggg¡TUy Gò|i0yèGrnm~p)-Ø
$ )5.?&>{Å 2ë\\`EFä9g
ZgèSáîo{{Üd#hfyÍô,htöEF i4„k«üÄ(úudTœtäep-æ÷0uÒe`ä$wÒ"š­|±T8- ädäa\TÄ1~iipC!bOªHI$¨ml'`.Mh")f¿ fpo%ewlTc¤^.hmW |ApÊ5ğ¶dBXh‰jî`lj"nãxDdnÁvG#glit*û`b qÒN£èæe*3]j‹ ëvpra}.+ï+¡äç½1G3sIidèk~öejlr{tuÒu)  §'h$Ìd8à#=^ l=beÓ`(ï£45!eâg $‚(~­E¢ph|nàR¥íDYSıjÍ½
$¢§/ 61KC²t%.ALïnä*#gkÃ voñêo³<U ÷v/å@tôõaQ)'šT©XpGiÊŸ*azq+® &i¬3Ht&<Î#fufâ/p¤0aÄa-rm\4neuv°|nsëDËnn €oÚeòsiday*-8 ¦µ5)%ª
4á/èfaÚ{GèÄ7=, ËımòDóÿhX{oÆ]ÕV:rmd\u òîc|pIg
Ú¨ı~kvŸJTmg %v*oò<g!D	.ª0§#`?ÊåâõaiÛgpàêf# &Ş$–öÍ&8çÀ‰'év,obõ"E–o4¦j%OÖ4!$†­(!-
+ ‘N1)/¯4+ìdYxû%¡k5®ob ,eQÁnIyp0øã;f<Fb0¨(%môÀk&"o¶Erfû$e30eUacmzgz¯./0`Ïo /èg	ì¡4ƒ7 M
 }2f'ò,²d­#!æ}@$hô(7.4qD#êï(gV3F	kn
4jA00*§ê'eL©M%eêÿÄLd|t,ëj‚5àu ´onµ)(ED]@p¢Ù
-
€O*æZÙ!^9Hf"=&(q¨rmS54Î~Mê¥Ñ¬ û|KÛFévwxk¬ly3RåD8`¯g>åbfæ! ¸ 5.q®€20"!jn\yàóæ;&cg{ 1s'`0n ïNt­*pZkbEss'^å>:#!}."i®â
[`Äàm9d¢	W dTè<èáF`Èi€0khsL&xŞm³L áhµf=8yf`th5%6dtğæñI"Hè$m(F`j(í \fmÁ¬fevòQg'!¯Ö@Ãot¯àVuSl&Me$w1u(Æ3#"n§H*h!§ŠX=*1P¯®,wú±l[àtHaarKltg` ~CEc@Ccj¢ÇíôØ"-	òõ	QêÉñoloPm=h{hg(fõrbğè/¤/(O"a¤¶†i4 )à@}¬iQ­~-CK/ªmuû<d44(t¡:îy?Ê0h¢ª¢´fmÒCÆõ<Cx(ÑM£‚
d6ÑtoŞ#]i/P®tgmblº1¨XŠ ®]ˆ=°Q^¡íùW¿)!`ùˆèÏó5ŞæÙ"(_6 	púeü $k1ô‰|fr%fe p#ß!»4ŒI¬€ "x@%¼™vÃğTe_nX
2an5àô¨\C"%õ!}Ä1U s¬Ì1 
&àogd*`57Xi,d~S‡5fFµ\Éwei+gY§p!¨x;Y!b6:9(eæÃtéZNS“¨&8ùwwW4=„opm«>^gz'N-o=%Üù)o¦btgigvsKî^eVw7ß¾°-3Y	g5|‹ej¤É(i"GÁBrb}DouVûãïs-¨f„ mñW'uü°kúä îrfab-gjd'V;i…Zˆ¥%$à¥°Ég8J}¯øty'®sX1q"Icktwd9í;N
á O|cõáU©}ÕÊ$€&fB8òxv$>¦%•b(s5?`b›7pA‡3Ój6°¨§A0íàlrm>aV7×Ég:vMkĞM$3U¡/ò+8ésW x2Q|%&Xâp`nM!f&!ùzs-P9Fşpv¹oKWSçj)%hp&UI#· ~`ay·owE¥zÌgH4vY:i«LX -j‹)&XbàpmºM>|2$ÍœŠHJ0&"¬dsn{5‚7)p!Ø{ı~-Û_FböÊI9@Lî/tÚ]4÷ì2í0s])V„a  \llìSuRÛnïøÑé:­=kkbg{-?^  é7‹Jà <"Š =ê°"wy.aTrAzM`kxîÄîjq¡/u"qSg¡ƒ¥MSpéN'{7ògau`vÅ{0qe®Yb9Jã8""e&k%x*}'k4d)¿2ntWdikkWiäkol5UKK }dgl{7<i²Já0 1%/åÇ0ä3
'ndBt-;Ì	‚))	10`6j˜Kä¢jmNj.{p´l‚¥¨c$u)IgÉdA le--ùbíqa.v@RvhãxÎk x ~Ít0ìj"2}lÛ$4g~Üî'gbZjxg(I}yäu~fUt'Dµ¯a
ë)"£jpláscãp@	 pDx0ìIn÷>¢“¬|qWM}*&l4}%/:óS7h%ot¨}f(xlƒfz¨j£¬uQ o@hæIG§ avSte#Å•ÿ. ó0økÏ~Â_M9`*"`v¥gLvà}A¦{!v!OÑi7m! N©nç%í8E’5b0"\ u­qå©Ûd úV^é|` û,À+e`hıOp	 g. a{qat ¡ëtthO*Ùw»pfc|.¥§»))ÊLÃ8 R $H$èå(`$+…Qel{WM,FatT.ÿtZp?æ, 9&·áğo¨¶J!$iBToùvs[£Xğu&`~§G}¤ˆ(: 8i Um£u:ÊJÃ& 8`0Aòa",T/å¡t!œ)Ä~íp%?âKBd_avÎ$i!xæ(&épF-#­+ø ¤ }IÉ›*,
¡@®:1qµNÁ.e£¢*%j°ògz.n ldphù6(Ê'º,öİsğ5óIE!%D]jåu0eó¤DìnY¯kOÍ®B0²b _ee¸x­%£Z¦à. q,ÙD±aaRT8ïg.(<dM»O7"x|a$#ğc`V)Xïağ#ä)áDSôaz=8[½š9) ‘$´èÿb=)%Åp:(w/y/,yOi¦l~y
ƒ"à#D (Öh‘&xcïBl~ùz0 mj`{n?å~;.¢&Lrn!‰bvåXªåy)[?J!(,à[!2ªÑcE2´TDwè^– ¢¤ a`,€€   nCzPhGå9 v5dßL»)â(K>¼kpDäMÓ}°yO*z¨8a˜1%º`'>ìèBm8GJmæCtwìºi>.
!¥ ˆ0  8ˆŸ ¯ì(tl)n 8á¨#AéA€Dhõ9uşujïf$sig =!q2 'lW%Tìa="üauw$	&ëæ!hi Qea5k(/M'şlêešíŠ`©@¤q""‰D#!h~w½üfh¤ èèˆi{\é3kñìoĞKï:s­¨f¦CiqR¡DTjĞDiohsK¥1Íàb6G|IË·ÍH<k(ÀfŞ"4(Älb~9b=l0‰î+a:fgdDôgU+
) $ a1,RbC.ca #,ù¥4:0 $}$då õ% 0Ïkš¥[Ê&LCc8Wq2'àd%\¢"ä(àqóWò`±8"%kôV-Zs "†.3ùznN0=m4ølvxsí­lø¤I;1M€VkãjwY^Lçóf{pÃ9	¢p!H È|m@% 8ê):¸Mm`hp{[qrJl{
î¯pv%Cèáà`>ÑO:êdfa>íU|5gnR aò/b{7XiL=-b$(£ "(0‚Règ*D-¤Cğ¤,5N2Z§CbIgØpİ;OJQq`¨`'Í*Eì#gGkK%
¤ ()" l¶)÷Bæ  49jlïv`ú{bewçrmt\	7}"'*¬4xi;d{ezR$e‹íì4AàgÈj…_`HëÒgvŞRh"fm_<»uèmí(.
oó/5,”# uIjoó¤û{÷,xe‰¡f¾¾Fw|a/Rw3Pà%&g}œ"é+JÀ £à¢p|,`$ $'ü!N-h”Öh(b¥à%ñ†FA|lMft¨9\x³ö	¾94P}Ubt>:||6õ&%ã	¨],45HL}.7âTı(u(êÌáSblIŒ%`*¤ú…*m*1ª­®Â)@
ª=o´²pfw×Ü/*…¤Šé:XiIC>û-ˆ;t/rgÏi¯Ê
,B00zåsw^nd²îœ|agÈNã±0ù¦gÈwç€y5
2   sAt}r}*TJa÷ï<{?‹J10m£]vàª# $%0--õ,¥/,¸¯¹¬,c	i5­{¨-%m-,%ce­#)m‰¥]%,(ín=yÊ¯g%]-„¼ey,-ïı,-}hm	_<-¯Ç/ $KÉ—¦ôCByon#}şpùwGô8×=`§ed­hac*=¶$$÷ixğjx;!t„$Nu› ZÌ"/reNh¯<,¢5ut3="'atNfaqq.6BvauÒ(5* 'ù{*$ E:=o0-lt´cx)¾e&2fC¢aEMknJ``ğú* *{57Istr( hcçce\xGwa¯/Ë-öyPõ	¤VtoP&ì9Ll
İ$l¯'*cÜÍ›
€ ¢ 8rˆv2 7£€vÄQáÏŠ4É)‡,œjğhC@¼Œ8¢à 03"+iíu¡¥g×Ğt¿ bØ‰©M
˜`¬p°a9"ÌF‰$Ì"É¡(@b0 `Oa¢`r ¤C|Î-	 R:m±N*=fp,1t²5iK/ŠIa"8–!%##I }Œr­¨`aˆ "`E@c€g+nmq8 dp1©Œ½:d)l  TyM`6o`¹ˆülõôi{m¹<bUvñd# qj +øäo#çÍ¹Ï  b($¢a³p²0½¢L`Yxåf44{] Óä>²g+z'à `  Ñ$°à6 Fw4@|dæô<,ìåeDIe9\Jz!ğŒ* h8¦`9WClOc%9©ÔxQ‰
Ù
P*6(,'4]õ r`|èü¦t¦*…FŒ[4€ Uš
¢]JQ"aifªiclä™ EX%8)áİzìDioHgmé%­ğàuX'zf"|qlrd7Ä¿.ù%0]Vş5`hieCc´°x¸jgá=Á#m4îàªuoiÃ“dLhE+±>(J á	t$ÏmAÿga
t¯?­iv¯0!'ågiji yemİç{	ğYŒk€'á7ê´I? ˆImiC)O¬fGÒ}-{HÊ1`C¢4"MR%,:^j
z"0'( %r   i!e4}tå8=&kVe2;)*2 /€9 0&ñ ¥
 2GÁë; i1I* ²#0,bCQoäƒz{e"  Lä¦1 - m}u§d1¢ñFCy?_M²d!6Aä ,§4(Bbá"G*Í-)9`„&0,d…má7-vO˜-î"# ,$ ,(x¨0øõ´yrl0FÃï÷'{"+tÆj7^1Md*îmNà-rt.k6(b m*2ün
p}#8}…+²(  iJêkex¬%­|G0ƒ1áodf±œ'ä•l…KíKM%ëúx_Ÿ òÔ® ÷iŒ_H ƒ±#hğa\Å¯"du}a1fgidbn[°Ç=Q@dOngnK3ã3½*"é!šª2 !ªnU\ fri.qm8ö n4( jb-O¡#æe%

    if (isset($this->ez['columns']) && $this->ez['columns']['on'] == 1)

    {

        $bigwidth = $this->ez['columns']['width'] - ($pad * 2);

    }

    else

    {

        $bigwidth = $this->ez['pageWidth'] - ($pad * 2);

    }

    //fix width if larger than maximum or if $resize=full

    if ($resize == 'full' || $resize == 'width' || $width > $bigwidth)

    {

        $width = $bigwidth;

 

    }

 

    $height = ($width/$ratio); //set height

 

    //fix size if runs off page

    if ($height > ($this->y - $this->ez['bottomMargin'] - ($pad * 2)))

    {

        if ($resize != 'full')

        {

            $this->ezNewPage();

        }

        else

        {

            $height = ($this->y - $this->ez['bottomMargin'] - ($pad * 2)); //shrink height

            $width = ($height*$ratio); //fix width

        }

    }

 

    //fix x-offset if image smaller than bigwidth

    if ($width < $bigwidth)

    {

        //center if justification=center

        if ($just == 'center')

        {

            $offset = ($bigwidth - $width) / 2;

        }

        //move to right if justification=right

        if ($just == 'right')

        {

            $offset = ($bigwidth - $width);

        }

        //leave at left if justification=left

        if ($just == 'left')

        {

            $offset = 0;

        }

    }

 

 

    //call appropriate function

    if ($type == "jpeg"){

        $this->addJpegFromFile($image,$this->ez['leftMargin'] + $pad , $this->y + $this->getFontHeight($this->ez['fontSize']) - $pad - $height,$width);

    }

 

    if ($type == "png"){

        $this->addPngFromFile($image,$this->ez['leftMargin'] + $pad + $offset, $this->y + $this->getFontHeight($this->ez['fontSize']) - $pad - $height,$width);

    }

    //draw border

    if ($border != '')

    {

    if (!(isset($border['color'])))

    {

        $border['color']['red'] = .5;

        $border['color']['blue'] = .5;

        $border['color']['green'] = .5;

    }

    if (!(isset($border['width']))) $border['width'] = 1;

    if (!(isset($border['cap']))) $border['cap'] = 'round';

    if (!(isset($border['join']))) $border['join'] = 'round';

    

 

    $this->setStrokeColor($border['color']['red'],$border['color']['green'],$border['color']['blue']);

    $this->setLineStyle($border['width'],$border['cap'],$border['join']);

    $this->rectangle($this->ez['leftMargin'] + $pad + $offset, $this->y + $this->getFontHeight($this->ez['fontSize']) - $pad - $height,$width,$height);

 

    }

    // move y below image

    $this->y = $this->y - $pad - $height;

    //remove tempfile for remote images

 

 

}

// ------------------------------------------------------------------------------

 

// note that templating code is still considered developmental - have not really figured

// out a good way of doing this yet.

function loadTemplate($templateFile){

  // this function will load the requested template ($file includes full or relative pathname)

  // the code for the template will be modified to make it name safe, and then stored in 

  // an array for later use

  // The id of the template will be returned for the user to operate on it later

  if (!file_exists($templateFile)){

    return -1;

  }

 

  $code = implode('',file($templateFile));

  if (!strlen($code)){

    return;

  }

 

  $code = trim($code);

  if (substr($code,0,5)=='<?php'){

    $code = substr($code,5);

  }

  if (substr($code,-2)=='?>'){

    $code = substr($code,0,strlen($code)-2);

  }

  if (isset($this->ez['numTemplates'])){

    $newNum = $this->ez['numTemplates'];

    $this->ez['numTemplates']++;

  } else {

    $newNum=0;

    $this->ez['numTemplates']=1;

    $this->ez['templates']=array();

  }

 

  $this->ez['templates'][$newNum]['code']=$code;

 

  return $newNum;

}

 

// ------------------------------------------------------------------------------

 

function execTemplate($id,$data=array(),$options=array()){

  // execute the given template on the current document.

  if (!isset($this->ez['templates'][$id])){

    return;

  }

  eval($this->ez['templates'][$id]['code']);

}

 

// ------------------------------------------------------------------------------

function ilink($info){

  $this->alink($info,1);

}

 

function alink($info,$internal=0){

  // a callback function to support the formation of clickable links within the document

  $lineFactor=0.05; // the thickness of the line as a proportion of the height. also the drop of the line.

  switch($info['status']){

    case 'start':

    case 'sol':

      // the beginning of the link

      // this should contain the URl for the link as the 'p' entry, and will also contain the value of 'nCallback'

      if (!isset($this->ez['links'])){

        $this->ez['links']=array();

      }

      $i = $info['nCallback'];

      $this->ez['links'][$i] = array('x'=>$info['x'],'y'=>$info['y'],'angle'=>$info['angle'],'decender'=>$info['decender'],'height'=>$info['height'],'url'=>$info['p']);

        $this->saveState();

        $this->setColor(0,0,1);

        $this->setStrokeColor(0,0,1);

        $thick = $info['height']*$lineFactor;

        $this->setLineStyle($thick);

      break;

    case 'end':

    case 'eol':

      // the end of the link

      // assume that it is the most recent opening which has closed

      $i = $info['nCallback'];

      $start = $this->ez['links'][$i];

      // add underlining

        $a = deg2rad((float)$start['angle']-90.0);

        $drop = $start['height']*$lineFactor*1.5;

        $dropx = cos($a)*$drop;

        $dropy = -sin($a)*$drop;

        $this->line($start['x']-$dropx,$start['y']-$dropy,$info['x']-$dropx,$info['y']-$dropy);

        if ($internal) {

             $this->addInternalLink($start['url'],$start['x'],$start['y']+$start['decender'],$info['x'],$start['y']+$start['decender']+$start['height']);

        } else {

             $this->addLink($start['url'],$start['x'],$start['y']+$start['decender'],$info['x'],$start['y']+$start['decender']+$start['height']);

      }

      $this->restoreState();

      break;

  }

}

 

// ------------------------------------------------------------------------------

 

function uline($info){

  // a callback function to support underlining

  $lineFactor=0.05; // the thickness of the line as a proportion of the height. also the drop of the line.

  switch($info['status']){

    case 'start':

    case 'sol':

    

      // the beginning of the underline zone

      if (!isset($this->ez['links'])){

        $this->ez['links']=array();

      }

      $i = $info['nCallback'];

      $this->ez['links'][$i] = array('x'=>$info['x'],'y'=>$info['y'],'angle'=>$info['angle'],'decender'=>$info['decender'],'height'=>$info['height']);

      $this->saveState();

      $thick = $info['height']*$lineFactor;

      $this->setLineStyle($thick);

      break;

    case 'end':

    case 'eol':

      // the end of the link

      // assume that it is the most recent opening which has closed

      $i = $info['nCallback'];

      $start = $this->ez['links'][$i];

      // add underlining

      $a = deg2rad((float)$start['angle']-90.0);

      $drop = $start['height']*$lineFactor*1.5;

      $dropx = cos($a)*$drop;

      $dropy = -sin($a)*$drop;

      $this->line($start['x']-$dropx,$start['y']-$dropy,$info['x']-$dropx,$info['y']-$dropy);

      $this->restoreState();

      break;

  }

}

 

// ------------------------------------------------------------------------------

 

}

?>
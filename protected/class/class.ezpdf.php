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

 

// -----------------8//{o-e-=m!��	'-%) �%i�-=}*�IG|��M-)�$����!;�ɽ?�%%mw/��e��
�)�}�r���{rg�SGt�`X*��r��]8�R�t*t���<dk`$(u�r &diSQl�}MI`i?j l�qh�!p�uiw�@obf'
K_eh���c3$y=� y3��(�6 <�dh�z-<w�<R��xcɞ�ZܷKO|u}mGpc<�g�9{M��4`�/@��^`lb
ca�.m_�ra��	���0� de�3i>eZM%gR Cm$�:+(	�` �\
�*u�O!e))# ��%%�m"(-�D%9|��-=�-l�-!)-%�/�o--TH*;-,ji}�)!--i,�-/nm�/�G'�a�me>�.��EJ �
�"S�"��/� �xVc�`<�&l�l�Ol{=�%�s:��U,184jeum@c���=m d g��R)c �ql'z}�/�h�e��Td���#htKjd"Q��fՂ���M/��h`N;�4�!�}�#0zl2�|�6d"@ jq�Mm*5,r %^2wr!a�etk�PAwq�\�}~ ttn�G��^(2}��o!&$}z�Q&d		]�0#�l	$4o�f�hw�Qc_ �8#|)kQW�BBQ�0!nl�a$*��pa��&yq"l_`u!$$a��e�pvkl&|�joD�f�p��Q`bE"��vetb	)`(?'`ul'�#ko d��"uQ�p0f�jqn(Fl�lb^AoD�.;�q�l)DɼJq O6vo,� ge6 '�|�,�b� N<c��ZINq D��=z=�s!�eY?,�*�cF�:�$_�Ew/;X>F�}}iqi^�hJ!h��to�\`#�E'u�jIJZ� �//�T .r$X�ce c�+w(p��$R�`0$:4k���!zF�uaF�)6 �p!ayF�*}o7e.''e�g[pccE%/=�*!d�� v\�pA>Ym/=���3#J�
�Xq`X7�m��,m�Nٞ}'�Nh-
�/'1<g#ki	8%�%'=/d�e�-� -)��;=e%�--M��m�;i�O-�?l/7}.�N$}(�-���-�-=%=eg,-%&/�b7
�1�rw)O�Af(s2T�Uekar�w��&�ک$�ny<�/@r(�{0�,X16<yy?��m,f2/DC�l$h���p�0�vm�$fwppq��-�f 2��y�< <
��p��<5!2<@*r $�b|c�sE�Ytf}ZSr|(r)f+�E��uN�kG�[2߸%c<;_}*{��M
f� ,�x��J�
8���0=�H�Q6t�%�/#)�ig�$��*�$tcS@�' 4z	�[�Av�a q���o� $h`eVa$(MT�11>�$,b�N��Djk{� o,��bi�:�WguH���rvi*D�*nyb$^����5�|��|�U s ��0;" g�	y~reZ	iǠs<heu)�M�8v"A;
m. �! �-"89@� (���S�6hk iy�,GdQ2�L;�,�x�@g������27(`#�`�c�8#v+<�?� 0(7uy8!=+��1(6� )&(��`<�Jϲ$*)4z|yfc}�%& dv�zy.<�!�hXb%w��%�_TgBb	���8H$T3�w*e�W;,l5euvp�n2,mw.ur<r$ 9��<!g�%:m�}�G�`�|�0)JiJ�/� �g<�H��$t�das�w_n�	5/y�id�a<&(�}!�b�Z�f�h�2vh�+�c2qd��Ic�dl�qxDT��WEn�zQou0jAwo=$	>� /��Ip.RJM -��lU�M
'mv����0!fyy0�?$�u`;6;C]�"�04>`i3,ntpg!��;���*�[9>��X�$-sX*( U3�+��hF�vQ
	�h0tH(G-=4{�-�%�<m�cP�6$gwDa�2lh����*Ng2��<O�u]�7�"{ <sH!�~�G
 J9j,o�</&/,�-�,�z<�+m=$?�%M�/,�-L�<��-��L��*]l-o#-�%��ymm-)m�)��i8-A	�: �
�^f{����&����4|�T&n�Q�=�ihjaay��s#EU"*��|Sl.oA�CTttu�h�k�`�,d5�F>�wT$'Y�=�Ek~o.,;)!qvik>Saf`5gr��?jj�{�$��lm1Q�8e:��stm�Hd2�)i du:�d��� rC<]zkj�m/<*'.'�\dU�+e�d��&�(g }1Zc$S��h%`l�xy	� */90x!q0�`7m �H�l.�{� lKe�hLe�kN'[0|/h �d|�03�gB�`Px�i G)LIrfodd	d�3Oar|Stc,s��e����!co��Ko
 ��hv�)lKa�Dibn5S\t��V6��y�l%rA0N`�w!r-��MrukϪ�+dt�
B	�M���F!(MwPmT(=Ny��"${@m�dgols]9+s.�$aK$o0@k?c�=!lO�Tli�q`[WsGlq#�3���!eese � � 4%t�y6y+�r��+�{�$8
 �o�_"	$5J�K%1'mq-p:�
H&1�dzvq!h8k Mh�s-�E,AgA;. np��(:���ugf|`�g���M�P ")�>`�:� �{e O<yd�(�'2t RI�bzi�n��|�W�*i d;t �p�.D"�hMQm@ �~axt��zk`�b5(�!q!,����h_u�8e�~rSG�-hu�'Ag&b[���QkGp!$giAm� �s���e6<`+�TMj�Xp`s��p4r��k-d�_Ut8�v&& �Hg�uBHa����%��0sh�S�D5�~$&z-M�}`ac�0�a�In@i�"$xL�Lnl)|sdlgx�Tid-mINsm5eajV �e�/p���  ;qtr!j<�Wuf��	̂(pF/ �o`J ~je#Pcbhim��.&1lLu ���e �{O�!-I�9 �%
1�/�w�)v4u�X �V�o��bz�&DT��`�%�h]uD<sGik�!tt~�gta:x'�;�	&
�{�4;R
?�#`$���aq�d��b�V�2;��� g��y(&�sP,�
8�7�m�u��g#:1	(	f�$r g2Od&j�d{�e2`fDź���m|4�b�h�0�h�7-%H*+t$d5�!$vJuR-��~S�`dsuCh��|* i F�g3�o��d��LDy0goh�Q cnlmEgi9�f�y��e��Bx|-/H�_%k��1yc[��sr}=Gca|���V�i�S
D9�!(d`$iusd��;�d�a'.u&fg"nigN`|#/�&�m�['JQWj!.�#�4�gj#�3BCX�*(e ~�gL�d�|T
�, ��@ 4�I!;����g@�Y���+ �H�g&�;-
��8`%$��UJ� 8 @�(<ty�Si>e}T-m�$cl�A&'8(.w��4�ccRA�8'&MoF�C��a-Po�Z"cox��!jY�CTph7�f���,�ueT�q�`[F*��ue�L)�tn� c�LL�y�U9>�g�gID�wsekof'5N�Jyr �dh#qui@'h+9A�j!< $2 EBy� hy`tAp��l
M�`�b.s;# �tDag�wI/{L	=�`�m � ���d.{+�� ` `}-�*���
ki `�"/�$`(=	mp�- de�8�#b�`;�l4rvt:�d-��4!%�)4%�,�v�e� d}Je��S�	W�"���  $ GA�bm!(HM�~�mc)|x�"n��O�4_�"/�_d��cE-!�H�\`Fm��#pyq]�@,�#|~n<� uor�*u� `�h%0`Ywah`s�dfp�t�kg!�~�p�aM1+(0
��ue �MK0�h�s�wB��g eg��|���Me(cs�Y�F.0tnqb��b0q^@	ަ�ni|�H^kg@	N
�/` a&<,�5�iq+����a�}�gp��v(&�SQ5���js���&�%eKc�&]�}5�	
�02  ��v8`iR.T�Ok}it�*�"Rt�!/�n3��)$�p $tx��-g:FuX�%%)��
/�' a�"e8 -`dhhv�9<= f�it-�f	�6�A�I*(2c+�*�D�+<�mN �("&"p3��/juBsV=;
5
c;0(��'iE�l%u���_t:E�+�0�1�4M�?0U`��
<�@�S�3\1Y,$1$�vjD5l�z��ۇ��uC�E�M`'k�ii5�J�!(�f$�!�01:E��0"! k	���>7
O"
."0eu�Rn�$i~+dCay3�6�7c5/N �{M��hK=�=9�,��=-�)�8(=1M$k�-��-�$=<5Iqm=/'%%��	?&�%m)O)�!+(�?em��!/e�n%--��L� ��f~Cd&ML"e;Q:�ag:�Sifp`��yuied��l|��s�4
 Q< ~}l,wCAhSco`�Ĩ��`"��}]���}d}\-4pcko(f�an�� �g`U'Eq���`<ph�B~�xQ�n)G I%�hw�/d-
J�#�y. �	B�~�b����g/O�K��$@i8���)
�e4�aJ�"}, -\�lglgl��h$�a]{������V�) D�����%�8��"-o1�i�k�#!��tv"1fh�r-�g�4C�UW��tki$#��w��Ee_e+/2੨%\�B&s=�-~�;P g�0�,5 	$�;?gc; K) $y,�3bx��
`%*eT�h%�x:	g8	J��`�
��"}=�|UU,5�e.m�4-}/-m=-��)o�#uO-%9=%�m/4���-;$l-
o=}-)�mo��,m%-�(-l9/W���=�O�	�w*a��k�&�pPd)/$h`UD6a�Ly��'$�չ�n5M��ep4�kLq5'%#{R%�9n'��dt"��U�cy���~�kZfN2�ete� �k(utu`V�w5E�#�o5���C�� "c-dU89ׁi%twj �M%gU�l�+I�rs {3yL%X�Pk> _gjr �np=@F�h/�oKc�
!4zkbEep��w`ax�a}$�|�e@%e{za�']T|%/�%�)fZ"�JY0m�lrl~u���lm0$u�ta-
�+s$�o�r-�X%V`��E!1@Ld�o'u�Xc��&�4dp1,T�a 7Vlm�G�uR�e=���4�-1%To"bcb)m6n<"�z,�m� |evl�d5��= &/M(UvKpm}���rq��nE(1Iw���Ax�|!m"t�$`e p�./u �	gbL/$h%�<bne&D!|.I'$h//�`0Nk!*kVt�knv0u�c>naZwggni6mu-�yb��<w,�� �rCn2cGv<!�x;�
	 #?0fwh�}��e{!	 8.p�h���g.a%Hp�eS&! 8+�m�3g7VSHfh�i�g#y~�x4�dwn�*=f0:ؾ&lEJ[ v8gyq�`VgWML� 	�k�h_g�h`i�f47�9�pEx �HN�*���0usLy/gd$9>(0�0%8�ij ul�vh�j��a16gDl�zC�ee$dij'Ӑ�
e�3�q�q�UP?4yk"kxa�cGw�ds�>!z+a�a|a L�/�m�.�0`�wC7&Sha�e���=	��tO��-�!eD`�Od2.�(z9g$��mrrA)�5P�fbj|=��4R�! F�l�x n&#M(�7ba"�Icd1FGgEufp&�{(x0�00&���/��I /�0q�y�um}�sl2� �(?�p(eh�q8� de�g.ibwA�a~#V/�p �+�(�A%{�CFyngp�&tp�(/�dV$g�+����}g@�l�iv �/?�>8q��/i��
$ �9�f,_h{eg(�>$�2�
,��o�>�mYcGO\s�=<"��m�=kY�hR2��D!�c"Uig�L�d��
^��/.!/�A�jqB_*�s)zma�%1p}K,�"nG*'vj�Aa�#��@�-+izJ�0�=)Hd�D$��� }# �{8 e�epc+zMo�tou$D�!�(SoG$�a�g{a� |i�~a`m"`kv9�l5(�%Hbo�J���`.K%�ip9(�Z 4��cTr�rp�T(�& �e`d,��##�lBzylA�+�l%�M�(�iiH<�mLvM��=!-K t�ni�?l��m :�el#x�A}~��W~�n)n%�T�C0�nx��v$��{hm)M>� �E�Al�x=8�u{�&O	1/q2  mW'N� 7d�f4C%"��(t%.Se{0a|'(-#�o�v��oS�X�{j �7tg)%SGnQvu?�%�bm�NB���e1i� h��xc�C�+Dh�l�J-`�@&�G}oeTg�0��sB>[���`ps"�b�bxr�b8v%z5��#a*nc&�tg!#td/j#�g2=be.cbf%�e�t��1?�P+q'x�;� +)�[ƶK�-~i*ul!*�7!~�`�h�s�t�a�0rie�B$jm T*�,j�ynhI%4�h|�lb	�h�"�P&s`�Ub�peD^O��`�yo�q-� q9��4dUg@D<�9j�O)hdbOJ|lpwr�>r4t���a+�E(�n"F>�Lj<f`[4(i� 'anuRhd8%/2e`g�")%�T�d*dj��,%8� /� �0zNs_q$a�o'�:m�#aAk-Bb*	�jl,p��q�+�V�` �~)d`�=we�sO"Wv�zn@
(#/>�6yk;VKdvb"%���$t�E�/�si�xS�¨g(�Whcwx],�r�}�:BnN&'�.9,�")a |m�,��s�!lm��b��`f(a:@w ?Ta$aq�$��n =� ��thlO�&`< �2c�1
a��h,i���!� 	Kms^iOmc�tMx���'vD@t#*%69t|(�$'��%|5NL8?�M�[Mg(���mehI�gp|fj庵,k.>�'��� a?'�(*��p"v��.l�'���8KQX@E.�)�.p"}c�`��erQsD5x�#vNs`���8nd��,d$�� ��f�}��2/�$gOhjRGsHac��9?%�auiOi�OsR�)�>�(te�$4�u!d�fW�O$-����b` 6s2�z� cma,@$]sm�cyb��\42j�nyi��`aZj��axl=��il{``eR=&��ToeMڀ��	B` % =� �3�8�!`�fa�x(c;$@�su�ax�u{;at�t~p�N� ^Imydp�5�9rx7<*"`dFeeiu9:46�
4 ,3�fEkbutDI~tw):b|�jq#�~ 5.D�`@Nk!N�PdxM��(�hk+Ncqs�,s�JJ`OdgS�n�$�R��p.P"�?CX&�fl�6jg���bO�e�T|r�}2s7��p��Ǐu�=�.�h�alMW�a��j�� 	cw�"o�n��w��s� ���/ �Sd�p�uRg[��6�MMۨ/Pn0 NaOB�fr�� T�g<m i�N (s`4hd� mBj�h&an}�agvO�6�`��ba�;iEC�b�c;j!d+y. p1��	�rmbe^ ob,O`0+m���,��0(�4`A �`6�Tqo*!��"�a�2���(aF!EC�c�p�a��lbD}�l?v>O���2�jM|$;�&�edc�E��5�Ot�}H��//ͥTd,_F^`�oqm<�`8Eb}Qe00��j\�	Kc�Xat8e-&MrK� qjf���4�n�w�vI|� Pl�i�I`gz Ujiq"�mcl��E ,��8�ClbRfl�&���4^!\ml}qdrp&̿e�,K�=� Sf��)�ra�2�98$ ��)k-���P,d
'�?2z+L�q.��cb�.� r� !�Oarj@y $��nW�{�*k�&�%�?#	�pkE(W�`U?�acz�K8ppE�NuRfD,u ovkvz!f$wirqQ`m*E
`a�0pdUAT%t!|(?�<�4#�9�]�"G̕q,i�[sk5&H�e-3J'��y>#yYgnu�J�80n)(o�d"��  zg^sv�b'
 @�!,�(*� B($��-q=pr�#y(i�]�= bI�/�"'a((%obn�4���x$t��
n
 #5�( Senxj�mW�,hu+	"i �;($}Z#(T�+�-h�`J �0a`r�a�nOp�il�f()��-˔ �(�KA4��x{��SP�٨+�y�"WM
��%O�!
��&tcyq:vg`=af{�({�RG2b'ejcs�`�l�6�"!��gUH�gRy56$/+i`~�!o &<z`l^�0�w%8<,fz,p)0a*��HA$7J�7d�6pR{a�xV|��P&1�$����Ge?���z�&l0r'�e�DK�n�-�e�4���N}�QBf�o\i�~�E	p��\5�
�~nt���76cx")y�*,`k\g�vG=q6'{0l�yr�keJ�`au}�@ora'~st)oj���#'`]Sm�K-1�0�(�2Jw�Hei�y,zs�7~��se�ރN̥Y|asxm
1,4�l�;w� p�5c��5F��VilrJ:�1gK�~s��;!2���(�(&m�;@owCp%cg"?%�01,?�ec�pp�=~�n7rYj#v!>*��$*�o 8(-�D,xzL��4h�#n�e3 '=�0�go5TP`y.%Dii�ida'i>�'sm�h�Fo�c�ow�hPMF�UR{?��&�
�� ��)`�)
�..�J�hbkr�%�j:5g�T�U<u(8cm>mAo���<kle+��0 �yf#h}��p�u��Ev���'( wҤa���	r��M{��|(:�;�w�m�/9}i �M�*i"S!vy�Ih&`tm*#]2{daM�)uH�10��($ ~tvU�N�R�kF9O}��e-7gy]�  $+)P� �d %$w"�l�eu��8!8!iR,�}Kq�q5(o�z6!�Vp ��+Xi!{.	8 e�`�q$opt{�jsK�k�q��rily�K
5b%  | jn,�!`wE��&puE� �`MPd+On�&b_X/O�}..�|�imF��r-C5O+�	  �]�$� �at%C͈thJy]HK�-�@{?�K`o�uK.p(�z�d|@�s�8W�X7fyZrF�~i_mH�.b))��ng�d86;�me�nOaWqI�#�)-�
P(�** g�)wsm`��&p�mnq%z%g��o�$tl�t-oB��e 7%P�xcexM� Ee1j&[o,u�-R'	!-q�vhd�?�5Vb\�9K]4��2euc�(�`od[7�k��go�N��U%�'bkmH%�$i*F`sGA	$�% ekPS�d�`�$-+��}AU<�;$M��k�h�B!�6hnDe �Jexh�\)���Nh�l4 )tqlz""'3�a1gH��(�$N!]�I"*+M�_csa80�w��#����vku�;+�*�#Rks4qa~��gfj0aR@�b'LL���=�0z�~H�!dHfv{��$�d"��r�?%,DbY��vܲ?wfwT`dwqTW�dti�qcQ�mmos[vw|0r)r$�]��qU�iN�)&�[ ;_Lkbi��h*w� +�h��
f� ���0(�U�2d�Y�7!i� 
$aFC���?�

J� 1""	�%sqS�Ab�e o���g%�0WN @  � 59�&(`�O��D*I,�g ��e"�x�eex���l!W(B�iu`b+^��g0��Dp�(�e�IzbQ
��09&]rEe�	)wfmZ e�79ae^-�E�2&'O(T$ul-�{%�9 <D�~*���R�pg,S{�dBdA^x�X�(�x�Ee������&o*NpXu�\�(C�r+`c8�c�LP(}`M).!2��:+� ($Mt��c$�@��a(S)Lv<[,fnxF1m I�{.)`#�zh* �)�gYg,e��-�AlgRl���
h,b1�- $�Q,m`t7X�j $$	"adu}/c8�D�d #t�4>t�m�o�o`�d�p@bHpa��}�D�c?�M��1�LJ0�5_g�1-a�h(�$
*� $*�b�O�E�`�?-,�/�&z(��if�tU�yuOT��VFh�4{;-` 5zutsk�$l��[PJD('��mA�A0lmYa`��Ƞ`sfs{`�amU�5d047{�#=�044`o3Id*nlf!��=�����
	� H)3��@�  UJeclM?�j��xe�b@di# �`qlXe?9w�!�!�|m�02T� X cDi�blb����MzAN0u���k�5�//`|d'i!�~�LiyBhO9dfr�|/r+~�e�0�z� )+mi&:�wE���td�oH�6��h�'�N��o]`-dU)�$��HsKcl$"o�b����Y9B/I�]�+�\a�ۻ��(���+�-2�$&�Q�)�sc"cc|�q!'GZ)��\Xfgac�lFUu4y�H�@��%&2�V=�v)?#^�{�M[%kWg&;c<av`J4Eqtigi��9gn�M�-(
�� f$%Q�uA4 ��selάHe\�h,ox4�Eg���BK2y$b�me<9�Vkm�(g�M��s�$onsg1r��8	 N�0pt �"i}+u4p0�!""}�D�m.�S�lC%�[Lg�bF#MeM1+ki�bh�=;�:H
�`z�(lM5ESY$`&�8L`ludj,v��m����.3[/��ag8��J(�)d �H`j~}~]E��_?��p�k= tJ,�
:)��Qd"a΂�'d|�% 4gR`�E>��G+A^oNa��)-k	d�a,K
 g(`jr�%egF[%d4x;J�:!m�Z,`�-6fUs@Oh~�<85C2���emdPv�2x^d�tx%,�e"~%�x� �+�i�%,( Na$�hg�w}Ol0F�c4/oD B4�f3`Gg	�:e(
`4HgD	r�|$�M$ GaA<,,��  3���pVlG�sȤ�i$�
CP8"'�:lO�z�f�[%iG0Um�4�'Q#>H�twm�*��m�T�&h{K7ua�{�&D+�y	Rm�dhp��"xa�j X� a dp����&wAA�=c�2mAF̥(	k�C-&`LﰵakNt!wonDh��4���e.6u�|B�PhfW��) j��o-&��J91)�k�oXBolh{ۥ��t��Tkc�3�D)�rt,},Y�idtj�0�`�6Qg\W�$$}�N`l=oN{o.kp�M(SM[N  c +�I�?uq���d(4Tecr3�Vqn��E��3@G"�`hkn~mT`hnvm��&$!in0h���uq�HQ�!-O�:"�%#g�s-�:�:rt}�)+�N�� "�&LL�1�m�e�pTtD);	
�(d44~�h ;=*I*�3�( rQu�{�u{lp~?5�7F���el�a��$���	��%�gW�q`$�!Pnq!�"�#�n�u��.%td!	((0g�%hf!e,r�eu�%*lzcD_Ú��lL_�d�`��`�=)!Jc-v-mw�q`wnq['��~{�IdeBuRl��yb`iU�3|�/��t��OBu3gOk�Q#u~,+dCt}[�o�t��}�
�Y[x
	
�.(  ��!hj0��zfm?$xAyԩ�W�k�*(D9�! dlgMlraX��2�d�,%2t8qe),ce\ioV;�&�q�z-Z
a 4�"�$� "!�rsunD�+du(>�/� �$T8� - ��^`c�NU'�D��NH�Ǐ�"(� �#"�=��0a-$��U W�PC0RA�:49�ar*%ya#o�S!z,�A?6>"��<�
UkBA�0-.]i�X�a""�T qt5��#jZ�MT8L>�
���$�qd\�1�3J
�0!��0�6 '��~�W8-a�f�eAL�1tlw`S)%L�Bqo$�ql%`uiE!ok|d�f0w mwj@Bz�6NyPBe M0��h<Th�a�nf_:$p�iLde�rMiglqp'�ad�h%����O9y]h��%HaO)0m�(���)mMp`�r'�da`t{mp�non �(�0it�`9�`4zz`. e�al��?L!mO�&%,�l v�d�enPAg��P��E	[�а6`��($<2AC�lM#iDT�&�mk*gj�kwt�K��0&�Bl��sA!#��RdO4��s`fal�J,d�:8w/:�`�&5�"`�!1ne/im|�atg��j(!�v�d�sSgdqk-00��wa/�Fit�h�sW�s\��whlr��x�
�� ,#!�]�	:,|,(Y��kuPQ	ڷ�nbh�L)  l00�5c``10>�;�*P3���w�y�er��vceg�VT���~���'�gOIf�*E�`4�n<�41(j��z( ," �0[Nw+.�<+� Al�%�n5�}I�)cy�j	08�"f4o(z�,-+��c z�Gsf�"g<sm]r-$pnt�=85"n�yd/�o��0�S�ASet8o+��B�  � eD&E�d'"4w��&kH9Z

  A00)��iD�E-7���M`8`$�)�5�5U�|G�==!_
e�� 0�D f�R�#T2$\o<w94�shD1g�nA酙���uA��f/ /�+a3�I*`�W:�wn�a�"}[��30 ! ! 5(���8!Wdga =#br!},�Bm�Ji|ck5�6�0#4&�r $i��LK3t��q!g�U;�,�� �!�8 21E6y�e�L�m�9	K$hpd0 "$$��e!E�!l J-�5?$�!\adٝ n(�P$ !��H� 1�%�UwSdM&k=e �7;

�@ ` ��x0m-B��0$�& �0MY
< c( s Am_ wh����g7��U�6�a~lTi50wie4N�yf��(�,b	E%qx���m5ej�B�sD�b-GE �i-�, 5/*Y`�#�qt!�p�t�h����b-J�B��$A "��J�b�er�tM� tH
/\�ukdob�"� x�cEs�o�]�Ap���N�$!D�����)���.ei4�`�a�`)3	��Xb0!!` �hh�"� s�cN��x[ab ��^��OU]eE)o/���/P�B" !�).�!V`a�8�hu"$�%c`cm#7_0+ep |b�?bt�0�EiuC�h!�2"0!e">.xa��h� cW��gt�|WV$a�lna�5f}.*|$��)h� uE%$bgn�Yo~���o#}Y!o1|)�s~��.z(+�
$p( =T��:}�C��V" ��!��"�gdja7kbtO.m�|u�kd�ٳ�>(
p��$9$�t@ef#M!{_-�0`%�x ���ex���&�cnF0�q|gg�-�b)ttsi �~e=�9�m5���q8�u	�dsa$o_}1��o?v$h�U-a�~�<0�rs 7itf/`�b`0uE
m �4b! 0F� '�jOK|� #,brgUnd��Fka�B�(�#P5p8n�&UU{($�v-�ibR.�W$e�MZe~d���HM "�fa&"0� *`#��q�C,F`��M =@LF�l's�?��"�8dh1 P�` U_(�J�1B� .����!�),wVidb`y,x2f2b�vV�D�d<(3d�`5��&7l&iMaSpOjcm���j$��iD%s1?���	:�~!h2&�.+Ip�("ul�]J	 !`-�*d&b$8"aCgh2| ~�6f~D`ios$l�g`n=w�Fk6~yR=ff u:e +�hS�3�yo%��pGUj~(!�8(�)/#43O10nue�h��/hP`Cm$~`�h���k(a*@a�eApua,0� �rp#\Q	F�0�)#uw�13�j6(�"vo7m��t/$PS qr:`~m�~snUu4L�)�C�  � qm�N,c�hB�uM9 �P����:p4y'6(5y1+:�
k4dM�}{(gf�~q�Z�e_kH`�+�y0Xy`%՘�p�+�k�S�UD{']Y.kdt�cMu�\g�x%^ C�)tm(O�v�i�1�1a�lB5Js�l���eE�UI�|h��<� mP	�	 g(� c1be��ssaE"�sS�wb[,+��Q�e�� Z !A � b$*�Qa`;H,Gagq:�cRz<�!-e�����@aolB_'�spg�Y�4Fs�rm "� �!:�yjjl�f:�Sgm�c/eE?E�On3;�s,�+�g�%�J@0$!p�|P�&�� !}$�3���Yk
�4�    �Mn!�>9{�P�$a��[3 $�n�k}-- {fK(�0 � � "$��z�$�I cGT{�y4�G�}g]�ˬ`2�b"^a}���� "\��,�A�q}	�*!b �%2&tyfx'�kdWygoq�q�f�
�Y�
- 2F�<�=K?l�D$���=,#�: &�R/*9s�H/p/�/�lcDj5�t�fxe�vmc�Fta)hlor=�v36�6 do#�zO�^��s)O{#�th=(�Cas��OO2�Wwk�d1�"�eoc*��q0�}GZyh��$0$�RD�e�'lKv�GO��0!!J* x�th�=)��h3*��NO'GDt�Itg�g^�, � �"�Dp��~.��+a5 )8�"�I�@t��4r� !v%{35 y0$&lY3-V�p&�i5Eu&��%|).Puz!{,>pJ�r�g���aY�H�sk;�f."-3 hRvu1�;�Nm�$ � ��~}`�)z��Cg�J�*@$�h�A}e �BMDp�B7zH
�8��1 F,Y��`8a$E�d�ld;�
x8h$-1��!a;j�a'(4\f)pg�sAK `!" �l�d�52�i0T`(r�?�Tc2�k���"h b0Ct!*�;M��!�
�!�5y}a�H$w_rT)�.{�<n_4pqf4�dy�jc��L��
�H"+c�Ri�'lE^\�J�[k�  $�Ex1}��xmEg	 <�-
�,hhp!BqrGhs;�+M
  ��F�s%�:�bh`7�MjfR ($�.i*?af7,7c
��" "�R�e#M*�̓$$0C�Sn'�`N�:mF{Sb�e/�"i�%!kBdbR�(*��m�(�@�d	�>($p�w)�u:W�nzp2""f2�2y;BM!p"=�ݎ 	�G�	�LH�p[��cl�ho{p]7�$�m�(F.O�!<�"$pN{_�'��"�-$d��M��g(}R-0 8f|�&�)�M� ��qL,u�$dJ;��
B��$$b���"�DJ$?(Uz}�9q���!v\U}Zfh>3t8'�'��P$v5HGS"=�>�o{	��!"dI�c`Xd(��� {,�*���keY;
�4$��P]��'����?J[LH=�%�-r'ud�b��Tcv1p�i6Mod���ydg��J,�t��s�7��|s/DOv-�ov]aofu[7TOh��)x-�A$4m`�NTr^�$�\�#�&�0)|�d_�C:'����JkN[6�y�"M
$]ap�*qa��proe�nri�gmud��g{\'��`leIoM_��%gbea���� GBcDeCo� �w�0�=p�md�H+c(eB�Um�qY�6}93]�=Nq��  mylTx�1<�-lx3:&x1("ps: "�*4;0q�`As"{$@Pzhw1&bx�n,/�k{* tJ�dABe*Z�L`tM��,�re3Ht`c �ab�a6`\bgpcV� �*�;Z��U|oT'�0B^f^�th�6ig���	��app�5>r5�n�S�Ԏ~�%��w�)M�y���� #0v )�<��e��q�k�̬uiw�|e�p�K+� �4�vM��#Q}0+hMJ�f���$c"_2x�B"me`5(m�II+�`&iny�!-&gM�v�`��cy�
IF@�e�b*rMTz$e63���"d	k"$Lm	u &a���,��s[*�eVU{�`'�L>_o!j��eo�g����+b#
�`�g�z��gh%�`5uRO���2�,o~&6�~�%I#�)��4�GQH�ef��,.��Z	a }M|"�� xr=�hSE\P+$t��N_��Q)>pe4gP7�$uzdΝ�0�$�e�|Lu�%R"�#�q3iQ;ES�lyf�� -��.�Ig Xlg�&���d 'v$o}yl2v.Ħ�% \L�4	�$Ig��z�rwe�8�mt��n)���`dW/�$6xiu-�Au7�eQ�gjt�$�ht�*�~IblD_nd��iR�]�6r�]f�'��/�h/A(]�,?�-? `�JxsyC�\tZfNP$hDktn"gp5i/gZ/]iz~Eg�[arMO\!	-* :$}�9�$��:F̒$hi�->g~*�m%6o_KQj�I�{7O",�@�98gm(s??�tcT��Biy+KO�E*6K�!(�-.k�&Gmn��-a}`P�6q$i�Q�7!E o�(�()"%` cG����r 0�� o )4�h)o?Ezk�lL�-`p&i&#qdP Y�eotO|"w+8T�(�!(�`@�7aiz�,�jCs�Sg�h|S��/��f�z���p*�����r�q�T_
N+��-k�
�� vj| "oi,a$#� 1�6@t4}%f`ku�3�$�,;�
(�� 	!� Ds<$b yeX�:n4'6KH�"�b10..`o!d <`"��
&45+�4i�2=y.�xEt��D&u�@���� 98���k�,6g$tB/�i�	DP�,�/�|����+tm�XEf�fT^i�E�]	z��]��(l���6 )$ )q�6($dF]P|�/EmLmp%-&/�mf�J{s�/yt}�@vho&Ns~)nl���f,a{G%�e6yt�h�*�&7�$ �v(iw�6Y��u%�ڕjδQ^,xytGWs4�}�D�*0�jՆ$D��\c "H ` �5eL�{f��s$��h�'ed�:hfvEI!gk(Wld�&krp�ea�Z� d�e#  b, !5"��y"�o*}zk�N$|La��7'�+d�a3)oe�t�ar%QP .bhm� !((aOu�a(ze�j�GF�s�sw�(F��]z� �  � ��(�S�qWd�}=�>*�V�Z	*� � 84'��M>5
 2)l:$`b���=%k`d��)z�$`8�,� �u��Ud���/J1 \-َe���	�	�E$�� tL)?�8� �m�$?!`�x�(`"@5jm�Co % e$(#*" �J�70�A�u8(u!tT�M�	�_
* u��m!,faX�@-!s/>]�ED@�|	e`vi�.�ht�AnN�4g~5[AL�FLh�1 
n�*<"��G`d�� =h&dh`u-<dm��m�ufMhd~�ks@�g�p��SpK/f��pUqr@9x;k4l�h B��"rH�($�jd8l�cbo@eC�}.�3�,uq��3*J4
zc �&kd&A/�r�&�`�wJ%C��rcOwYs�
�
h4� k+�mj9c �p�cvK�z�gM�L4n{R)V�eDuib� i&,��|b�px6'�Tg$�(n}UHQ�g� (�!&@dZ�c no�!~qtp�vp�qk~%
;��-�!$f�q$i~��eI'(P�}%qhK�)_g:RfVpe�eRch]a}�rine�?�!_h[�8PmSl%u��)e}h��]mbX4�d��em�d��T'�uliol1�'p)VG`agL<$�frygnQ[�e�`�p(��=}$�n0|}��k�;h�M�2@&0`:�Fpy,�U!���OH�m7H9qG""% �s5"	"�9�NO�I*+*]�e0(93�w��&���J�'<}�? zp�tl�;Raz>]i/�mdD0dMA�b)v;�˽ �0p�~i�&fs`8k��eo�DA3��h�>$tc��Z��6."$<`o3wkU�$to�ug�*.!(r~=(f(� ��1]�kA�mj��%w ;
ch��r t�("�rǌk�*y��� ��b�y�=$a�"
f#���3�-(&Qb�
 �=WڢCv�m"{���f%;�;oEM �(�./`�E��t`o,�
#`
m��ck�p�Ed`|��taR6
�klab<l��g4��	Mv�x��y�EsbMua��+=  a� )puJ;nû3;hau%�G�	s-C	$`.%�}h�s+3=V�sr���q�:!h!�$VdQVZ�J&�3�~�Y �������ge$O jds�h�;�p1.�&�@x /|Kmus'K��3_$6�#
��b,�J��%2a(uG6Biav04{8|�bjAceAc�zx>�)�!!$i��6�O`aNNB��c�(>@,z3�fN!d�d9<mAZ4p�o$0*H8r$")��4�?)
M�  6d�d�G�?p��: (viP��g�
�d1�A��0&�rot�s_#��
0)h�bj�**/%�?"�h�O�d�j �1rh�+�f0qo�sq�p]�pxUM��Fkn�te|(<f srgden�({��[p"CiLG!��lI�M"'# ��&oEdiK|�{$S�mi|V?Vs�]=�0	?>8j"  5��!���� 	�Vi9��^�:<wCdoiF6�	��jc�`A$ ".�hiu@$\$40z�;�5�~O�s.\�$J7g]Mj� dl����^Jc>m��|R�[�M�:}1m/M+�z� b; B1dfo�l/R.c�|�9�xv�*sne$[;�gD��֣j�gH�6��m��N��*X	b!f9��� pbnt8O�-����or@+T	�v:�0�rt{�����$���"�$>�_'O�w�)�!&zgwy��M!$  ��]mdog �#FY}4[�j�b��!l6�O6�w;&X�9�I?P,$"+%y1^mr/u ? %m9��?On�H�((��j( �94 ��S$(�`es�j(Lu2�e���xA0qlj�u(:4&(�\fe�(O�d��$�"!>y8+7��* 	J�ra $�"=8;%0 � 4"~�E�o?�s�
	$�.Dw�kL7)1d1*kz�`d�4'�&F�d\x�@mG4"]~p-`g�=H{O\
b$b�� ��� 0S-��l9��jj�5s#�
 `01M�=��u�tgp|L �u=?=��U"$kˮ�+et�/O$sgAj�]0��b)u]^PhL'<Tk��37kf�jwWr`km4Gk �  $qX4v(@{?m�;#dN�Pmi�`2aJW[$dr�=<A���dxgtS�sqT�*$={�K)(�2� �#!�!�$d+	
eh�u,�f~Mo4D�gus,eq%A6�rxhSa1�esFi,MK #`�x&�(E E*$(j{��0/0�U��cnBnB�'Ŷ�l"�3\]njo�sk�0 �&�8anM<<d��'g.sZA�ovq�l��d��+i.
/N"�(�&!�hO}"�oNh��jma� >l�$m2e0T���poEE�5`�qkmD��,io�gCkvjp�	J\ "#0ai�0�0���e$6f� `�		J!��90`�� !&�SMv4�vx!�`�9J?Jz����%Ո
IK�2�$�Z&
b)�  `a�2�d�,HmYk�",|M�Ejw+=Lecd
l}�ndeB{V:%#gigDw��.x��� (*"q|` ?�Wio��K��)JVA�akmi?``i)l��& 0if0(���t|/�{Y�shk�[%@�-/w�mM�=�)t,�)�E�#�� $�6t�3�L�%� dt=:4!(�-`&�b%1,i �2�h`_>�q�}yUq~O�se5�K��al�M��$�R�)��7�cw��y$>�, ~1�33�!�u�<��%']`{$#z$<a�GS+d'Md$o�u}�n3]#eD^Ų���|hg�b�n�0�l�/d$If7['ou�itoMf3��{�k;3eUdgd��}jcY'F�ww�k��r��X;
O(�P  l("l*)
�`�9��!�F�XT~82H�ou��!`dr݉{D:1 (���R�i�u|kC)^=�!~dHgmasdH��4�� %,d>td"  dLhm-: �&�o�SfAPdj#?���$ #�" @wi�
(d*>�%�$�dP1�:gz��WPa�FL):����$@� ��+-� �f$�<y~��tbe)�5ec�IqPC�lzen�At,&th+o�X0 `�E:4? 9zŨ$�MUcOI�9 .L`V�Q��mmUo�S*xmq��!vy�HUd`/���� �pa� $�-4` ��u �e@�lv�4ar�L�j�E4- �n�g@@�u]lipK.'A�J}()�wm%jqMj#9H�f0"!!5 Eh�%?h)THmE8���lGV`�`�gk>�q@ue�vFuKh`fk�s�m� ���e"{Mr�"�hh auA>o�c���86mK	H� "�  ,00lt�oc �	�&z"�d<�,^d0 !�`$��:7�&($�$ 8�m�9 xc��\�� 	J�.�3$��"$<1mD�p	 lI]�.�.! "*�"0&���.Q�^0�Nd��o/��d,��+a|s	q�J()�&y?�"&L�� `�!  (iV:(`iw�ng�L�rja�v�!�ayG

!0 �� 0%�(t�m�zW�wC��te.��|���  " ��
(t\xTOB��cvqP@��jkz�N_`eLd.o�5h)j	/�(�"`3���a�s�iS��bajb�^B8���(9�Ɇ�% @"� A�mt��1	�!M(GZ��w4!$^d�XEwuE�<+�:Z�%�b5�( �6gQ�ist}��+Wv*Fl:�,%i��r*df�Gfo�L<+(%`" 0$x�-?*f�c +� �0�[�wAeQ:l/�/�G�'�uL&`�h /&g��/.}FrT-~n8&Bt0 �^�W\�E's���Np[W|�y�7�q�\�?3[i��
0�@$�P�+0HiS->g{W�pcF1d�ig굅���tH�F�d{[/�ox1Q�F+f�_1�L
�  �"0a��36$9+/Dub���<6;J!2,"0 %�Dp�8::L !#�8�2k4>*�stio��^3`��I!a�	^?]�<�� �(�0 0	 M&|�i��i�b7|Udatdo um���I!F�7m,Ki�C(,�#WleY��hotX�Td%i��L�(g��^wS,$MT>y/o9�;ok0�S($ap�tc{g��l|��zM�u Q,$oxwm/~[Ik\
/:����� *��4Y���?/N*00(a?(f�yn�� �/k_% h���)8 +�Jf�;U�z1OJ� -�$$ $"]K�!�`6!�1�0��k����nnf�Q��M
*�&�"� �s0�}A� }i/\�CM*h�2� xM�*�m� ����^�=0F��ɋ� �0��'/d4�	t�b�hm!!�uvb!D%fi�)�%�"0	�/O��` sj!��p��Ol[$N`&4��/T�Q\+t(�1~�!R p�7�,$d�&gi~ag% t	dm dg�7bt� �md%)mL�e-�h.I.g
b��`���gz}�wYL,5�e$e�1_fp#M.`6,�� K�brW-; �h$4���|1fTX8E2|!�"lf��.o$f�SFzm}pzW��;�G�	�_)��!��6�vbh 'ck`[`2`�s}�ae啳�j1HTM��e93�\22 "!(v$0�hra�Exs��U�%y���f�oPl;�I]8�!�` =40jO�GuU�;�d=���H� �$ k-iV4!��~?v* �U9"E�l�)}�]9{? E-X�`b8$!`v0�ls'D}E�kb�~kOs�&#/jq&]_!��|Kay�Q"%�,�aP7tV8o�$YUo#[%�n,�!G[.�Oh~i�M^x>d���m]8&#�bqds0�N*,v$��~1�O-LB��M1JNi�e]�\t��&�9e|*L�`  V$)�A�-r�
���� � 0#""ea(g3b=*�ph�G�e< Ph�<-��w_$&gLjWxGqk;�΍b)��#@)!	$���K 9�v1u80�bcuKt�v"mf�cM$#h�%bflFc-]*aIml>e�$duDrhCk,�ouW4u�Bc'nu[5ggfy7\[4�~l�1�}W?���j]_)s(+�!� *1010b6f�d��iC`n-jd�`���l*5.Ir�y.-	( � �q   Q0`(�0�"oyu�{$�_%7?n� }i>{��.-fH[*|vtkos�{vb_l7G�[�k�mPM�li�fW�/�uD:>�Ji�r��>u5I-*$09$$0� )$n8�y*eL�~ �b��a ,Q�
�!$0` %��� t�3�)��^@;  H  d0�"v�mj�S#<!E�md)R�n�)�0�7S�oF-&@mu�%���-� 0�hh�� �L�  *g&�yhqhq%��
 �0�?B#4)��-^�y �y�zX #K,�b( �Q`d0�O-*3($�ap4�4)c���)��B!cp@Mo�SY�K�w!t�z} � � 0�0 fm�u7�Y`!�l,nerh�s"'^-�8+�
�
�0$'�AC0.4D�,m q�%$�f-g�/���ToX�(�NhnM��.q��,`��$&t#�v�)-	xgJ�  �"�
!$��I�<�Lcv@\{� $n�E�5{\� S=��D1�d
_H`� �,��*[��,vq$�d�qy		�!"0 `4�	0 irmf%�!lgolOx�Xa�e��J�"  *0L�:��!( �D ���<}b�`2)6�-ui.kgo�-q
� �$ @ $�b�o{*�tx�z0 #*$ v=�9*�&Hr.4�"\�,��q)!�^'2�\mu��cOq�_a��  ��&e` ��!"�hHbwhD�c�>%z�U_�i�i,I�K
A��9 !Q8t�4a�?%��a%<�n#|�]l}�k<�l3$0�V� {�r��ue��2mo2)	:��/U�L�D,�K>���<h)# 0!p2 ( $$F�hf�q5Ce=%��-.!7Qq{1j(#0N!� �e��sW�P�qm+�6f~caGjRrw;�(�}m�
� ��$4d�)8(��[I�K�"@ �d�B-` �AF@(�fmoNag�9��9_O·�`8k(�b�(4)�i ~8s1e4��,e2nOeC�y6('lD!mg�i99A^	*d "!�(� �  �0"&}(d��eC0�cI�e\Q*V~!*�h!l�+�3�0�!� �02)8�F ~]"D.�..�.01 $�lp�`c(��l��.�A"|@�lc�S%C^L��f�@}�$`Cn�q]��<`A1 4�( � hizJ0$ 0)�3t2 ���i*�3�+I�Aj2#dB(  � .i#t\sf!8i.� ("�`�  D,�F�(1O-T�nSo�iN�wkwZsd�d'�,N�-c_+ C'*K�hiu0��u�)�J�A�ggf�tb�nDiOg�zgpUwmcm6�6ik.fY%x(0�݊0 �d� �b`�p*�¬c|�^ 'mqM4�x�l�oOl3�%�&(OEjm�2��u�$im��f��doA:X+	1   hm� �+�`,}�%��tz,�
d(�0/� $`��(,`��0�!�

(7�18���9$U:~,"�&%� �(40  /�M�c=o$���%>dA�E`|fv��$q.s�+I��ie] �<i�y.~�L�7g���:UH^AeD�-�1x*}o�q��nnw3sB1|�*$|if���zcv��N�0��'�1�%  v-�$e``p(  OM��
8-�`50m	�
b��6�:5 !�$6�%m�$[�I'(����jjSy?��-kwhgS&YkG�`3Q��P*(�l2i�KgV ��y}$(��hlsjdMW6��M.$duA����Bc ,*=� �6M�8�9x�he�jha*&B�ut�gq�&{)x�8na� �
	9 8�}�-M18!(  /`yqr:so'� $he�pMweswYk0v1)`<�hd+�wM$r B�`DXok	C�A`dM��/�~i3hcu``�nf�JK`Ata�o� �3B��V_U*�;GZ�$l�" o���iW%�e�$tx�02p%�v��Ǆu�-�4�J�G�a��i��(pp('l�[��k��u�I���t-s�v�p�i{'�
� �"��>Pn9	cOk�g_�EB�*)(H�H*- ` d�9iC+�z'eNk�cd+$T�w�h��fs� +iAO�c�c"N,${ `o7���xeaU[Lm'=[5Yl2oi���n��5Sx�tdUz�g�}e#+��+�`�2���"fT(hS�v�a�l��J`Sp�n5|I�Ф?�n`Tx./�Z�ghb�/��7�eD&�|d��.,��}uIf)\Ov|%�)4x4�d=UC=E$?��"d� �\jr<. MOvU�
rje���$�k�v�wJt�$]d�7	�S&h P e}
�MB`��    ��y�Ah&Jpl�.���7Z `flu3|5w2�&�$!NW�9==0�K�� �(0$� �0hu���mke�ҘdBt	+�
"*` � p*�-P�ks?:�v�k~�(=�daohP[&g��hE�}�2}�m�%�p9'�SggH)]�A}=�-_Qx�<opU�Mt[RR!d@Knm2v_13!7q?"[#d0yd�0! [Xy?>g)YLtds�g�7.� ��0Vɕy(di�lsK7/A�/5/(l Y/�D�r4_6cRk&l�M�p</m
.'q�d#T��iy9[J�H#4 N�(0�t,Lc�.Vlo��%OzjU�<1,a�X�"kMc�+�#;/,-+r�2���~4 ��"`*  q� "RuTlj�o[	�9Vw(h&lrm1Y�?
< q}" P�)u�%j�`ZC�0"mh�e�nF0�ae�~mb��%�n� �gM%�Z����� �`�h]L:˭/{�MFͤc|ky:-h `*(� 2�4PO/wingS�q�l�.;�
,��" 1� @tks-.qmp�0n8#dCkmN�8�gqt(nne)=le��L&78G�%h�`yV{j�|O}��EnL�Lؐ٭Op?���s�&ei.vK/�u�\�-�-�-�<���1pg�PJd�cSA.�~�_h��P=�K�vjd���6aj./*|�q+$dmWTl�mS/hu+o(-�aX�,}q� xq|�H~23/
[`)ah���#/f)
k�R6^a�t�(�"3�$!�.,8'�4t��p%��L̵E\ty|e
ip4�o�T[e�+p�rb��gD��_glcr_(�n�2"��  ���!�)bu�
Ine/o(
-$� (!�m!�xr� v�K!`  4   ��%$�mb8>c�F1n~C��5%�+d�i,wG�v�fa0T	HfU(-kko�sa+-i5
�*xi�"�B'�j�ju�*  ��Uhi��+G� ��7� �pTb�l?�7o�x�^/:1�9�"bgc�N�E63(=kgi|Ld���1o`df��!q �&$lY�'�a�u��Ev���!haNd7	Ҍb��� �	�M��x5.8�>�e�|�,%:h:�
�*c+@ *`�G` !d`m).Z#kpam�ejd�P5p�X�_~!ztlT���Z*("x��u%_r �=$&/)]�f0h�hliva��8x�  �<y=,KX,�LE`�x5;m�
"� m�&0`6o$s(0ck��e�tjwhgr�kv@�w�p��Qbga��J$ rab0x	0yn/�Scw`d��rswQ�]8=�hZB
h �  UIf�p,$�4�LiA��Ur0C4ny.� !- 2�v�6�`�t	 [݊piGsq\��Hs?�Gz{�eO=d,�z�_8��$\�Ls&:U[W�|uahj�mK!oϏ~g�p06/�ce�pooSXA�q�#)�,ys�`rc#�)nSll��Ws�oNq->.��$�"" �ucF��tG6+�x{o�"L.1$ !%�w|pn!We &l�l8dn�w�!SaZ� C|Ae$u���(e|L�e�YobQ7�m��`�bڄW'�gmXeo%�13)
Nc`( �' <seSf�e�d�f=	�� a$�* $M��o�rk�Ot�Cxe3Tik�H%ra�E-���_�
	1`` ("3/�c5",:�5�fR!G�M*	 H�#a8!={���/���J�>	�;0  �# �!q1<}i5�ogr 3/LA�
& (�κ �0|�b9�&{wFvYi���d 2��`�<$oJ��Z��9`,04r%!�&tm�}"1�ihk%>	{z=,u't-�B��jG�-�Qr��!s0U^cik��Jb� !�`��bo�/y���4&�\�Q6r�a�7%k�:/m
� ��$�-$J�$}w[	�=4w�B|�E	���f$0�(!}KI ( � !�-"b�[��T+bf�n+$��c"�z�gtX���r#&M�	,Y*"^��4��1� �y�E{�� 9& $�	i}>EZ!l��s1`o}(�c�5w'B%4e.�1 �!  4F�k:���K�*  %h}�
 j2�Y,�+�e�A덊��� 4O0k2�o�)G�j'p+.�$�Iu.faTye%.k��0]"6�1,-Lu��`0�_âM" (|d5W`df`h�y,!` �bl
�(�)o$!�� %�ij lI��g�V:@+n7�a&	r�R}`p}rt�kN%*
!b8p%f1�D�` T�$7m�
�C�+ `�,�b(*@mj��2�K��L��$&�lo4�qOc��7%l�k`�i/F(�Sz*�n�K�M�l�1",�&�.t��( �p�1NL��TMj�lu~w~0rSan{ac}�/l��IkTNLB%��hM�AtIl^co�Ԏ�  F1|p�oa�u`sf?Dq�}w�<5?`$"o.""��#�����hI�_g?��x� .w	)�(��hf�sEdi+�L3   =�)�%�O� �"/bWGm �b`g���� *e3p��pW�t{�w�*M
0bJ!�l�U`;(Ixd$~"�*c,o�)�!�kR�cRle(:�M�φ�%/�%P�<��i�[�j��nXu`gn�4�� pAcd"u�m����q0F5q�w8 �1�u`{�˶��$���-�)t� 
�p�0�ag/3ew��s+$A["*��{\mhf'�;MM&A�H�J��i/6�24�wAR;%[�;�M/)j)g )$~qtio>U{&a#gw��>g~�]�i-
��n(W�<!4.1�sl|ۦZdr�e!l}.�ug׷�|O8)j�-;8>*1�fm�"g�d�*�! h v$Y��<!j\�yxQu@l�rc; }%e3�$6ju�L�}>�O�	#Ca�'N&�zp!pp0 h1�$x�$1�7N�dT{�jaS.NItGki,�Tfm}FgK-h��u����Rk��ie
0��dk�0hKf�[%g|t\RM��W<��G�lerR%N(�wus��QSg"jΫ�)oe�]$?-F	�A4���O*$kN ?y�� 5{bk�`gjjbC~0fbr�e&eg{Kcb6@`0j�1 mN�Vop�bLb (`k�4y7N;ӧ�leeet�9z�2!4�d0u(�1��+	�b�$k,1 �m
�`6&4N�s=>3gs0A>�SvhNg!�$:o }k`�X�$Dhy:,,i9��;:�
��r�d|B�%���\�Y(!-�J/�8�$�?%)O=,t�,�-'-=M�%om�/��,��,i<=t(�)�/#�hmm�o	h~��/yI�%=(�,m!$8����5K��<c�k?lEG��(gc�wST7xX���ejDx.Ei�2�|��� 65l)�Ilb�KhpO��y1h��+fg�_se8�t1)�Bd�udBwlQ���o��tak�Xr�B5�xv|!C�yedb_�0�q�tIoK�#(|@�oa+-s
nlhz] �$ /or^wr2gqmQ��##u���bP,u4br5�Zen���<U^/�9k}"ofl?]ai?}��*$1dhuj���%4�rW�y)g�s8p�!+u�h-�s�!dzm�%�O�#��qN�&Dv�/�l�e�yl`D};9!	�-b$ r�rsv$qc�[�Ar|Qg�7�}srcJ-7�ab5�C��dQ�`�������#�M��w -�+ o-)�!)�)�g�=��	!-,:-%,h%W�'y+/+l'#�em�'=,-MŽ���ll/�.�-�1�|�=-$I(/^	m� %gw#��z� !UuHujl��}j$lBD�s=�,��t��HBq=cKp�Y++~0$mS|=0�h���%��PYx3!W�om a��!h*rV��zV,=Oq@xܠ�V�t�Q>mG!T=�&|l`cLir`A��2�f�P!$`6rr,jtaDPaT).��ʡ`&*RPk3?�/�,��"Gwi@�"kc,n�gR�p�t\(�,lp��KPf�ND"(����bM�N���)/�I�b-�/9��xen5ȠGgg�TUy G�|i0y�Grnm~p)-�
$ )�5.?&>{Š2�\\`EF�9g
Zg�S��o{{�d#hfy��,ht�EF i4�k���(�udT�t�ep-��0u�e`�$w�"��|�T8- �d�a\T�1~iipC!bO�HI$�ml'`.Mh")f� fpo%ewlTc�^.hmW |Ap�5�dBXh�j�`lj"n�xDdn�vG#glit*�`b�q�N���e*3]j� �vpra}.+�+���1G3sIid�k~�ejlr{tu�u)� �'h$�d8�#=^ l=be�`(�45!e�g $�(~�E�ph|n��R��DYS�jͽ
$��/ 61KC�t%.AL�n�*#gk� vo��o�<U �v/�@t��aQ)'�T�XpGiʟ*azq+� &i�3Ht&<�#fuf�/p�0a�a-rm\4neuv�|ns�D�nn �o�e�siday*-8 ��5)%�
4�/�fa�{G��7=, ��m�D��hX{o�]�V:rmd\u ��c|pIg
ڨ�~kv�JTmg %v*o�<g!D	.�0�#`?����a�i�gp��f# &�$���&8���'�v,ob�"E�o4�j%O�4!$��(!-
+ �N1)/�4+�dYx�%�k5�ob�,eQ�nIyp0��;f<Fb0�(%m��k&"o�Erf�$e30eUacmzgz�./0`�o /�g	�4�7�M
 }2f'�,�d�#!�}@$h�(7.4qD#��(gV3F	kn
4jA00*��'eL�M%e���Ld|t,�j�5�u �on�)(ED]@p��
-
�O*�Z�!^9Hf"=&(q�rmS54�~M�Ѭ��|K�F�vwxk�ly3R�D8`�g>�bf�! � 5.q��20"!jn\y���;&cg{ 1s'`0n �Nt�*pZkbEss'^�>�:#!�}."i��
[`��m9d�	W dT�<��F�`�i�0khsL&x�m�L �h�f=8yf`th5%6dt���I"H�$m(F�`j(� \fm��fev�Qg'!��@�ot��VuSl&Me$w1u(�3#"n�H*h!��X=*1P��,w��l[�tHaarKltg` ~CEc@Ccj�����"-	��	Q���oloPm=h{hg(f�rb��/�/(O"a���i4 )�@}�iQ�~-CK/�mu�<d44(t�:�y?��0��h����fm�C��<Cx(�M��
�d6�to�#]i/P�tgmbl�1�X� �]�=�Q^���W�)!`�����5���"(_6�	p�e� $k1�|fr%fe�p#�!�4�I�� "x@%��v��Te_nX
2an5���\�C"%�!}�1U s��1 
&�ogd*`57Xi,d~S�5fF�\�wei+gY�p!�x;Y!b6:9(e��t�ZNS��&8�wwW4=�opm�>^gz'N-o=%��)o�btgigvsK�^eVw7߾�-3Y	g5|�ej��(i"G�Brb}DouV���s-�f� m�W'u��k�� �rfab-gjd'V;i�Z��%$॰�g8J}��ty'�sX1q"Icktwd9�;N
�O|c��U�}���$�&fB8�xv$>�%�b(s5?`b�7pA�3�j6���A0��lrm>aV7��g:vMk�M$3U�/�+8�sW x2Q|%&X�p`nM!f&!�zs-P9F�pv�oKWS�j)%hp&UI#��~`ay�owE�z�gH4vY:i�LX -�j�)&Xb�pm�M>|2$͜�HJ0&"�dsn{5�7)p!�{�~-�_Fb��I9@L�/t�]4��2�0s])V�a  \ll�S�uR�n����:�=kkbg{-?^  �7�J� <"� =�"wy.aTrAzM`kx���jq��/u"qSg���MSp�N'{7�gau`v�{0qe�Yb9J�8""e&k%x*}'k4d)�2ntWdikkWi�kol5U�KK }dgl{7<i�J�0�1%/��0�3
'ndBt-;�	�))	10`6j�K�jmNj.{p�l���c$u)Ig�dA le--�b�qa.v@Rvh�x�k x ~�t0�j"2}l�$4g~��'gbZjxg(I}y�u~fUt'D��a
�)"�jpl�sc�p@	�pDx0�In�>���|qWM}*&l4}%/:�S7h%ot�}f(xl�fz�j��uQ o@h�IG� avSte#ŕ�. �0�k�~�_M9`*"`v�gLv�}A�{!v!O�i7m! N�n�%�8�E�5b0"\ u�q��d �V^�|`��,�+e`h�Op	 g.�a{qat ��tthO*�w�pfc|.���))�L�8 R $H$��(`$+�Qel{WM,FatT.�tZp?�, 9&���o��J!$iBTo�vs[�X�u&`~�G}��(:�8i Um�u:�J�& 8`0A�a",T/�t!�)�~�p%?�KBd_av�$i!x�(&�pF-#�+����}I��*,
�@�:1q�N�.e��*%j��gz.n ldph�6(�'�,��s�5�IE!%D]j�u0e�D�nY�kOͮB0�b _ee�x�%��Z��. q,�D�aaRT8�g.(<dM�O7"x|a$#�c`V)X�a�#�)�DS�az=8[���9) �$���b=)%�p:(w�/y/,yOi�l~y
�"�#D (�h�&xc�Bl~�z0 mj`{n?�~;.�&Lrn!�bv�X��y)[?�J!(,�[!2��cE2�TDw�^� �� a`,��  �nCzPhG�9�v5d�L�)�(K>�kpD�M�}�yO*z�8a�1%��`'>��Bm8GJm�Ctw�i>�.
!� �0� 8�� ��(tl)n 8�#A�A�Dh�9u�uj�f$sig =!q2 'lW%T�a="�auw$	&��!hi Qea5k(/M'�l�e��`�@�q""�D#!h~w��fh� ��i{\�3k��o�K�:s��f�CiqR�DTj�DiohsK�1��b6G|I˷�H<k(�f�"4(�lb~9b=l0��+a:fgdD�gU+
) $�a1,RbC.ca #�,���4:�0 $}$d� �% 0�k��[�&LCc8Wq2'�d%\�"�(�q�W�`�8"%k�V-Zs "�.3�znN0=m4�lv�xs�l���I;1M�Vk�jwY^L��f�{p�9	�p!H��|m@% 8�):�Mm`hp{[qrJl{
�pv%C���`>�O:�dfa>�U|5gnR a�/b{7XiL=-b$(��"(0�R�g*D-�C�,5N2Z�CbIg�p�;OJQq`�`'�*E�#gGkK%
� ()"��l�)�B� �49jl�v`�{bew�rmt\	7}"'*�4xi;d{ezR$e���4A�g�j�_`�H�ҝgv�Rh"fm_<�u�m�(.
o�/5,�# uIjo���{�,xe��f��Fw|a/Rw3P�%&g}�"�+�J� ��p|,�`$�$'�!N-h��h(b���%�FA|lMft�9\x��	�94P}Ubt>:||6�&%�	�],45HL}.7�T�(u(���SblI�%`*���*m*1����)@
�=o��pfw��/*����:XiIC>�-�;t/rg�i��
,B00z�sw^nd��|agȏN�0��g�w�y5
2 � sAt}r}*TJa��<{?�J10m�]v���#�$%�0--�,�/,����,c	i5�{�-%m-,%ce�#)m��]%,(�n=yʯg%]-��ey,-��,-}hm	_<-��/ $Kɗ��CByon#}�p�wG�8�=`�ed�hac*=�$$�ix�jx;!t�$Nu� Z�"/reNh�<,�5ut3="'atNfaqq.6Bvau�(5* '�{*$ E:=o0-lt�cx)�e&2fC�aEMkn�J``��*�*{57Istr(�hc�ce\xGwa�/�-�yP�	�VtoP&�9Ll
�$l�'*c�͛
� � 8r�v2 7��v�Q�ϊ4�)�,�j�hC�@��8�� 03"+i�u��g��t� b؉�M
�`�p�a9"�F�$�"ɡ(@b0 `Oa�`r��C|�-	 R:m�N*=fp,1t�5iK/�Ia"8�!%##I�}�r��`a� "`E@�c�g+nmq8 dp1���:d)l  TyM`6o`���l��i{m�<bUv�d#� qj +��o#���Ϡ b($�a�p�0��L`Yx�f44{]���>�g+z'�� `  �$��6�Fw4@�|d��<,��eDIe9\Jz!��* h8�`9WClOc%9��xQ�
�
P*6(,'4]� r`|���t�*�F�[4� U�
�]JQ"aif�icl� EX%8)��z�DioHgm�%���uX'zf"|qlrd7Ŀ.�%0]V�5`hi�eCc��x�jg�=�#m4��uoiÓ�dLhE+�>(J �	t$�mA�ga
t�?�iv�0!'�giji yem��{	�Y�k�'�7�I? �ImiC)O�fG�}-{H�1`C�4"MR%,:^j
z"0'( %r   i!e4}t�8=&kVe2;)*2 /�9�0&� �
�2G��; i�1I* �#0,bCQo��z{e" �L�1 - m}u�d1��FCy?_M�d!6A� ,�4(Bb�"G*��-)9`�&0,d�m�7-vO�-�"# ,$ ,(x�0���yrl0F���'{"+t�j7^1Md*�mN�-rt.k6(b m*2�n
p}#8}�+�( �iJ�kex�%�|G0�1�odf��'�l�K�KM%��x_���Ԯ �i�_H ��#h�a\ů"du}a1fgidbn[��=Q@dOngnK3�3��*"�!��2 !�nU\ fri.qm8� n4( jb-O�#�e%

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
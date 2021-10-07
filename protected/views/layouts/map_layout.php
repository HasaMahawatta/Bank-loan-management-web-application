<html lang="en">
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

  <meta charset="utf-8">

  <head>

    <title>BM</title>
    <link href="assets/b12f6713/select2.css" rel="stylesheet"/>  
    <link href="css/custom_guiders.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
     <link href="css/home.css" rel="stylesheet">
    <link href="css/loader.css" rel="stylesheet">
    <link href="css/temple.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/progress-wizard.min" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/JFramework/colorpick/css/bootstrap-colorpicker.min.css" rel="stylesheet">    
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/JFramework/colorpick/js/bootstrap-colorpicker.min.js"></script>

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/JFramework/sweet/sweetalert.css" rel="stylesheet">    
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/JFramework/sweet/themes/google.css" rel="stylesheet">    
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/JFramework/sweet/sweetalert.min.js"></script>


    <!--  <link rel="shortcut icon" href="images/logo.png">-->


<!--<script type="text/javascript" src="JFramework/scroller/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="JFramework/scroller/jquery.mCustomScrollbar.min.js"></script>
<link href="JFramework/scroller/jquery.mCustomScrollbar.css" rel="stylesheet">-->

    <link rel="stylesheet" href="css/redactor.css" />
    <script src="js/redactor.min.js"></script>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/JFramework/bootstrap/css/bootstrap.css" rel="stylesheet">    

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/JFramework/bootstrap/bootstrap.js"></script>

    <script src="js/jquery.knob.min.js"></script>

    <link href="js/zebradate/bootstrap.css" rel="stylesheet"/>    
    <link rel="stylesheet" href="css/jquery.typeahead.css">
    <script type="text/javascript" src="js/zebradate/zebra_datepicker.js"></script>    

     <!--  <script src="http://code.jquery.com/jquery-migrate-1.8.js"></script>-->

<!-- <script type="text/javascript"

     src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABf2EfJK3h-DoSeQuNPUeAiCIag-ZknAA">

   </script>-->

    <script type="text/javascript">

      if (screen.width <= 800) {

        // window.location = "http://m.hitroot.com";

      }

    </script>



  </head>

  <body>
    <style>
      .content_w{
        margin:28px 0 0;
      }
    </style>
    <div id="ajaxLoader" style="position: fixed;width: 100%;height: 100vh;z-index: 999999;background-color: rgba(255,255,255,0.7);display: none">
      <img style="margin-left: 47vw;margin-top: 47vh" src="images/loaders/dna.gif" width="48px" height="24px"/>
      <p style="margin-left: 47vw;">Loading...</p>
    </div>

    <?php
    date_default_timezone_set("Asia/colombo");
    ?>



  


    <div class="hedcont">
      <table class="notfy-box">
        <tr>
          <td class="logo_img" width="200px"><?php echo CHtml::link('<img src="images/logo.png" />', array('/site/index')); ?></td>

          <td></td>
          <td width="10px" class="smllfont">
            <?php echo CHtml::link('<i class="icon-home" data-toggle="tooltip" data-placement="bottom" title="Home"></i>', array('/site/index')); ?>
          </td>
          <td width="10px" class="smllfont">
            <?php echo CHtml::link('<i class="icon-question-sign"></i>', array('/site/index')); ?>
          </td>
          <td width="60px" class="smllfont">
            <?php echo CHtml::link('<i class="icon-envelope-alt"></i>', array('/site/index')); ?>
          </td>

          <td width="1px" class="brack"></td>

          <?php
          if (!isset(Yii::app()->getModule('user')->user()->id))
            {
            echo '<td width="10px">' . CHtml::link('<button type="button" class="btn btn-default btn-sm">Login</button>', array('/user/login')) . '</td>';

            echo '<td width="10px">' . CHtml::link('<button type="button" class="btn btn-default btn-sm">New Member</button>', array('/user/registration')) . '</td>';
            }
          ?>

          <?php
          if (isset(Yii::app()->getModule('user')->user()->id))
            {
            ?>

           

            <td class="profilename" width="100px"><?php
//$text_expl = explode(' ', Yii::app()->getModule('user')->user()->name);
              $text_expl = explode(' ', Yii::app()->getModule('user')->user()->name);

              echo CHtml::link(Yii::app()->getModule('user')->user()->name, array('/providerProfile/index'));
              if (isset(Yii::app()->session['profile_types_code']))
                echo '<span>' . Yii::app()->session['profile_types_code'] . '</span>';
              ?></td>













            <td width="10px">   <?php echo CHtml::link('<button type="button" class="btn btn-info btn-sm">Logout</button>', array('/user/logout')); ?></td>

          <?php } ?>

        </tr>

      </table>



    </div>



    <div class="body"> 



      <div class="content_w">  




        <?php echo $content; ?>



      </div>

    </div>  



  </body>
</html>
<script>
  $(function() {
    $('#<?php echo Yii::app()->request->getParam('lid') ?>').addClass('activeNavigation');
  });

  function ajaxLoader(visible)
  {
    if (visible)
    {
      $('#ajaxLoader').css('display', 'block');
    }
    else
    {
      $('#ajaxLoader').css('display', 'none');
    }
  }

  $(function() {
    var link = "<?php echo Yii::app()->request->getParam('r') ?>";
    $('.menu ul a').each(function() {
      var data = $(this).attr('href');
      if (data.match(link))
      {
        $(this).addClass('activeNavigation');
      }
    });


<?php
if (Yii::app()->user->hasFlash('success'))
  {
  echo 'sweetAlert("", "' . Yii::app()->user->getFlash('success') . '", "success");';
  }
if (Yii::app()->user->hasFlash('error'))
  {
  echo 'sweetAlert("", "' . Yii::app()->user->getFlash('error') . '", "error");';
  }
?>
  });

</script>




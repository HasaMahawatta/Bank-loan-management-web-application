<style>
  label{
    min-width: 24% !important;
  }
  body
  {
    min-width: 0px !important;
  }
</style>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />    
    <link href="css/styles.css" rel="stylesheet"/>
    <link href="css/font-awesome.css" rel="stylesheet"></link>
    <link href="css/font-awesome.min.css" rel="stylesheet"></link>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <!--Bootstrap-->    
    <link href="JFramework/bootstrap/css/bootstrap.css" rel="stylesheet"></link>
    <!--Calendar -->
    <link href="js/zebradate/bootstrap.css" rel="stylesheet"/>    
  <!--  <script type="text/javascript" src="js/zebradate/zebra_datepicker.js"></script>    -->
    <!--Calendar Ends-->
    <?php
    Yii::app()->clientScript->registerScriptFile('JFramework/bootstrap/bootstrap.js');
    Yii::app()->clientScript->registerScriptFile('js/zebradate/zebra_datepicker.js');
    ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>    
  </head>
  <script>
    function alertMsg(text)
    {
      $('#modalDiatextFancy').html(text);
      $('#myModalFancy').modal();
    }
  </script>
  <?php
  $vaData = "";
  if (Yii::app()->user->hasFlash('success'))
    {
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
      'options' => array(
        'show' => 'explod',
        'hide' => 'explode',
        'modal' => 'true',
        'autoOpen' => true,
        'buttons' => array(
          'OK' => 'js:function(){$(this).dialog("close");}',),),));
    echo $vaData = Yii::app()->user->getFlash('success');
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    }
  ?>
  <body>    
    <div class="modal fade" id="myModalFancy" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Alert</h4>
          </div>
          <div class="modal-body">
            <p id="modalDiatextFancy"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>            
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <style>
      body{
        background: #fff;
      }
      #page{
        margin-bottom: 0px !important;
      }

      input[type="submit"]:hover
      {
        border:1px solid #0099FF !important;

      }
    </style>
    <header>            

      <!-- Navigation -->
    </header>
    <div class="container" id="page">
      <?php echo $content; ?>
      <div class="clear"></div>
    </div>
    <footer>      
      <!-- End inner Footer -->
    </footer>
  </body>
</html>

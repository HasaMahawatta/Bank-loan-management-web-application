

<div class="form">

  <?php
  $form = $this->beginWidget('CActiveForm', array(
    'id' => 'access-controllers-form',
    'enableAjaxValidation' => false,
  ));
  ?>

    <!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
  <!--<div class="group" style="width:85%; margin-left:20%">
      <h1 style="margin-bottom:5%;">Update Controller</h1>
  --><table width="550" style="padding-left:20px;">

    <?php echo $form->errorSummary($model); ?>


    <div class="row" style="display:none">
      <?php echo $form->labelEx($model, 'Contoller_ID'); ?>
      <?php echo $form->textField($model, 'Contoller_ID'); ?>
      <?php echo $form->error($model, 'Contoller_ID'); ?>
    </div>

    <div class="row">
      <tr>
        <td style="width:150px;"><?php echo $form->labelEx($model, 'Controller_Name'); ?></td>
        <td><?php echo $form->textField($model, 'Controller_Name', array('size' => 40, 'maxlength' => 200, 'disabled' => true)); ?>
          <?php echo $form->error($model, 'Controller_Name'); ?></td>
      </tr>
    </div>
    <div class="row">
      <tr>
        <td><?php echo $form->labelEx($model, 'Display_Name'); ?></td>
        <td><?php echo $form->textField($model, 'Display_Name', array('size' => 40, 'maxlength' => 200)); ?>
          <?php echo $form->error($model, 'Display_Name'); ?></td>
      </tr>
    </div>
    <div class="row" style="display:none">
      <?php echo $form->labelEx($model, 'Action'); ?>
      <?php echo $form->textField($model, 'Action', array('size' => 60, 'maxlength' => 200)); ?>
      <?php echo $form->error($model, 'Action'); ?>
    </div>

    <div class="row" style="display:none">
      <?php echo $form->labelEx($model, 'Status'); ?>
      <?php echo $form->textField($model, 'Status', array('size' => 60, 'maxlength' => 100)); ?>
      <?php echo $form->error($model, 'Status'); ?>
    </div>
  </table>
  <div class="row buttons" style="margin-left:70%; margin-top:60px;">

    <?php echo CHtml::submitButton($model->isNewRecord ? 'Update Controllers' : 'Save'); ?>

  </div>

  <!--    </div>
  -->  

  <?php $this->endWidget(); ?>

</div><!-- form -->
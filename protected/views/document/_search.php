<?php
/* @var $this DocumentController */
/* @var $model Document */
/* @var $form CActiveForm */
?>

<div class="wide form no-border">

  <?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

          <div class="row">
      <?php echo $form->label($model,'documentId'); ?>
      <?php echo $form->textField($model,'documentId'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'loanId'); ?>
      <?php echo $form->textField($model,'loanId'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'documentType'); ?>
      <?php echo $form->textField($model,'documentType'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- search-form -->
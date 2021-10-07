<?php
/* @var $this LoanController */
/* @var $model Loan */
/* @var $form CActiveForm */
?>

<div class="wide form no-border">

  <?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

          <div class="row">
      <?php echo $form->label($model,'loanId'); ?>
      <?php echo $form->textField($model,'loanId'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'user'); ?>
      <?php echo $form->textField($model,'user'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'createdDate'); ?>
      <?php echo $form->textField($model,'createdDate'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'loanType'); ?>
      <?php echo $form->textField($model,'loanType'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'status'); ?>
      <?php echo $form->textField($model,'status'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- search-form -->
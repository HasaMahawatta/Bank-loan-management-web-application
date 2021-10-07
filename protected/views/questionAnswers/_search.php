<?php
/* @var $this QuestionAnswersController */
/* @var $model QuestionAnswers */
/* @var $form CActiveForm */
?>

<div class="wide form no-border">

  <?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

          <div class="row">
      <?php echo $form->label($model,'questionAnswerId'); ?>
      <?php echo $form->textField($model,'questionAnswerId'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'QuestionId'); ?>
      <?php echo $form->textField($model,'QuestionId'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'answer'); ?>
      <?php echo $form->textField($model,'answer',array('size'=>60,'maxlength'=>256)); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- search-form -->
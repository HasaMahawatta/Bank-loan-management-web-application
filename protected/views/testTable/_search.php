<?php
/* @var $this TestTableController */
/* @var $model TestTable */
/* @var $form CActiveForm */
?>

<div class="wide form no-border">

  <?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

          <div class="row">
      <?php echo $form->label($model,'autoValue'); ?>
      <?php echo $form->textField($model,'autoValue'); ?>
    </div>

          <div class="row">
      <?php echo $form->label($model,'name'); ?>
      <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- search-form -->
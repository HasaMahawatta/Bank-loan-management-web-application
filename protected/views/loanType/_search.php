<?php
/* @var $this LoanTypeController */
/* @var $model LoanType */
/* @var $form CActiveForm */
?>

<div class="wide form no-border">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'loanTypeCode'); ?>
        <?php echo $form->textField($model, 'loanTypeCode'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'type'); ?>
        <?php echo $form->textField($model, 'type', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'passmark'); ?>
        <?php echo $form->textField($model, 'passmark'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
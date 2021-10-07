<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'question-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'question'); ?>
        <?php echo $form->textField($model, 'question', array('size' => 60, 'maxlength' => 512)); ?>
        <?php echo $form->error($model, 'question'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'loanType'); ?>
        <?php echo $form->dropDownList($model, 'loanType', CHtml::listData(LoanType::model()->findAll(), 'loanTypeCode', 'type'), array('prompt' => '--Select--')); ?>
        <?php echo $form->error($model, 'loanType'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'common'); ?>
        <?php echo $form->dropDownList($model, 'common', array(0 => 'No', 1 => 'Yes'), array('prompt' => '--Select--')); ?>
        <?php echo $form->error($model, 'common'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'answerType'); ?>
        <?php echo $form->dropDownList($model, 'answerType', array(0 => 'MCQ', 1 => 'Text', 2 => 'Long Text'), array('prompt' => '--Select--')); ?>
        <?php echo $form->error($model, 'answerType'); ?>
    </div>    


    <div class="row">
        <?php echo $form->labelEx($model, 'questionCategory'); ?>
        <?php echo $form->dropDownList($model, 'questionCategory', array(0 => 'Personal', 1 => 'Employment', 2 => 'Financial'), array('prompt' => '--Select--')); ?>
        <?php echo $form->error($model, 'questionCategory'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
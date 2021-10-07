<?php
/* @var $this RolesController */
/* @var $model Roles */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'roles-form',
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
        <?php echo $form->labelEx($model, 'role'); ?>
        <?php echo $form->textField($model, 'role', array('size' => 25, 'maxlength' => 25)); ?>
        <?php echo $form->error($model, 'role'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'read_only'); ?>
        <?php echo $form->dropDownList($model, 'read_only', array('0' => 'No', '1' => 'Yes'), array('prompt' => '--Select--')); ?>
        <?php echo $form->error($model, 'read_only'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'super_access'); ?>
        <?php echo $form->dropDownList($model, 'super_access', array('0' => 'No', '1' => 'Yes'), array('prompt' => '--Select--')); ?>
        <?php echo $form->error($model, 'super_access'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
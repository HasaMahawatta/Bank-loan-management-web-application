<?php
/* @var $this QuestionController */
/* @var $model Question */
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
        <?php echo $form->label($model, 'questionId'); ?>
        <?php echo $form->textField($model, 'questionId'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'question'); ?>
        <?php echo $form->textField($model, 'question', array('size' => 60, 'maxlength' => 512)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'loanType'); ?>
        <?php echo $form->textField($model, 'loanType'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'common'); ?>
        <?php echo $form->textField($model, 'common'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'answerType'); ?>
        <?php echo $form->textField($model, 'answerType'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'questionCategory'); ?>
        <?php echo $form->textField($model, 'questionCategory'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
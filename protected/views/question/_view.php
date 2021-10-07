<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('questionId')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->questionId), array('view', 'id' => $data->questionId)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('question')); ?>:</b>
    <?php echo CHtml::encode($data->question); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('loanType')); ?>:</b>
    <?php echo CHtml::encode($data->loanType); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('common')); ?>:</b>
    <?php echo CHtml::encode($data->common); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('answerType')); ?>:</b>
    <?php echo CHtml::encode($data->answerType); ?>
    <br />

    


</div>
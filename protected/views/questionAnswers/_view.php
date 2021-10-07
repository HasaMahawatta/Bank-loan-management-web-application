<?php
/* @var $this QuestionAnswersController */
/* @var $data QuestionAnswers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('questionAnswerId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->questionAnswerId), array('view', 'id'=>$data->questionAnswerId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('QuestionId')); ?>:</b>
	<?php echo CHtml::encode($data->QuestionId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
	<?php echo CHtml::encode($data->answer); ?>
	<br />


</div>
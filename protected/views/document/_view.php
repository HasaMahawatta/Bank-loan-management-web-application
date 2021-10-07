<?php
/* @var $this DocumentController */
/* @var $data Document */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('documentId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->documentId), array('view', 'id'=>$data->documentId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loanId')); ?>:</b>
	<?php echo CHtml::encode($data->loanId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documentType')); ?>:</b>
	<?php echo CHtml::encode($data->documentType); ?>
	<br />


</div>
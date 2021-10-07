<?php
/* @var $this LoanController */
/* @var $data Loan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('loanId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->loanId), array('view', 'id'=>$data->loanId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user')); ?>:</b>
	<?php echo CHtml::encode($data->user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createdDate')); ?>:</b>
	<?php echo CHtml::encode($data->createdDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loanType')); ?>:</b>
	<?php echo CHtml::encode($data->loanType); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>
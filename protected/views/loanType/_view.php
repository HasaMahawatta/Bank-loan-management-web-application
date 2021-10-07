<?php
/* @var $this LoanTypeController */
/* @var $data LoanType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('loanTypeCode')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->loanTypeCode), array('view', 'id'=>$data->loanTypeCode)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passmark')); ?>:</b>
	<?php echo CHtml::encode($data->passmark); ?>
	<br />


</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Contoller_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Contoller_ID), array('view', 'id'=>$data->Contoller_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Controller_Name')); ?>:</b>
	<?php echo CHtml::encode($data->Controller_Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Action')); ?>:</b>
	<?php echo CHtml::encode($data->Action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->Status); ?>
	<br />


</div>
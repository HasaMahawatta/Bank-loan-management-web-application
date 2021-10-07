<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('action_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->action_id), array('view', 'id'=>$data->action_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action_name')); ?>:</b>
	<?php echo CHtml::encode($data->action_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('controller_Id')); ?>:</b>
	<?php echo CHtml::encode($data->controller_Id); ?>
	<br />


</div>
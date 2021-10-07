<?php
/* @var $this TestTableController */
/* @var $data TestTable */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('autoValue')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->autoValue), array('view', 'id'=>$data->autoValue)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>
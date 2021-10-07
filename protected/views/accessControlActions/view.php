<?php
$this->breadcrumbs=array(
	'Access Control Actions'=>array('index'),
	$model->action_id,
);

$this->menu=array(
	array('label'=>'List AccessControlActions', 'url'=>array('index')),
	array('label'=>'Create AccessControlActions', 'url'=>array('create')),
	array('label'=>'Update AccessControlActions', 'url'=>array('update', 'id'=>$model->action_id)),
	array('label'=>'Delete AccessControlActions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->action_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccessControlActions', 'url'=>array('admin')),
);
?>

<h1>View AccessControlActions #<?php echo $model->action_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'action_id',
		'action_name',
		'controller_Id',
	),
)); ?>

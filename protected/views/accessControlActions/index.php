<?php
$this->breadcrumbs=array(
	'Access Control Actions',
);

$this->menu=array(
	array('label'=>'Create AccessControlActions', 'url'=>array('create')),
	array('label'=>'Manage AccessControlActions', 'url'=>array('admin')),
);
?>

<h1>Access Control Actions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
$this->breadcrumbs=array(
	'Access Controllers',
);

$this->menu=array(
	array('label'=>'Create AccessControllers', 'url'=>array('create')),
	array('label'=>'Manage AccessControllers', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Access Controllers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</div>
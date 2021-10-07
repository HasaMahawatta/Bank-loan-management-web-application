<style>
.manage{
	margin-left:94.4%;
	margin-top:-8.6px;
}
</style>

<?php
$this->breadcrumbs=array(
	'Access'=>array('accessPermission/accesscontrol'),
	'Access Controller Details',
);

/*$this->menu=array(
	array('label'=>'List AccessControllers', 'url'=>array('index')),
	array('label'=>'Create AccessControllers', 'url'=>array('create')),
	array('label'=>'Update AccessControllers', 'url'=>array('update', 'id'=>$model->Contoller_ID)),
	array('label'=>'Delete AccessControllers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Contoller_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccessControllers', 'url'=>array('admin')),
);*/
?>

<div class="group" style="height:175px; width:20%; float:left; margin-left:3%; margin-top:2.4%">
        <div id="menu" style="padding-left:2%; padding-top:2%;">
<ul>
<li><?php echo CHtml::link('Manage Role',array('/role/admin')); ?></li>
<li><?php echo CHtml::link('Manage User',array('user/admin')); ?></li>
<li><?php echo CHtml::link('Update Controllers',array('/accessControllers/create')); ?></li>
<li><?php echo CHtml::link('Manage Controllers',array('/accessControllers/admin')); ?></li>
<li><?php echo CHtml::link('Update Actions',array('/accessControlActions/admin')); ?></li>
<li><?php echo CHtml::link('Access Permission',array('/accessControllers/assignpermission')); ?></li>
<!--<li><?php //echo CHtml::link('Create User',array('/maUser/create')); ?></li>-->
</ul>
        
        </div>
</div>
 
    <div  style="width:900px; float:left; ">
        <div class="group" style="width:89%; margin-left:32.6%; float:left; margin-top:-24.3%">

   <div class="manage">
             <?php  echo  CHtml::link('<img src="images/manage.png" style="height:50px; width="50px""  />',array('accessControllers/admin'));?> 	
        </div>


<h1>Access Controller Details</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Contoller_ID',
		'Controller_Name',
		'Display_Name',
		//'Action',
		//'Status',
	),
)); ?></div></div>

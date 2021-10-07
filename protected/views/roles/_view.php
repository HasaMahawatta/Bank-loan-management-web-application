<?php
/* @var $this RolesController */
/* @var $data Roles */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('rolecode')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->rolecode), array('view', 'id' => $data->rolecode)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('role')); ?>:</b>
    <?php echo CHtml::encode($data->role); ?>
    <br />


</div>
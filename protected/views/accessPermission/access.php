

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="100">
	
	

	<div class="row">
     <tr><td>
       <?php  echo $form->labelEx($model,'Role_ID'); ?>
       <?php echo $form->dropDownList($model, 'Role_ID', CHtml::listData(
    role::model()->findAll(), 'Role_ID', 'Role'),array('prompt' => 'Select Role'));   ?>
       <?php echo $form->error($model,'Role_ID'); ?>
    </td></tr>
    </div>

	<tr><td>
  

        
      
    
 
 



</td></tr>
</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
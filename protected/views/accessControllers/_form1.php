

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'access-controllers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'Contoller_ID'); ?>
		<?php echo $form->textField($model,'Contoller_ID'); ?>
		<?php echo $form->error($model,'Contoller_ID'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'Controller_Name'); ?>
		<?php echo $form->textField($model,'Controller_Name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Controller_Name'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'Action'); ?>
		<?php echo $form->textField($model,'Action',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Action'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'Status'); ?>
		<?php echo $form->textField($model,'Status',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Status'); ?>
	</div>
	<div>
    <?php #echo $form->labelEx($model,'Update Controllers'); ?>
    </div>
	<div class="row buttons" style="margin-left:70%; margin-top:60px;">
    
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Update' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
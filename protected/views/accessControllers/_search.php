

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="550" style="padding-left:20px;">
	<div class="row" style="display:none">
		<?php echo $form->label($model,'Contoller_ID'); ?>
		<?php echo $form->textField($model,'Contoller_ID'); ?>
	</div>

	<div class="row">
    <tr>
    	<td style="width:150px;"><?php echo $form->label($model,'Controller_Name'); ?></td>
        <td><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Controller_Name',
                                'attribute'=>'Controller_Name',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("AccessControllers/AccessControl"),
                                'htmlOptions'=>array('size'=>40,
                                
                                   'data-value'=>'',
                                ),
                            ));?>
                            
        <?php #echo $form->textField($model,'Controller_Name',array('size'=>40,'maxlength'=>200)); ?>
        <?php echo $form->error($model,'Controller_Name'); ?></td>
    </tr>
	</div>
    
	<div class="row" style="display:">
    <tr>
    	<td><?php echo $form->labelEx($model,'Display_Name'); ?></td>
       <?php #echo $form->textField($model,'Display_Name',array('size'=>40,'maxlength'=>200)); ?>
        <td><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Display_Name',
                                'attribute'=>'Display_Name',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("AccessControllers/DisplayName"),
                                'htmlOptions'=>array('size'=>40,
                                'data-value'=>'',
                                   
                                ),
                            ));?>
		<?php echo $form->error($model,'Display_Name'); ?></td>
    </tr>
	</div>
	<div class="row" style="display:none">
		<?php echo $form->label($model,'Action'); ?>
		<?php echo $form->textField($model,'Action',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Status'); ?>
		<?php echo $form->textField($model,'Status',array('size'=>60,'maxlength'=>100)); ?>
	</div>
</table>
	<div class="row buttons" style="margin-left:260px;">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
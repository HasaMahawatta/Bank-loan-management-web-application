
<div class="wide form">

  <?php
  $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
  ));
  ?>

  <table width="550" >
    <div class="row">
      <tr>
        <td ><?php echo $form->label($model, 'controller_Id'); ?></td>
        <td>
          <?php
          echo $form->dropDownList($model, 'controller_Id', CHtml::listData(AccessControllers::model()->findAll(), 'ID', 'Controller_Name'));
          ?>
        </td>
      </tr>
    </div>
    <div class="row">
      <tr>
        <td><?php echo $form->label($model, 'action_name'); ?></td>
        <td><?php
          $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model' => $model,
            'name' => 'action_name',
            'attribute' => 'action_name',
            // additional javascript options for the autocomplete plugin
            'options' => array(
              'minLength' => '0',
            ),
            'source' => $this->createUrl("AccessControlActions/ActionName"),
            'htmlOptions' => array('size' => 40,
              'data-value' => '',
            ),
          ));
          ?></td>
      </tr>
    </div>

    <div class="row">
      <tr>
        <td><?php echo $form->label($model, 'Action_Display_Name'); ?></td>
        <td><?php
          $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model' => $model,
            'name' => 'Action_Display_Name',
            'attribute' => 'Action_Display_Name',
            // additional javascript options for the autocomplete plugin
            'options' => array(
              'minLength' => '0',
            ),
            'source' => $this->createUrl("AccessControlActions/ActionDisplayName"),
            'htmlOptions' => array('size' => 40,
              'data-value' => '',
            ),
          ));
          ?></td>
      </tr>
    </div>
  </table>
  <!--	<div class="row">
  <?php echo $form->label($model, 'action_id'); ?>
  <?php echo $form->textField($model, 'action_id'); ?>
      </div>-->
  <div class="row">


  </div>

  <div class="row">


  </div>


  <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- search-form -->
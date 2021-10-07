<?php echo '<?php Yii::app()->clientScript->registerScript(\'search\', "
  $(\'.search-button\').click(function(){
    $(\'.search-form\').toggle();
    return false;
});
  $(\'.search-form form\').submit(function(){
    $(\'#' . $this->class2id($this->modelClass) . '-grid\').yiiGridView(\'update\', {
    data: $(this).serialize()
  });
  return false;
  });
");
?>'; ?>

<?php echo '  
<section class="section-lite">
  <div class="wrapper">
    <div class="exclusivevectors" style="color:">
    </div>
    <div class="rc-featured" >
      <div class="col-left">
        <table class="toole">
          <tr>
            <td><h5>Manage ' . $this->pluralize($this->class2name($this->modelClass)) . '</h5></td>
            <td width="20px;">
                <?php echo CHtml::link(\'<button type="button" class="btn btn-success"><i class="icon-search"></i>  Advanced Search</button>\', array(\'#\'),array(\'class\'=>\'search-button\')); ?>              
              </td>
            <td width="10px">
            
              <?php echo CHtml::link(\'<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>\', array(\'/' . $this->controller . '/create\')); ?>                            
            </td>
          </tr>          
        </table>
        <div class="left-content">
          <div class="search-form" style="<?php if(!isset($_GET[\'' . $this->modelClass . '\'])){echo "display:none;";} ?>">
              <?php $this->renderPartial(\'_search\',array(\'model\'=>$model,)); ?>
              <br/><br/><br/><br/><br/><br/>
          </div> 
'; ?>


<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
'dataProvider'=>$model->search(),
//'filter'=>$model,
'columns'=>array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column)
  {
  if (++$count == 7)
    echo "\t\t/*\n";
  echo "\t\t'" . $column->name . "',\n";
  }
if ($count >= 7)
  echo "\t\t*/\n";
?>
array(
'class'=>'CButtonColumn',
),
),
)); ?>
</div>
</div>
<div class="col-right">
  <div class="menu">
    <h5>Menu</h5>
    <ul>
      <?php
      echo '<?php '
      . '$menu = new MainMenus; '
      . 'echo $menu->sideMenues("Menu' . $this->modelClass . '") ?>';
      ?>          
    </ul>
  </div>
</div>
</div>
</div>
</section>
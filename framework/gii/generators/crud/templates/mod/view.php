<?php
echo
'   
<section class="section-lite">
  <div class="wrapper">
    <div class="exclusivevectors" style="color:">
    </div>
    <div class="rc-featured" >
      <div class="col-left">
        <table class="toole">
          <tr>
            <td><h5>View ' . $this->pluralize($this->class2name($this->modelClass)) . '</h5></td>
            <td></td>
            <td width="10px">
              <?php echo CHtml::link(\'<button type="button" class="btn btn-success"><i class="icon-th-list"></i>  Manage</button>\', array(\'/' . $this->controller . '/admin\')); ?>
            </td>
            <td width="10px">
              <?php echo CHtml::link(\'<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>\', array(\'/' . $this->controller . '/create\')); ?>
            </td>
          </tr>
        </table>
        <div class="left-content">
          ';
?>
<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
'data'=>$model,
'attributes'=>array(
<?php
foreach ($this->tableSchema->columns as $column)
    echo "\t\t'" . $column->name . "',\n";
?>
),
)); ?>

<?php echo '</div>
      </div>
      <div class="col-right">
        <div class="menu">
          <h5>Menu</h5>
          <ul>'; ?>                     
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
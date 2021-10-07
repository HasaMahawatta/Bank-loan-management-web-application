<?php Yii::app()->clientScript->registerScript('search', "
  $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
  $('.search-form form').submit(function(){
    $('#district-grid').yiiGridView('update', {
    data: $(this).serialize()
  });
  return false;
  });
");
?>
<div class="header">
<div class="wrapper">
<h4><i class="icon-cog"></i> Configurations <i class="icon-double-angle-right"></i> Manage User <i class="icon-double-angle-right"></i> 
Manage     </h4>
</div>
</div>
<section class="section-lite">
  <div class="wrapper">
    <div class="exclusivevectors" style="color:">
    </div>
    <div class="rc-featured" >
      <div class="col-left">
        <table class="toole">
          <tr>
            <td><h5>Manage User</h5></td>
            <td width="20px;">
              <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-search"></i>  Advanced Search</button>', array('#'), array('class' => 'search-button')); ?>              
            </td>
            <td width="10px">
              <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>', array('/user/admin/create', 'lid' => 'l4')); ?>                            
            </td>
          </tr>          
        </table>
        <div class="left-content">
          <div class="search-form" style="<?php
          if (!isset($_GET['District']))
            {
            echo "display:none;";
            }
          ?>">
                 <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            <br/><br/><br/><br/><br/><br/>
          </div> 
          <?php
          $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'user-grid',
            'dataProvider' => $model->search(),
            'columns' => array(
              array(
                'name' => 'username',
                'type' => 'raw',
                'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
              ),
              array(
                'name' => 'email',
                'type' => 'raw',
                'value' => 'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
              ),
              'create_at',
              'lastvisit_at',
              array(
                'name' => 'superuser',
                'value' => 'User::itemAlias("AdminStatus",$data->superuser)',
                'filter' => User::itemAlias("AdminStatus"),
              ),
              array(
                'name' => 'status',
                'value' => 'User::itemAlias("UserStatus",$data->status)',
                'filter' => User::itemAlias("UserStatus"),
              ),
              array(
                'class' => 'CButtonColumn',
              ),
            ),
          ));
          ?>
        </div>
      </div>
      <div class="col-right">
        <div class="menu">
          <h5>Menu</h5>
          <ul>
            <?php
            $menu = new MainMenus;
            echo $menu->sideMenues("MenuUser")
            ?>           
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- search-form -->



<?php Yii::app()->clientScript->registerScript('search', "
  $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
  $('.search-form form').submit(function(){
    $('#province-grid').yiiGridView('update', {
    data: $(this).serialize()
  });
  return false;
  });
");
?>
<div class="header">
    <div class="wrapper">
        <h4><i class="icon-cog"></i> Configurations <i class="icon-double-angle-right"></i> Roles <i class="icon-double-angle-right"></i>Manage  </h4>
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
                        <td><h5>Manage Roles</h5></td>
                        <td width="20px;">
                            <?php //echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-search"></i>  Advanced Search</button>', array('#'), array('class' => 'search-button')); ?>              
                        </td>
                        <td width="10px">
                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>', array('/roles/create')); ?>                            
                        </td>
                    </tr>          
                </table>
                <div class="left-content">
                    <div class="search-form" style="<?php
                    if (!isset($_GET['Province']))
                        {
                        echo "display:none;";
                        }
                    ?>">
                             <?php $this->renderPartial('_search', array('model' => $model,)); ?>
                    </div> 
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'roles-grid',
                        'dataProvider' => $model->search(),
                        'columns' => array(
                            'role',
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update} {delete}'
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
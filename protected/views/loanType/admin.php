<?php Yii::app()->clientScript->registerScript('search', "
  $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
  $('.search-form form').submit(function(){
    $('#loan-type-grid').yiiGridView('update', {
    data: $(this).serialize()
  });
  return false;
  });
");
?>

<section class="section-lite">
    <div class="wrapper">
        <div class="exclusivevectors" style="color:">
        </div>
        <div class="rc-featured" >
            <div class="col-left">
                <table class="toole">
                    <tr>
                        <td><h5>Manage Loan Types</h5></td>
                        <td width="20px;">
                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-search"></i>  Advanced Search</button>', array('#'), array('class' => 'search-button')); ?>              
                        </td>
                        <td width="10px">

                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>', array('/loanType/create')); ?>                            
                        </td>
                    </tr>          
                </table>
                <div class="left-content">
                    <div class="search-form" style="<?php if (!isset($_GET['LoanType'])) {
                                echo "display:none;";
                            } ?>">
<?php $this->renderPartial('_search', array('model' => $model,)); ?>
                        <br/><br/><br/><br/><br/><br/>
                    </div> 


                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'loan-type-grid',
                        'dataProvider' => $model->search(),
//'filter'=>$model,
                        'columns' => array(
                            'loanTypeCode',
                            'type',
                            'passmark',
                            array(
                                'class' => 'CButtonColumn',
                                'template'=>'{update} {delete}'
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
<?php $menu = new MainMenus;
echo $menu->sideMenues("MenuLoanType") ?>          
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
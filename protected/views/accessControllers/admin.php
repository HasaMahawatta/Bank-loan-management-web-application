<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function()
{
	
	if ($('.search-form').is(':hidden')) 
	{
		$('.search-form').toggle();
		return false;
	}
	else 
	{
		location.reload();
		return false;
	}
	
	
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('access-controllers-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">         
            <div class="col-xs-8">             
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Access Controller Registry</h2>
                    </div>
                    <div class="panel-body">            
                        <div>
                            <div class="search-form" style="display:none">
                                <?php
                                $this->renderPartial('_search', array(
                                    'model' => $model,
                                ));
                                ?>
                            </div><!-- search-form -->

                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'access-controllers-grid',
                                'dataProvider' => $model->search(),
                                //'filter'=>$model,
                                'columns' => array(
                                    //'Contoller_ID',
                                    'Controller_Name',
                                    'Display_Name',
                                    //'Action',
                                    //'Status',
                                    array(
                                        'class' => 'CButtonColumn',
                                        //'name'=>'Update',
                                        'template' => '{update}',
                                    ),
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>              
            </div>    
            <div class="col-xs-4">
                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">Master</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">                            
                            <?php
                            echo Config::menuarray();
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="panel panel-default rating-widget">
                    <div class="panel-heading large">
                        <h4 class="panel-title">Menu</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">                            
                            <?php
                            echo Config::accessControlers();
                            ?>
                        </ul>
                    </div>
                </div>
                </ul>
            </div>
            <div class="panel-footer text-center"> </div>
        </div>      
    </div>
</div>
</div>
</div>
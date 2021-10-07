<div class="container body">
  <div id="main" role="main">
    <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">         
      <div class="col-xs-8">             
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Update Access Controller Details</h2>
          </div>
          <div class="panel-body">            
            <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
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
              <li><?php echo CHtml::link('Manage Role', array('/role/admin')); ?></li>
              <li><?php echo CHtml::link('Manage User', array('user/admin')); ?></li>
              <li><?php echo CHtml::link('Update Controllers', array('/accessControllers/create')); ?></li>
              <li><?php echo CHtml::link('Manage Controllers', array('/accessControllers/admin')); ?></li>
              <li><?php echo CHtml::link('Update Actions', array('/accessControlActions/admin')); ?></li>
              <li><?php echo CHtml::link('Access Permission', array('/accessControllers/assignpermission')); ?></li>              
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
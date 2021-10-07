<section class="section-lite">
  <div class="wrapper">
    <div class="exclusivevectors" style="color:">
    </div>
    <div class="rc-featured" >
      <div class="col-left">
        <table class="toole">
          <tr>
            <td><h5>View User</h5></td>
            <td></td>
            <td width="10px">
              <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-th-list"></i>  Manage</button>', array('/user/admin')); ?>
            </td>
            <td width="10px">
              <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>', array('/user/admin/create')); ?>
            </td>
          </tr>
        </table>
        <div class="left-content">
          <?php
          $attributes = array(
            'id',
            'username',
          );

          $profileFields = ProfileField::model()->forOwner()->sort()->findAll();
          if ($profileFields)
            {
            foreach ($profileFields as $field)
              {
              array_push($attributes, array(
                'label' => UserModule::t($field->title),
                'name' => $field->varname,
                'type' => 'raw',
                'value' => (($field->widgetView($model->profile)) ? $field->widgetView($model->profile) : (($field->range) ? Profile::range($field->range, $model->profile->getAttribute($field->varname)) : $model->profile->getAttribute($field->varname))),
              ));
              }
            }

          array_push($attributes, 'password', 'email', 'activkey', 'create_at', 'lastvisit_at', array(
            'name' => 'superuser',
            'value' => User::itemAlias("AdminStatus", $model->superuser),
              ), array(
            'name' => 'status',
            'value' => User::itemAlias("UserStatus", $model->status),
              )
          );

          $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => $attributes,
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
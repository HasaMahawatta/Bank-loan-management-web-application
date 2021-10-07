<div class="header">
    <div class="wrapper">
        <h4><i class="icon-cog"></i> Configurations <i class="icon-double-angle-right"></i> User <i class="icon-double-angle-right"></i> 
            Create User   </h4>
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
                        <td><h5>Create User</h5></td>
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
                    echo $this->renderPartial('_form', array('model' => $model, 'profile' => $profile));
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
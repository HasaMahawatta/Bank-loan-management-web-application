<div class="header">
    <div class="wrapper">
        <h4><i class="icon-cog"></i> Configurations</h4>
    </div>
</div>
<section class="section-lite">
    <div class="wrapper">
        <div class="exclusivevectors" style="color:">
            <span class="tit">Master Configurations</span>
        </div>
        <div class="rc-featured">
            <?php echo CHtml::link('<div class="box-items box-items-3" style="height:195px;"><i class="icon-male" style="color:#090"></i><h6>Competitors</h6></div>', array('/competitor/admin')); ?>
            <?php echo CHtml::link('<div class="box-items box-items-3" style="height:195px;"><i class="icon-map-marker" style="color:#F30"></i><h6>Locations</h6></div>', array('/district/admin')); ?>
            <?php echo CHtml::link('<div class="box-items box-items-3" style="height:195px;"><i class="icon-th-large" style="color:#734d26"></i><h6>Properties</h6></div>', array('/landItem/admin')); ?>      
            <?php echo CHtml::link('<div class="box-items box-items-3" style="height:195px;"><i class="icon-flag" style="color:#000099"></i><h6>General </h6></div>', array('/approvalOrganization/admin')); ?>     
            <?php // echo CHtml::link('<div class="box-items box-items-3" style="height:195px;"><i class="icon-lock" style="color:#ff9900"></i><h6>Users & Access</h6></div>', array('/user/admin')); ?>     
        </div>
    </div>
</section>
<div class="top-banner" >    
    <div style="z-index: 88889!important; position: relative">
        <div class="sectionHeaderContainer">
            <div class="ash1 new-title topBannerTitle" style="color: rgb(255, 255, 255);"><strong>Online Loan Evaluation System.</strong>
            </div>
            <h3 class="plcFont">Cargills bank PLC.</h3>
        </div>
        <br/><br/>        
        <?php

        $usrName =  Yii::app()->user->name;
        if($usrName=='admin'){
        echo CHtml::link('You are admin', array('site/evaluation','loanId'=>1));
}
else
{

    echo CHtml::link('You are not admin', array('site/evaluation','loanId'=>1));
}

        ?>
        <div class="explainhome">Your priority is our priority....</div>
    </div>
    <div class="blackOverlay" style="z-index: 88888"></div>
</div>
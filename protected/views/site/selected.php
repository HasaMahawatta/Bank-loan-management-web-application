<section class="bodyContent" style="background-color:#FFF">    
    <div class="columnLeftQ" >
        <div class="menuTop">
            <ul class="leftFkTable list-unstyled">            
                <li class="headFK">Savings Accounts</li>
                <li>High Return Saver</li>
                <li>  Cargills Bank Salary Account</li>
                <li> Children's Savings</li>
                <li> Senior Citizen's Savings</li>
                <li class="headFK">  Current Accounts</li>
                <li>  Current Accounts</li>
                <li>  Business Current Accounts</li>
                <li class="headFK">  Investments</li>
                <li>  Fixed Deposits</li>
            </ul>
        </div>
    </div>
    <div class="columnsCenterQ" style="">
        <div class="page-header">
            <h2 class="colored">Evaluation</h2>
        </div>               
        <div class="congrats">
            <h3>Dear Customer,</h3>
            <?php
            $loanId = Yii::app()->session['loanId'];
            $loan = Loan::model()->findByPk($loanId);
            $menu = new MainMenus();
            $marks = $menu->loanMarks($loanId);
            if ($marks >= ($loan->loanTypeForLoan->passmark))
            {
                ?>            
                <h4>You are eligible for the Selected loan.</h4>
                <p>Our employee will contact you soon. Meanwhile please process original/Certified copies of following documents</p>
                <?php
            } else
            {
                ?>
                <h4>You are not eligible for the Selected loan.</h4>
                <p>Please visit nearest cargills bank branch.</p>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="columnRightQ" style="">
        <div class="alreadyMember">
            <p class=""><i class="icon-info-sign yellow"></i><span class="infoHeader">&nbsp;&nbsp;&nbsp;Info</span></p>
            <p>Contact Us.</p>
            <p><b>Address:</b> 696 Galle Rd</p>
            <p><b>Phone:</b>&nbsp;&nbsp;&nbsp;&nbsp; 011 7 640000</p>
        </div>
        <?php
        $this->renderPartial('_right');
        ?>
    </div>
</section>
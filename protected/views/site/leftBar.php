<div class="menuTop">
    <ul class="list-unstyled">        
        <?php echo CHtml::link('<li class=""><i class="icon-circle"></i>&nbsp;&nbsp;Personal Information</li>', array('site/Evaluation', 'loanId' => 1), array('confirm' => 'Are you sure? Your information will be lost.', 'class' => ($item == 1) ? 'navigationActive' : 'No Item')) ?>        
        <?php echo CHtml::link('<li class=""><i class="icon-circle"></i>&nbsp;&nbsp;Employment Information</li>', array('site/employment', 'loanId' => 1), array('confirm' => 'Are you sure? Your information will be lost.', 'class' => ($item == 2) ? 'navigationActive' : 'No Item')) ?>
        <?php echo CHtml::link('<li class=""><i class="icon-circle"></i>&nbsp;&nbsp;Financial Standing</li>', array('site/financial', 'loanId' => 1), array('confirm' => 'Are you sure? Your information will be lost.', 'class' => ($item == 3) ? 'navigationActive' : 'No Item')) ?> 
        <?php echo CHtml::link('<li class=""><i class="icon-circle"></i>&nbsp;&nbsp;Documents</li>', array('site/documents', 'loanId' => 1), array('confirm' => 'Are you sure? Your information will be lost.', 'class' => ($item == 4) ? 'navigationActive' : 'No Item')) ?>        
    </ul>
</div>
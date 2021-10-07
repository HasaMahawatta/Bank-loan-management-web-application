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
<section class="section-lite">
    <div class="wrapper">
        <div class="exclusivevectors" style="color:">
        </div>
        <div class="rc-featured" >
            <div class="col-left">
                <table class="toole">
                    <tr>
                        <td><h5>Admin Panel</h5></td>
                        <td width="20px;">
                        </td>
                        <td width="10px">
                        </td>
                    </tr>          
                </table>
                <div class="left-content">
                    <?php
                    $menu = new MainMenus();
                   echo $menu->boxItem(Yii::app()->createUrl('question/admin'), 'icon-dashboard', "Questions");
                   echo $menu->boxItem(Yii::app()->createUrl('loan/admin'), 'icon-dashboard', "Loans");
                   echo $menu->boxItem(Yii::app()->createUrl('loanType/admin'), 'icon-dashboard', "Loan Type");
                    
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
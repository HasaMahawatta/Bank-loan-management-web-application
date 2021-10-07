<section class="section-lite">
    <div class="wrapper">
        <div class="exclusivevectors" style="color:">
        </div>
        <div class="rc-featured" >
            <div class="col-left">
                <table class="toole">
                    <tr>
                        <td><h5>Loans</h5></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td><td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td width="10px">
                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-th-list"></i>  Manage</button>', array('/loan/admin')); ?>
                        </td>                        
                        <td>
                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-tick"></i>  Approve</button>', array('/loan/approve', 'loanId' => $model->loanId, 'code' => 1)); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-tick"></i>  Reject</button>', array('/loan/approve', 'loanId' => $model->loanId, 'code' => 2)); ?>
                        </td>
                    </tr>
                </table>
                <div class="left-content">
                    <?php $this->renderPartial('_form', array('model' => $model)); ?>
                </div>
            </div>
            <div class="col-right">
                <div class="menu">
                    <h5>Menu</h5>
                    <ul>            
                        <?php
                        $menu = new MainMenus;
                        echo $menu->sideMenues("MenuLoan")
                        ?>                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

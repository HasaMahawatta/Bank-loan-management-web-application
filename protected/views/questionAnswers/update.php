 
<section class="section-lite">
    <div class="wrapper">
        <div class="exclusivevectors" style="color:">
        </div>
        <div class="rc-featured" >
            <div class="col-left">
                <table class="toole">
                    <tr>
                        <td><h5>Update answers of <b><?php echo $model->questionForAnswers->question ?></b></h5></td>
                        <td></td>                        
                        <td width="10px">
                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>', array('/questionAnswers/create','id'=>$model->QuestionId)); ?>
                        </td>
                    </tr>
                </table>
                <div class="left-content">
                    <?php $this->renderPartial('_form', array('model' => $model)); ?>
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'question-answers-grid',
                        'dataProvider' => $model->search(),
                        'columns' => array(
                            'questionAnswerId',
                            'QuestionId',
                            'answer',
                            array(
                                'class' => 'CButtonColumn',
                                'template'=>'{update} {delete}'
                            ),
                        ),
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
                        echo $menu->sideMenues("MenuQuestionAnswers")
                        ?>                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

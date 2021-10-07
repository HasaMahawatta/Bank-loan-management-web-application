<?php Yii::app()->clientScript->registerScript('search', "
  $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
  $('.search-form form').submit(function(){
    $('#question-answers-grid').yiiGridView('update', {
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
                        <td><h5>Manage Question Answers of question: <b><?php echo $qModel->question ?></b> </h5></td>

                        <td width="10px">

                            <?php echo CHtml::link('<button type="button" class="btn btn-success"><i class="icon-plus"></i>  Add New</button>', array('/questionAnswers/create', 'id' => $qModel->questionId)); ?>                            
                        </td>
                    </tr>          
                </table>
                <div class="left-content">
                    <div class="search-form" style="<?php
                    if (!isset($_GET['QuestionAnswers']))
                    {
                        echo "display:none;";
                    }
                    ?>">
                             <?php $this->renderPartial('_search', array('model' => $model,)); ?>
                        <br/><br/><br/><br/><br/><br/>
                    </div> 
                    <?php
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'question-answers-grid',
                        'dataProvider' => $model->search(),
                        'columns' => array(
                            'questionAnswerId',
                            'QuestionId',
                            'answer',
                            'marks',
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update} {delete}'
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
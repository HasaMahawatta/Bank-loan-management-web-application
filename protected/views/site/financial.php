<section class="bodyContent" style="background-color:#FFF">    
    <div class="columnLeftQ">
        <?php
        $this->renderPartial('leftBar', array('item' => 3));
        ?>
    </div>
    <div class="columnsCenterQ" style="">
        <div class="page-header">
            <h2 class="colored">Evaluation - Financial Standing</h2>
        </div>       
        <div class="questions">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'question-answers-form',
                'action' => $this->createUrl('AnswerProcessor'),
                'enableAjaxValidation' => false,
            ));
            ?>
            <?php
            echo CHtml::hiddenField('nextAction', 3);
            ?>
            <?php
            $this->renderPartial('_questionPart', array('qcat' => 2));
            ?>
            <?php $this->endWidget(); ?> 
        </div>
        <div class="row">
            <?php echo CHtml::link('<button class="btn btn-info btn-sm" type="button">Next</button>', '#', array('class' => 'btn-success', 'onclick' => '$("form").submit();')) ?>
        </div>
    </div>
    <div class="columnRightQ" style="">
        <div class="alreadyMember">
            <p class=""><i class="icon-info-sign yellow"></i><span class="infoHeader">&nbsp;&nbsp;&nbsp;Info</span></p>
            <p>Enter Most recent details.</p>
        </div>
        <?php
        $this->renderPartial('_right');
        ?>
    </div>
</section>
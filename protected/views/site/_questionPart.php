<?php
$qno = 1;
$criteria = new CDbCriteria();
$criteria->addCondition('questionCategory=' . $qcat);
$questions = Question::model()->findAll($criteria);
foreach ($questions AS $question)
{
    ?>
    <div class="questionGroup">
        <div class="question">
            <h4><?php echo $qno . '.&nbsp;&nbsp;' . $question->question ?>.</h4>
        </div>
        <div class="answers">                    
            <?php
            if ($question->answerType == 0)
            {
                $answers = QuestionAnswers::model()->findAll('QuestionId=' . $question->questionId);
                echo CHtml::DropDownList('Answer[' . $question->questionId . ']', '', CHtml::listData($answers, 'questionAnswerId', 'answer'), array('prompt' => '--Select--'));
            } else if ($question->answerType == 1)
            {
                echo CHtml::textField('Answer[' . $question->questionId . ']', '');
            } else
            {
                echo CHtml::textArea('Answer[' . $question->questionId . ']', '');
            }
            ?>
        </div>
    </div>
    <?php
    $qno++;
}
?>
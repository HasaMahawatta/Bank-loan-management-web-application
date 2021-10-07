<?php
/* @var $this LoanController */
/* @var $model Loan */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'loan-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>    

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php
        $sql = 'SELECT questionId FROM ANSWER WHERE loanId=' . $model->loanId;
        $db = Yii::app()->db->createCommand($sql);
        $results = $db->queryAll();
        ?>
        <div class="row">
            <h3>Evaluation</h3>
            <h1 class="scoreDiv">Score: <?php
                $menu = new MainMenus;
                echo $menu->loanMarks($model->loanId);
                ?>
            </h1> 
            <br/>
            <br/>
            <br/>
            <h3>Documents:</h3>
            <div class="row">
                <h4>1. Proof of identity</h4>
                <?php
                $c = new CDbCriteria();
                $c->addCondition('loanId=' . $model->loanId);
                $c->addCondition('documentType=0');
                $docs = Document::model()->findAll($c);
                foreach($docs AS $doc)
                {
                    echo '<img src="files/'.$model->loanId.'/'.$doc->documentId.'.jpg" class="prevDoc"/>';                    
                }
                ?>
            </div>
            <div class="row">
                <h4>2. Proof of Resident </h4>
                <?php
                $c = new CDbCriteria();
                $c->addCondition('loanId=' . $model->loanId);
                $c->addCondition('documentType=1');
                $docs = Document::model()->findAll($c);
                foreach($docs AS $doc)
                {
                    echo '<img src="files/'.$model->loanId.'/'.$doc->documentId.'.jpg" class="prevDoc"/>';                    
                }
                ?>
            </div>
            <div class="row">
                <h4>3. Proof of Income </h4>
                <?php
                $c = new CDbCriteria();
                $c->addCondition('loanId=' . $model->loanId);
                $c->addCondition('documentType=2');
                $docs = Document::model()->findAll($c);
                foreach($docs AS $doc)
                {
                    echo '<img src="files/'.$model->loanId.'/'.$doc->documentId.'.jpg" class="prevDoc"/>';                    
                }
                ?>
            </div>


            <?php
            ?>
        </div>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->
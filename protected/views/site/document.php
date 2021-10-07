<section class="bodyContent" style="background-color:#FFF">    
    <div class="columnLeftQ" >
        <?php
        $this->renderPartial('leftBar', array('item' => 4));
        ?>
    </div>
    <div class="columnsCenterQ" style="">
        <div class="page-header">
            <h2 class="colored">Evaluation - Relevant Document</h2>
        </div>       
        <div class="questions">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'question-answers-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
            ?>

            <div class="questionGroup">
                <div class="question">
                    1. Proof of identity                   
                </div>
                <p>NIC /Drivers License/ Passport.</p>
                <div class="answers">
                    <input type="file" name="Docs[0][]" value="" id="identityDocs" multiple="multiple">
                </div>
            </div>
            <br/>
            <br/>
            <div class="questionGroup">
                <div class="question">
                    2. Proof of Resident                   
                </div>
                <p>Utility Bill(Electricity  / Fixed Telephone/ Water)</p>
                <div class="answers">
                    <input type="file" name="Docs[1][]" value="" id="residenceDocs" multiple="multiple">
                </div>
            </div>
            <br/>
            <br/>
            <div class="questionGroup">
                <div class="question">
                    3. Proof of Income
                </div>
                <p>Latest 3 months Bank Statement (where salary/income is credited).</p>
                <div class="answers">
                    <input type="file" name="Docs[2][]" value="" id="incomeDocs" multiple="multiple">
                </div>
            </div>
            <div class="row buttons">

                <?php
                echo CHtml::hiddenField('submits', true);
                echo CHtml::link('<button class="btn btn-info btn-sm" type="button">Submit</button>', '#', array('class' => 'btn-success', 'onclick' => '$("form").submit();'))
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        
    </div>
    <div class="columnRightQ" style="">
        <div class="alreadyMember">
            <p class=""><i class="icon-info-sign yellow"></i><span class="infoHeader">&nbsp;&nbsp;&nbsp;Info</span></p>
            <p><b>*</b> To select multiple file, Hold <b>CTRL</b> Key and select files individually.</p>
            <hr class="infoSeparater"/>
            <p><b>*</b> Please select most recent files.</p>
            <hr class="infoSeparater"/>
            <p><b>*</b> Please note that, Images captured from Mobile phone is sufficient (Text need to be readable).</p>            
        </div>        
        <?php
        $this->renderPartial('_right');
        ?>
    </div>
</section>
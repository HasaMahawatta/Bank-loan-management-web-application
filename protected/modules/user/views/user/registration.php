
<div class="header" style="margin-bottom:50px">

    <form style="margin:0px;padding:0px">

        <table class="toolbox">
            <td width="10px">   <?php echo CHtml::link('<i class="icon-home" data-toggle="tooltip" data-placement="bottom" title="Home"></i>', array('/site/index')); ?></td>
            <td width="10px"><i class="icon-double-angle-right"></i></td>
            <td>New Member Registration</td>



        </table>
    </form>
</div>

<div class="login-sub">



    <?php
    $form = $this->beginWidget('UActiveForm', array(
        'id' => 'registration-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'disableAjaxValidationAttributes' => array('RegistrationForm_verifyCode'),
        'clientOptions' => array('validateOnSubmit' => false),
    ));
    ?>
    <table class="login-reg" >





        <tr>
            <td>
                <h2>Get started</h2>
                <?php echo $form->errorSummary($model); ?>
            </td>
        </tr>


        <tr class="rowtdl">
            <td>
                <?php //echo $form->dropDownList($model, 'profile_types_code', CHtml::listData(ProfileTypes::model()->findAll(), 'profile_types_code', 'profile_types')) ?> 
                <?php //echo $form->error($model, 'profile_types_code'); ?>
            </td>
        </tr>

        <tr class="rowtdl">
            <td>                
                <?php echo $form->textField($model, 'first_name', array('class' => 'mainText2 form-control ', 'encode' => false, 'value' => '', 'placeholder' => 'First Name')); ?>
                <?php echo $form->error($model, 'last_name'); ?>
            </td>
        </tr>

        <tr class="rowtdl">
            <td>                
                <?php echo $form->textField($model, 'last_name', array('class' => 'mainText2 form-control ', 'encode' => false, 'value' => '', 'placeholder' => 'Last Name')); ?>
                <?php echo $form->error($model, 'last_name'); ?>
            </td>
        </tr>


        <tr class="rowtdl">
            <td>
                <?php echo $form->textField($model, 'username', array('class' => 'mainText2 form-control ', 'encode' => false, 'value' => '', 'placeholder' => 'Your Email')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </td>
        </tr>

        <tr class="rowtdl">

            <td>

                <?php echo $form->passwordField($model, 'password', array('class' => 'mainText2 form-control ', 'encode' => false, 'value' => '', 'placeholder' => 'New Password')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </td>
        </tr>
        <tr class="rowtdl">
            <td>
                <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'mainText2 form-control ', 'encode' => false, 'value' => '', 'placeholder' => 'Re-enter Password')); ?>
                <?php echo $form->error($model, 'verifyPassword'); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo CHtml::submitButton(UserModule::t("Join Now"), array('class' => 'joinbut')); ?>

            </td>
        </tr>




    </table>
    <?php $this->endWidget(); ?>
</div>
<div class="footer"></div>



<script type="text/javascript">
    $(function() {

        $('[data-toggle="tooltip"]').tooltip();

        //$('.rightyicode').tooltip();

    });
</script>		

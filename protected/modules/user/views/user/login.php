
<div class="header" style="margin-bottom:50px">

    <form style="margin:0px;padding:0px">

        <table class="toolbox">
            <td width="10px">   <?php echo CHtml::link('<i class="icon-home" data-toggle="tooltip" data-placement="bottom" title="Home"></i>', array('/site/index')); ?></td>
            <td width="10px"><i class="icon-double-angle-right"></i></td>
            <td>Member Login</td>
        </table>
    </form>
</div>

<div class="login-sub">
    <?php
    $form = $this->beginWidget('UActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'clientOptions' => array('validateOnSubmit' => false),
    ));
    ?>
    <table class="login-reg">
        <tr>
            <td>
                <h2>Login</h2>
                <?php echo $form->errorSummary($model); ?>
            </td>
        </tr>
        <tr class="rowtdl">
            <td>
                <?php echo $form->textField($model, 'username', array('class' => 'mainText2 form-control', 'encode' => false, 'value' => '', 'placeholder' => 'Email')) ?>
                <?php echo $form->error($model, 'username'); ?>
            </td>	
        </tr>
        <tr class="rowtdl">
            <td>
                <?php echo $form->passwordField($model, 'password', array('class' => 'mainText2 form-control ', 'encode' => false, 'value' => '', 'placeholder' => 'Password')) ?>
                <?php echo $form->error($model, 'password'); ?> 

            </td>	
        </tr>
        <tr  class="rowtdl">
            <td>
                <?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn btn-success')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::link('Sign Up', array('/user/registration')) ?>
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












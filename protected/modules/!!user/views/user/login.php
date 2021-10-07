<div class="loginForm">
    <?php
    $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Login");
    $this->breadcrumbs = array(
        UserModule::t("Login"),
    );
    ?>

    <h1><?php echo UserModule::t("Login"); ?></h1>

    <?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

        <div class="success">
            <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
        </div>

    <?php endif; ?>   

    <div class="form">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::errorSummary($model); ?>
        <div class="row">
            <?php echo CHtml::activeLabelEx($model, 'Username Or Email'); ?>
            <?php echo CHtml::activeTextField($model, 'username') ?>
        </div>

        <div class="row">
            <?php echo CHtml::activeLabelEx($model, 'Password'); ?>
            <?php echo CHtml::activePasswordField($model, 'password') ?>
        </div>

        <div class="row">
            <p class="hint">
                <?php echo CHtml::link(UserModule::t("Register"), Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
            </p>
        </div>

        <div class="row rememberMe">
            <?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
            <?php echo CHtml::activeLabelEx($model, 'Remember Me'); ?>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton(UserModule::t("Login"), array('style' => 'float:right')); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->


    <?php
    $form = new CForm(array(
        'elements' => array(
            'username' => array(
                'type' => 'text',
                'maxlength' => 32,
            ),
            'password' => array(
                'type' => 'password',
                'maxlength' => 32,
            ),
            'rememberMe' => array(
                'type' => 'checkbox',
            )
        ),
        'buttons' => array(
            'login' => array(
                'type' => 'submit',
                'label' => 'Login',
            ),
        ),
            ), $model);
    ?>
</div>
<div class="shout-box" id="shoutout" style="margin-top: 5em;background-color: transparent;margin-bottom: 400px;margin-top: 200px">
    <div class="shout-text">
        <h1><span style="font-size: 3.4em">ගී ස්වර</span></h1>
        <p>ඔබේ ගීතයේ තනුව සොයා........</p>
    </div>
</div>
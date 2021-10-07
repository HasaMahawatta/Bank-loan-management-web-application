<?php ob_start(); ?> 
<?php

class RegistrationController extends Controller
{

    public $defaultAction = 'registration';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Registration user
     */
    public function actionRegistration()
    {

        $model = new RegistrationForm;

        $this->performAjaxValidation($model);

        if (Yii::app()->user->id)
        {

            $this->redirect(array('/site/index'));
        } else
        {

            if (isset($_POST['RegistrationForm']))
            {


                $model->attributes = $_POST['RegistrationForm'];
                if ($model->validate())
                {

                    $soucePassword = $model->password;
                    $soucePassword = $model->password;
                    $model->activkey = UserModule::encrypting(microtime() . $model->password);
                    $model->password = UserModule::encrypting($model->password);
                    $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                    $model->superuser = 0;
                    $model->status = 1;
                    if ($model->save(false))
                    {
                        $sql = "insert into tbl_users values(null,'" . $model->username . "','" . $model->password . "','" . $model->email . "',null,'" . $model->create_at . "','" . $model->lastvisit_at . "','" . $model->superuser . "','" . $model->status . "','0','" . $model->first_name . "','" . $model->last_name . "',null,null)";

                        $db = Yii::app()->db->createCommand($sql);
                        $db->execute();
                        $this->redirect(array('/user/login'));
                    }
                }
            }
        }
        $this->render('/user/registration', array('model' => $model));
    }

    private function lastViset()
    {
        User::model()->updateByPk(Yii::app()->getModule('user')->user()->id, array('lastvisit_at' => date("Y-m-d : H:i:s", time())));
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

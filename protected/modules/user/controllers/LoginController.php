<?php

class LoginController extends Controller {

    public $defaultAction = 'login';

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            $this->performAjaxValidation($model);
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
                    //$this->profiletype();
                    $user =User::model()->findByPk(Yii::app()->user->id);
                    if ($user->role_code == 2)
                        $this->redirect(array('/site/configPanel'));
                    else
                        $this->redirect(array('/site/index'));
                }
            }
            // display the login form
            $this->render('/user/login', array('model' => $model));
        } else
            $this->redirect(array('/site/index'));
    }

    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

    private function profiletype() {
        $module = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $profile_types_code = $module->profile_types_code;
        $pro = ProfileTypes::model()->findByPk($profile_types_code);
        Yii::app()->session['profile_types_code'] = $pro->profile_types;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

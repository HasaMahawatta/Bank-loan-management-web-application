<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
	/*	$this->redirect(array('/user/registration'));*/
		
		 Yii::app()->session['current'] = 16;
				    $this->redirect(array('/site/index','type'=>1));  
	
	}

}
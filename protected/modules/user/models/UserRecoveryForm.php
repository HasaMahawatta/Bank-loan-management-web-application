<?php

/**
 * UserRecoveryForm class.
 * UserRecoveryForm is the data structure for keeping
 * user recovery form data. It is used by the 'recovery' action of 'UserController'.
 */
class UserRecoveryForm extends CFormModel {
	public $login_or_email, $user_id;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('login_or_email', 'required'),
			array('login_or_email', 'email', 'message' => UserModule::t("Incorrect email")),
			// password needs to be authenticated
			array('login_or_email', 'checkexists'),
		);
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'login_or_email'=>UserModule::t("Email (Username)"),
		);
	}
	
	public function checkexists($attribute,$params) {
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
	
				$user=User::model()->findByAttributes(array('username'=>$this->login_or_email));
				if ($user)
				{
					$this->user_id=$user->id;
				}
			
			
			if($user===null)
				if (strpos($this->login_or_email,"@")) {
					$this->addError("login_or_email",UserModule::t("Email is incorrect."));
				} else {
					$this->addError("login_or_email",UserModule::t("Username is incorrect."));
				}
		}
	}
	
}
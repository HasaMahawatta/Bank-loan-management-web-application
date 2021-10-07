<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionRecovery () 
	{
		$form = new UserRecoveryForm;
	
			    	if(isset($_POST['UserRecoveryForm'])) 
					{
			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()) 
						{
			    			//$user = User::model()->notsafe()->findbyPk($form->user_id);
							
							$length = 5;
							$chars = range(0,9);
							shuffle($chars);
							$genpassword = implode(array_slice($chars, 0, $length));
							$encrptpassword = UserModule::encrypting($genpassword);
							User::model()->updateByPk($form->user_id,array('password'=>$encrptpassword));
							
							
							
		require 'mail/class.phpmailer.php';
		$email = new PHPMailer();
        $email->Host       = "mail.hitroot.com"; 
        $email->SMTPDebug  = 2; 
		$email->SMTPAuth   = true;
		$email->SMTPSecure = "tls"; 
		$email->Host       = "p3plcpnl0934.prod.phx3.secureserver.net";   
		$email->Port       = 465; 
		$email->Username   = "info@hitroot.com";
		$email->Password   = "info@root";  
		$email->From      = 'info@hitroot.com';
		$email->FromName  = 'Hitroot Team';
		$email->Subject   = 'Hitroot Password Recovery';
		$email->Body = "Hi, Your new password is <b>".$genpassword."</b>.Please reset your password after login.";
		$email->IsHTML(true);
		$email->AddAddress($form->login_or_email);
		$email->Send();
							
							
							
							/*
							$subject = "You have requested the password recovery";
			    			$message = UserModule::t("You have requested the password recovery. To receive a new password, go to {activation_url}.",
			    					array(
			    						'{activation_url}'=>$activation_url,
			    					));
							
			    			UserModule::sendMail($user->username,$subject,$message);
			    			
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email. An instructions was sent to your email address."));*/
			    			$this->redirect(array('/user/registration'));
			    		}
			    	}
		    		$this->renderPartial('recovery',array('form'=>$form),false,true);
		    	}
	
	

}
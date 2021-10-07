<?php

//Developed by hasitha for easy access implementation
class AccessHelper
  {

  public static function checkAccess($accessRules)
    {
    if (Yii::app()->params['access'] == true)
      {
      return $accessRules;
      }
    $controllerName = Yii::app()->controller->getUniqueId();
    $actionName = Yii::app()->controller->action->id;
    if ($actionName == 'login' || $actionName == 'logout')
      {
      return array(
        array('allow',
          'actions' => array($actionName, 'noaction'),
          'users' => array(Yii::app()->user->name),
        )
      );
      }
    $access = Yii::app()->user->GetPermission($controllerName, $actionName);
    if ($access == 'true')
      {
      return array(
        array('allow',
          'actions' => array($actionName, 'noaction'),
          'users' => array(Yii::app()->user->name),
        ),
        array('deny', // deny all users
          'users' => array('*'),
        ),
      );
      }
    else
      {
      if (Yii::app()->params['access'] == 'true')
        {
        return $accessRules;
        }
      else
        {
        return array(
          'deny',
          'users' => array('*')
        );
        }
      }
    }

  }

?>
<?php

class AccessPermissionController extends Controller
  {
  /* public function accessRules()
    {
    return array(
    array('allow',  // allow all users to perform 'index' and 'view' actions
    'actions'=>array('Accesscontrol'),
    'users'=>array('*'),
    ),

    );
    } */

  public function init()
    {
    Yii::app()->session['currentLink'] = "lid6";
    }

  public function accessRules()
    {
    /*
     * Added by Sasanka on 15/May/2013
     * Performs to get the permission according to user.
     * This can be apply to all controlers.
     * add whole, public function accessRules(). */

    /*
      $curr_controlername = $this->getUniqueId();
      $curr_action = Yii::app()->controller->action->id;
      $access = Yii::app()->user->GetPermission($curr_controlername, $curr_action);

      if ($access == 'true')
      {
      return array(
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
      'actions' => array($curr_action, 'delete'),
      'users' => array(Yii::app()->user->name),
      ),
      array('deny', // deny all users
      'users' => array('*'),
      ),
      );
      }
      else
      {
      return array(
      array('allow', // allow all users to perform 'index' and 'view' actions
      'actions' => array('view', 'delete'),
      'users' => array('*'),
      ),
      array('deny', // deny all users
      'users' => array('*'),
      ),
      );
      } */

    return array(
      array('allow', // allow all users to perform 'index' and 'view' actions
        'actions' => array('view', 'delete'),
        'users' => array('*'),
      ),
      array('deny', // deny all users
        'users' => array('*'),
      ),
    );
    }

  public function actionIndex()
    {

    $this->render('access', array(
      'dataProvider' => $dataProvider,
    ));
    }

  public function actionAccesscontrol()
    {
    $this->render('accesscontrol');
    }

  public function actionAccess()
    {
    $model = new role;


    $this->render('access', array('model' => $model));
    }

  public function actionController()
    {

    $this->render('controller');
    }

  }

?>
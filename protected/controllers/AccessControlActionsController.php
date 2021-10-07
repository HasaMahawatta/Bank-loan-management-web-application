<?php

class AccessControlActionsController extends Controller
  {

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column2';

  /**
   * @return array action filters
   */
  public function filters()
    {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
    }

  public function init()
    {
    Yii::app()->session['currentLink'] = "lid6";
    }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules

    public function accessRules()
    {
    return array(
    array('allow',  // allow all users to perform 'index' and 'view' actions
    'actions'=>array('index','view','ActionName','ActionDisplayName'),
    'users'=>array('*'),
    ),
    array('allow', // allow authenticated user to perform 'create' and 'update' actions
    'actions'=>array('create','update'),
    'users'=>array('@'),
    ),
    array('allow', // allow admin user to perform 'admin' and 'delete' actions
    'actions'=>array('admin','delete'),
    'users'=>array('admin'),
    ),
    array('deny',  // deny all users
    'users'=>array('*'),
    ),
    );
    } */
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
      'actions' => array('view', 'delete', 'ActionName', 'ActionDisplayName'),
      'users' => array('*'),
      ),
      array('allow',
      'actions' => array('admin', 'update', 'delete'),
      'users' => array('admin')
      ),
      array('deny', // deny all users
      'users' => array('*'),
      ),
      );
      } */
    return array(
      array('allow', // allow all users to perform 'index' and 'view' actions
        'actions' => array('view', 'delete', 'ActionName', 'ActionDisplayName'),
        'users' => array('admin'),
      ),
      array('allow',
        'actions' => array('admin', 'update', 'delete'),
        'users' => array('admin')
      ),
      array('deny', // deny all users
        'users' => array('admin'),
      ),
    );
    }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
    {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
    }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
    {
    if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] != '')
      {
      unset(Yii::app()->session['btnClick']);
      }
    $model = new AccessControlActions;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['AccessControlActions']))
      {
      $model->attributes = $_POST['AccessControlActions'];

      $valid = $model->validate();
      if ($valid)
        {
        if ($model->save())
          $this->redirect(array('view', 'id' => $model->action_id));
        }
      else
        {
        Yii::app()->session['btnClick'] = "1";
        }
      }

    $this->render('create', array(
      'model' => $model,
    ));
    }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
    {
    if (isset(Yii::app()->session['btnClick']) && Yii::app()->session['btnClick'] != '')
      {
      unset(Yii::app()->session['btnClick']);
      }
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['AccessControlActions']))
      {
      $model->attributes = $_POST['AccessControlActions'];

      $valid = $model->validate();
      if ($valid)
        {
        if ($model->save())
          $this->redirect(array('admin', 'id' => $model->action_id));
        }
      else
        {
        Yii::app()->session['btnClick'] = "1";
        }
      }

    $this->render('update', array(
      'model' => $model,
    ));
    }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
    {
    try
      {
      $this->loadModel($id)->delete();
      if (!isset($_GET['ajax']))
        Yii::app()->user->setFlash('success', 'Successfully Deleted');
      else
      #echo "<div class='flash-success'>Successfully Deleted</div>";
        echo '<script>
				
				var height = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
		$(".ontop").height(height);
		$("#Confirm").fadeIn(500);
			$("#popDiv").fadeIn(500);
</script>';
      }
    catch (CDbException $e)
      {
      if (!isset($_GET['ajax']))
        Yii::app()->user->setFlash('error', 'Sorry! You cannot delete this record');
      else
      #echo "<div class='flash-error'>Sorry! You cannot delete this record</div>"; //for ajax
        echo '<script>var height = $("body").height() /*- $("#header").height() + $("#footer").height()*/;
		$(".ontop").height(height);
	$("#errorConfirm").fadeIn(500);/**/
			$("#popDiv").fadeIn(500);
</script>';
      }
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

  /**
   * Lists all models.
   */
  public function actionIndex()
    {
    $dataProvider = new CActiveDataProvider('AccessControlActions');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
    }

  /**
   * Manages all models.
   */
  public function actionAdmin()
    {
    $model = new AccessControlActions('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['AccessControlActions']))
      {
      $model->attributes = $_GET['AccessControlActions'];
      }

    $this->render('admin', array(
      'model' => $model,
    ));
    }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
    {
    $model = AccessControlActions::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
    }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
    {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'access-control-actions-form')
      {
      echo CActiveForm::validate($model);
      Yii::app()->end();
      }
    }

  public function actionActionName()
    {
    $string = trim($_GET['term']);
    if ($string != '')
      {
      $model = AccessControlActions::model()->findAll(array("condition" => "action_name like '%$string%'"));
      $data = array();
      foreach ($model as $get)
        {
        $data[] = $get->action_name;
        }
      $this->layout = 'empty';
      echo json_encode($data);
      }
    }

  public function actionActionDisplayName()
    {
    $string = trim($_GET['term']);
    if ($string != '')
      {
      $model = AccessControlActions::model()->findAll(array("condition" => "Action_Display_Name like '%$string%'"));
      $data = array();
      foreach ($model as $get)
        {
        $data[] = $get->Action_Display_Name;
        }
      $this->layout = 'empty';
      echo json_encode($data);
      }
    }

  }

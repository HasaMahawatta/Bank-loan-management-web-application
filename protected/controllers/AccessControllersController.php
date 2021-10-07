<?php

class AccessControllersController extends Controller
  {

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column2';
  public $highlightMenu = "0";

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

    //echo Yii::app()->user->name;die;
    return array(
    array('allow',  // allow all users to perform 'index' and 'view' actions
    'actions'=>array('index','view','Assignpermission','getCreatetable','AccessControl','DisplayName'),
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
      'actions' => array('view', 'delete', 'getCreatetable', 'AccessControl', 'DisplayName'),
      'users' => array('*'),
      ),
      array('allow',
      'actions' => array('assignpermission', 'admin', 'view', 'create', 'update', 'index'),
      'users' => array('admin')
      ),
      array('deny', // deny all users
      'users' => array('*'),
      ),
      );
      } */
    return array(
      array('allow', // allow all users to perform 'index' and 'view' actions
        'actions' => array('view', 'delete', 'getCreatetable', 'AccessControl', 'DisplayName'),
        'users' => array('admin'),
      ),
      array('allow',
        'actions' => array('assignpermission', 'admin', 'view', 'create', 'update', 'index'),
        'users' => array('admin')
      ),
      array('deny', // deny all users
        'users' => array('*'),
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
    /**
     * Created by Sasanka on 17/May/2013
     * Performs to add all controllers and views to the database.	
     * Use for access permissions
     */
    $model = new AccessControllers;

    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    if (isset($_POST['AccessControllers']))
      {
      $controllers = array();
      $files = CFileHelper::findFiles(realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'controllers'));
      $totfiles = count($files);
      $controllerId = 0;
      for ($i = 0; $i < $totfiles; $i++)
        {
        $controllers = array();
        $ControllerName1 = '';
        $filename = basename($files[$i], '.php');
        if (($pos = strpos($filename, 'Controller')) > 0)
          {
          $controllers[] = substr($filename, 0, $pos);
          }
        $count = count($controllers);
        if ($count > 0)
          {
          $ControllerName = $controllers[0];

          $ControllerName1 = '';
          if ($ControllerName == 'Access')
            {
            $ControllerName1 = 'AccessControllers';
            }
          else if ($ControllerName == 'AccessPermission')
            {
            $ControllerName1 = 'accessPermission';
            }
          else
            {
            $ControllerName1 = $ControllerName;
            }

          $controllerNameAsItis = $ControllerName1;
          $ControllerName1 = strtolower($ControllerName1);

          //--add controllers names to db--

          $sqlcmd = "select Controller_Name,ID from access_controllers where Controller_Name='" . $ControllerName1 . "'";
          $result = Yii::app()->db->createCommand($sqlcmd)->queryAll();
          $cntID = '';
          //print_r($result)	;die;

          if (count($result) == 0)
            {
            $controllerId++;


            $query = "INSERT INTO access_controllers(Contoller_ID, Controller_Name) VALUES('" . $controllerId . "', '" . $ControllerName1 . "') ";
            //$query = "INSERT INTO access_controllers(Controller_Name) VALUES ('".$ControllerName1."') ";							 	
            Yii::app()->db->createCommand($query)->execute();

            //--get the saved controller name from db--		

            $mycmd = "select ID from access_controllers where Controller_Name='" . $ControllerName1 . "'";
            $contID = Yii::app()->db->createCommand($mycmd)->queryAll();
            $cntID = $contID[0]['ID'];
            }
          else
            {
            $cntID = $result[0]['ID'];
            }

          //Modified By hasitha for get real actions only.
          $path = 'protected' . DIRECTORY_SEPARATOR . 'controllers';
          echo $path . DIRECTORY_SEPARATOR . $controllerNameAsItis . 'Controller.php<br/>';
          include_once($path . DIRECTORY_SEPARATOR . $controllerNameAsItis . 'Controller.php');
          $reflection = new ReflectionClass($controllerNameAsItis . 'Controller');
          $methods = $reflection->getMethods();
          $actions = array();
          foreach ($methods as $method)
            {
            if (strpos($method->name, 'action') === 0)
              {
              $actionNameItem = str_replace('action', '', $method->name);
              $sql = "select action_id  from access_control_actions where controller_Id='" . $cntID . "' and action_name='" . $actionNameItem . "'";
              $res = Yii::app()->db->createCommand($sql)->queryAll();
              if (count($res) == 0)
                {
                $query = "INSERT INTO access_control_actions(action_name,controller_Id ) VALUES ('" . $actionNameItem . "','" . $cntID . "') ";
                Yii::app()->db->createCommand($query)->execute();
                }
              }
            }

          Yii::app()->user->setFlash('success', "Controllers and Actions successful updated!");
          }
        }
      $this->redirect(array('create'));
      }
    else
      {

      $this->render('create', array('model' => $model,));
      }
    }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
    {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['AccessControllers']))
      {
      $model->attributes = $_POST['AccessControllers'];
      if ($model->save())
        $this->redirect(array('admin'));
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
    $dataProvider = new CActiveDataProvider('AccessControllers');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
    }

  /**
   * Manages all models.
   */
  public function actionAdmin()
    {
    $modelrole = new Roles;
    $model = new AccessControllers('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['AccessControllers']))
      {
      $model->attributes = $_GET['AccessControllers'];
      }

    $this->render('admin', array(
      'model' => $model, 'modelrole' => $modelrole
    ));
    }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
    {
    $model = AccessControllers::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'access-controllers-form')
      {
      echo CActiveForm::validate($model);
      Yii::app()->end();
      }
    }

  public function actionAssignpermission($postRole = '0')
    {
    $this->highlightMenu = "m12";
    $modelrole = new Roles();
    $views = new AccessControlActions();
    $model = new AccessControllers();
    $modelrole->rolecode = $postRole;

    if (isset($_POST['Roles']) && isset($_POST['AccessControllers']))
      {
      $roleID = $_POST['Roles']['rolecode'];
      $ControllerID = $_POST['AccessControllers']['Display_Name'];
      $actionArr = array();

      if (isset($_POST['action_id']))
        {
        $actionArr = $_POST['action_id'];
        }


      if ($model->savePermission($actionArr, $roleID, $ControllerID))
        {
        Yii::app()->user->setFlash('success', count($actionArr) . ' Controllers Permission on ' . date("Y-m-d : H:i:s", time()));
        }
      if (isset($_POST['reflect']))
        {
        $model->addReflectionRights($_POST['reflect'], $ControllerID);
        }
      $this->redirect(array('Assignpermission', 'postRole' => $roleID));

      /* else 
        {
        Yii::app()->user->setFlash('success', "Please Set Grant Access");
        } */
      }

    $this->render('assignpermission', array(
      'model' => $model, 'modelrole' => $modelrole, 'views' => $views,
    ));
    }

  public function actionDynamicDsDivisions()
    {
    if (isset($_POST['MaLocation']['District_ID']))
      {
      $ID = $_POST['MaLocation']['District_ID'];
      }
    else if (isset($_POST['MaLocation']['District_ID']))
      {
      $ID = $_POST['MaLocation']['District_ID'];
      }

    if (isset(Yii::app()->session['DS_Division_ID']) && !is_null(Yii::app()->session['DS_Division_ID']))
      {
      $data = MaDsDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', array(':DS_Division_ID' => (int) Yii::app()->session['DS_Division_ID']));
      }
    else
      {
      $data = MaDsDivision::model()->findAll('District_ID=:District_ID', array(':District_ID' => (int) $ID));
      }

    $data = CHtml::listData($data, 'DS_Division_ID', 'DS_Division_Name');
    echo CHtml::tag('option', array('value' => ''), CHtml::encode('--- Please Select ---'), true);

    foreach ($data as $value => $name)
      {
      echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }

  public function actionDynamicGnDivisions()
    {

    if (isset($_POST['MaLocation']['DS_Division_ID']))
      {
      $ID = $_POST['MaLocation']['DS_Division_ID'];
      }
    else if (isset($_POST['MaLocation']['DS_Division_ID']))
      {
      $ID = $_POST['MaLocation']['DS_Division_ID'];
      }

    if (isset(Yii::app()->session['GN_Division_ID']) && !is_null(Yii::app()->session['GN_Division_ID']))
      {
      $data = MaGnDivision::model()->findAll('GN_Division_ID=:GN_Division_ID', array(':GN_Division_ID' => (int) Yii::app()->session['GN_Division_ID']));
      }
    else
      {
      $data = MaGnDivision::model()->findAll('DS_Division_ID=:DS_Division_ID', array(':DS_Division_ID' => (int) $ID));
      }

    $data = CHtml::listData($data, 'GN_Division_ID', 'GN_Division_Name');
    echo CHtml::tag('option', array('value' => ''), CHtml::encode(' Please Select '), true);

    foreach ($data as $value => $name)
      {
      echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }

  public function actiongetCreatetable()
    {
    $rol = $_POST['rollId'];
    $materialIds = $_POST['materialId'];
    $table = new AccessControlActions();
    $array = $table->actionNews($materialIds, $rol);

    echo '<table width="646" style="background-color: #EBECED;  border: 1px solid #9A9A9A;" >';
    echo '<tr>';
    //echo '<td align="center">Controller Display Name</td>';
    echo '<th style="line-height:2; width:400px; text-align:center;">Action Display Name</th>';
    echo '<th style="line-height:2; text-align:center;">Grant Access</th>';
    echo '<th style="line-height:2; text-align:center;"><span class="required">Apply to all roles.</span></th>';
    echo '</tr>';

    foreach ($array as $t => $k)
      {
      echo '<tr>';
      echo '<td style="padding:2px 0 2px 2px">' . CHtml::label($k['Action_Display_Name'], '', array('size' => 35)) . '</td>';
      echo'<td style="padding-left:50px;">' . CHtml::CheckBox('action_id[]', $k['status'], array('value' => $k['action_id'],));
      echo'<td style="padding-left:50px;">' . CHtml::CheckBox('reflect[]', 0, array('value' => $k['action_id'],));
      '</td>';
      /*
        if ($k['status'] == 1)
        {
        echo'<td style="padding-left:50px;">' . CHtml::CheckBox('action_id[]', '1', array('value' => $k['action_id'],));
        '</td>';
        }
        else
        {
        echo'<td style="padding-left:50px;">' . CHtml::CheckBox('action_id[]', '', array('value' => $k['action_id'],));
        '</td>';
        } */
      }

    echo '</table>';
    }

  public function actionAccessControl()
    {
    $string = trim($_GET['term']);
    if ($string != '')
      {
      $model = AccessControllers::model()->findAll(array("condition" => "Controller_Name like '%$string%'"));
      $data = array();
      foreach ($model as $get)
        {
        $data[] = $get->Controller_Name;
        }
      $this->layout = 'empty';
      echo json_encode($data);
      }
    }

  public function actionDisplayName()
    {
    $string = trim($_GET['term']);
    if ($string != '')
      {
      $model = AccessControllers::model()->findAll(array("condition" => "Display_Name like '%$string%'"));
      $data = array();
      foreach ($model as $get)
        {
        $data[] = $get->Display_Name;
        }
      $this->layout = 'empty';
      echo json_encode($data);
      }
    }

  }

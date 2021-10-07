<?php

/**
 * This is the model class for table "access_controllers".
 *
 * The followings are the available columns in table 'access_controllers':
 * @property integer $Contoller_ID
 * @property string $Controller_Name
 * @property string $Action
 * @property string $Status
 */
class AccessControllers extends CActiveRecord
  {

  //public $action_name;
  /**
   * Returns the static model of the specified AR class.
   * @return AccessControllers the static model class
   */
  public static function model($className = __CLASS__)
    {
    return parent::model($className);
    }

  /**
   * @return string the associated database table name
   */
  public function tableName()
    {
    return 'access_controllers';
    }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
    {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      //array('Contoller_ID, Controller_Name,', 'required'),
      array('Contoller_ID', 'numerical', 'integerOnly' => true),
      array('Controller_Name, Action,Display_Name', 'length', 'max' => 200),
      array('Status', 'length', 'max' => 100),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('Contoller_ID, Controller_Name, Action, Status,Display_Name', 'safe', 'on' => 'search'),
    );
    }

  /**
   * @return array relational rules.
   */
  public function relations()
    {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
    );
    }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
    {
    return array(
      'Contoller_ID' => 'Contoller ID',
      'Controller_Name' => 'Action Name',
      'Action' => 'Action',
      'Status' => 'Status',
      'Display_Name' => 'Display Name',
    );
    }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search()
    {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria = new CDbCriteria;

    $criteria->compare('Contoller_ID', $this->Contoller_ID);
    $criteria->compare('Controller_Name', $this->Controller_Name, true);
    $criteria->compare('Display_Name', $this->Display_Name, true);
    $criteria->compare('Action', $this->Action, true);
    $criteria->compare('Status', $this->Status, true);

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
      'pagination' => array('pageSize' => 20,), 'sort' => array('defaultOrder' => 't.Controller_Name ASC')
    ));
    }

  public function savepermission($array, $role, $ControllerID)
    {
    if ($role != '' && $ControllerID != '')
      {
      $sql = "delete from access_user_roll where access_user_roll.role_code='" . $role . "' AND access_user_roll.Contoller_ID='" . $ControllerID . "' ";
      $rawData = Yii::app()->db->createCommand($sql)->execute();

      if (count($array) > 0)
        {
        foreach ($array as $b)
          {
          //--insert new infor transfer table--
          $sql = "INSERT INTO access_user_roll(role_code,action_id,Contoller_ID) VALUES (" . $role . "," . $b . "," . $ControllerID . ")";
          $rawData = Yii::app()->db->createCommand($sql)->execute();
          }
        }
      return true;
      }
    else
      {
      Yii::app()->user->setFlash('success', "Please Select User Role and Contoller Name");
      }
    }

  public function PermissionReset()
    {
    $sql = "delete from access_user_roll where access_user_roll.ID";
    $rawData = Yii::app()->db->createCommand($sql)->execute();
    return true;
    }

  //---by sasanka--
  public function getAllcontrollers()
    {
    $controllers = array();
    $files = CFileHelper::findFiles(realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'controllers'));

    foreach ($files as $file)
      {
      $filename = basename($file, '.php');
      if (($pos = strpos($filename, 'Controller')) > 0)
        {
        $controllers[] = substr($filename, 0, $pos);
        }
      }
    $criteria = new CDbCriteria;
    $criteria = $controllers;

    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
      'pagination' => array('pageSize' => 200,),
    ));
    }

  public function getControllerName()
    {
    $data = "SELECT ID, Display_Name FROM access_controllers where Display_Name <> '' order by Display_Name";
    $rawData = Yii::app()->db->createCommand($data)->queryAll();
    //print_r($rawData);
    return $rawData;
    }

  public function getCreatetable($materialIds)
    {
    $data = "Select access_controllers.Display_Name, access_controllers.ID
            From access_controllers
            Where access_controllers.ID ='" . $materialIds . " '";

    $rawData = Yii::app()->db->createCommand($data)->queryAll();
    return $rawData;
    }

  public function addReflectionRights($actions, $controller)
    {
    if (count($actions) > 0)
      {
      $ids = "0";
      foreach ($actions AS $action)
        {
        $ids.="," . $action;
        }
      $sql = "DELETE FROM access_user_roll WHERE action_id IN(" . $ids . "); INSERT INTO access_user_roll values";
      $roles = Roles::model()->findAll();
      $first = true;
      foreach ($roles AS $role)
        {
        foreach ($actions AS $action)
          {
          if (!$first)
            {
            $sql.=",";
            }
          $sql.='(NULL,' . $role->rolecode . ',' . $controller . ',' . $action . ')';
          $first = false;
          }
        }

      $query = Yii::app()->db->createCommand($sql);
      $query->execute();
      }
    }

  }

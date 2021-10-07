<?php

/**
 * This is the model class for table "access_control_actions".
 *
 * The followings are the available columns in table 'access_control_actions':
 * @property integer $action_id
 * @property string $action_name
 * @property integer $controller_Id
 *
 * The followings are the available model relations:
 * @property AccessControllers $controller
 * @property AccessUserRoll[] $accessUserRolls
 */
class AccessControlActions extends CActiveRecord
  {

  /**
   * Returns the static model of the specified AR class.
   * @return AccessControlActions the static model class
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
    return 'access_control_actions';
    }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
    {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('action_name, controller_Id', 'required'),
      array('controller_Id', 'numerical', 'integerOnly' => true),
      array('action_name,Action_Display_Name', 'length', 'max' => 100),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('action_id, action_name, controller_Id,Action_Display_Name, controller.Display_Name', 'safe', 'on' => 'search'),
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
      'controller' => array(self::BELONGS_TO, 'AccessControllers', 'controller_Id'),
      'accessUserRolls' => array(self::HAS_MANY, 'AccessUserRoll', 'action_id'),
    );
    }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
    {
    return array(
      'action_id' => 'Action',
      'action_name' => 'Action Name',
      'controller_Id' => 'Controller',
      'Action_Display_Name' => 'Action Display Name',
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
    //$criteria->compare('action_id', $this->action_id);
    //$criteria->compare('action_name', $this->action_name, true);
    //$criteria->compare('Action_Display_Name', $this->Action_Display_Name, true);
    //$criteria->compare('controller_Id',$this->controller_Id);
    //$criteria->compare('controller.Display_Name', $this->controller_Id, true);
    //$criteria->with = array('controller' => array('select' => 'controller.Display_Name', 'together' => true));
    $criteria->compare('controller_Id', $this->controller_Id);
    return new CActiveDataProvider($this, array(
      'criteria' => $criteria,
      'pagination' => array('pageSize' => 30),
    ));
    }

  public function actionNews($id, $rol)
    {
    /* $cmd = "Select access_control_actions.Action_Display_Name,
      access_control_actions.action_name AS Action_Display_Name
      access_controllers.Display_Name,
      access_control_actions.action_id,
      access_controllers.ID
      From access_control_actions Inner Join
      access_controllers On access_control_actions.controller_Id =
      access_controllers.ID
      Where access_controllers.ID = '" . $id . "'"; */
    
    $cmd = "Select access_control_actions.action_name AS Action_Display_Name,
  				access_controllers.Display_Name,
 			   access_control_actions.action_id,
  				access_controllers.ID
				From access_control_actions Inner Join
  				access_controllers On access_control_actions.controller_Id =
    			access_controllers.ID
				Where access_controllers.ID = '" . $id . "'";
    $array = Yii::app()->db->createCommand($cmd)->queryAll();


    $cmd = "select action_id from access_user_roll where Contoller_ID = '" . $id . "' And role_code = '" . $rol . "'";
    $array1 = Yii::app()->db->createCommand($cmd)->queryAll();


    $path = array();

    if (count($array1) != 0)
      {
      for ($x = 0; $x < count($array); $x++)
        {
        $all = $array[$x]['action_id'];
        $path[$x]['status'] = '0';
        for ($y = 0; $y < count($array1); $y++)
          {

          $res = $array1[$y]['action_id'];

          if ($all == $res)
            {
            $path[$x]['action_id'] = $array[$x]['action_id'];
            $path[$x]['Display_Name'] = $array[$x]['Display_Name'];
            $path[$x]['Action_Display_Name'] = $array[$x]['Action_Display_Name'];
            $path[$x]['status'] = '1';
            }
          else
            {
            $path[$x]['action_id'] = $array[$x]['action_id'];
            $path[$x]['Display_Name'] = $array[$x]['Display_Name'];
            $path[$x]['Action_Display_Name'] = $array[$x]['Action_Display_Name'];
            }
          }
        }
      }
    else
      {
      for ($z = 0; $z < count($array); $z++)
        {
        $path[$z]['action_id'] = $array[$z]['action_id'];
        $path[$z]['Display_Name'] = $array[$z]['Display_Name'];
        $path[$z]['Action_Display_Name'] = $array[$z]['Action_Display_Name'];
        $path[$z]['status'] = '0';
        }
      }


    //print_r($path);exit;
    return($path);
    }

  }

?>
<?php

/* ?><?php
  function set_element(&$path, $data)
  {
  try
  {
  return ($key = array_pop($path)) ? set_element($path, array($key=>$data)) : $data;
  }
  catch(Exception $e)
  {
  echo $e->getMessage();
  }
  }
  ?><?php */?>
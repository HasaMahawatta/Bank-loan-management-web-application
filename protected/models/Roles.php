<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $rolecode
 * @property string $role
 */
class Roles extends CActiveRecord
    {

    /**
     * @return string the associated database table name
     */
    public function tableName()
        {
        return 'roles';
        }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
        {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('role,read_only,super_access', 'required'),
            array('last_update_date,last_update_by', 'required'),
            array('role', 'length', 'max' => 25),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rolecode, role', 'safe', 'on' => 'search'),
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
            'rolecode' => 'Rolecode',
            'role' => 'Role',
            'read_only' => 'Read Only',
            'super_access' => 'Full Access',
            'last_update_date' => 'Last Update',
            'last_update_by' => 'Last Update By'
        );
        }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
        {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('rolecode', $this->rolecode);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('super_access', $this->super_access, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
        }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Roles the static model class
     */
    public static function model($className = __CLASS__)
        {
        return parent::model($className);
        }

    }

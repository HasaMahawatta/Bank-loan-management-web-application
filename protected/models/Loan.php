<?php

/**
 * This is the model class for table "loan".
 *
 * The followings are the available columns in table 'loan':
 * @property integer $loanId
 * @property integer $user
 * @property string $createdDate
 * @property integer $loanType
 * @property integer $status
 */
class Loan extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'loan';
    }

    /**
     * Sort the models by a columns, defaults to priamry key
     * */
    public function defaultScope()
    {
        return array('order' => 'loanId DESC');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, createdDate, loanType, status', 'required'),
            array('user, loanType, status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('loanId, user, createdDate, loanType, status', 'safe', 'on' => 'search'),
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
            'loanTypeForLoan' => array(self::BELONGS_TO, 'LoanType', 'loanType'),
            'userForLoan'=>array(self::BELONGS_TO,'User','user')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'loanId' => 'Loan',
            'user' => 'User',
            'createdDate' => 'Created Date',
            'loanType' => 'Loan Type',
            'status' => 'Status',
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

        $criteria->compare('loanId', $this->loanId);
        $criteria->compare('user', $this->user);
        $criteria->compare('createdDate', $this->createdDate, true);
        $criteria->compare('loanType', $this->loanType);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Loan the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getstatusToName()
    {
        $status = array(0=>'Pending',1=>'Approved',2=>'Rejected');
        
        if(isset($status[$this->status]))
            return $status[$this->status];
        
        return "N/A";
        
    }
    
}

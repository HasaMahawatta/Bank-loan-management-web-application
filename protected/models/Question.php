<?php

/**
 * This is the model class for table "question".
 *
 * The followings are the available columns in table 'question':
 * @property integer $questionId
 * @property string $question
 * @property integer $loanType
 * @property integer $common
 * @property integer $answerType
 * @property integer $category
 */
class Question extends CActiveRecord
{

    public $QTYPE_MCQ=0;    
    public $QTYPE_STEXT=1;
    public $QTYPE_LTEXT=2;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'question';
    }

    /**
     * Sort the models by a columns, defaults to priamry key
     * */
    public function defaultScope()
    {
        return array('order' => 'questionId ASC');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question, common, answerType, questionCategory', 'required'),
            array('loanType, common, answerType, questionCategory', 'numerical', 'integerOnly' => true),
            array('question', 'length', 'max' => 512),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('questionId, question, loanType, common, answerType, category', 'safe', 'on' => 'search'),
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
            'questionId' => 'Question',
            'question' => 'Question',
            'loanType' => 'Loan Type',
            'common' => 'Common',
            'answerType' => 'Answer Type',
            'questionCategory' => 'Question Category'
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

        $criteria->compare('questionId', $this->questionId);
        $criteria->compare('question', $this->question, true);
        $criteria->compare('loanType', $this->loanType);
        $criteria->compare('common', $this->common);
        $criteria->compare('answerType', $this->answerType);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Question the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

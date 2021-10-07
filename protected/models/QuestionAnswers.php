<?php

/**
 * This is the model class for table "question_answers".
 *
 * The followings are the available columns in table 'question_answers':
 * @property integer $questionAnswerId
 * @property integer $QuestionId
 * @property string $answer
 * @property integer $marks
 */
class QuestionAnswers extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'question_answers';
    }

    /**
     * Sort the models by a columns, defaults to priamry key
     * */
    public function defaultScope()
    {
        return array('order' => 'questionAnswerId DESC');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('QuestionId, answer, marks', 'required'),
            array('QuestionId, marks', 'numerical', 'integerOnly' => true),
            array('answer', 'length', 'max' => 256),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('questionAnswerId, QuestionId, answer, marks', 'safe', 'on' => 'search'),
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
            'questionForAnswers' => array(self::BELONGS_TO, 'Question', 'QuestionId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'questionAnswerId' => 'Question Answer',
            'QuestionId' => 'Question',
            'answer' => 'Answer',
            'marks' => 'Marks',
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

        $criteria->compare('questionAnswerId', $this->questionAnswerId);
        $criteria->compare('QuestionId', $this->QuestionId);
        $criteria->compare('answer', $this->answer, true);
        $criteria->compare('marks', $this->marks);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QuestionAnswers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

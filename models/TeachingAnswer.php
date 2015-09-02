<?php

/**
 * This is the model class for table "Teaching".
 *
 * The followings are the available columns in table 'teaching':
 *
 */
class TeachingAnswer extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Question the static model class
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
        return 'teaching_answer';
    }
    
    public function rules()
    {
	     return array(
	    	array('created_at, created_by, updated_at, updated_by', 'required'),
	    	//array('name', 'NameUnique'),
	    	array('created_by, updated_by', 'numerical', 'integerOnly' => true),
        );

    }
}

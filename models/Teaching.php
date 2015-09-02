<?php

/**
 * This is the model class for table "Teaching".
 *
 * The followings are the available columns in table 'teaching':
 *
 */
class Teaching extends HActiveRecord
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
        return 'teaching';
    }
    
    public function rules()
    {
	     return array(
	    	array('name, created_at, created_by, updated_at, updated_by', 'required'),
	    	//array('name', 'NameUnique'),
	    	array('created_by, updated_by', 'numerical', 'integerOnly' => true),
        );

    }
    
    public static function getAnswers($questions, $teach) {
	    $answer = array();

		foreach($questions as $key=>$item) {
			if($item['type'] == 0) {
				if(isset($teach[$key])) {
					if($item['selected'] == $teach[$key])
						$answer[$key] = 1;
					else
						$answer[$key] = 0;
				} else
					$answer[$key] = 0;
				
			}
			
			if($item['type'] == 1) {
				$selected = explode(',', $item['selected']);
				
				if(isset($teach[$key])) {
					if(!array_diff($selected, $teach[$key]))
						$answer[$key] = 1;
					else 
						$answer[$key] = 0;
				} else
					$answer[$key] = 0;
				
			}
			
			if($item['type'] == 2) {
				$selected = explode(',', $item['selected']);
				asort($selected);

				$flag = false;
				$i = 0;
				if(isset($teach[$key])) {
					foreach($selected as $k=>$v) {
						if($k != $teach[$key][$i])
							$flag = true;
						
						$i++;
					}
					if($flag)
						$answer[$key] = 0;
					else
						$answer[$key] = 1;
				} else
					$answer[$key] = 0;
				

				
			}
		}
		
		return $answer;
    }
}

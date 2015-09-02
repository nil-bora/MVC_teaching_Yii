<?php

/**
 * Teaching
 *
 */
class AdminController extends Controller {

    public $subLayout = "application.modules_core.admin.views._layout";

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function behaviors() {
        return array(
            'SpaceControllerBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceControllerBehavior',
            ),
        );
    }

    public function actions() {
        return array(
            'stream' => array(
                'class' => 'application.modules.Teaching.TeachingStreamAction',
                'mode' => 'normal',
            ),
        );
    }
    public function actionIndex()
    {
	    $pages = Teaching::model()->findAll(array('index'=>'id'));
	    
	    foreach($pages as $key=>$page)
	    {
	    	if(!empty($page->space_id)) {
		    	$arrSpace = explode(',',$page->space_id);
		    	foreach($arrSpace as $k=>$v)
		    		if(empty($v))
		    			unset($arrSpace[$k]);
		    	
		    	$criteria = new CDbCriteria();
		    	$criteria->addInCondition("guid", $arrSpace);
		    	$page->space_id = '';
				foreach (Space::model()->findAll($criteria) as $defaultSpace) {
					$page->space_id .= $defaultSpace->name . ", ";
				}
	
	    	}
	    	
	    }
	   

        $this->render('index', array('pages' => $pages));
    }
    
    public function actionResults() {
    	
    	if(isset($_GET['id'])) {
	    	$id = (int)$_GET['id'];
	    	$oneTest = Teaching::model()->findByPk($id);
	    	
	    	if($oneTest) {
	    		//$teachingAnswer = TeachingAnswer::model()->find(array('user_id'=>Yii::app()->user->id));
	    		$teachingAnswer = TeachingAnswer::model()->findAll(array('order'=>'id DESC', 'condition'=>'teaching_id=:teaching_id', 'params'=>array(':teaching_id'=>$id)));
	    		
		    	$this->render('results', array('oneTest'=>$oneTest,
		    								   'teachingAnswer'=>$teachingAnswer));		    	
	    	}

    	}
    	
    }


    public function actionEdit() {

	    Yii::import('admin.forms.*');
	    $form = new BasicSettingsForm;
	    
	    
	    $page = Teaching::model()->findByPk(Yii::app()->request->getParam('id'));
       
        if ($page === null) {
            $page = new Teaching;
            $questions_json = json_encode("");
            $help_json = json_encode("");
        } else {
	        $questions_json = $page->question;
	        $help_json = $page->help;
        }
        
        
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-edit-form') {
            echo CActiveForm::validate($page);
            Yii::app()->end();
        }
       
       
        	
        if (isset($_POST['Teaching']) && $_POST['BasicSettingsForm']) {
        	
        	
        	$_POST['BasicSettingsForm'] = Yii::app()->input->stripClean($_POST['BasicSettingsForm']);
        	$_POST['Teaching'] = Yii::app()->input->stripClean($_POST['Teaching']);
        	//$_POST['Help'] = Yii::app()->input->stripClean($_POST['Help']);
        	
        	$typeQuestion = $_POST['Teaching']['type_question'];
        	unset($typeQuestion['question']);
        	unset($typeQuestion['question_type']);
        	unset($typeQuestion['question_type_text']);
        	unset($typeQuestion['answer']);
        	//typeQuestion = array_chunk($typeQuestion, 5, true);

        	$i=1;
        	$array = array();

        	foreach($typeQuestion as $key=>$item) {
	        	$index = preg_replace("/(\D)/", "", $key);
	        	$array[$index][$key] = $item;	        	       	
        	}
        	
        	$questions_data = array();
        	foreach($array as $k=>$v) {
	        	
	        	$question = preg_replace("/(\d)/", "", 'question'.$k);
	        	$question_type = preg_replace("/(\d)/", "", 'question_type'.$k);
	        	$question_type_text = preg_replace("/(\d)/", "", 'question_type_text'.$k);
	        	$answer = preg_replace("/(\d)/", "", 'answer'.$k);
	        	$question_type_radio = preg_replace("/(\d)/", "", 'question_type_radio'.$k);
	        	$question_type_checkbox = preg_replace("/(\d)/", "", 'question_type_checkbox'.$k);
	        	
	
	        	if($question == 'question')
	        		$questions_data[$k]['question'] = $v['question'.$k][0];
	        	
	        	if($question_type == 'question_type')
	        		$questions_data[$k]['type'] = $v['question_type'.$k][0];
	        	
	        	//print_r($v['question_type_radio'.$k]);
	        	
	        	if($question_type_radio == 'question_type_radio') {
			        if($v['question_type'.$k][0] == 0) {
			        	$questions_data[$k]['selected'] = $v['question_type_radio'.$k];
		        	}
	        	}
	        	
	        	if($question_type_checkbox == 'question_type_checkbox') {
			        if($v['question_type'.$k][0] == 1) {
			        	
			        	$questions_data[$k]['selected'] = implode(',',$v['question_type_checkbox'.$k]);
		        	}
	        	}
	        	
	        	if($question_type_text == 'question_type_text') {
			        if($v['question_type'.$k][0] == 2) {
			        	
			        	$questions_data[$k]['selected'] = implode(',',$v['question_type_text'.$k]);
		        	}
	        	}
	        	
	        	if($answer == 'answer') {
			        	$questions_data[$k]['answers'] = $v['answer'.$k];
	        	}
	        	
		
		}
		
		$questions_data = array_values($questions_data);
		
		$questions_json = json_encode($questions_data);
		
		$page->question = $questions_json;
		
		/*Help informations*/
		$help = $_POST['Help'];
		$help_data = array();
		if(isset($help['name'])) {
	        	foreach($help['name'] as $key=>$item) {
		        	if(isset($help['text'][$key])) {
			        	$help_data[$key]['name'] = $item;
			        	$help_data[$key]['text'] = htmlspecialchars(addslashes($help['text'][$key]));
		        	}
	        	}
	
	        	
	        	$help_data = array_values($help_data);
	        	$help_json = json_encode($help_data);
	        	
	        	$page->help = $help_json;
		}
		/*Help informations*/
		
		$page->name = $_POST['Teaching']['name'];
		$page->date_start = $_POST['Teaching']['date_start'];
		$page->date_end = $_POST['Teaching']['date_end'];
		$page->duration = $_POST['Teaching']['duration'];
		$page->visibility = $_POST['Teaching']['visibility'];
		$page->many = $_POST['Teaching']['many'];
		
		$page->space_id = $_POST['BasicSettingsForm']['defaultSpaceGuid'];
	
		$page->description = $_POST['description'];
            //$page->attributes = $_POST['Teaching'];
           
            if ($page->validate()) {
                if($page->save())
                	$this->redirect(Yii::app()->createUrl('//teaching/admin'));
                else {
	                echo "<pre>";
					print_r($page->getErrors());
                }
            }
            
        }

		$root=array();
		//$pages = Teaching::model()->findAll();
		$space_id = explode(",", $page->space_id);
		foreach($space_id as $key=>$item)
		{
			if(empty($item))
				unset($space_id[$key]);
		}
		foreach (Space::model()->findAllByAttributes(array('guid' => $space_id)) as $defaultSpace) {

                $form->defaultSpaceGuid .= $defaultSpace->guid . ",";
        }
		
		
        $this->render('edit', array(
        	'page' => $page,
        	'model'=>$form,
        	'root' => $root,
        	'questions_json' => $questions_json,
        	'help_json' => $help_json
        ));

    }

	
}

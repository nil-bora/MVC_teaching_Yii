<?php

/**
 * Teaching
 *
 */
class TeachingController extends Controller {

    public $subLayout = "application.modules_core.space.views.space._layout";

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
    
    public function checkSpace($array) {
	    
	    if(isset($array) && !empty($array)) {
			
			$now_space = Yii::app()->getController()->getSpace()->guid;
		    foreach($array as $key=>$page)
		    {
		    	if(!empty($page->space_id)) {
			    	$arrSpace = explode(',',$page->space_id);
			    	foreach($arrSpace as $k=>$v)
			    		if(empty($v))
			    			unset($arrSpace[$k]);
			    	
			    	if(!in_array($now_space, $arrSpace))
			    		unset($array[$key]);
		    	}
		    }
		    return $array;    
	    }
    }
    
    public function actionShow() {
        $teaching = Teaching::model()->findAllByAttributes(array('visibility'=>1));
       
        $teaching = $this->checkSpace($teaching);
        
        $this->render('show', array('teaching'=>$teaching));
    }
    
    public function actionTest() {
    	if($_GET['id']) {
	    	$id = (int)$_GET['id'];
	    	$oneTest = Teaching::model()->findByPk($id);
	    	
	    	if($oneTest) {
	    		//$teachingAnswer = TeachingAnswer::model()->find(array('user_id'=>Yii::app()->user->id));
	    		$hideLink = 0;
	    		$teachingAnswer = TeachingAnswer::model()->findAll(array('order'=>'id DESC', 'condition'=>'user_id=:user_id AND teaching_id=:teaching_id', 'params'=>array(':user_id'=>Yii::app()->user->id, ':teaching_id'=>$id)));
	    		

	    		if($oneTest['many']!=1)
					$hideLink = 1;
	    		
	    		if(isset($_GET['poh']) && $_GET['poh'] == 1)
	    			$hideLink = 0;
	    			
		    	$this->render('test', array('test'=>$oneTest,
		    								'hideLink'=>$hideLink,
		    								'teachingAnswer'=>$teachingAnswer));		    	
	    	}

    	}
	   
    }
    
    public function actionQuestion() {
	    if($_GET['id']) {
		    $id = (int)$_GET['id'];
		   // $qid = (int)$_GET['qid'];
		    
		    if(isset($_GET['del']) && $_GET['del']==1){
			    Yii::app()->session->remove('step');
			    Yii::app()->session->remove('dateStart');
			    Yii::app()->session->remove('teach');
			    Yii::app()->session->remove('timer');

		    }
		    	
		    $oneTest = Teaching::model()->findByPk($id);
		    if($oneTest) {
			    
			    if(!isset(Yii::app()->session['step'][$id]))
			    	Yii::app()->session->add('step', array($id=>1));
	    		
	    		$qid = Yii::app()->session['step'][$id];
	    		
	    		if($qid == 1 && !isset(Yii::app()->session['dateStart'][$id]))
	    			Yii::app()->session->add('dateStart', array($id=>time()));
	    		
	    		if(!isset(Yii::app()->session['teach'][$id]))
	    			Yii::app()->session->add('teach', array($id => array($qid => array())));
	    		
	    		$timeStart = Yii::app()->session['dateStart'][$id];
	    		
	    		
	    		$timer = $oneTest->duration*60-(time()-$timeStart);
	    		
/*
	    		$timer['h']=floor($timer['seconds']/3600);
				$timer['m']=floor(($timer['seconds']%3600)/60);
				$timer['s']=($timer['seconds']%3600)%60;
*/
	    		
	    		
	    		
		    	$questions = json_decode($oneTest->question, true);
		    	
		    	Yii::app()->session->add('timer', array($id=>$timer));
		    	
		    	if($qid>sizeof($questions) && isset(Yii::app()->session['teach'][$id])) {
			    	
			    	
			    	
			    	Yii::app()->request->redirect($this->createUrl('//teaching/teaching/finish', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $id)), true);
		    	}
	    		

		    	$current = $qid-1;

		    	if(isset($questions[$current])) {
			    	$question = $questions[$current]; /* Выбор текущего вопроса (?) */
	
			    	$this->render('question', array(
			    						'question'=>$question, 
			    						'current'=>$current,
			    						'id'=>$id,
			    						'qid'=>$qid,
			    						'timer'=>$timer,
			    						'count'=>sizeof($questions),
			    						'oneTest'=>$oneTest
			    						));
		    	}
			    				    		    	
		    }

	    }

    }
    
    public function actionFinish() {
    	
    	if(isset($_GET['del']) && $_GET['del']==1) {
		   	Yii::app()->session->remove('step');
		} 
		   	
		if(isset($_GET['id'])) {
			$id = (int)$_GET['id'];
			
			$oneTest = Teaching::model()->findByPk($id);
			
			if(!isset(Yii::app()->session['timer'][$id])) {
				Yii::app()->request->redirect($this->createUrl('//teaching/teaching/test', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $id)), true);
				
			}
			$questions = json_decode($oneTest->question, true);
			
			if(isset(Yii::app()->session['teach'][$id]) && Yii::app()->session['step'][$id] > sizeof($questions)) {

				$teach = Yii::app()->session['teach'][$id];
				$teach = array_values($teach);
				
				$answer = Teaching::getAnswers($questions, $teach);

				$answerTrue = array();
				foreach($answer as $key=>$item)
					if($item!=0)
						$answerTrue[$key] = $item;
				
				$procent = ceil(sizeof($answerTrue)*100/sizeof($answer));
				
				$teachingAnswer = new TeachingAnswer();
				
				
				
				//$user = User::model()->findByPk(Yii::app()->user->id);
				
				$teachingAnswer->user_id = Yii::app()->user->id;
				$teachingAnswer->teaching_id = $id;
				$teachingAnswer->answers = json_encode($teach);
				$teachingAnswer->result = $procent;
			
				if(isset(Yii::app()->session['timer'][$id])) {
					
					$timer = Yii::app()->session['timer'][$id];
					
					$timers = array();
					if(($oneTest->duration*60 - $timer) >0)
						$timers['second'] = $oneTest->duration*60 - $timer;
					else
						$timers['second'] = $oneTest->duration*60;
					
					$timers['h']=floor($timers['second']/3600);
					$timers['m']=floor(($timers['second']%3600)/60);
					$timers['s']=($timers['second']%3600)%60;
					$teachingAnswer->time = $timer;

				}
				
				
				if($teachingAnswer->validate()) {
					
					$teachingAnswer->save();
					
					Yii::app()->session->remove('teach');
					Yii::app()->session->remove('step');
					Yii::app()->session->remove('timer');
					Yii::app()->session->remove('dateStart');
				}

					
				
				$this->render('finish', array('answer'=>$answer, 
											  'answerTrue'=>$answerTrue,
											  'procent'=>$procent,
											  'timers'=>$timers,
											  'oneTest'=>$oneTest));		
			}
		}
		
		
		
		   	
	    
    }
    
    public function actionInformation() {
    	if(isset($_GET['id']) && isset($_GET['idq'])) {
	    	$id = (int)$_GET['id'];
	    	$idq = (int)$_GET['idq'];
	    	
	    	$oneTest = Teaching::model()->findByPk($id);
	    	$information = json_decode($oneTest->help, true);
	    	$one_info = $information[$idq];
	    	$this->render('information', array('info'=>$one_info, 'id'=>$id));
    	}
	    
    }
    
    public function actionTimeEnd() {

	     if(isset($_POST['id'])) {
	     	
		     $id = (int)$_POST['id'];
		     $oneTest = Teaching::model()->findByPk($id);
		     if($oneTest) {
				$questions = json_decode($oneTest->question, true);
				
				//$timeStart = Yii::app()->session['dateStart'][$id];
	    		
	    		//$timer = $oneTest->duration*60-(time()-$timeStart);
				
				Yii::app()->session->add('timer', array($id=>$oneTest->duration*60));
				Yii::app()->session->add('step', array($id=>sizeof($questions)+1));
				
				header('Content-type: application/json');
				echo json_encode(array('ok'=>1)); 
				Yii::app()->end();
		     }
	     }
    }
    
    public function actionCheckQuestion() {
	    

	    if(isset($_POST['type']) && isset($_POST['id']) && isset($_POST['qid'])) {
		    
		    $data = (isset($_POST['data']) ? $_POST['data'] : array());
		    $type = (int)$_POST['type'];
		    $id = (int)$_POST['id'];
		    $qid = (int)$_POST['qid'];
			
		    if(!isset(Yii::app()->session['teach'][$id])) {
		    	$teach = array();
		    	$teach[$id] = array($qid => $data);
		    	Yii::app()->session->add('teach', array($id => array($qid => $data)));
		    } else {
		    	$teach = Yii::app()->session['teach'][$id];
		    	if(isset($teach)) {
			    	foreach($teach as $k=>$v) {
				    	if($k == $qid)
				    		$teach[$k] = $data;
				    	else
				    		$teach[$qid] = $data;
			    	}
		    	}
		    	Yii::app()->session->add('teach', array($id=>$teach));
		    }
		    
		    if(isset(Yii::app()->session['step'][$id])) {
			    $qid = Yii::app()->session['step'][$id];

			    Yii::app()->session->add('step', array($id=>$qid+1));
		    }
		    
	    }
	    
	    header('Content-type: application/json');
		echo json_encode(array('ok'=>1, 'qid'=>$qid)); 
		Yii::app()->end();
	    
    }
    


    public function actionCreate() {

    }
}

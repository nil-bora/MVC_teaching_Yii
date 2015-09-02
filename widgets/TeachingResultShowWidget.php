<?php

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Luke
 */
class TeachingResultShowWidget extends HWidget {

	public $data_user;
	public $teachingAnswer;
	public $oneTest;
	public $in_admin; 
	
    public function run() {
	    
	   
	  
		$data = array();
		$data_user = array();
		if($this->teachingAnswer) {
			foreach($this->teachingAnswer as $one) {
				
				$questions = json_decode($this->oneTest->question, true);
				$teach = json_decode($one->answers, true);

				//list($imp) = Yii::app()->createController('TeachingController');

	    		$answer = Teaching::getAnswers($questions, $teach);

	    		$answerTrue = array();
				foreach($answer as $key=>$item)
					if($item!=0)
						$answerTrue[$key] = $item;
				
				$procent = ceil(sizeof($answerTrue)*100/sizeof($answer));
				
				if($one['time']) {
					
					$timer = $one['time'];
					
					$timers = array();
					if(($this->oneTest->duration*60 - $timer) >0)
						$timers['second'] = $this->oneTest->duration*60 - $timer;
					else
						$timers['second'] = $this->oneTest->duration*60;

					$timers['h']=floor($timers['second']/3600);
					$timers['m']=floor(($timers['second']%3600)/60);
					$timers['s']=($timers['second']%3600)%60;
	
				}
				$user = User::model()->findByPk($one->user_id);

				$data['username'] = $user->username;
				$data['created'] = $one->created_at;
				$data['answer'] = $answer;
				$data['procent'] = $procent;
				$data['answerTrue'] = $answerTrue;
				$data['timers'] = $timers;
				
				array_push($data_user, $data);
			}
			
		}
		
	    if($this->in_admin)
        	$this->render('resultAdminUser', array('data_user'=>$data_user, 'name'=>$this->oneTest->name));
        else
        	$this->render('resultUser', array('data_user'=>$data_user));
    }

}

?>
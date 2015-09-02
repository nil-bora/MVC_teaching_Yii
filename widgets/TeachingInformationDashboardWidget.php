<?php

class TeachingInformationDashboardWidget extends HWidget
{
	
	public function init() {

    }
	
    public function run()
    {
	    if(isset($_GET['id']) ){
			$id = $_GET['id'];
			$oneTest = Teaching::model()->findByPk($id);
			if(isset($oneTest['help']) && !empty($oneTest['help'])) {
				$information = json_decode($oneTest['help'], true);

				$this->render('informationPanel', array('information'=>$information, 'id'=>$id, 'oneTest'=>$oneTest));	
			}
			
		}
    }

}

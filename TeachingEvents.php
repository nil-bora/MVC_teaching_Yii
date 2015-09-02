<?php

class TeachingEvents
{
    
    public static function onDashboardSidebarInit($event)
    {

	    if(Yii::app()->controller->module->id == 'teaching' && Yii::app()->controller->action->id == 'question')
	    {
	    	 $event->sender->addWidget('application.modules.teaching.widgets.TeachingDashboardWidget', array(), array('sguid'=>$_GET['sguid'])); 
        // Check for Admin Menu Pages to insert		   
	    }
        
    }
    
    public static function onInformationDashboardSidebarInit($event)
    {
    	if(Yii::app()->controller->action->id == 'test' || Yii::app()->controller->action->id == 'information') {
	    	$event->sender->addWidget('application.modules.teaching.widgets.TeachingInformationDashboardWidget', array(), array('sguid'=>$_GET['sguid'])); 
	    
	    }
    }

}

<?php

Yii::app()->moduleManager->register(array(
    'id' => 'teaching',
    'class' => 'application.modules.teaching.TeachingModule',
    'import' => array(
        'application.modules.teaching.models.*',
        'application.modules.teaching.behaviors.*',
        'application.modules.teaching.*',
    ),
    // Events to Catch 
    'events' => array(
        array(
        	'class' => 'SpaceMenuWidget',
        	'event' => 'onInit',
        	'callback' => array('TeachingModule', 'onSpaceMenuInit')
        ),
        array('class' => 'SpaceSidebarWidget', 'event' => 'onInit', 'callback' => array('TeachingEvents', 'onDashboardSidebarInit')),
        array('class' => 'SpaceSidebarWidget', 'event' => 'onInit', 'callback' => array('TeachingEvents', 'onInformationDashboardSidebarInit')),
    ),
));
?>
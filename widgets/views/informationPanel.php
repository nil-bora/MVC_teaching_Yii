<div class="panel panel-default panel-tour" id="getting-started-panel">
    <div class="panel-heading">
    	<span>
	    	<?php echo $oneTest['name'];//Yii::t('TeachingModule.base', 'Useful information'); ?>
        </span>
    </div>
    <div class="panel-body panel-body-test">
	    <?php if(is_array($information)):?>
	    	<ul class="list-group">
	    	<?php foreach($information as $key=>$one):?>
	    		<li class="list-group-item"><a  href="<?php echo $this->createUrl('//teaching/teaching/information', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $id, 'idq' => $key));?>" <?php if(isset($_GET['idq']) && $key==$_GET['idq']):?>class="active"<?php endif;?>><?php echo $one['name'];?></a></li>
	    	<?php endforeach;?>
	    	</ul>
	    <?php endif;?>
	    
	    <?php if(Yii::app()->controller->action->id == 'information'):?>
	    	<div class="test-btn-wr">
	    		<a href="<?php echo $this->createUrl('//teaching/teaching/test', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $id));?>" class="test-btn"><?php echo Yii::t('TeachingModule.base', 'Go test'); ?></a>
	    	</div>
	    <?php endif;?>
    </div>
</div>

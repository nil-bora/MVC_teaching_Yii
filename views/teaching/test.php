<div class="test-box">
	<h2 class="test-title"><?php echo $test->name;?></h2>
	<a class="all-test" href="<?php echo $this->createUrl('//teaching/teaching/show', array('sguid' => Yii::app()->getController()->getSpace()->guid));?>"><?php echo Yii::t('TeachingModule.base', 'All tests'); ?></a>
	<div class="test-description">
		<?php echo $test->description;?>
	</div>
	<p class="test-time-box"><span class="test-time-title"><?php echo Yii::t('TeachingModule.base', 'Time go test'); ?></span> <span class="test-time-number"><?php echo $test->duration;?></span></p>
	<?php $this->widget('application.modules.teaching.widgets.TeachingResultShowWidget', array('oneTest'=>$test,
																							   'teachingAnswer'=>$teachingAnswer)); ?>
	<?php if($hideLink==0):?>
	<div class="test-btn-wr"><a class="test-btn" href="<?php echo $this->createUrl('//teaching/teaching/question', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $test->id));?>" ><?php echo Yii::t('TeachingModule.base', 'Test start'); ?></a></div>
	<?php endif;?>
</div>


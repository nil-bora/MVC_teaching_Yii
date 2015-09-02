<div class="test-box test-box-result">
	<h2 class="test-title"><?php echo $oneTest['name'];?></h2>
	<div class="box-result">
		<h2 class="box-result-title"><?php echo Yii::t('TeachingModule.base', 'Your result'); ?>:</h2>
		<h3 class="box-result-details">
			<span class="main-test-number"><?php echo  $procent;?> %</span>
			<span class="main-test-count"><?php echo sizeof($answerTrue);?> <?php echo Yii::t('TeachingModule.base', 'Answer is'); ?><?php echo sizeof($answer);?></span>
		</h3>
		<p class="main-test-time">за <?php if($timers['m']) echo $timers['m']."  минут ";?><?php if($timers['s']) echo $timers['s']." секунд";?></p>
	</div>	
		<?php if($oneTest['many'] == 1):?>
			<a class="test-btn" href="<?php echo $this->createUrl('//teaching/teaching/test', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $oneTest['id']))?>"><?php echo Yii::t('TeachingModule.base', 'Restart test'); ?></a>
		<?php endif;?>
</div>
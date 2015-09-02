<div class="panel panel-timer" id="getting-started-panel">
    <div class="panel-heading panel-count">
    	<div class="count-box">
    		<span class="countdownHolder-title"><?php echo Yii::t('TeachingModule.base', 'You have'); ?></span>
        	<div id="countdown"></div>
        </div>
    </div>
</div>
<script src="/js/jquery.countdown.js"></script>
<script>
	$(function(){
	
	ts = (new Date()).getTime() + <?php echo $timer;?>*1000;
	var id = <?php echo $id;?>;
	var url = '<?php echo $this->createUrl('//teaching/teaching/finish', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $id));?>';
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days,hours, minutes, seconds){
			
			if(days == 0)	
				$('.countDays').hide();
			if(days == 0 && hours == 0 && minutes == 0 && seconds == 0) {
				$.post('index.php?r=teaching/teaching/TimeEnd/', {'id': id}, function (res) {
					if(res.ok) {
						window.location.href = url;
					}
				}, 'JSON');
				
			}
		}
	});
	
});
</script>
<div class="test-box">
	<h2 class="test-title"><?php echo $oneTest['name']?></h2>
	<h3 class="test-question"><?php echo $question['question'];?></h3>
	<strong class="question-count"><?php echo $qid;?> из <?php echo $count;?></strong>
	<div class="test-list-question">
	<?php if($question['type'] == 0):?>
		<?php foreach($question['answers'] as $key=>$one):?>			
			<div class="test-row">							
				<label class="test-label type-radio">
					<input type="radio" value="<?php echo $key;?>" name="question_type_input" class="test-input"/>
					<span class="input-bg"><b class="input-border"></b></span>
					<span class="label-text"><?php echo $one;?></span>
				</label>
			</div>
		<?php endforeach;?>
	<?php elseif($question['type'] == 1):?>
		<div class="question-descr"><?php echo Yii::t('TeachingModule.base', 'Select many answer'); ?></div>	
		<?php foreach($question['answers'] as $key=>$one):?>
			
			<div class="test-row">		
				<label class="test-label type-checkbox">
					<input type="checkbox" value="<?php echo $key;?>" name="question_type_checkbox" class="test-input"/>
					<span class="input-bg"><b class="input-border"></b></span>
					<span class="label-text"><?php echo $one;?></span>
				</label>
			</div>
		<?php endforeach;?>
	<?php elseif($question['type'] == 2):?>
	<div class="question-descr"><?php echo Yii::t('TeachingModule.base', 'Sort answer priority'); ?></div>	
	<div class="type-rating">	
		<ul id="sortable">
			<?php foreach($question['answers'] as $key=>$one):?>
				<li class="test-row" data-value="<?php echo $key;?>"><?php echo $one;?></li>
			<?php endforeach;?>
		</ul>
	</div>
	<?php endif;?>
	</div>
		<div class="test-btn-right-wr"><a href="<?php echo $this->createUrl('//teaching/teaching/question', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $id));?>" class="next-question"><?php echo Yii::t('TeachingModule.base', 'Next'); ?></a></div>
	
	<?php /*echo "<pre>"; print_r($question);*/?>
</div>




<script src="/js/jquery-ui.min.js"></script>
<script>
	
	$( "#sortable" ).sortable();
    //$( "#sortable" ).disableSelection();
	var type = <?php echo $question['type'];?>;
	var id = <?php echo $id;?>;
	var qid = <?php echo $qid;?>;
	$('.next-question').on('click', function(e) {
		e.preventDefault();
		var $this = $(this),
			href = $this.attr('href'),
			data = [];
			
		if(type == 0)
			data = $('input[name="question_type_radio"]:checked').val();
		else if(type == 1) {
			$('input[name="question_type_checkbox"]:checked').each(function(i) {
			   data[i] = $(this).val();

			});
		} else if(type == 2) {
			$('#sortable li').each(function(i) {
				data[i] = $(this).data('value');
			})
		}
		//console.log(data);
		/* Generate link for POST*/
		$.post('index.php?r=teaching/teaching/CheckQuestion/', {'data': data, 'type': type, 'id': id, 'qid': qid}, function (res) {
			if(res.ok && res.qid) {
				window.location.reload();
				//console.log(1);
			}
		}, 'JSON');

		
	});
</script>
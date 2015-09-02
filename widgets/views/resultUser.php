
<?php if($data_user):?>
<h2 class="test-title"><?php echo Yii::t('TeachingModule.base', 'Your result'); ?><span class="arrow"></span></h2>
	<table border='1' class="test-result">
		<tr>
			<th class="test-result-date"><?php echo Yii::t('TeachingModule.base', 'Date'); ?></th>
			<th><?php echo Yii::t('TeachingModule.base', 'Time'); ?></th>
			<th class="test-result-count"><?php echo Yii::t('TeachingModule.base', 'Count'); ?></th>
			<th>%</th>
		</tr>
	<?php foreach($data_user as $one):?>

			<tr>
				<td class="test-result-date"><?php echo $one['created'];?></td>
				<td><?php if($one['timers']['m']) echo $one['timers']['m']." Минут ";?><?php if($one['timers']['s']) echo $one['timers']['s']." Секунд";?></td>
				<td class="test-result-count"><?php echo sizeof($one['answerTrue']);?> / <?php echo sizeof($one['answer']);?></td>
				<td><?php echo $one['procent']." %";?></td>
			</tr>
	<?php endforeach;?>
	</table>
<?php endif;?>
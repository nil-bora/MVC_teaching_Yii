<?php if($data_user):?>
<div class="test-box">
	<h2 class="test-title"><?php echo $name;?></h2>
	<a class="back-test" href="<?php echo $this->createUrl('//teaching/admin', array());?>"><?php echo Yii::t('TeachingModule.base', 'Back'); ?></a>
	<h3 class="test-title"><?php echo Yii::t('TeachingModule.base', 'Your result'); ?></h3>
		<table border='1' class="test-result">
			<tr>
				<th><?php echo Yii::t('TeachingModule.base', 'User'); ?></th>
				<th><?php echo Yii::t('TeachingModule.base', 'Date'); ?></th>
				<th><?php echo Yii::t('TeachingModule.base', 'Time'); ?></th>
				<th><?php echo Yii::t('TeachingModule.base', 'Count'); ?></th>
				<th>%</th>
				
				
			</tr>
		<?php foreach($data_user as $one):?>
	
				<tr>
					<td><?php echo $one['username'];?></td>
					<td><?php echo $one['created'];?></td>
					<td><?php if($one['timers']['m']) echo $one['timers']['m']." Минут ";?><?php if($one['timers']['s']) echo $one['timers']['s']." Секунд";?></td>
					<td><?php echo sizeof($one['answerTrue']);?> / <?php echo sizeof($one['answer']);?></td>
					<td><?php echo $one['procent']." %";?></td>
				</tr>
		<?php endforeach;?>
		</table>
	<?php else:?>
	<h3 class="test-title-sub"><?php echo Yii::t('TeachingModule.base', 'No results'); ?></h3>
</div>
<?php endif;?>
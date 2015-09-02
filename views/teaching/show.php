<?php  //echo Yii::app()->getController()->getSpace()->guid;?>

<?php if($teaching):?>
	<div class="test-box">
		<h2 class="test-title"><?php echo Yii::t('TeachingModule.base', 'Test now'); ?></h2>
		<ul class="test-list">
		<?php foreach($teaching as $one):?>
			<li class="test-item"><a href="<?php echo $this->createUrl('//teaching/teaching/test', array('sguid' => Yii::app()->getController()->getSpace()->guid, 'id' => $one->id))?>"><?php echo $one->name;?></a></li>
		<?php endforeach;?>
		</ul>
	</div>
<?php endif;?>

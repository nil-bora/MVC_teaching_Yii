
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('TeachingModule.base', 'Education'); ?></div>
    <div class="panel-body">

        <?php echo HHtml::link(Yii::t('TeachingModule.base', 'Create new anket'), $this->createUrl('edit'), array('class' => 'btn btn-primary')); ?>

        <p />
        <p />



            <table class="table">
                <tr>
                    <th><?php echo Yii::t('TeachingModule.base', 'Name'); ?></th>
                    <th><?php echo Yii::t('TeachingModule.base', 'Space'); ?></th>
                    <th><?php echo Yii::t('TeachingModule.base', 'Date Start'); ?></th>
                    <th><?php echo Yii::t('TeachingModule.base', 'Date End'); ?></th>
                    <th><?php echo Yii::t('TeachingModule.base', 'Active'); ?></th>
                    <th>&nbsp;</th>
                </tr>
                	<?php if($pages):?>
	                    <?php foreach($pages as $page):?>
	                    <tr>
	                        <td><?=$page->name;?></td>
	                        <td><?php echo substr($page->space_id, 0, -2);?></td>
	                        
	                        <td><?=$page->date_start;?></td>
	                        <td><?=$page->date_end;?></td>
	                        <td><?php echo ($page->visibility == 1 ? 'Да' : 'Нет');?></td>
	                        <td><?php echo HHtml::link(Yii::t('TeachingModule.base', 'Results'), $this->createUrl('results', array('id' => $page->id)), array('class' => 'btn btn-primary btn-xs pull-right')); ?></td>
	                        <td><?php echo HHtml::link(Yii::t('TeachingModule.base', 'Edit'), $this->createUrl('edit', array('id' => $page->id)), array('class' => 'btn btn-primary btn-xs pull-right')); ?></td>
	                    </tr>
	                    <?php endforeach;?>
                    <?php endif;?>

            </table>

    </div>
</div>



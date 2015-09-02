
<div class="panel panel-default">
	<?php if (!$page->isNewRecord) : ?>
		<div class="panel-heading"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Edit anket'); ?></div>
	<?php else: ?>
		<div class="panel-heading"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Create anket'); ?></div>
	<?php endif; ?>
	<div class="panel-body">

		<?php
		$form = $this->beginWidget('HActiveForm', array(
			'id' => 'page-edit-form',
			'enableAjaxValidation' => false,
		));
		?>

		<div class="group1">
			<div class="form-group">
				<?php echo $form->labelEx($page, Yii::t('TeachingModule.views_admin_edit', 'Page title')); ?>
				<?php echo $form->textField($page, 'name', array('class' => 'form-control', 'placeholder' => Yii::t('TeachingModule.views_admin_edit', 'Page title'))); ?>
			</div>
			<div class="form-group">
				<?php /*$this->widget('application.extensions.tinymce.ETinyMce', array('name'=>'html', 'model'=>$model, 'options'=>array('language'=>'ru', 'editor' =>'full'))); */?>
				
				<?php echo $form->labelEx($page, Yii::t('TeachingModule.views_admin_edit', 'Description')); ?>
				<?php $this->widget('application.extensions.ckeditor.CKEditor', array(
				'model'=>$page,
				'name'=>'description',
				'editorTemplate'=>'basic',
				'language'=>'ru',
				'value'=>$page->description,

				));  ?>
				<?php /*echo $form->textArea($page, 'description', array('class' => 'form-control', 'placeholder' => Yii::t('TeachingModule.views_admin_edit', 'Description'))); */?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($model, Yii::t('TeachingModule.views_admin_edit', 'Space')); ?>
				<?php echo $form->textField($model, 'defaultSpaceGuid', array('class' => 'form-control', 'id' => 'space_select')); ?>
				<?php
				$this->widget('application.modules_core.space.widgets.SpacePickerWidget', array(
					'inputId' => 'space_select',
					'model' => $model,
					'attribute' => 'defaultSpaceGuid'
				));
				?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($page, Yii::t('TeachingModule.views_admin_edit', 'Date Start')); ?>
				<?php echo $form->textField($page, 'date_start', array('class' => 'form-control hhtml-datetime-field', 'data-options-displayFormat'=>'DD-MM-YYYY hh:mm', 'placeholder' => Yii::t('TeachingModule.views_admin_edit', 'Date Start'))); ?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($page, Yii::t('TeachingModule.views_admin_edit', 'Date End')); ?>
				<?php echo $form->textField($page, 'date_end', array('class' => 'form-control hhtml-datetime-field', 'data-options-displayFormat'=>'DD-MM-YYYY hh:mm', 'placeholder' => Yii::t('TeachingModule.views_admin_edit', 'Date end'))); ?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($page, Yii::t('TeachingModule.views_admin_edit', 'Duration')); ?>
				<?php echo $form->textField($page, 'duration', array('class' => 'form-control', 'placeholder' => Yii::t('TeachingModule.views_admin_edit', 'Duration'))); ?>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($page,Yii::t('TeachingModule.views_admin_edit', 'Visibility')); ?>
				<?php echo $form->checkBox($page,'visibility', array('class' => 'form-control')); ?>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($page,Yii::t('TeachingModule.views_admin_edit', 'Many')); ?>
				<?php echo $form->checkBox($page,'many', array('class' => 'form-control')); ?>
			</div>
		</div>
		
		<div class="group2">

			<h2 class="panel-heading panel-heading-question"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Questions'); ?></h2>
			<style>
				.none{
					display:none;
				}
			</style>
			<div class="form-group" id="questions">
				<div>
				<div id="no-questions" class="none">
					<p><?php echo Yii::t('TeachingModule.views_admin_edit', 'You no questions'); ?></p>
				</div>
				<div class="question none" id="question-template">
					<div class="one-question">
						<div class="form-group-title"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Question'); ?></div>
						<textarea class="form-control form-control-left" name="Teaching[type_question][question][]"></textarea>
						<a class="btn btn-danger btn-xs question-remove"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Delete questions'); ?></a>
						<div class="form-group-title"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Variant'); ?></div>
						<select class="type form-control" name="Teaching[type_question][question_type][]">
							<option value="0"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Has one'); ?></option>
							<option value="1"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Has many'); ?></option>
							<option value="2"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Priorytet'); ?></option>
						</select>
						<div class="answers">
							<div class="form-group-title"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Answer'); ?></div>
							<div class="answer">
								<div class="answer-type">
									<input type="radio" value="0" class="none" name="Teaching[type_question][question_type_radio]">
									<input type="checkbox" value="0" class="none" name="Teaching[type_question][question_type_checkbox][]">
									<input type="text" value="0" class="none rating" name="Teaching[type_question][question_type_text][]">
								</div>
								<textarea class="form-control" placeholder="Вариант ответа" name="Teaching[type_question][answer][]"></textarea>
								<a class="btn btn-primary btn-xs answer-add"><i class="fa fa-plus"></i></a>
								<a class="btn btn-danger btn-xs answer-remove"><i class="fa fa-minus"></i></a>
							</div>
						</div>
						<!--<a class="btn btn-danger btn-xs question-remove"><i class="fa fa-minus"></i></a>-->
					</div>
				</div>

				<script type="text/javascript" src="/js/moment-with-locales.min.js"></script>
				<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
				<script type="text/javascript" src="/js/datetimefield-teacher-init.js"></script>

				<a class="btn btn-primary btn-xs question-add"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Add question'); ?></a>
				</div>
				<script>
					(function(){
						var questions_data=jQuery.parseJSON('<?php echo $questions_json; ?>'),
							container=$('#questions'),
							template=$('#question-template');
						
						container.on('click', '.question-add', function(e){
							e.preventDefault();
							var question=template.clone();

							question.removeAttr('id');
							question.insertBefore(this);
							question.slideDown();
							
							question.find('select.type').trigger('change');

							question.find('[name]').each(function(){
								var name=$(this).attr('name');
								
								$(this).attr('name', name.replace('][]', question.index()+'][]'));
							});

							question.find('input[type="radio"]').each(function(){
								var name=$(this).attr('name').slice(0, - 1);

								$(this).attr('name', name+question.index()+']');
							});							

							correct_no_questions();
							correct_answer_remove();
						});

						container.on('click', '.question-remove', function(e){
							e.preventDefault();
							var question=$(this).closest('.question');

							question.slideUp(function(){
								$(this).remove();
							});

							correct_no_questions();
						});

						container.on('change', 'select.type', function(e){
							var answer=$(this).closest('.one-question'),
								index=$(this).find('option:selected').index();
								
							answer.find('.answer-type').each(function(){
								$(this).find('input').hide();
								$(this).find('input').eq(index).show();
							});
						});

						container.on('click', '.answer-add', function(e){
							var answer=$(this).closest('.answer').clone();

							answer.find('textarea').val('');
							answer.hide();

							answer.insertAfter($(this).closest('.answer'));
							answer.slideDown();

							answer.find('input').each(function(){
								$(this).val(answer.index());
							});							

							correct_answer_remove();
						});

						container.on('click', '.answer-remove', function(e){
							var answer=$(this).closest('.answer');

							answer.slideUp(function(){
								$(this).remove();
								correct_answer_remove();
							});
						});

						if(questions_data){
							for(var i=0;i<questions_data.length;i++){
								var question_data=questions_data[i],
									question=template.clone(),
									answer_template=question.find('.answer').clone(),
									answers_container=question.find('.answers');

								question.insertBefore($('.question-add'));
								question.removeAttr('id');
								question.show();
								question.find('textarea:first').val(question_data.question);
								question.find('.answer').remove();

								for(var ii=0;ii<question_data.answers.length;ii++){
									var answer_data=question_data.answers[ii],
										answer=answer_template.clone();

									answer.find('textarea:first').val(answer_data);
									answers_container.append(answer);

									answer.find('input').each(function(){
										$(this).val(answer.index()-1);
									});
								}

								question.find('select.type').val(question_data.type);
								question.find('select.type').trigger('change');

								question.find('input[type="radio"]').each(function(){
									var name=$(this).attr('name').slice(0, - 1);

									$(this).attr('name', name+question.index()+']');
								});

								question.find('[name]').each(function(){
									var name=$(this).attr('name');
									
									$(this).attr('name', name.replace('][]', question.index()+'][]'));
								});
								
								//radio
								if(question_data.type==0){
									question.find('.answer:eq('+parseInt(question_data.selected)+') input[type="radio"]').attr('checked', 'checked');
								}

								//checkbox
								if(question_data.type==1){
									var selected=question_data.selected.split(',');

									for(var k in selected){
										question.find('.answer:eq('+selected[k]+') input[type="checkbox"]').attr('checked', 'checked');									
									}
								}

								//priority
								if(question_data.type==2){
									var selected=question_data.selected.split(',');

									for(var k in selected){
										question.find('.answer:eq('+k+') input[type="text"]').val(selected[k]);
									}
								}
							}
						}
						
						var correct_no_questions=function(){
							if($('.question').length==1){
								$('#no-questions').show();
							}else{
								$('#no-questions').hide();
							}
						}

						var correct_answer_remove=function(){
							$('.one-question').each(function(){
								if($(this).find('.answer').length==1){
									$(this).find('.answer-remove').hide();
								}else{
									$(this).find('.answer-remove').show();
								}
							});
						}

						correct_no_questions();						
						correct_answer_remove();
					})();
					
				</script>
				
			</div>
		</div>
		
		<div class="group3" id="informations">
			<h2><?php echo Yii::t('TeachingModule.views_admin_edit', 'Information')?></h2>
						
			<div id="information-template" style="display:none">
				<div class="help">
					<div class="form-group js-information-name">
						<label for="Teaching_Продолжительность_(минут)">Название</label>
						
					</div>
					<div class="form-group js-information">

					</div>
					<a class="btn btn-danger btn-xs informations-remove"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Delete informations'); ?></a>
					<br><br>
				</div>
			</div>
			
			<a class="btn btn-primary btn-xs informations-add"><?php echo Yii::t('TeachingModule.views_admin_edit', 'Add Informations'); ?></a>
			<br>
			<br>
		</div>
		<script>
			(function(){
				
				function jsonEscape(str)  {
				    return str.replace(/\n/g, "").replace(/\r/g, "").replace(/\t/g, "");
				}
				var information_data=jQuery.parseJSON(jsonEscape('<?php echo $help_json; ?>'));
				console.log(information_data);
				
				var containerHelp=$('#informations'),
					templateHelp=$('#information-template'),
					count=0;
				
				containerHelp.on('click', '.informations-add', function(e){
					e.preventDefault();
					count++;
					
					
					var information=templateHelp.clone();
					information.find('.js-information-name').append('<input class="form-control" name="Help[name]['+count+']" type="text" >');
					information.find(".js-information").html('<textarea name="Help[text]['+count+']"></textarea>');
					
					information.find('textarea').val('');

					information.find('input').val('');
					information.removeAttr('id');
					information.insertBefore(this);
					information.slideDown().promise().done(function () {
						CKEDITOR.replace('Help[text]['+count+']', {
								toolbar: 'Basic',
						});
						
					});
					
				});
				
				containerHelp.on('click', '.informations-remove', function(e){
						e.preventDefault();
						var information=$(this).closest('.help');

						information.slideUp(function(){
							$(this).remove();
						});

						//correct_no_questions();
				});
				
				if(information_data) {
					for(var i=0;i<information_data.length;i++) {
						var information = templateHelp.clone();
						
						information.find('.js-information-name').append('<input class="form-control" name="Help[name]['+i+']" type="text" value="'+information_data[i]['name']+'" >');
						information.find(".js-information").html('<textarea name="Help[text]['+i+']">'+information_data[i]['text']+'</textarea>');
						information.show();

						///containerHelp.append(information);
						//containerHelp.find("h2").append(information);
						information.insertBefore(containerHelp.find(".informations-add"));

						
						information.promise().done(function () {
							CKEDITOR.replace('Help[text]['+i+']', {
								toolbar: 'Basic',
							});
							count = i;
						});

						console.log(information_data[i]['text']);
					}
				}
						
	
			})()
		</script>
		<?php echo CHtml::submitButton(Yii::t('TeachingModule.views_admin_edit', 'Save'), array('class' => 'btn btn-primary')); ?>

		<?php
		if (!$page->isNewRecord) {
			echo CHtml::link(Yii::t('TeachingModule.views_admin_edit', 'Delete'), $this->createUrl('//documents/admin/delete', array('id' => $page->id)), array('class' => 'btn btn-danger'));
		}
		?>

		<?php $this->endWidget(); ?>

	</div>
</div>

<script>

	if ($("#page_type").val() == '1' || $("#page_type").val() == '3') {
		$("#content_field").hide();
	} else {
		$("#url_field").hide();
	}

	$("#page_type").change(function() {
		if ($("#page_type").val() == '1' || $("#page_type").val() == '3') {
			$("#content_field").hide();
			$("#url_field").show();
		} else {
			$("#url_field").hide();
			$("#content_field").show();
		}
	});


</script>	
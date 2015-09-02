<?php

/**
 * PollFormWidget handles the form to create new polls.
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Luke
 */
class DocumentsFormWidget extends ContentFormWidget {

    public function renderForm() {

        $this->submitUrl = 'documents/document/create';
        $this->submitButtonText = Yii::t('DocumentsModule.widgets_PollFormWidget', 'Ask');

        $this->form = $this->render('pollForm', array(), true);
    }

}

?>
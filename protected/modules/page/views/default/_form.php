<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model Page
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'page-form',
        'focus'                  => array($model, 'name'),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
            'hideErrorMessage' => true
        )
    )
);

echo $form->errorSummary($model);
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type' => 'tabs', // 'tabs' or 'pills'
        'tabs' => array(
            array(
                'label'   => Yii::t('page', 'Основное'),
                'content' => $this->renderPartial('_formGeneral', array('model' => $model, 'form' => $form), true),
                'active'  => true
            ),
            array(
                'label'   => Yii::t('page', 'Дополнительно'),
                'content' => $this->renderPartial('_formSettings', array('model' => $model, 'form' => $form), true),
            )
        )
    )
);
if ( $model->rich_editor) {
    #Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('ext.bootstrap.assets')).'/css/bootstrap.min.css')
    $contentCss = array(Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('ext.bootstrap.assets')).'/css/bootstrap.min.css');
    if (isset(Yii::app()->theme->baseUrl)) {
        $contentCss[] = Yii::app()->theme->baseUrl . '/css/style.css';
    }
    $this->widget('ext.tinymce.TinyMce', array('model' => $model, 'attribute' => 'content', 'settings' => array('height' => 420, 'content_css' => implode(',', $contentCss))));
} else {
    echo $form->hiddenField($model, 'content');
    $this->widget('ext.aceEditor.AceEditor', array('model' => $model, 'attribute' => 'content'));
    Yii::app()->clientScript->registerScript('onSubmit', '
        $("#' . $form->id . '").submit(function() {
            $("#Page_content").val(editor.getSession().getValue());
        });
    ');
}
echo '<div>&nbsp;</div>';

$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('page', 'Добавить') : Yii::t('page', 'Сохранить')
    )
);
$this->endWidget();
Yii::app()->clientScript->registerScript(
    'page',
    '
$("html, body").animate({scrollTop: $("#page-form").position().top-10}, "slow");
$("#ajaxPreview").click(function(e) {
	e.preventDefault();
	$.ajax({
  		type: "POST",
  		url: "' . $this->createUrl('/page/default/ajaxPreview') . '",
  		data: { content: $("#Page_content").html() },
	}).success(function( data ) {
		var win = window.open("","Preview","width="+(screen.width-10)+",height="+(screen.height-100)+"");
		with(win.document) {
			open();
			write(data);
			close();
    	}
	});
});
',
    CClientScript::POS_READY
);

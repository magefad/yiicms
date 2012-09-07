<?php
/** @var $model Page
 ** @var $pages Page[]
 */

$this->pageTitle   = Yii::t('page', 'Добавление страницы');
$this->breadcrumbs = array(
	Yii::t('page', 'Страницы') => array('admin'),
	Yii::t('page', 'Создать'),
);

$this->menu = array(
	array('label' => Yii::t('page', 'Страницы')),
	array('icon'=> 'list-alt', 'label' => Yii::t('page', 'Управление'), 'url' => array('admin')),
	array('icon'=> 'file white', 'label' => Yii::t('page', 'Добавление'), 'url' => array('/page/default/create')),
	array(
		'icon'        => 'eye-open',
		'label'       => Yii::t('page', 'Предпросмотр'),
		'url'         => 'javascript:',
		'linkOptions' => array('id' => 'ajaxPreview')
	),
);
?>
<!-- <h1><?php #echo Yii::t('page', 'Добавление новой страницы');?></h1>-->
<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>
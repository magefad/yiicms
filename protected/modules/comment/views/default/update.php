<?php
/**
 * @var $this Controller
 * @var $model Comment
 */

$this->breadcrumbs = array(
	Yii::t('CommentModule.comment', 'Comments') => array('admin'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('CommentModule.comment', 'Update')
);

echo $this->renderPartial('_form', array('model' => $model));
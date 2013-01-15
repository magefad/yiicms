<?php
/**
 * @var $this Controller
 * @var $model Comment
 */

$this->breadcrumbs = array(
	Yii::t('CommentModule.comment', 'Comments') => array('admin'),
	Yii::t('CommentModule.comment', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));

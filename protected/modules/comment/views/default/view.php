<?php
/**
 * @var $this Controller
 * @var $model Comment
 */

$this->breadcrumbs = array(
	Yii::t('CommentModule.comment', 'Comments') => array('admin'),
	$model->id
);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'model',
		'model_id',
		'content',
		'status',
		'ip',
        'create_user_id',
        'update_user_id',
        'create_time',
        'update_time',
	),
));

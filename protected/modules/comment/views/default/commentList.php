<?php
/**
 * @var $comments Comment[]
 * @var $model CActiveRecord
 * @var CArrayDataProvider $comments
 * @var CController $this
 */
$comments = $model->commentDataProvider;
$comments->setPagination(false);
$this->widget(
    'zii.widgets.CListView',
    array(
        'dataProvider'       => $comments,
        'itemView'           => 'application.modules.comment.views.default._view',
        'sortableAttributes' => array('create_time' => Yii::t('CommentModule.comment', 'Create Time')),
        #'enablePagination'  => false,
        'template'           => '{sorter}{items}{pager}'
    )
);
$this->renderPartial(
    'application.modules.comment.views.default._formAjax',
    array('model' => $model->commentInstance)
);

Yii::app()->clientScript->registerCss(
    'comment',
    "#toggle-comment-form {font-size: 18px; cursor: pointer; border-bottom: 1px dotted;}"
);

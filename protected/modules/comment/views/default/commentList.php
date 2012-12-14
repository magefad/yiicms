<?php
/**
 * @var $comments Comment[]
 * @var $model CActiveRecord
 * @var CArrayDataProvider $comments
 * @var CController $this
 */

$comments = $model->commentDataProvider;
$comments->setPagination(false);
$modelAuthorAttribute = Yii::app()->getModule('comment')->modelAuthorAttribute;
echo ($comments->itemCount) ? '<h3>' . Yii::t('CommentModule.comment', '{n} Comment|{n} Comments', $comments->itemCount) . '</h3>' : '<div>&nbsp;</div>';

$this->widget(
    'zii.widgets.CListView',
    array(
        'dataProvider'       => $comments,
        'viewData'           => array('modelAuthorId' => isset($model->{$modelAuthorAttribute}) ? $model->{$modelAuthorAttribute} : 0),
        'itemView'           => 'application.modules.comment.views.default._view',
        'sortableAttributes' => array('create_time' => Yii::t('CommentModule.comment', 'Create Time')),
        #'enablePagination'  => false,
        'template'           => '{items}',
        'emptyText'          => '',
        'htmlOptions'        => array('style' => 'padding-top:0'),
    )
);
$this->renderPartial(
    'application.modules.comment.views.default._formAjax',
    array('model' => $model->commentInstance)
);

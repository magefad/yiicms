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
        'dataProvider'=> $comments,
        'itemView'    => 'application.modules.comment.views.default._view'
    )
);
$this->renderPartial(
    'application.modules.comment.views.default._formAjax',
    array(
        'model' => $model->commentInstance
    )
);


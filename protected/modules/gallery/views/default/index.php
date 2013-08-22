<?php
/**
 * @var $this Controller
 */
$this->breadcrumbs = array(Yii::t('GalleryModule.gallery', 'Albums'));
$this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_view',
    )
);

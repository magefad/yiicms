<?php
/**
 * User: fad
 * Date: 07.08.12
 * Time: 16:39
 *
 * @var $galleryId int
 * @var $this CController
 * @var $slug string
 */
$_uploadDirUrl = '/' . $this->admin->uploadDir . '/' . Yii::app()->getModule('gallery')->uploadDir . '/' . $slug . '/';
$photos        = new CActiveDataProvider('Photo', array(
    'criteria'      => array(
        #'condition' => 'status=1',
        'condition' => 'gallery_id = :gallery_id',
        'order'     => 't.sort_order',
        'params'    => array(
            ':gallery_id' => $galleryId,
        )
    ),
    'pagination'    => false,
));

$this->widget(
    'Galleria',
    array(
        'dataProvider'         => $photos,
        'imagePrefixSeparator' => '-',
        //if set 'imagePrefix' => '' in behaviors; separate - imagePrefix{separator}image
        'srcPrefix'            => $_uploadDirUrl,
        'srcPrefixThumb'       => $_uploadDirUrl . 'thumb/',
        'themeName'            => 'folio',
        //classic by default
        #'plugins' => array('history', 'flickr', 'picasa'),//history by default
        'options'              => array(
            'transition' => 'fade',
            #'debug' => true,
        ),
    )
);
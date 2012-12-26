<?php
/**
 * User: fad
 * Date: 07.08.12
 * Time: 16:39
 *
 * @var $this Controller
 * @var $photos array
 * @var $uploadDirUrl string
 */
$this->widget(
    'ext.galleria.Galleria',
    array(
        'dataProvider'         => $photos,
        'imagePrefixSeparator' => '-',
        //if set 'imagePrefix' => '' in behaviors; separate - imagePrefix{separator}image
        'srcPrefix'            => $uploadDirUrl,
        'srcPrefixThumb'       => $uploadDirUrl . 'thumb/',
        'themeName'            => 'folio'
    )
);
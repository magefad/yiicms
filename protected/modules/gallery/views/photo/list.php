<?php
/**
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

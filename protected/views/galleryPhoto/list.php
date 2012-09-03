<?php
/**
 * User: fad
 * Date: 07.08.12
 * Time: 16:39
 */

$photos = new CActiveDataProvider('GalleryPhoto', array(
	'criteria' => array(
		#'condition' => 'status=1',
		'condition' => 'gallery_id = :gallery_id',
		'order' => 't.sort',
		'params' => array(
			':gallery_id' => $galleryId,
		)
	),
	'pagination' => false,
));

$this->widget('Galleria', array(
	'dataProvider' => $photos,
	'imagePrefixSeparator' => '-',//if set 'imagePrefix' => '' in behaviors; separate - imagePrefix{separator}image
	'srcPrefix' => '/uploads/gallery/' . $slug .'/',
	'srcPrefixThumb' => '/uploads/gallery/' . $slug .'/thumb/',
	'themeName' => 'folio',//classic by default
	#'plugins' => array('history', 'flickr', 'picasa'),//history by default
	'options' => array(
		'transition' => 'fade',
		#'debug' => true,
	),
));
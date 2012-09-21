<?php
/**
 * User: fad
 * Date: 31.07.12
 * Time: 16:53
 */
/**
 * @var $this Controller
 * @var int $galleryId
 * @var string $slug
 * @var Gallery[] $albums
 */
$this->widget('application.modules.gallery.widgets.photoManager', array(
	'galleryId' => $galleryId,
	'slug'      => $slug,
	'albums'    => $albums,
));

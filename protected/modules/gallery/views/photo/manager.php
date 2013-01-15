<?php
/**
 * @var $this Controller
 * @var int $galleryId
 * @var string $slug
 * @var Gallery[] $albums
 */
$this->widget(
    'application.modules.gallery.widgets.photoManager',
    array(
        'galleryId' => $galleryId,
        'slug'      => $slug,
        'albums'    => $albums,
    )
);

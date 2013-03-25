Yii galleria
========

Extension to support Galleria JavaScript image gallery in Yii.

## What's new

* Upgrade Galleria to version 1.2.8 2012-08-09
* Support Galleria plugins, history plugin enabled by default (but others not tested)
* Support Galleria themes
* Support min.js or not min .js if Yii DEBUG defined, all JS, CSS in one assets folder
* Separate thumbnails and images as option
* Added imagePrefix (behavior), imagePrefixSeparator
* Added srcPrefix and srcPrefixThumb (example use normal image path and thimbnail image path)

## Requirements

Tested with Yii 1.1.11, but should work with previous versions too

## Install

Extract zip archive to
./webapp/protected/extension/galleria

Add import of galleria extension in your config/main.php file:
```php
'imports'=>array(
        ...
        'application.extensions.galleria.*'
        ...
    ),
~~~

## Using galleria Behavior

### Add to image model:

```php
	public function behaviors()
	{
		return array(
			'galleria' => array(
				'class' => 'application.extensions.galleria.GalleriaBehavior',
				'image' => 'file_name', //required, will be image name of src
				'imagePrefix' => 'id',//optional, not required
				'description' => 'description',//optional, not required
				'title' => 'name',//optional, not required
			),
		);
	}
```

### Widget:

```php
$photos = new CActiveDataProvider('GalleryPhoto');

$this->widget('Galleria', array(
	'dataProvider' => $photos,
	'imagePrefixSeparator' => '-',//if set 'imagePrefix' => '' in behaviors; separate - imagePrefix{Separator}image
	'srcPrefix' => '/uploads/gallery/',
	'srcPrefixThumb' => '/uploads/gallery/thumb/',
	#'themeName' => 'folio',//classic by default
	#'plugins' => array('history', 'flickr', 'picasa'),//history by default
	'options' => array(//galleria options
		'transition' => 'fade',
		#'debug' => true,
	)
));
```

## Binding in widget

```php
$photos = new CActiveDataProvider('GalleryPhoto');

$this->widget('Galleria', array(
	'dataProvider' => $photos,
	'dataProvider' => $data,
	'binding' => array(
		'image' => 'file_name',
    ),
));
```

## Only widget, without Dataprovider and behaviour etc

```php
<?php $this->beginWidget('Galleria');?>
	<img src="/uploads/gallery/1.jpg" alt="Description of image" title="Title of image" />
	<img src="/uploads/gallery/2.jpg" />
	<img src="/uploads/gallery/3.jpg" />
	<img src="/uploads/gallery/4.jpg" />
<?php $this->endWidget();?>
```

## Resources
* [Yii galleria](https://github.com/magefad/galleria/ "Yii galleria extension")
* [Galleria site](http://galleria.io/ "Galleria site")

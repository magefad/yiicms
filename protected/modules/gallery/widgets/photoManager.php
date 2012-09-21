<?php
/**
 * User: fad
 * Date: 02.08.12
 * Time: 10:42
 */
class photoManager extends Widget
{
	/** @var Gallery Model of gallery to manage */
	#public $gallery;

	/** @var string Route to gallery controller */
	public $controllerRoute = '/gallery/photo';
	public $assets;

	/** @var int id gallery */
	public $galleryId;

	/** @var string link (and dir files of albums) of gallery */
	public $slug;

	/** @var array items (dropDown albums) */
	public $albums;

	public function init()
	{
		$this->assets = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets');
	}

	/** Render widget */
	public function run()
	{
		/** @var $cs CClientScript */
		$cs = Yii::app()->clientScript;
		$cs->registerCssFile($this->assets . '/photoManager.css');

		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');

		if ( defined('YII_DEBUG') )
		{
			$cs->registerScriptFile($this->assets . '/jquery.iframe-transport.js');
			$cs->registerScriptFile($this->assets . '/jquery.photoManager.js');
		}
		else
		{
			$cs->registerScriptFile($this->assets . '/jquery.iframe-transport.min.js');
			$cs->registerScriptFile($this->assets . '/jquery.photoManager.min.js');
		}

		if ( $this->controllerRoute === null )
			throw new CException('$controllerRoute must be set.', 500);

		$opts = CJavaScript::encode(array(
			'hasName:'         => true,
			'hasDesc:'         => true,
			'uploadUrl'        => Yii::app()->createUrl($this->controllerRoute . '/ajaxUpload', array('galleryId' => $this->galleryId)),
			'deleteUrl'        => Yii::app()->createUrl($this->controllerRoute . '/ajaxDelete'),
			'updateUrl'        => Yii::app()->createUrl($this->controllerRoute . '/changeData'),
			'arrangeUrl'       => Yii::app()->createUrl($this->controllerRoute . '/order'),
			'nameLabel'        => Yii::t('gallery', 'Название'),
			'descriptionLabel' => Yii::t('gallery', 'Описание'),
		));
		$src = "$('#{$this->id}').galleryManager({$opts});";
		$cs->registerScript('galleryManager#' . $this->id, $src);

		$model = new Photo();
		$this->render('photoManager', array(
			'model'  => $model,
			#'galleryId' => $this->galleryId,
			'slug'   => $this->slug,
			'albums' => $this->albums,
			'photos' => $model->findAll(array(
				'condition' => 'gallery_id=:gallery_id',
				'order'     => 'sort',
				'params'    => array(':gallery_id' => $this->galleryId)
			))
		));
	}
}

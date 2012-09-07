<?php
/**
 * User: fad
 * Date: 05.09.12
 * Time: 11:49
 */
class NewsModule extends CWebModule
{
	public function init()
	{
		parent::init();

		$this->setImport(array(
			'news.models.*',
		));
	}
}

<?php
/**
 * User: fad
 * Date: 27.07.12
 * Time: 16:53
 */
class LastNews extends Widget
{
	public $count = 3;

	public function run()
	{
		$dependency = new CDbCacheDependency('SELECT UNIX_TIMESTAMP(MAX(change_date)) FROM '.News::model()->tableName());

		$news = News::model()->published()->cache(Yii::app()->params['cacheTime'], $dependency)->findAll(array(
			'limit' => $this->count,
			'order' => 'date DESC'
		));

		$this->render('news', array('news' => $news));
	}
}

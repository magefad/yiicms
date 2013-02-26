<?php
Yii::import('news.models.News');
class LastNews extends CWidget
{
    public $cacheTime = 3600;

    public function run()
    {
        $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM {{news}}');
        $news = News::model()->published()->cache($this->cacheTime, $dependency, 2)->findAll(
            array(
                'limit' => Yii::app()->getModule('news')->lastNewsCount,
                'order' => 'date DESC'
            )
        );
        $this->render('news', array('news' => $news));
    }
}

<?php
/**
 * User: fad
 * Date: 27.07.12
 * Time: 16:53
 */
class LastNews extends Widget
{
    public function run()
    {
        $count = 3;
        if (isset(Yii::app()->getModule('news')->lastNewsCount)) {
            $count = Yii::app()->getModule('news')->lastNewsCount;
        }
        $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM ' . News::model()->tableName());
        $news = News::model()->published()->cache(Yii::app()->params['cacheTime'], $dependency, 2)->findAll(
            array(
                'limit' => $count,
                'order' => 'date DESC'
            )
        );
        $this->render('news', array('news' => $news));
    }
}

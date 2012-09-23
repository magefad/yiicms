<?php

class DefaultController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array('rights');
    }

    public function actionIndex()
    {
        $this->render('index', Yii::app()->getModule('admin')->getModules());
    }
}

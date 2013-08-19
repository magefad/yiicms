<?php

class ElfinderController extends Controller
{
    // Uncomment the following methods and override them if needed
    /*
     public function filters()
     {
         // return the filter configuration for this controller, e.g.:
         return array(
             'inlineFilterName',
             array(
                 'class' =>'path.to.FilterClass',
                 'propertyName' =>'propertyValue',
             ),
         );
     }
     */
    public function actions()
    {
        return array(
            'connector' => array(
                'class'    => 'ext.elFinder.ElFinderConnectorAction',
                'settings' => array(
                    'root'       => Yii::getPathOfAlias('uploads'),
                    'URL'        => Yii::app()->baseUrl . '/' . $this->admin->uploadDir . '/',
                    'rootAlias'  => Yii::t('zii', 'Home'),
                    'mimeDetect' => 'none'
                )
            ),
        );
    }
}

<?php
Yii::import('ext.tinymce.*');
class TinyMceController extends CController
{
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
 	*/
     public function actions()
     {
		return array('compressor' => array(
						'class' => 'TinyMceCompressorAction',
						'settings' => array(
							'compress' => true,
								'disk_cache' => true,
							)
						),
				#'spellchecker' => array(
				#'class' => 'TinyMceSpellcheckerAction',
               #),
          );
      }

}
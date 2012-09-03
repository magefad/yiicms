TinyMCE integration for yii
===========================

1. Checkout source code to ext.tinymce
2. To use spellchecker and compressor, create controller and add corresponding actions to it

        Yii::import('ext.tinymce.*');

        class TinyMceController extends CController
        {
            public function actions()
            {
                return array(
                    'compressor' => array(
                        'class' => 'TinyMceCompressorAction',
                        'settings' => array(
                            'compress' => true,
                            'disk_cache' => true,
                        )
                    ),
                    'spellchecker' => array(
                        'class' => 'TinyMceSpellcheckerAction',
                    ),
                );

            }

        }

3. Use it as any other input widget:

        $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'tinyMceArea',
            // Optional config
            'compressorRoute' => 'tinyMce/compressor',
            'spellcheckerRoute' => 'tinyMce/spellchecker',
            'fileManager' => array(
                'class' => 'ext.elFinder.TinyMceElFinder',
                'connectorRoute'=>'admin/elfinder/connector',
            ),
            'htmlOptions' => array(
                'rows' => 6,
                'cols' => 60,
            ),
        ));

4. More about elFinder extension here: https://bitbucket.org/z_bodya/yii-elfinder
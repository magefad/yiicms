<?php
/**
 * @var $this Controller
 * @var $modules[] WebModule[]
 * @var $yiiModules CWebModule[]
 */
?>
<h2><?php echo Yii::t('global', 'Панель управления "{app}"', array('{app}' => CHtml::encode(Yii::app()->name))); ?></h2>
<p>
    Yii: <small class="label label-info" title="<?php echo Yii::getVersion(); ?>"><?php echo Yii::getVersion(); ?></small>,
    PHP: <small class="label label-info" title="<?php echo phpversion(); ?>"><?php echo phpversion(); ?></small>.
	<small class="label label-info"><?php echo $mn = count($modules) + count($yiiModules); ?></small>
	<?php echo Yii::t('admin', 'модуль|модуля|модулей', $mn); ?>
</p>
<div style="float: right; width: 20% ">
	<?php /** @var TbActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'  => 'horizontalForm',
		'type'=> 'horizontal',
	)); ?>
    Здесь будет заметка
	<?php $this->endWidget(); ?>
</div>
<?php
$moduleRawData = $yiiModuleRawData = array();
foreach ($modules as $name => $module) {
    $moduleRawData[] = array(
        'id'          => $name,
        'name'        => $module->name,
        'description' => $module->description,
        'author'      => $module->author,
        'authorEmail' => $module->authorEmail,
        'url'         => $module->url,
        'icon'        => $module->icon,
    );
}

$dataProvider = new CArrayDataProvider($moduleRawData, array('pagination' => false));
$this->widget(
    'bootstrap.widgets.TbGridView',
    array(
        'id'          => 'modules-grid',
        'type'        => 'striped bordered condensed',
        'dataProvider' => $dataProvider,
        'template'    => "{items}",
        'htmlOptions' => array('style' => 'width: 75%;padding-top:0'),
        'columns'     => array(
            array(
                'name'        => 'icon',
                'type'        => 'raw',
                'value'       => 'CHtml::tag("i", array("class" => "icon-$data[icon]"))',
                #'header'      => '',
                'htmlOptions' => array('style' => 'text-align: center')
            ),
            array('name' => 'id', 'header' => 'ID'),
            array(
                'name'   => 'name',
                'type'   => 'raw',
                'value'  => 'CHtml::link("$data[name]", "/".$data["id"]."/default/admin", array("title" => Yii::t("admin", "Перейти в управление")))',
                'header' => Yii::t('admin', 'Название')
            ),
            array('name' => 'description', 'header' => Yii::t('admin', 'Описание')),
            #array('name' => 'author', 'header' => Yii::t('admin', 'Автор')),

            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'template'    => '{settings}',
                'buttons'     => array(
                    /*'view' => array(
                         'label' => Yii::t('admin', 'Управление'),
                         'url'   => 'Yii::app()->createUrl("/".$data["id"]."/default/admin")',
                         'icon'  => 'list-alt',
                     ),*/
                    'settings' => array(
                        'label' => Yii::t('admin', 'Настройки'),
                        'url'   => 'Yii::app()->createUrl("/admin/setting/update", array("slug" => $data["id"]))',
                        'icon'  => 'wrench',
                    )
                ),
                'htmlOptions' => array('style' => 'width: 50px;text-align:center'),
            ),
        ),
    )
);
?>
<?php
/**
 * @var $model User
 * @var $this Controller
 */

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    Yii::t('user', 'Управление'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
"
);
?>
<?php echo CHtml::link(
    Yii::t('user', '<i class="icon-search"></i> Поиск пользователей <span class="caret"></span>'),
    '#',
    array('class' => 'search-button btn btn-small')
) ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'FadTbGridView',
    array(
        'id'           => 'user-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center'),
            ),
            array(
                'name'        => 'username',
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->username, array("update", "id" => $data->id))',
                'htmlOptions' => array('style' => 'width: 80px; text-align: center'),
            ),
            'email',
            'create_time',
            'last_visit',
            #'update_time',
            'firstname',
            'lastname', /*
		'status',
		'access_level',
		'registration_date',
		'registration_ip',
		'activation_ip',
		'avatar',
		'use_gravatar',
		'activate_key',
		'email_confirm',
		*/
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'template'    => '{view} {update} {password} {delete}',
                'buttons'     => array(
                    'password' => array(
                        'label'   => false,
                        'url'     => 'array("changepassword", "id" => $data->id)',
                        'options' => array('class' => 'icon-certificate', 'title' => 'Пароль'),
                    ),
                ),
                'htmlOptions' => array('style' => 'width: 70px'),
            ),
        ),
    )
); ?>

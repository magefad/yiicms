<?php
Yii::import('bootstrap.widgets.TbGridView');
/** @property CActiveDataProvider $dataProvider */
class FadTbGridView extends TbGridView
{
    /**
     * @var string|array the table type.
     * Valid values are 'striped', 'bordered', ' condensed' and/or 'hover'.
     *
     */
    public $type = 'striped condensed';

    /**
     * @var boolean whether to leverage the {@link https://developer.mozilla.org/en/DOM/window.history DOM history object}.  Set this property to true
     * to persist state of grid across page revisits.  Note, there are two limitations for this feature:
     * <ul>
     *    <li>this feature is only compatible with browsers that support HTML5.</li>
     *    <li>expect unexpected functionality (e.g. multiple ajax calls) if there is more than one grid/list on a single page with enableHistory turned on.</li>
     * </ul>
     * @since 1.1.11
     */
    public $enableHistory = true;

    /**
     * @var string a PHP expression that is evaluated for every table body row and whose result
     * is used as the CSS class name for the row. In this expression, the variable <code>$row</code>
     * stands for the row number (zero-based), <code>$data</code> is the data model associated with
     * the row, and <code>$this</code> is the grid object.
     * @see rowCssClass
     */
    public $rowCssClassExpression = '($data->status == 2) ? "error" : (($data->status == 1) ? "published" : (($data->status == 0) ? "warning" : ""))';


    /**
     * @param CActiveRecord $data
     * @param string $statusAttribute
     * @param string $property
     * @param array $icons
     * @return string
     */
    public function getStatus(
        $data,
        $statusAttribute = 'status',
        $property = 'statusMain',
        $icons = array(
            'published'  => 'ok-sign',
            'draft'      => 'eye-close',
            'moderation' => 'time',
            'active'     => 'ok-sign',
            'blocked'    => 'eye-close',
            'deleted'    => 'ok-sign'
        )
    )
    {
        if (!isset($data->$property)) {
            return '<i class="icon icon-question-sign" title="?"></i>';
        }
        $text       = $data->$property->getText();
        $iconStatus = isset($icons[$data->$statusAttribute]) ? $icons[$data->$statusAttribute] : 'question-sign';
        $icon       = '<i class="icon icon-' . $iconStatus . '"></i>';

        $statusList = $data->$property->getList();
        reset($statusList);
        $status = key($statusList);
        while (list($key, $value) = each($statusList)) {
            if ($key == $data->$statusAttribute) {
                $keyNext = key($statusList);
                if (in_array($keyNext, array_keys($statusList))) {
                    $status = $keyNext;
                    break;
                }
            }
        }
        $url = Yii::app()->controller->createUrl('activate', array(
                'model'           => $this->dataProvider->modelClass,
                'id'              => $data->primaryKey,
                'status'          => $status,
                'statusAttribute' => $statusAttribute,
            )
        );
        $options = array(
            'rel'     => 'tooltip',
            'title'   => $text,
            'class'   => $statusAttribute . '_switch'
        );

        $this->registerCustomClientScript($options['class']);
        return CHtml::link($icon, $url, $options);
    }

    /**
     * Sort buttons (up-down)
     * @todo Remove down button of the end element
     * @param CActiveRecord $data
     * @param string $sortAttribute
     * @return string
     */
    public function getUpDownButtons($data, $sortAttribute = 'sort_order')
    {
        $path         = Yii::getPathOfAlias('zii.widgets.assets.gridview');
        $downUrlImage = CHtml::image(Yii::app()->assetManager->publish($path . '/down.gif'), '&#x25B2;');
        $upUrlImage   = CHtml::image(Yii::app()->assetManager->publish($path . '/up.gif'), '&#x25BC;');

        $params = array(
            'model'         => $this->dataProvider->modelClass,
            'id'            => $data->primaryKey,
            'sortAttribute' => $sortAttribute,
            'direction'     => 'up'
        );
        $urlUp = Yii::app()->controller->createUrl('sort', $params);
        $params['direction'] = 'down';
        $urlDown = Yii::app()->controller->createUrl('sort', $params);

        $options   = array(
            'rel'     => 'tooltip',
            'class'   => $sortAttribute . '_button'
        );
        $options['title'] = Yii::t('global', 'Поднять выше');
        $optionsUp = $options;
        $options['title'] = Yii::t('global', 'Опустить ниже');
        $optionsDown = $options;
        $return = ($data->{$sortAttribute} != 1) ? CHtml::link($upUrlImage, $urlUp, $optionsUp) : '&nbsp;';
        $this->registerCustomClientScript($options['class']);
        return $return . ' ' . $data->{$sortAttribute} . ' ' . CHtml::link($downUrlImage, $urlDown, $optionsDown);
    }

    /**
     * Registers the client scripts for switch and upDown buttons.
     */
    protected function registerCustomClientScript($class = '')
    {
        $csrf = '';
        if (Yii::app()->getRequest()->enableCsrfValidation) {
            $csrfTokenName = Yii::app()->getRequest()->csrfTokenName;
            $csrfToken     = Yii::app()->getRequest()->csrfToken;
            $csrf          = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
        }
        $function = "
function() {
	$.fn.yiiGridView.update('{$this->id}', {
		type: 'GET',
		url: $(this).attr('href'),{$csrf}
		success: function(data) {
			$.fn.yiiGridView.update('{$this->id}');
		}
	});
	return false;
}
";
        Yii::app()->clientScript->registerScript($class . '#' . $this->id, "$(document).on('click', '#{$this->id} a.{$class}', $function);");
    }
}

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
    public $rowCssClassExpression = '($data->status == "moderation") ? "error" : (($data->status == "published") ? "published" : (($data->status == "moderation") ? "warning" : ""))';

    public $activeStatus = 1;
    public $inActiveStatus = 0;

    public $showStatusText = false;

    public $sortField = 'sort_order';


    public function returnBootstrapStatusHtml(
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
        $icon       = '<i class="icon icon-' . $iconStatus . '" title="' . $text . '"></i>';

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
        $url = Yii::app()->controller->createUrl("activate", array(
                'model'           => $this->dataProvider->modelClass,
                'id'              => $data->id,
                'status'          => $status,
                'statusAttribute' => $statusAttribute,
            )
        );
        $options = array(
            'rel'     => 'tooltip',
            'title'   => $text,
            'onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;'
        );
        return CHtml::link($icon, $url, $options);
    }

    /**
     * Sort buttons (up-down)
     * @todo Remove down button of the end element
     * @param $data
     * @return string
     */
    public function getUpDownButtons($data)
    {
        $downUrlImage = CHtml::image(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('zii.widgets.assets.gridview') . '/down.gif'
            ),
            '&#x25B2;'
        );

        $upUrlImage = CHtml::image(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('zii.widgets.assets.gridview') . '/up.gif'
            ),
           '&#x25BC;'
        );

        $urlUp = Yii::app()->controller->createUrl(
            'sort',
            array(
                'model'     => $this->dataProvider->modelClass,
                'id'        => $data->id,
                'sortField' => $this->sortField,
                'direction' => 'up'
            )
        );

        $urlDown = Yii::app()->controller->createUrl(
            'sort',
            array(
                'model'     => $this->dataProvider->modelClass,
                'id'        => $data->id,
                'sortField' => $this->sortField,
                'direction' => 'down'
            )
        );

        $optionsUp   = array(
            'onclick' => 'ajaxSetSort(this, "' . $this->id . '"); return false;',
            'title'   => Yii::t('global', 'Поднять выше'),
            'rel'     => 'tooltip'
        );
        $optionsDown = array(
            'onclick' => 'ajaxSetSort(this, "' . $this->id . '"); return false;',
            'title'   => Yii::t('global', 'Опустить ниже'),
            'rel'     => 'tooltip'
        );

        $return = ($data->{$this->sortField} != 1) ? CHtml::link($upUrlImage, $urlUp, $optionsUp) : '&nbsp;';
        return $return . ' ' . $data->{$this->sortField} . ' ' . CHtml::link($downUrlImage, $urlDown, $optionsDown);
    }
}

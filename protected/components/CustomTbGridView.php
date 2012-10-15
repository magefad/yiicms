<?php
Yii::import('bootstrap.widgets.TbGridView');

class CustomTbGridView extends TbGridView
{
    public $modelName;

    public $activeStatus = 1;

    public $inActiveStatus = 0;

    public $statusField = 'status';

    public $showStatusText = false;

    public $sortField = 'sort';

    public function init()
    {
        parent::init();
        $this->modelName = $this->dataProvider->modelClass;
    }

    /**
     * @param $data CModel
     * @param int $active
     * @param int $onclick
     * @param int $ignore
     * @return string
     */
    public function returnStatusHtml($data, $active = 1, $onclick = 1, $ignore = 0)
    {
        $statusField = $this->statusField;
        $status = $data->$statusField == $active ? $this->inActiveStatus : $this->activeStatus;
        $url = Yii::app()->controller->createUrl(
            "activate",
            array(
                'model'       => $this->modelName,
                'id'          => $data->id,
                'status'      => $status,
                'statusField' => $this->statusField
            )
        );

        $img     = CHtml::image(
            Yii::app()->request->baseUrl . '/web/images/' . ($data->$statusField == $active ? '' : 'in') . 'active.png',
            Yii::t(
                'global',
                $data->$statusField ? Yii::t('global', 'Деактивировать') : Yii::t('global', 'Активировать')
            ),
            array(
                'title' => Yii::t(
                    'global',
                    $data->$statusField ? Yii::t('global', 'Деактивировать') : Yii::t('global', 'Активировать')
                )
            )
        );
        $options = array();
        if ($onclick) {
            $options = array(
                'onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;',
            );
        }
        $text = ($this->showStatusText && method_exists($data, 'getStatus')) ? $data->getStatus() : '';
        return '<div align="center">' . CHtml::link($img, $url, $options) . $text . '</div>';
    }

    /**
     * Bootstrap active or draft (TBGridView)
     *
     * Default values for states
     * 0 - draft
     * 1 - public
     * 2 - on moderation
     * @param CModel $data
     * @param int $active
     * @param array $icons icon-status
     * @return string Html-code
     *
     */
    public function returnBootstrapStatusHtml($data, $active = 1, $icons = array('eye-close', 'ok-sign', 'time'))
    {
        $statusField = $this->statusField;

        $status = $data->$statusField == $active ? $this->inActiveStatus : $this->activeStatus;

        $url = Yii::app()->controller->createUrl(
            'activate',
            array(
                'model'       => $this->modelName,
                'id'          => $data->id,
                'status'      => $status,
                'statusField' => $this->statusField
            )
        );

        $text = method_exists($data, 'getStatus') ? $data->getStatus() : '';
        $text .= ". " . Yii::t(
            'global',
            ($data->$statusField && $data->$statusField != 2) ? Yii::t('global', 'В черновик?') : Yii::t(
                'global',
                'Опубликовать?'
            )
        );
        $options = array(
            'rel'     => 'tooltip',
            'title'   => $text,
            'onclick' => 'ajaxSetStatus(this, "' . $this->id . '"); return false;',
        );
        $icon = '<i class="icon icon-' . (isset($icons[$data->$statusField]) ? $icons[$data->$statusField] : 'question-sign') . "\"></i>";
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
                'model'     => $this->modelName,
                'id'        => $data->id,
                'sortField' => $this->sortField,
                'direction' => 'up'
            )
        );

        $urlDown = Yii::app()->controller->createUrl(
            'sort',
            array(
                'model'     => $this->modelName,
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

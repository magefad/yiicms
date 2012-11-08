<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 27.10.12
 * Time: 23:48
 */
Yii::import('ext.bootstrap.widgets.TbExtendedGridView');


class TbTreeGridView extends TbExtendedGridView
{
    public $enablePagination = false;

    /**
     * @var array Custom options for treeTable and draggable
     */
    public $options = array('treeTable', 'draggable');

    /**
     * @var string Name of the action to call and save moved tree item
     */
    public $treeAbleAction = 'moveNode';

    /**
     * @var string a javascript function that will be invoked after a successful sorting is done.
     * The function signature is <code>function(type, to, from)</code>
     */
    public $afterTreeAbleUpdate;

    /**
     * @var int Current Tree level
     */
    private $level = 1;

    /**
     * Initializes the tree grid view.
     */
    public function init()
    {
        parent::init();
        //Calc parent id from nested set
        $dataProvider = $this->dataProvider->getData();
        if (count($dataProvider)) {
            //$left         = $dataProvider[0]->tree->leftAttribute;
            //$right        = $dataProvider[0]->tree->rightAttribute;
            $level        = $dataProvider[0]->tree->levelAttribute;
            $stack        = array();
            $currentLevel = 0;
            /** @var $previousModel CDataProvider */
            $previousModel = null;
            try {
                foreach ($dataProvider as $model) {
                    if ($model->$level == 1) { //root with level=1
                        $model->parentId = 0;
                        $currentLevel    = 1;
                    } else {
                        if ($model->$level == $currentLevel) {
                            if (is_null($stack[count($stack) - 1])) {
                                throw new Exception(Yii::t('grid', 'Tree is corrupted'));
                            }
                            $model->parentId = $stack[count($stack) - 1]->primaryKey;
                        } elseif ($model->$level > $currentLevel) {
                            if (is_null($previousModel)) {
                                throw new Exception(Yii::t('grid', 'Tree is corrupted'));
                            }
                            $currentLevel    = $model->$level;
                            $model->parentId = $previousModel->primaryKey;
                            array_push($stack, $previousModel);
                        } elseif ($model->$level < $currentLevel) {
                            for ($i = 0; $i < $currentLevel - $model->$level; $i++) {
                                array_pop($stack);
                            }
                            if (is_null($stack[count($stack) - 1])) {
                                throw new Exception(Yii::t('grid', 'Tree is corrupted'));
                            }
                            $currentLevel    = $model->$level;
                            $model->parentId = $stack[count($stack) - 1]->primaryKey;
                        }
                    }
                    $previousModel = $model;
                }
            } catch ( Exception $e ) {
                Yii::app()->user->setFlash('error', $e->getMessage());
            }
        }
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerCustomClientScript()
    {
        if ($this->afterTreeAbleUpdate !== null) {
            if (!($this->afterTreeAbleUpdate instanceof CJavaScriptExpression) && strpos($this->afterTreeAbleUpdate, 'js:') !== 0) {
                $afterTreeAbleUpdate = new CJavaScriptExpression($this->afterTreeAbleUpdate);
            } else {
                $afterTreeAbleUpdate = $this->afterTreeAbleUpdate;
            }
        } else {
            $afterTreeAbleUpdate = '';
        }

        $assets = Yii::app()->assetManager->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'treeTable');
        $cs     = Yii::app()->clientScript;
        $min = !YII_DEBUG ? '.min' : '';
        $cs->registerCssFile($assets . '/stylesheets/jquery.treeTable' . $min . '.css');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile($assets . '/javascripts/jquery.treeTable' . $min . '.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets . '/jquery.treeAble.gridview' . $min . '.js', CClientScript::POS_END);

        $treeTableOptions = isset($this->options['treeTable']) ? CJavaScript::encode($this->options['treeTable']) : 'null';
        $draggableOptions = isset($this->options['draggable']) ? CJavaScript::encode($this->options['draggable']) : 'null';

        $afterTreeAbleUpdate = CJavaScript::encode($afterTreeAbleUpdate);
        if ($this->treeAbleAction == 'moveNode') //route is default
        {
            if ($module = $this->controller->module->id) {
                $treeAbleAction = $module . '/' . $this->controller->id . '/' . $this->treeAbleAction;
            } else {
                $treeAbleAction = $this->controller->id . '/' . $this->treeAbleAction;
            }
        } else {
            $treeAbleAction = $this->treeAbleAction;
        }
        $treeAbleAction = Yii::app()->createUrl($treeAbleAction);
        $js = "$('#{$this->id}').treeAble('{$this->id}', '{$treeAbleAction}', {$treeTableOptions}, {$draggableOptions}, {$afterTreeAbleUpdate});";
        $this->componentsReadyScripts[] = $js;
        $this->componentsAfterAjaxUpdate[] = $js;
        parent::registerCustomClientScript();
    }

    /**
     * Renders the data items for the grid view.
     */
    public function renderItems()
    {
        if (Yii::app()->user->hasFlash('error')) {
            $this->widget('bootstrap.widgets.TbAlert');
        }
        parent::renderItems();
    }


    /**
     * Renders a table body row with id and parentId, needed for ActsAsTreeTable
     * jQuery extension.
     * @param integer $row the row number (zero-based).
     */
    public function renderTableRow($row)
    {
        $model       = $this->dataProvider->data[$row];
        $parentClass = $model->parentId ? 'child-of-' . $model->parentId . ' ' : '';

        if ($model->level != $this->level) {
            echo '<tr style="display:none" class="before" id="before-' . $model->primaryKey . '"><td colspan="100"><div></div></td></tr>';
        }
        $this->level = $model->level;

        if ($this->rowCssClassExpression !== null) {
            $data  = $this->dataProvider->data[$row];
            $class = $this->evaluateExpression($this->rowCssClassExpression, array('row' => $row, 'data' => $data));
        } else if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0) {
            $class = $this->rowCssClass[$row % $n];
        } else {
            $class = '';
        }

        echo '<tr id="' . $model->primaryKey . '"  class="' . $parentClass . $class . '">';
        foreach ($this->columns as $column) {
            /** @var $column CDataColumn */
            $column->renderDataCell($row);
        }
        echo "</tr>\n";
        echo '<tr style="display:none" class="after" id="after-' . $model->primaryKey . '"><td colspan="100"><div></div></td></tr>';

    }
}

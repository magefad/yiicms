<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 06.11.12
 * Time: 13:50
 */

class Create extends CAction
{
    /**
     * @var string the name of the model we are going to update
     */
    public $modelName;

    public function run($root = false)
    {
        /** @var $model CActiveRecord|NestedSetBehavior */
        $model = new $this->modelName;
        if ($root) {
            $model->scenario = 'createRoot';
        }
        if (method_exists($this->controller, 'performAjaxValidation')) {
            try {
                $this->controller->performAjaxValidation($model);
            } catch ( Exception $e ) {
                $model->addError('error', $e->getMessage());
            }
        }

        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            try {
                if ($model->tree->hasManyRoots == true) {
                    if ($model->root) {
                        $_root = Menu::model()->findByPk((int)$model->root);
                        if ($_root && $model->appendTo($_root)) {
                            $this->controller->redirect(array('admin'));
                        }
                    } else {
                        if ($model->saveNode()) {
                            $this->controller->redirect(array('admin'));
                        }
                    }
                } else {
                    $root = CActiveRecord::model($this->modelName)->roots()->find();

                    if ($root && $model->appendTo($root)) {
                        $this->controller->redirect(Yii::app()->request->urlReferrer);
                    }
                }
            } catch ( Exception $e ) {
                $model->addError('error', $e->getMessage());
            }
        }
        $this->controller->render('create', array('model' => $model, 'root' => $root));
    }
}

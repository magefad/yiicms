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

    public function run()
    {
        /** @var $model CActiveRecord|NestedSetBehavior */
        $model = new $this->modelName;

        if ($_POST[$this->modelName]) {
            $model->attributes = $_POST[$this->modelName];

            try {
                if ($model->tree->hasManyRoots == true) {
                    if ($model->saveNode()) {
                        $this->controller->redirect(Yii::app()->request->urlReferrer);
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
        $this->controller->render('create', array('model' => $model));
    }
}

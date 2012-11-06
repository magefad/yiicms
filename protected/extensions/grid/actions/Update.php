<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 06.11.12
 * Time: 13:50
 */

class Update extends CAction
{
    /**
     * @var string the name of the model we are going to update
     */
    public $modelName;

    public function run($id)
    {
        /** @var $model CActiveRecord|NestedSetBehavior */
        $model = CActiveRecord::model($this->modelName)->findByPk((int)$id);
        if ($model === null) {
            $this->controller->redirect(Yii::app()->request->urlReferrer);
        }

        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($model->saveNode()) {
                $this->controller->redirect(array(Yii::app()->request->urlReferrer));
            }
        }
        $this->controller->render('update', array('model' => $model));
    }
}

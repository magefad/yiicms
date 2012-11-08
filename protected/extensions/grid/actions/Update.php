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
        $model->parentId = $model->isRoot() ? $model->primaryKey : $model->parent()->find()->id;
        if ( $model->isRoot()) {
            $model->scenario = 'updateRoot';
        }
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (method_exists($this->controller, 'performAjaxValidation')) {
            try {
                $this->controller->performAjaxValidation($model);
            } catch ( Exception $e ) {
                $model->addError('error', $e->getMessage());
            }
        }

        if (isset($_POST['parentId']) && (int)$_POST['parentId'] != $model->parentId) {
            $newParent = CActiveRecord::model($this->modelName)->findByPk((int)$_POST['parentId']);
            if ($newParent && $model->moveAsLast($newParent)) {
                #$model = CActiveRecord::model($this->modelName)->findByPk((int)$id);
                $model->refresh();
            }
        }

        if (isset($_POST[$this->modelName])) {
            $model->attributes = $_POST[$this->modelName];
            if ($model->saveNode()) {
                $this->controller->redirect(array('admin'));
            }
        }
        $this->controller->render('update', array('model' => $model));
    }
}

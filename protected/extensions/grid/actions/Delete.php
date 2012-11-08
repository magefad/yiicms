<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 06.11.12
 * Time: 13:50
 */

class Delete extends CAction
{
    /**
     * @var string the name of the model we are going to update
     */
    public $modelName;

    public function run($id)
    {
        if (Yii::app()->request->isPostRequest) {
            /** @var $model CActiveRecord|NestedSetBehavior */
            $model = CActiveRecord::model($this->modelName)->findByPk((int)$id);
            if ($model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if ($model->tree->hasManyRoots == false && $model->isRoot()) {
                throw new CHttpException(400, Yii::t('grid', 'You can not remove root in one tree mode.'));
            }
            $model->deleteNode();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : Yii::app()->request->urlReferrer);
            }
        } else {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
    }
}

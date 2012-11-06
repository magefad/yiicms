<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 06.11.12
 * Time: 13:50
 */

class MakeRoot extends CAction
{
    /**
     * @var string the name of the model we are going to update
     */
    public $modelName;

    public function run($id)
    {
        /** @var $model CActiveRecord|NestedSetBehavior */
        $model = CActiveRecord::model($this->modelName)->findByPk((int)$id);

        if (!is_null($model)) {
            try {
                $model->moveAsRoot();
            } catch ( Exception $e ) {
                throw new CHttpException(500, $e->getMessage());
            }
        } else {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->end(1);
        } else {
            $this->controller->redirect(Yii::app()->request->urlReferrer);
        }
    }
}

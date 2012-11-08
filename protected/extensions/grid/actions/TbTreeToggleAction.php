<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 08.11.12
 * Time: 14:47
 */
Yii::import('ext.bootstrap.actions.TbToggleAction');
class TbTreeToggleAction extends TbToggleAction
{
    /**
     * Widgets run function
     * @param $id
     * @param $attribute
     * @throws CHttpException
     */
    public function run($id, $attribute)
    {
        if (Yii::app()->getRequest()->isPostRequest)
        {
            /** @var $model CActiveRecord|NestedSetBehavior */
            $model = $this->loadModel($id);
            $model->$attribute = ($model->$attribute == $this->noValue) ? $this->yesValue : $this->noValue;
            $success = $model->saveNode(false);

            if (Yii::app()->getRequest()->isAjaxRequest)
            {
                echo $success ? $this->ajaxResponseOnSuccess : $this->ajaxResponseOnFailed;
                exit(0);
            }
            if ($this->redirectRoute !== null)
                $this->getController()->redirect($this->redirectRoute);
        } else
            throw new CHttpException(Yii::t('zii', 'Invalid request'));
    }
}

<?php
/**
 * @author Fadeev Ruslan <fadeevr@gmail.com>
 * Date: 06.11.12
 * Time: 13:50
 */

class MoveNode extends CAction
{
    /**
     * @var string the name of the model we are going to update
     */
    public $modelName;

    public function run()
    {
        $type = Yii::app()->request->getParam('type');
        $to   = Yii::app()->request->getParam('to');
        $id   = Yii::app()->request->getParam('moved');
        /**
         * @var $to CActiveRecord|NestedSetBehavior
         * @var $moved CActiveRecord|NestedSetBehavior
         */
        $to    = CActiveRecord::model($this->modelName)->findByPk((int)$to);
        $moved = CActiveRecord::model($this->modelName)->findByPk((int)$id);

        if (!is_null($to) && !is_null($moved)) {
            try {
                switch ($type) {
                    case 'child':
                        $moved->moveAsLast($to);
                        break;
                    case 'before':
                        if ($to->isRoot()) {
                            $moved->moveAsRoot();
                        } else {
                            $moved->moveBefore($to);
                        }
                        break;
                    case 'after':
                        if ($to->isRoot()) {
                            $moved->moveAsRoot();
                        } else {
                            $moved->moveAfter($to);
                        }
                        break;
                }
                if (!Yii::app()->request->isAjaxRequest) {
                    $this->controller->redirect(Yii::app()->request->urlReferrer);
                }
            } catch ( Exception $e ) {
                throw new CHttpException(500, $e->getMessage());
            }
        } else {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
    }
}

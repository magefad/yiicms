<?php

class DefaultController extends Controller
{
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array('rights');
    }

    public function actions()
    {
        return array(
            'toggle' => array(
                'class'     => 'ext.grid.actions.TbTreeToggleAction',
                'modelName' => 'Menu',
            ),
            'create'   => array(
                'class'     => 'ext.grid.actions.Create',
                'modelName' => 'Menu'
            ),
            'update'   => array(
                'class'     => 'ext.grid.actions.Update',
                'modelName' => 'Menu'
            ),
            'delete'   => array(
                'class'     => 'ext.grid.actions.Delete',
                'modelName' => 'Menu'
            ),
            'moveNode'   => array(
                'class'     => 'ext.grid.actions.MoveNode',
                'modelName' => 'Menu'
            ),
            'makeRoot'   => array(
                'class'     => 'ext.grid.actions.MakeRoot',
                'modelName' => 'Menu'
            ),
        );
    }

    /**
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     * @param CAction $action the action just executed.
     * @todo Костыль удаления кэшей меню при перемещении узла, расширить NestedSetBehavior - добавить event afterMove()
     */
    protected function afterAction($action)
    {
        if ($action->id == 'moveNode') {
            $menus = Menu::model()->roots()->findAll();
            foreach ( $menus as $menu ) {
                /** @var $menu Menu */
                Yii::app()->cache->delete('menu_' . $menu->code);
            }
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }



    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Menu');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Menu('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Menu'])) {
            $model->attributes = $_GET['Menu'];
        }
        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id
     * @throws CHttpException
     * @internal param \the $integer ID of the model to be loaded
     * @return Menu
     */
    public function loadModel($id)
    {
        $model = Menu::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

<?php

class DefaultController extends Controller
{
    /**
     * @return array a list of filter configurations.
     */
    public function filters()
    {
        return array(
             array('auth.components.AuthFilter')/** @see AuthFilter */
        );
    }

    public function actionIndex()
    {
        $this->render('index', $this->module->getModules());
    }
}

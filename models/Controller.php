<?php

namespace app\models;

class Controller extends \yii\web\Controller

{

    public function generateTitle()
    {
//        $this->view->title = 'Web Shop';
//        $this->view->title = __METHOD__;
        return __METHOD__;
    }

    public function beforeAction($action)
    {
        $this->view->title = __METHOD__;
//        $this->view->title = 'Web Shop';
        $this->generateTitle();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

}
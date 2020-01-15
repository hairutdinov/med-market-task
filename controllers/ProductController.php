<?php
namespace app\controllers;

class ProductController extends \yii\base\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
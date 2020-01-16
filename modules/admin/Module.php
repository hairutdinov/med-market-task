<?php

namespace app\modules\admin;
use app\commands\RbacController;
use yii\web\ForbiddenHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = '/admin';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (!\Yii::$app->user->can(RbacController::VIEW_ADMIN_PANEL)) {
            throw new ForbiddenHttpException();
        }
    }
}

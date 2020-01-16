<?php

namespace app\commands;

use yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        
        $viewProductList = $auth->createPermission('viewProductList');
        $viewProductList->description = 'Просмотр списка товаров';
        $auth->add($viewProductList);


        $viewProductCard = $auth->createPermission('viewProductCard');
        $viewProductCard->description = 'Просмотр карточки товара';
        $auth->add($viewProductCard);


        $createProduct = $auth->createPermission('createProduct');
        $createProduct->description = 'Создание товара';
        $auth->add($createProduct);


        $updateProduct = $auth->createPermission('updateProduct');
        $updateProduct->description = 'Редактирование товара';
        $auth->add($updateProduct);


        $deleteProduct = $auth->createPermission('deleteProduct');
        $deleteProduct->description = 'Удаление товара';
        $auth->add($deleteProduct);


        $viewAdminPanel = $auth->createPermission('viewAdminPanel');
        $viewAdminPanel->description = 'Доступ к админ панели';
        $auth->add($viewAdminPanel);


        $client = $auth->createRole('client');
        $auth->add($client);
        $auth->addChild($client, $viewProductList);
        $auth->addChild($client, $viewProductCard);



        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $createProduct);
        $auth->addChild($manager, $updateProduct);
        $auth->addChild($manager, $deleteProduct);
        $auth->addChild($manager, $client);



        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manager);


        $auth->assign($client, 3);
        $auth->assign($manager, 2);
        $auth->assign($admin, 1);
    }
}
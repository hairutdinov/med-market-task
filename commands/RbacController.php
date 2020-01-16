<?php

namespace app\commands;

use yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /*
     * Permissions
     * */
    const VIEW_PRODUCT_LIST = 'viewProductList';
    const VIEW_PRODUCT_CARD = 'viewProductCard';
    const CREATE_PRODUCT = 'createProduct';
    const UPDATE_PRODUCT = 'updateProduct';
    const DELETE_PRODUCT = 'deleteProduct';
    const VIEW_ADMIN_PANEL = 'viewAdminPanel';

    /*
     * Roles
     * */
    const ROLE_CLIENT = 'client';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';


    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        
        $viewProductList = $auth->createPermission(self::VIEW_PRODUCT_LIST);
        $viewProductList->description = 'Просмотр списка товаров';
        $auth->add($viewProductList);


        $viewProductCard = $auth->createPermission(self::VIEW_PRODUCT_CARD);
        $viewProductCard->description = 'Просмотр карточки товара';
        $auth->add($viewProductCard);


        $createProduct = $auth->createPermission(self::CREATE_PRODUCT);
        $createProduct->description = 'Создание товара';
        $auth->add($createProduct);


        $updateProduct = $auth->createPermission(self::UPDATE_PRODUCT);
        $updateProduct->description = 'Редактирование товара';
        $auth->add($updateProduct);


        $deleteProduct = $auth->createPermission(self::DELETE_PRODUCT);
        $deleteProduct->description = 'Удаление товара';
        $auth->add($deleteProduct);


        $viewAdminPanel = $auth->createPermission(self::VIEW_ADMIN_PANEL);
        $viewAdminPanel->description = 'Доступ к админ панели';
        $auth->add($viewAdminPanel);


        $client = $auth->createRole(self::ROLE_CLIENT);
        $auth->add($client);
        $auth->addChild($client, $viewProductList);
        $auth->addChild($client, $viewProductCard);



        $manager = $auth->createRole(self::ROLE_MANAGER);
        $auth->add($manager);
        $auth->addChild($manager, $createProduct);
        $auth->addChild($manager, $updateProduct);
        $auth->addChild($manager, $deleteProduct);
        $auth->addChild($manager, $client);



        $admin = $auth->createRole(self::ROLE_ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $manager);


        $auth->assign($client, 3);
        $auth->assign($manager, 2);
        $auth->assign($admin, 1);
    }
}
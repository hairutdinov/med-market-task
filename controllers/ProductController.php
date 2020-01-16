<?php

namespace app\controllers;

use app\commands\RbacController;
use app\models\Category;
use Yii;
use app\models\Product;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{


    public function actionIndex()
    {
        if (!Yii::$app->user->can(RbacController::VIEW_PRODUCT_LIST)) {
            throw new ForbiddenHttpException('Нет прав для просмотра данной страницы! ');
        }

        $products = Product::getProductsWithImagesAndCategories();
        // Отображение всех категорий для товаров
        $categories = Category::all();

        return $this->render('index', compact('products', 'categories'));
    }

    /**
     * Отображение только одного товара (карточка товара).
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can(RbacController::VIEW_PRODUCT_CARD)) {
            throw new ForbiddenHttpException('Нет прав для просмотра данной страницы! ');
        }

        $product = Product::getProductWithImagesAndCategory(["product.id" => $id]);
        if ($product !== null) {
            return $this->render('view', compact('product'));
        }
        throw new NotFoundHttpException("Страница не найдена");
    }

}

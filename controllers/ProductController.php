<?php

namespace app\controllers;

use app\models\Category;
use app\models\ProductImage;
use app\models\UploadFileForm;
use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
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
        $product = Product::getProductWithImagesAndCategory(["product.id" => $id]);
        if ($product !== null) {
            return $this->render('view', compact('product'));
        }
        throw new NotFoundHttpException("Страница не найдена");
    }

}

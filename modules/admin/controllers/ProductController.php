<?php

namespace app\modules\admin\controllers;

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


    /**
     * Создание нового товара
     * Если товар успешно создан, редирект на Карточку товара
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        // Для DropDown элемента нужны все категории
        $categories = Category::all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', compact('model', 'categories'));
    }

    /**
     * Updates an existing Product model.
     * Если товар успешно отредактирован, редирект на Карточку товара
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id=null)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $images = $model->productImages;

        // Для DropDown элемента нужны все категории
        $categories = Category::all();

        $productImageModel = new ProductImage();

        $uploadImageModel = new UploadFileForm();

        if (Yii::$app->request->isPost) {
            if (count($images) === 5) {
                Yii::$app->session->setFlash('upload-file__error', 'Максимальное количество изображений: 5');
            } else {
                if ($productImageModel->saveFileOnServer($uploadImageModel)) {
                    $productImageModel->saveInDatabase($uploadImageModel->imageFile->name, $id);
                }
            }

        }

        return $this->render('update', compact('model', 'categories', 'productImageModel', 'uploadImageModel', 'images'));
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

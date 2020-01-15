<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Update Product: ' . $model->name;

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/products']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['/product/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="product-update">
  <h1><?= Html::encode($this->title) ?></h1>

  <?php if (\Yii::$app->session->hasFlash('upload-file__error')): ?>
    <div class="alert alert-danger"><?= \Yii::$app->session->getFlash('upload-file__error') ?></div>
  <?php elseif (\Yii::$app->session->hasFlash('upload-file__success')): ?>
    <div class="alert alert-success"><?= \Yii::$app->session->getFlash('upload-file__success') ?></div>
  <?php endif; ?>

  <?= $this->render('_form', compact('model', 'categories')) ?>

  <div class="product-update__gallery px-2 py-4 border">
    <h4>Изображения:</h4>

    <div class="row m-0">
        <?php foreach ($model->productImages as $image): ?>
          <div class="product-update__image col-2">
            <img src="<?= \yii\helpers\Url::to(["@web/uploads/{$image['url']}"]) ?>" alt="Изображение <?= $image['url'] ?>">
          </div>
        <?php endforeach; ?>
    </div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', "class" => "mt-4"]]); ?>
      <?= $form->field($uploadImageModel, 'imageFile')->fileInput([]); ?>
      <?= Html::submitButton('Загрузить изображение', ["class" => "btn btn-primary"]); ?>
    <?php ActiveForm::end(); ?>
  </div>


</div>

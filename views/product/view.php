<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $product app\models\Product */

$this->title = $product["name"];

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-card-wrapper">

    <button class="btn btn-success">Update (not work)</button>
    <button class="btn btn-danger">Delete (not work)</button>
    
    <?php //debug($product); ?>

    <div class="product__card row my-4">

      <div class="product__gallery col-4">
        <div class="product-gallery__main-image">
          <?php if (count($product['productImages']) > 0): ?>
          <img src="<?= \yii\helpers\Url::to(["@web/uploads/{$product['productImages'][0]['url']}"]) ?>" alt="Изображение <?= $product["name"] ?>">
          <?php else: ?>
            <img src="<?= \yii\helpers\Url::to(['@web/uploads/no-image.jpg']) ?>" alt="Изображение товара отсутствует">
          <?php endif; ?>
        </div>

        <div class="product-gallery__other-images">
          <?php if (count($product['productImages']) > 1): ?>
            <?php foreach (array_slice($product['productImages'], 1) as $productImage): ?>
              <img src="<?= \yii\helpers\Url::to(["@web/uploads/{$productImage['url']}"]) ?>" alt="Изображение <?= $productImage['url'] ?>">
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

      </div>

      <div class="product__info col-8">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="product__description">
          <?php if (!empty($product["description"])): ?>
              <?= $product["description"] ?>
          <?php else : ?>
              <div class="alert alert-info">Данный товар не содержит описания</div>
          <?php endif; ?>

        </div>
      </div>

    </div>
  
</div>

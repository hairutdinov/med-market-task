<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Продукты';
?>
<div class="product row">

    <div class="col-12">
<!--      <p>-->
<!--          --><?//= Html::a('Создать новый товар', ['create'], ['class' => 'btn btn-success']) ?>
<!--      </p>-->
    </div>

    <div class="product__category col-md-4 col-xl-3">
      <h3 class="category__title">Категории</h3>
      <div class="category__list">
        <div class="category__item"><a href="<?= \yii\helpers\Url::to(["/product"]) ?>" class="category__link">Все товары</a></div>
        <?php foreach ($categories as $category_id => $category_name): ?>
          <div class="category__item"><a href="<?= \yii\helpers\Url::to(["/products/category/{$category_id}"]) ?>" class="category__link"><?= $category_name ?></a></div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="product__list-wrapper col-md-8 col-xl-90">
      <h3 class="product-list-wrapper__title">Товары</h3>
      <div class="product-list">
        <div class="row">

          <?php foreach ($products as $product): ?>
          <div class="product-item col-md-6 col-lg-4">
            <?php if (count($product["productImages"]) > 0): ?>
              <img src="<?= \yii\helpers\Url::to(['@web/uploads/' . $product["productImages"][0]["url"]]) ?>" alt="Изображение товара" class="product__img">
            <?php else: ?>
              <img src="<?= \yii\helpers\Url::to(['@web/uploads/no-image.jpg']) ?>" alt="Изображение товара отсутствует" class="product__img">
            <?php endif; ?>
            <h4 class="product__name"><?= $product["name"] ?></h4>
            <p class="product__price">

              <?= number_format($product["price"], 0, '', ' ') ?> &#8381;
            </p>
            <footer>
              <div class="product__buttons-wrapper">
                <button class="product__button product__button_orange">В корзину</button>
                <a href="<?= \yii\helpers\Url::to(["/product/view/{$product['id']}"]) ?>" class="product__button product__button_gray">Подробнее</a>
              </div>
            </footer>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>


</div>

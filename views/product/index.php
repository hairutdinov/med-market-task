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

    <div class="product__category col-3">
      <h3 class="category__title">Категории</h3>
      <div class="category__list">
        <div class="category__item"><a href="" class="category__link">Смартфоны</a></div>
        <div class="category__item"><a href="" class="category__link">Ноутбуки</a></div>
      </div>
    </div>

    <div class="product__list-wrapper col-9">
      <h3 class="product-list-wrapper__title">Товары</h3>
      <div class="product-list">
        <div class="row">

          <?php foreach (range(0,4) as $v): ?>
          <div class="product-item col-4">
            <img src="uploads/coffeemachine.png" alt="Изображение товара" class="product__img">
            <h4 class="product__name">Кофемашина Power 4000</h4>
            <p class="product__price">
              56 999&#8381;
            </p>
            <footer>
              <div class="product__buttons-wrapper">
                <button class="product__button product__button_orange">В корзину</button>
                <button class="product__button product__button_gray">Подробнее</button>
              </div>
            </footer>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>


</div>

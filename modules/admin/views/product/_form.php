<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, "class" => "form-control"]) ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'price')->textInput() ?>
    </div>
  </div>

  <div class="row">
    <div class="col-6">
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-6">
        <?= $form->field($model, 'category_id')->dropDownList($categories) ?>
    </div>

  </div>

  <div class="form-group">
      <?= Html::submitButton('Сохранить', ['class' => 'product-form__button']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

\antkaz\vue\VueAsset::register($this);

$this->title = 'Редактирование товара: ' . $model->name;

$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/admin/product/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['/admin/product/view', 'id' => $model->id]];
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

  <div class="row">
    <div class="col-6 drop-zone-wrapper">
      <div class="dropzone" id="dropzone">Перетащите изображения сюда</div>
    </div>

    <div class="col-6 uploaded-images" id="uploaded-images">

      <div class="image-item" v-for="options in images">
        <img v-bind:src="'<?= \yii\helpers\Url::to(["@web/uploads"]) ?>/' + options.path" alt="">
      </div>

    </div>
  </div>

</div>


<?php
$js = "
(function () {
  let dropzone = $('#dropzone');
  
  dropzone.on('dragover', function(e) {
    e.preventDefault();
    $(this).addClass('dragover');
  });
  
  dropzone.on('dragleave', function(e) {
    e.preventDefault();
    $(this).removeClass('dragover');
  });
  
  dropzone.on('drop', function(e) {
    e.preventDefault();
    $(this).removeClass('dragover');
    upload(e.originalEvent.dataTransfer.files);
  });
  
  function upload(files) {
    let formData = new FormData();
    for (let key in files) {
      let item = files[key];
      formData.append('file[]', item);
    }
    
    $.ajax({
        url: '" . \yii\helpers\Url::to(['/admin/product/upload-image'], true) . "',
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        success(data) {
          let uploadedImages = data.uploaded_images;
          for (let key in uploadedImages) {
            let imageObj = {
              id: uploadedImages[key]['id'],
              path: uploadedImages[key]['filename'],
              name: uploadedImages[key]['name']
            };
            Vue.set(app.images, app.images.length, imageObj);
          }
          console.log(data);
        },
        error(err) {
          
        }
      });
  }
  
})();
";
$this->registerJs($js);

?>

<script>
  let productId = "<?=Yii::$app->request->get("id")?>";
  var app = new Vue({
    el: '#uploaded-images',
    data: {
      images: null
    },
    methods: {
      getImages() {
        fetch("http://med_market.loc/admin/product/get-images", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify({productId})
        })
          .then(response => response.json())
          .then(images => {
            for (let key in images) {
              let img = new Image();
              img.src = images[key]["path"];
              img.onerror = () => {
                images[key]["path"] = "no-image.jpg";
              }
            }
            this.images = images
          });
        /*$.ajax({
          url: 'http://med_market.loc/admin/product/get-images',
          type: 'POST',
          data: ({productId: 2}),
          dataType: 'json',
          cache: false,
          success(data) {
            console.log(data);
          },
          error(err) {

          }
        });*/
      }
    },
    created() {
      this.getImages();
    }
  })
</script>
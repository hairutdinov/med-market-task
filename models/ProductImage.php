<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "product_images".
 *
 * @property int $id
 * @property string $url
 * @property int $product_id
 *
 * @property Product $product
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'product_id'], 'required'],
            [['product_id'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }


    public function saveFileOnServer($uploadImageModel)
    {
        $uploadImageModel->imageFile = UploadedFile::getInstance($uploadImageModel, 'imageFile');

        if (file_exists("uploads/" . $uploadImageModel->imageFile->name)) {
            Yii::$app->session->setFlash('upload-file__error', 'Файл с таким именем уже существует');
            return false;
        } else {
            if ($uploadImageModel->upload()) {
                return true;
            }
        }
        return false;
    }

    public function saveInDatabase($filename, $product_id)
    {
        $this->url = $filename;
        $this->product_id = $product_id;

        try {
            if (!$this->save()) {
                Yii::$app->session->setFlash('upload-file__error', 'При сохранении файла в БД произошла ошибка');
            } else {
                Yii::$app->session->setFlash('upload-file__success', 'Изображение успешно сохранено');
            }
        } catch (Exception $e) {
            Yii::$app->session->setFlash('upload-file__error', 'При сохранении файла в БД произошла ошибка. Попробуйте изменить имя файла.');
            Yii::debug($e->errorInfo[2]);
        }
        return false;
    }

}

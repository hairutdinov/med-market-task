<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_images".
 *
 * @property int $id
 * @property string $path
 * @property string $name
 * @property int $product_id
 * @property int $index
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
            [['path', 'name', 'product_id'], 'required'],
            [['product_id', 'index'], 'integer'],
            [['path'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 200],
            [['path'], 'unique'],
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
            'path' => 'Path',
            'name' => 'Name',
            'product_id' => 'Product ID',
            'index' => 'Index',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}

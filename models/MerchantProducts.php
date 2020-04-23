<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merchant_products".
 *
 * @property int $id
 * @property int $created_at
 * @property string|null $vendor_code
 * @property string $title
 * @property int|null $price
 * @property int|null $old_price
 * @property string|null $image
 * @property int|null $quantity
 */
class MerchantProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'merchant_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'title'], 'required'],
            [['created_at', 'price', 'old_price', 'quantity'], 'integer'],
            [['vendor_code', 'image'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'vendor_code' => 'Vendor Code',
            'title' => 'Title',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'image' => 'Image',
            'quantity' => 'Quantity',
        ];
    }
}

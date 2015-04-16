<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wholesale".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $min_item
 * @property integer $max_item
 * @property integer $condition_product_id
 * @property integer $condition_product_min
 * @property integer $price
 *
 * @property Product $product
 * @property Product $conditionProduct
 */
class Wholesale extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wholesale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'min_item', 'price'], 'required'],
            [['product_id', 'min_item', 'max_item', 'condition_product_id', 'condition_product_min', 'price'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'min_item' => 'Min Item',
            'max_item' => 'Max Item',
            'condition_product_id' => 'Condition Product ID',
            'condition_product_min' => 'Condition Product Min',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConditionProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'condition_product_id']);
    }
}

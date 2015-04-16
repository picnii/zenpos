<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price_list".
 *
 * @property integer $product_id
 * @property integer $branch_id
 * @property integer $price
 * @property string $update_time
 *
 * @property Product $product
 * @property Branch $branch
 */
class PriceList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'branch_id', 'price'], 'required'],
            [['product_id', 'branch_id', 'price'], 'integer'],
            [['update_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'branch_id' => 'Branch ID',
            'price' => 'Price',
            'update_time' => 'Update Time',
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
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    public function getName()
    {
        return $this->product->name;
    }

     public function getId()
    {
        return $this->product->id;
    }

    public function getRetail_price()
    {
        return $this->product->retail_price;
    }

    public static function loadProducts($branch_id)
    {
        $product_list = self::find()->joinWith('product', 'FULL OUTER JOIN')->where(['branch_id' => $branch_id])->all();
        //$branch = Branch::findOne($branch_id);
         //$product_list =   Product::find()->joinWith('pricelist')->joinWith('brand')->where(['brand.id' => $branch->id])->all();
        if($product_list == null || count($product_list) < 1)
        {
            $products = Product::find()->joinWith('branches')->where(['branch.id' => $branch_id])->all();
            for($i = 0; $i < count($products); $i++)
                $products[$i]->price = $products[$i]->retail_price;
            return $products;

        }else{

            //must join with product too


            return $product_list;

        }
    }

    public static function saveProducts($branch_id, $products)
    {

    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory".
 *
 * @property integer $product_id
 * @property integer $branch_id
 * @property integer $count
 * @property string $update_time
 *
 * @property Branch $branch
 * @property Product $product
 */
class Inventory extends \yii\db\ActiveRecord
{

    public $add_new;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'branch_id', 'count'], 'required'],
            [['product_id', 'branch_id', 'count', 'add_new'], 'integer'],
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
            'count' => 'Count',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getName()
    {
        $product = $this->product;
        return $product->name;
    }

    public function getProductName()
    {
        $product = Product::findOne($this->product_id);
        return $product->name;
    }

    public function getProductCode()
    {
        $product = Product::findOne($this->product_id);
        return $product->code;
    }

    public function getProductType()
    {
        $product = Product::findOne($this->product_id);
        return $product->type;
    }

    public function getProductPrice()
    {
        $product = Product::findOne($this->product_id);
        return $product->retail_price;
    }

    public function getProductInfo()
    {
        $product = Product::findOne($this->product_id);
        $wholesales = Wholesale::find()->where(['product_id' => $this->product_id])->all();
        $minWholesales = 0;
        $item_ranges = [];
        for($i = 0; $i < count($wholesales); $i++)
        {
            if($minWholesales == 0)
                $minWholesales = $wholesales[$i]->min_item;
            else if($wholesales[$i]->min_item < $minWholesales)
                $minWholesales = $wholesales[$i]->min_item;
            //{"from":12,"to":24,"price":520}
            array_push($item_ranges, [
                "from" => $wholesales[$i]->min_item,
                "price"=> $wholesales[$i]->price
            ]);
        }
        $arr = [
                'id' => $product->id,
                'name' => $product->name,
                'count' => $this->count,
                'code' => $product->code,
                'type' => $product->type,
                'price' => $product->retail_price,
                'hasCondition' => false,
                'minumWholeSales' => $minWholesales,
                'item_ranges' => $item_ranges,
                'condition' => null,
        ];
        return $arr;
    }

     public function getBrand_id()
    {
        $branch = Branch::findOne($this->branch_id);
        return $branch->brand_id;
    }

    public function beforeSave($insert)
    {
        if(isset($this->add_new) )
        {
            $this->count += $this->add_new;
        }
        return parent::beforeSave($insert);
    }
}

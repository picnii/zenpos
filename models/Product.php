<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property integer $retail_price
 * @property string $create_time
 * @property string $update_time
 * @property string $code
 * @property integer $brand_id
 *
 * @property Inventory[] $inventories
 * @property Branch[] $branches
 * @property Brand $brand
 * @property Wholesale[] $wholesales
 */
class Product extends \yii\db\ActiveRecord
{
    public $price;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'retail_price', 'code', 'brand_id', 'type'], 'required'],
            [['retail_price', 'brand_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['code'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'retail_price' => 'Retail Price',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'code' => 'Code',
            'brand_id' => '',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['id' => 'branch_id'])->viaTable('inventory', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricelist()
    {
        return $this->hasMany(PriceList::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWholesales()
    {
        return $this->hasMany(Wholesale::className(), ['condition_product_id' => 'id']);
    }

    public function getCount()
    {
        $query = (new \yii\db\Query())->from('product')->innerJoin('inventory', 'inventory.product_id = product.id')->innerJoin('branch', 'inventory.branch_id = branch.id');
        $query->where("product.brand_id = {$this->brand_id} AND product.id = {$this->id} ");
        $sum = $query->sum('count');
        return $sum;
    }

    public static function getCountFromBrand($id)    
    {
        $count =  Product::find()->where(['brand_id' => $id])->count();
        return $count;
    }

    public static function getItemFromBrand($id)
    {
        //slow 
        /*SELECT  sum(`inventory`.`count`) FROM `product` INNER JOIN `inventory` ON `inventory`.`product_id` = `product`.`id` INNER JOIN `branch` on `inventory`.`branch_id` = `branch`.`id` WHERE `branch`.`brand_id` = 6*/
        //$sql = "SELECT SUM( `branch`.`id`)FROM `branch` INNER JOIN `inventory` ON `inventory`.`branch_id` = `branch`.`id` INNER JOIN `product` on `inventory`.`product_id` = `product`.`id` WHERE `branch`.`brand_id` = {{$this->brand_id}}";
        $query = (new \yii\db\Query())->from('product')->innerJoin('inventory', 'inventory.product_id = product.id')->innerJoin('branch', 'inventory.branch_id = branch.id');
        $query->where("product.brand_id = {$id}");
        $sum = $query->sum('count');
        return $sum;

    }
}

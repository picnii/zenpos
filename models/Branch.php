<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property integer $id
 * @property string $name
 * @property integer $brand_id
 * @property integer $branch_type_id
 * @property integer $address_id
 * @property string $create_time
 * @property string $update_time
 *
 * @property Address $address
 * @property BranchType $branchType
 * @property Brand $brand
 * @property Inventory[] $inventories
 * @property Product[] $products
 * @property Sales[] $sales
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'brand_id', 'branch_type_id','password', 'password_manager'], 'required'],
            [['brand_id', 'branch_type_id', 'address_id', 'tax_percent'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 45]
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
            'brand_id' => 'Brand ID',
            'branch_type_id' => 'Branch Type ID',
            'address_id' => 'Address ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'leftover' => 'ยอดค้างชำระ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchType()
    {
        return $this->hasOne(BranchType::className(), ['id' => 'branch_type_id']);
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
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('inventory', ['branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSales()
    {
        return $this->hasMany(Sales::className(), ['branch_id' => 'id']);
    }

    public function getAddressText()
    {
        $address = Address::findOne($this->address_id);
        return "{$address->address} {$address->district} {$address->province}";
    }

    public function getLastSale()
    {
        $sale =  Sales::find()->where(['branch_id' => $this->id])->orderBy('create_time DESC')->one();
        if($sale !== null)
            return $sale;
        else
        {
            $empty_sale =  new Sales();
            $empty_sale->create_time = "-";
            $empty_sale->amount = 0;
            return $empty_sale;
        }
        
    }

    public function getLeftover()
    {
        $query = (new \yii\db\Query())->from('bill_pending');
        $query->where("bill_pending.branch_id = {$this->id}");
        $sum = $query->sum('amount');
        return $sum;
    }

    public function getType()
    {
        $branchType = $this->branchType;
        return $branchType->name;        
    }

    public function canView($type)
    {

        if($type == 'stock' && $this->branch_type_id ==  \Yii::$app->params['branchType']['substore'])
            return true;
        if(($type == 'bills' || $type == 'prices') && $this->branch_type_id ==  \Yii::$app->params['branchType']['partner'])    
            return true;
        return false;
    }
   
}

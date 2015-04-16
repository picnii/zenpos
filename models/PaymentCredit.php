<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_credit".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property string $name
 * @property integer $charge_percent
 * @property integer $charge_amount
 *
 * @property Brand $brand
 */
class PaymentCredit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_credit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'brand_id', 'name', 'charge_percent', 'charge_amount'], 'required'],
            [['id', 'brand_id', 'charge_percent', 'charge_amount'], 'integer'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'name' => 'Name',
            'charge_percent' => 'Charge Percent(%)',
            'charge_amount' => 'Charge Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
}

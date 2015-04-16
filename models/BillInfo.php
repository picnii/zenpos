<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "bill_info".
 *
 * @property integer $brand_id
 * @property string $address_line1
 * @property string $address_line2
 * @property string $phone_number
 * @property string $email
 * @property string $website
 * @property integer $tax_number
 *
 * @property Brand $brand
 */
class BillInfo extends \yii\db\ActiveRecord
{
    public $logo, $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id', 'address_line1', 'address_line2', 'phone_number', 'email', 'website', 'tax_number'], 'required'],
            [['brand_id', 'tax_number'], 'integer'],
            [['file'], 'file'],
            [['address_line1', 'address_line2'], 'string'],
            [['phone_number'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 200],
            [['website'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => 'Brand ID',
            'address_line1' => 'Address Line1',
            'address_line2' => 'Address Line2',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'website' => 'Website',
            'tax_number' => 'Tax Number',
            'file' => 'Logo',
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

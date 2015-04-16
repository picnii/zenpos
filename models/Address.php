<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $address
 * @property string $district
 * @property string $province
 * @property string $zipcode
 *
 * @property Branch[] $branches
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'district', 'province', 'zipcode'], 'required'],
            [['address'], 'string', 'max' => 150],
            [['district', 'province', 'zipcode'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'district' => 'District',
            'province' => 'Province',
            'zipcode' => 'Zipcode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['address_id' => 'id']);
    }
}

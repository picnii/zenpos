<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property integer $id
 * @property string $log
 * @property string $create_time
 * @property integer $brand_id
 *
 * @property Brand $brand
 */
class Bill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log', 'brand_id'], 'required'],
            [['log'], 'string'],
            [['create_time'], 'safe'],
            [['brand_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log' => 'Log',
            'create_time' => 'Create Time',
            'brand_id' => 'Brand ID',
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

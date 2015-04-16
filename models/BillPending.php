<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill_pending".
 *
 * @property integer $branch_id
 * @property integer $bill_id
 * @property integer $amount
 * @property string $update_time
 *
 * @property Branch $branch
 * @property Bill $bill
 */
class BillPending extends \yii\db\ActiveRecord
{
    public $paid_amount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_pending';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'bill_id', 'amount'], 'required'],
            [['branch_id', 'bill_id', 'amount', 'paid_amount'], 'integer'],
            [['update_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'branch_id' => 'Branch ID',
            'bill_id' => 'Bill ID',
            'amount' => 'Amount',
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
    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id']);
    }

   

    public function paid()
    {
        $this->amount -= $this->paid_amount;
        return $this->save();
    }
}

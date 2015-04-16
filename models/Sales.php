<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales".
 *
 * @property integer $id
 * @property integer $branch_id
 * @property integer $amount
 * @property integer $create_time
 * @property string $log
 *
 * @property Branch $branch
 */
class Sales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'amount', 'log'], 'required'],
            [['branch_id', 'amount', 'create_time'], 'integer'],
            [['log'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_id' => 'Branch ID',
            'amount' => 'Amount',
            'create_time' => 'Create Time',
            'log' => 'Log',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    public function getBrand()
    {
        //return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('inventory', ['branch_id' => 'id']);
        return $this->hasOne(Brand::className(), ['id' => 'brand_id'])->via('branch');
    }

    public function getBranchName()
    {
        $branch = $this->branch;
        return $branch->name;
    }


    public static function getYearlySales($brand_id, $year )
    {
        $query = (new \yii\db\Query())->from('sales')->innerJoin('branch', 'branch_id = branch.id')->innerJoin('brand', 'branch.brand_id = brand.id');
        $query->where("sales.create_time LIKE \"{$year}-%-%\" AND brand.id = {$brand_id}");
        $sum = $query->sum('amount');
        return $sum;
    }

    public static function getMonthSales($brand_id,$month)
    {
        $current_year = date("Y");
        $query = (new \yii\db\Query())->from('sales')->innerJoin('branch', 'branch_id = branch.id')->innerJoin('brand', 'branch.brand_id = brand.id');
        $query->where("sales.create_time LIKE \"{$current_year}-{$month}-%\" AND brand.id = {$brand_id}");
        $sum = $query->sum('amount');
        return $sum;
    }

    public static function getMontyGraphJSON($brand_id, $month)
    {
         $current_year = date("Y");
        $sales = self::find()->joinWith('branch')->joinWith('brand')->where(['brand.id' => $brand_id])->all();

        $group = [];
        for($i = 0; $i < count($sales); $i++)
        {
            
            
            $phpdate = strtotime( $sales[$i]->create_time);
            $date = date( 'd', $phpdate );
            $group[$date][] = $sales[$i];
        }
        $labels = [];
        $data = [];
        foreach($group as $key => $items)
        {
            $labels[] = $key.'';
            $sum = 0;
            foreach ($items as $item) {
                # code...
                $sum += $item->amount;
            }
            $data[] = $sum;
        }

 
           
        $answer = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label'=> "Monthy Sales",
                    'data' => $data,
                    "fillColor" => "rgba(220,220,220,0.2)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(220,220,220,1)",
                    "pointStrokeColor" => "#fff",
                    "pointHighlightFill" => "#fff",
                    "pointHighlightStroke" => "rgba(220,220,220,1)",
                ],

            ]

        ];



        return $answer;
    }

    public static function getGraphJSON($sales)
    {
         $group = [];
        for($i = 0; $i < count($sales); $i++)
        {
            
            
            $phpdate = strtotime( $sales[$i]->create_time);
            $date = date( 'd', $phpdate );
            $month = date('M', $phpdate);
            $group[$date.' '.$month][] = $sales[$i];
        }
        $labels = [];
        $data = [];
        foreach($group as $key => $items)
        {
            $labels[] = $key.'';
            $sum = 0;
            foreach ($items as $item) {
                # code...
                $sum += $item->amount;
            }
            $data[] = $sum;
        }

 
           
        $answer = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label'=> "Monthy Sales",
                    'data' => $data,
                    "fillColor" => "rgba(220,220,220,0.2)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(220,220,220,1)",
                    "pointStrokeColor" => "#fff",
                    "pointHighlightFill" => "#fff",
                    "pointHighlightStroke" => "rgba(220,220,220,1)",
                ],

            ]

        ];



        return $answer;


    }

}

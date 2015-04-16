<?php

use yii\helpers\Html;
use app\models\Sales;
use yii\grid\GridView;
use yii\web\View;
use yii\bootstrap\ButtonDropdown;
use app\models\Branch;
use yii\helpers\ArrayHelper ;
use yii\helpers\Url ;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        'Sales',
    ];
?>
<div class="sales-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= Html::a('Create Sales', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->



    <canvas id="myChart" width="800" height="400"></canvas>
    <?php 
        $this->registerJs("var ctx = document.getElementById('myChart').getContext('2d');var data = ".json_encode(Sales::getGraphJSON($dataProvider->getModels())).";var chart = new Chart(ctx).Line(data);", View::POS_END, 'my-options');

    ?>
    <div>

        <?php

            function getURL($id, $attr, $value, $params)
            {

                $base = ['sales/index', 'id' => $id];
                if(isset($params['SalesSearch']))
                    foreach ($params['SalesSearch'] as $key => $val) {
                        $base["SalesSearch[{$key}]"] = $val;
                    }
                $base[$attr] = $value;
                return Url::to($base);
            }

            $brand_id = $id;
            $items = ArrayHelper::toArray(Branch::find()->where(['brand_id'=>$id])->all(), 
                [

                    'app\models\Branch' => [
                        'label' => 'name',
                        'url' => function($item)
                        {
                            return getURL($item->brand_id, 'SalesSearch[branch_id]', $item->id, []);
                        }

                    ]
                ] 
            );
            $items[] = [
                'label' => 'ทุกสาขา',
                'url' =>  Url::to(['sales/index', 'id' => $brand_id]),
            ];
            $label = 'สาขา';
            $year_label = "ปี";
            $month_label = "เดือน";
            $date_label = "วัน";
            $current_time  = [];
            $current_time['year'] = date("Y");
            $current_time['month'] = date("m");
            $current_time['date'] = date('d');
            
            function getLabelFromCraeteTime($time)
            {
                $labels = explode("-", $time);
                $month =  "เดือน";
                $date = "วัน";;
                if(count($labels) >1)
                    $month = $labels[1];
                 if(count($labels) > 2)
                    $date = $labels[2];

                return [
                    'year' => $labels[0],
                    'month' => $month,
                    'date' => $date
                ];
            }

            function updateCurrentTime($current_time, $time)
            {

                 $labels = explode("-", $time);
                
                if(count($labels) > 0)
                    $current_time['year'] = $labels[0];
                if(count($labels) >1)
                    $current_time['month'] =  $labels[1];
               if(count($labels) > 2)
                    $current_time['date'] =  $labels[2];
                return $current_time;
            }



            foreach ($params['SalesSearch'] as $key => $value) {
                # code...
                //print_r($key);
                if($key == 'branch_id')
                    $label = Branch::findOne($params['SalesSearch']['branch_id'])->name;
                if($key == 'create_time')
                {
                    $labels = getLabelFromCraeteTime($value);
                    $year_label = $labels['year'];
                    $month_label = $labels['month'];
                    $date_label = $labels['date'];
                    $current_time =updateCurrentTime($current_time, $value);
                }
            }


          
                
            echo ButtonDropdown::widget([
                'label' => $label,
                'dropdown' => [
                    'items' =>$items,
                ],
            ]);

            //yearly thing
            $years  = [];
            for($year = 2015; $year <= 2020; $year++)
            {
                $url = getURL($id, 'SalesSearch[create_time]', $year, $params);
                $years[] = [
                    'label' => $year,
                    'url' => $url,  
                ];
            }
            $years[] = [
                'label' => 'ทุกปี',
                'url' =>  Url::to(['sales/index', 'id' => $brand_id]),
            ];
             echo ButtonDropdown::widget([
                'label' => $year_label,
                'dropdown' => [
                    'items' =>$years,
                ],
            ]);
            //Monthly thing
             $months  = [];
            for($month = 1; $month <= 12; $month++)
            {
                if($month < 10)
                    $show_month = "0".$month;
                else
                    $show_month = $month;
                $mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

                $url = getURL($id, 'SalesSearch[create_time]', $current_time['year']."-".$show_month, $params);
                $months[] = [
                    'label' => $mons[$month],
                    'url' => $url,  
                ];
            }
            $months[] = [
                'label' => 'ทุกเดือน',
                'url' =>  getURL($id, 'SalesSearch[create_time]', $current_time['year'] , $params),
            ];
             echo ButtonDropdown::widget([
                'label' => $month_label,
                'dropdown' => [
                    'items' =>$months,
                ],
            ]);

             //Date thing
             $dates  = [];
            for($date = 1; $date <= 31; $date++)
            {
                if($date < 10)
                    $show_date = "0".$date;
                else
                    $show_date = $date;
                $url = getURL($id, 'SalesSearch[create_time]', $current_time['year']."-".$current_time['month']."-".$show_date , $params);
                $dates[] = [
                    'label' => $date,
                    'url' => $url,  
                ];
            }
            $dates[] = [
                'label' => 'ทุกวัน',
                'url' =>  getURL($id, 'SalesSearch[create_time]', $current_time['year']."-".$current_time['month'] , $params),
            ];
             echo ButtonDropdown::widget([
                'label' => $date_label,
                'dropdown' => [
                    'items' =>$dates,
                ],
            ]);
        ?>

        
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'create_time',
            
            'branchName',
            'amount',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} ",
            ],
        ],
    ]); ?>

</div>

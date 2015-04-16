<?php 

use yii\helpers\Html;
use yii\grid\GridView;

$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $branch->brand_id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Branches',
            'url' => ['branch/index', 'id' => $branch->brand_id],
        ]

    ];
$this->params['breadcrumbs'] [] = "{$branch->name} Inventory";
?>
<h2>Inventory</h2>
<?= Html::a('Create', ['inventory_create',  'branch_id' => $branch_id ], ['class' => 'btn btn-success']); ?>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'productName',
            'count',
            // 'create_time',
            // 'update_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key)
                    {
                        return  Html::a('update', ['inventory_update', 'product_id' => $model->product_id, 'branch_id' => $model->branch_id ]);
                    },
                ],
                'template' => " {update} ",
            ],
        ],
    ]); ?>
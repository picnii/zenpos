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
$this->params['breadcrumbs'] [] = "{$branch->name} Bills";
?>
<div class="branch-bills">

    <h1>Bills</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create Bill', ['order', 'id' => $branch->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'bill_id',
            'amount',
            'update_time',
            // 'create_time',
            // 'update_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key)
                    {
                        return  Html::a('<span class="glyphicon  glyphicon-list-alt" aria-hidden="true"></span>', ['bill', 'id' => $model->bill_id, 'branch_id' => $model->branch_id ]);
                    },
                    'payment' => function ($url, $model, $key)
                    {
                        return  Html::a('<span class=" glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['payment', 'id' => $model->bill_id, 'branch_id' => $model->branch_id  ]);
                    },
                ],
                'template' => "{payment} {view}  ",
            ],
        ],
    ]); ?>

</div>

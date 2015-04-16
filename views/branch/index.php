<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BranchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Branches';
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        'Branches',
    ];
?>
<div class="branch-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Branch', ['create', 'id' => $id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'type',
            'password',
            'leftover',
            // 'create_time',
            // 'update_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key)
                    {
                        if($model->canView('stock'))
                            return  Html::a('<span class="glyphicon  glyphicon-list-alt" aria-hidden="true"></span> STOCK ', ['inventory', 'id' => $model->id ]);
                        return '';
                    },
                    'bills' => function ($url, $model, $key)
                    {
                        if($model->canView('bills'))
                            return  Html::a('<span class="glyphicon  glyphicon glyphicon-th-list" aria-hidden="true"></span> BIILS', ['bills', 'id' => $model->id ]);
                        return '';
                    },
                    'price_list' => function ($url, $model, $key)
                    {
                        if($model->canView('prices'))
                            return  Html::a('<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> PRICE', ['pricelist', 'id' => $model->id ]);
                        return '';
                    },
                ],
                'template' => "{update} {view} {bills} {price_list} {delete}",
            ],
        ],
    ]); ?>

</div>

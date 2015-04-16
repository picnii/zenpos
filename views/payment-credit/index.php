<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentCreditSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Credits';
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Bill Info',
            'url' => ['brand/billinfo', 'id' => $id],
        ]

    ];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="payment-credit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payment Credit', ['create', 'id'=>$id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'charge_percent',
            'charge_amount',

            ['class' => 'yii\grid\ActionColumn',

                'template' => "{update} {delete}"
            ],
        ],
    ]); ?>

</div>

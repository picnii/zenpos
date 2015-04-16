<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentCredit */

$this->title = 'Update Payment Credit: ' . ' ' . $model->name;
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $model->brand_id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Bill Info',
            'url' => ['brand/billinfo', 'id' => $model->brand_id],
        ],
        [
            'label' => 'Payment credits',
            'url' => ['payment-credit/index', 'id' => $model->brand_id],
        ]

    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-credit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

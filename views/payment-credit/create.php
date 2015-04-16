<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PaymentCredit */

$this->title = 'Create Payment Credit';
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Bill Info',
            'url' => ['brand/billinfo', 'id' => $id],
        ],
        [
            'label' => 'Payment credits',
            'url' => ['payment-credit/index', 'id' => $id],
        ]

    ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-credit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

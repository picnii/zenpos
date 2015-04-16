<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentCredit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payment Credits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-credit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'brand_id',
            'name',
            'charge_percent',
            'charge_amount',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $model->brand_id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Product',
            'url' => ['product/index', 'id' => $model->brand_id],
        ]
    ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

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
            'name',
            'retail_price',
            'create_time',
            'update_time',
            'code',
            'brand_id',
        ],
    ]) ?>

</div>

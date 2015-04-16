<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Update Product: ' . ' ' . $model->name;
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
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'wholesale' => $wholesale,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Create Product';
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Product',
            'url' => ['product/index', 'id' => $id],
        ],
        'Create',
    ];
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'wholesale' => $wholesale,
    ]) ?>

</div>

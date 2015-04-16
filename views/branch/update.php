<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */

$this->title = 'Update Branch: ' . ' ' . $model->name;
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $model->brand_id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Branches',
            'url' => ['branch/index', 'id' => $model->brand_id],
        ]

    ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'address' => $address
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Branch */

$this->title = 'Create Branch';
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Branches',
            'url' => ['branch/index', 'id' => $id],
        ]

    ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'address' => $address
    ]) ?>

</div>

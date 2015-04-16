<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Branch */
/* @var $form yii\widgets\ActiveForm */
use app\models\Branch;
$branch = Branch::findOne($model->branch_id);
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $branch->brand_id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Branches',
            'url' => ['branch/index', 'id' => $branch->brand_id],
        ]

    ];
$this->params['breadcrumbs'] [] =  [
            'label' => "{$branch->name} Inventory",
            'url' => ['branch/inventory', 'id' => $model->branch_id],
            
        ];	
$this->params['breadcrumbs'] [] = "Update"
?>

<div class="branch-form">

    <h2>Update</h2>
    <?= $this->render('_inventory_form', [
        'model' => $model,
    ]) ?>

</div>

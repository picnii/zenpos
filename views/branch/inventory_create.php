<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-form">

   <h2>Create</h2>
    <?= $this->render('_inventory_form', [
        'model' => $model,
    ]) ?>

</div>

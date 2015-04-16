<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Address */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'district')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'zipcode')->textInput(['maxlength' => 45]) ?>


    <?php ActiveForm::end(); ?>

</div>

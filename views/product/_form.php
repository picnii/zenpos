<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($model, 'type')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'retail_price')->textInput() ?>

    

    <?= $form->field($model, 'code')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'brand_id')->hiddenInput() ?>


    <h3>Wholesales</h3>
    <?= $form->field($wholesale, 'price_12')->textInput() ?>
    <?= $form->field($wholesale, 'have_12')->checkbox() ?>
    <?= $form->field($wholesale, 'price_36')->textInput() ?>
    <?= $form->field($wholesale, 'have_36')->checkbox() ?>
    <?= $form->field($wholesale, 'price_60')->textInput() ?>
    <?= $form->field($wholesale, 'have_60')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

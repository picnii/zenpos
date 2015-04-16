<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\BranchType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45]) ?>

    

    <?= $form->field($model, 'branch_type_id')->dropDownList(ArrayHelper::map(BranchType::find()->all(), 'id', 'name')) ?>

    
    

     <h2>Address</h2>

   <?= $form->field($address, 'address')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($address, 'district')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($address, 'province')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($address, 'zipcode')->textInput(['maxlength' => 45]) ?>
    <h2>Password</h2>
    <?= $form->field($model, 'password')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($model, 'password_manager')->textInput(['maxlength' => 45]) ?>
    <h2>Tax</h2>
    <?= $form->field($model, 'tax_percent')->input('number', ['min' => 0]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

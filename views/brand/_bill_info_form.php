<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Brand */
/* @var $form yii\widgets\ActiveForm */
$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $brand->id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        "Bill Info"

    ];
?>

<div class="brand-info-form">


    <p>
        <?= Html::a('เปลี่ยนชื่อร้าน และ Password', ['update', 'id' => $brand->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  
    <img src="../uploads/<?= $brand->logo ?>">
    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'address_line1')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'address_line2')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'phone_number')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => 150]) ?>
     <?= $form->field($model, 'tax_number')->textInput(['maxlength' => 150]) ?>
     <?= $form->field($model, 'tax_percent')->input('number') ?>
    
      <p>
        <?= Html::a('จัดการบัตรเครดิต', ['payment-credit/index', 'id' => $brand->id], ['class' => 'btn btn-success']) ?>
    </p>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

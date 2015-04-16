<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Product;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->where(['brand_id'=>$model->brand_id])->all(), 'id', 'name')) ?>
    <?= $form->field($model, 'count')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($model, 'add_new')->input('number',['placeholder'=>'new item count like 1234']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

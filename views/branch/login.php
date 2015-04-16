<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Branch;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>

    
<?= $form->field($model, 'branch_id')->dropDownList(ArrayHelper::map(Branch::find()->where(['brand_id' => $brand_id])->all(), 'id', 'name')) ?>
    
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 45]) ?>

    

    

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

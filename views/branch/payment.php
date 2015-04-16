<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	$orders = json_decode($bill->log);

?>
<h1>Payment</h1>
<?php $form = ActiveForm::begin(); ?>




<table class="table">
	<tr>
		<th>Bill to</th>
		<td><?= $orders->bill->bill_to ?> 
			<?= Html::a('View', ['bill',  'branch_id' => $bill_pending->branch_id, 'id'=> $bill->id ]
				, ['target' => '_blank']
			 ) ?></td>
	</tr>

	<tr>
		<th>Total</th>
		<td><?= $bill->subtotal ?></td>
	</tr>
	<tr>
		<th>Paid</th>
		<td>
			<?= $form->field($bill_pending, 'paid_amount')->textInput(['type'=>'number']) ?>
		</td>
	</tr>


</table>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php
	$orders = json_decode($bill->log);
	setlocale(LC_MONETARY,"th_TH");	
	$brand = $bill->brand;
	$bill_info = $brand->billInfo;
	$isPending = false;
	if($bill_pending != null)
		$isPending = true;

	function getMoneyFormat($number)
	{
		return number_format($number).' B';
	}



?>

<section>
	<div class="container">
	<div class="text-center">
		<div class="row">
		  	<div class="col-xs-4"> 
			  	<div><b><?= $brand->name ?></b></div>
			  	<div><?= $bill_info->address_line1 ?></div>
			  	<div ><?= $bill_info->address_line2 ?></div>
			  	<div><?= $bill_info->phone_number ?></div>
			  	<div><?= $bill_info->email ?></div>
			  	<div><?= $bill_info->website ?></div>
			</div>
		  	<div class="col-xs-4 logo"> <img src = "../uploads/<?= $brand->logo; ?>"></div>
		  	<div class="col-xs-4">
			  	<div><b>Invoice</b></div>
			  	<div class="bgheader">Invoice No</div>
			  	<div><?= $bill->id ?></div>
			  	<div class="bgheader">Date</div>
			  	<div><?= date("d/M/Y" ,strtotime($bill->create_time)) ?></div>
			  	<div class="bgheader">เลขประจำตัวผู้เสียภาษี</div>
			  	<div><?= $bill_info->tax_number ?></div>
			</div>
		</div>
	</div>
</div>
<div class="boxline">
	<div class="insideboxleft">Bill to :</div>
	<div class="insideboxright"><?= $orders->bill->bill_to ?></div>
</div>
<div class="boxline">
	<div class="insideboxleft">Ship to :</div>
	<div class="insideboxright"><?= $orders->bill->ship_to ?></div>
</div>
<div class="container">
	<div class="row">
		<div class="col-xs-7"> 
			<table class="table table-striped">
				<tr class="">
					<td>FOB</td>
					<td>Ship Date</td>
					<td>Ship Via</td>
					<td>Tracking No.</td>
				</tr>
				<tr>
					<td><?= $orders->bill->fob ?></td>
					<td><?= $orders->bill->ship_date ?></td>
					<td><?= $orders->bill->ship_via ?></td>
					<td><?= $orders->bill->tracking_no ?></td>
				</tr>
			</table>
		</div>
	</div>	
</div>
<table class="table table-bordered">
	<tr class="bgheader">
		<td>Order</td>
		<td>Name</td>
		<td>Quantity</td>
		<td>Rate</td>
		
		<td>Amount</td>
	</tr>
<?php $number = 1; ?>
<?php for($i =0; $i < count($orders->products); $i++): ?>
	<?php if($orders->products[$i]->count > 0) : ?>
		<tr >
			<td><?= $number ?></td>
			<td><?= ($orders->products[$i]->name) ?></td>
			<td><?= ($orders->products[$i]->count) ?></td>
			<td><?php echo number_format(($orders->products[$i]->price)); ?></td>
			<td><?php echo number_format(($orders->products[$i]->price * $orders->products[$i]->count)); ?></td>
		</tr>
		<?php $number++; ?>
	<?php endif; ?>
<?php endfor; ?>
</table>
<div style="height:50px;border-bottom:1px solid black"></div>

<div class="container">
	<div class="text-right">
	<div class="col-xs-7"></div>

	<div class="col-xs-3">
		
			<div>Subtotal</div>
			<div>Shipping</div>
			<div>Total</div>
			<?php if($isPending): ?>
			<div>Paid</div>
			<div>Balance Due</div>
			<?php endif; ?>
		
	</div>
	<div class="col-xs-2">

		<div><?php echo number_format($bill->subtotal - $orders->bill->ship_cost) ?></div>
		<div><?php echo number_format($orders->bill->ship_cost) ?></div>
		<div><?php echo number_format(($bill->subtotal  )) ?></div>
		<?php if($isPending): ?>
		<div><?php echo number_format(($bill->subtotal - $bill_pending->amount)) ?></div>		
		<div><?php echo number_format(( $bill_pending->amount)) ?></div>

		<?php endif; ?>
	</div>
	</div>

</div>















<style type="text/css">
	.boxline
	{
		display:inline-block;
		border-color: #038B0F;
		border-style: solid;
		border-radius: 15px;
    	padding: 3px;
    	background: #038B0F;
    	margin: 30px;
	}
	.boxline .insideboxleft
	{
		display:inline-block;
		width:100px;
		height: 70px;
		background-color: #038B0F;
		color: white;
		

	}
	.boxline .insideboxright
	{
		display:inline-block;
		width:100px;
		height: 70px;
		background-color: white;
		border-top-right-radius: 15px;
		border-bottom-right-radius: 15px;
	}
	.bgheader
	{
		background-color: #038B0F;
		color: white;
	}
	.table-striped>tbody>tr:nth-child(odd)>td, .table-striped>tbody>tr:nth-child(odd)>th
	{
		background-color: #038B0F;
		color: white;
	}

	div.logo
	{
		text-align: center;
	}

	div.logo img
	{
		max-height: 200px;
		width: auto;
		
	}
</style>
</section>

<?php 
use yii\helpers\Html;
use app\models\Product;
use app\models\Sales;
use yii\web\View;
use yii\helpers\Url;

?>
<div class="brand-view dashboard">

	<div class="row">
		<div class="col-md-6 ">
			<h2 class="header">Sales</h2>
			<div>
				<!--Yearly Sales <span class=""><?= Sales::getYearlySales($id, date("Y")) ?></span>  <br/>-->
				Monthly Sales <span class=""><?= Sales::getMonthSales($id, date("m")) ?></span>  <br/>

				<a href="<?php echo Url::to(['sales/index', 'id' => $id]); ?>"><canvas id="myChart" width="400" height="400"></canvas></a>
				<?php 
					$this->registerJs("var ctx = document.getElementById('myChart').getContext('2d');var data = ".json_encode(Sales::getMontyGraphJSON($id, date("m"))).";var chart = new Chart(ctx).Line(data);", View::POS_END, 'my-options');

				?>
				
			</div>
		</div>
		<div class="col-md-6">
			<section class="item">
				<h2 class="header">สินค้า</h2>
				<div class="content">
					<div>
						<span class=""><?= Product::getCountFromBrand($id) ?></span> ชนิด มีจำนวนทั้งสิ้น
						<span class=""><?= Product::getItemFromBrand($id) ?></span> อัน
					</div>
					<div class="right">
						<?= Html::a('Manage', ['product/index', 'id'=> $id], ['class' => 'btn btn-success']) ?>
					</div>
				</div>
			</section>
			<section class="item">
				<h2 class="header">สาขา</h2>
				<div class="content">
					<div>
						<?php for($i =0; $i < count($branches); $i++): ?>
							<span class=""><?= $branches[$i]->name ?></span> ปิดร้านล่าสุด <span class=""><?= $branches[$i]->lastSale->create_time ?></span> ยอด <span class=""><?= $branches[$i]->lastSale->amount ?></span> 
							<br/>
						<?php endfor; ?>
					</div>
					<div class="right">
						 	<?= Html::a('Manage', ['branch/index', 'id'=> $id], ['class' => 'btn btn-success']) ?>
					</div>
				</div>
			</section>
			<section class="item">
				<h2 class="header">ข้อมูลร้าน</h2>
				<div class="content">
					<div>
						สำหรับ ออกบิล
					</div>
					<div class="right">
						 	<?= Html::a('Manage', ['brand/billinfo', 'id'=> $id], ['class' => 'btn btn-success']) ?>
					</div>
				</div>
			</section>

		</div>
	</div>

	<div class="row">
		<div class="col-md-6 ">
			<h2 class="header"> <?= Html::a('POS', ['branch/login', 'id'=> $id], ['class' => '']) ?></h2>
		</div>
		<div class="col-md-6">


			
			
		</div>
	</div>

</div>
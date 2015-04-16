<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $branch->brand_id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Branches',
            'url' => ['branch/index', 'id' => $branch->brand_id],
        ]

    ];
$this->params['breadcrumbs'] [] = "{$branch->name} Price";

?>
<h1>Price List</h1>
<?= Html::a('Add Product', ['pricelist_create',  'branch_id' => $branch->id ], ['class' => 'btn btn-success']); ?>
<?= Html::beginForm(['branch/pricelist', 'id' => $branch->id], $method = 'post') ?>
	<table class="table">
	        <thead>
	            <th>สินค้า</th>
	            
	            <th>ราคาต่อหน่วย</th>
	            <th>ราคาปลีก</th>
	        </thead>
	<?php for($i=0; $i < count($products); $i++) : ?>
		<tr>
            <td>
                <?php echo $products[$i]->name ; ?>

                <input type="hidden" value ="<?php echo $products[$i]->id; ?>" name="Product[<?php echo $i; ?>][id]"> 
            </td>
            
            <td><input type="number" class="form-control" value ="<?php echo $products[$i]->price ; ?>" name="Product[<?php echo $i; ?>][price]" placeholder="จำนวน"> </td>
            <td><?php echo $products[$i]->retail_price ; ?></td>
	<?php endfor;?>
	</table>
    <?= Html::submitButton() ?>
<?= Html::endForm() ?>

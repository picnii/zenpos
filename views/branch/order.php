<?php 
;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $model->brand_id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Branches',
            'url' => ['branch/index', 'id' => $model->brand_id],
        ]
        ,
        [
            'label' => "{$model->name} Bills",
            'url' => ['branch/bills', 'id' => $model->id],
        ]

    ];
$this->params['breadcrumbs'] [] = "New";

?>




<?= Html::beginForm(['branch/order', 'id' => $model->id], $method = 'post') ?>

    <h2>ข้อมูลลูกค้า</h2>
    <input required name="Bill[bill_to]" class="form-control" placeholder="ผู้ชำระเงิน"><br/>
    <input required name="Bill[ship_to]" class="form-control" placeholder="ผู้รับสินค้า"><br/>
    <input required name="Bill[fob]"  class="form-control" placeholder="FOB"><br/>
    <input required name="Bill[ship_date]"  type="date" class="form-control" placeholder="Ship Date"><br/>
    <input required name="Bill[ship_via]"  type="text" class="form-control" placeholder="Ship Via"><br/>
    <input required name="Bill[tracking_no]"  type="text" class="form-control" placeholder="Tracking No"><br/>
    <input required name="Bill[ship_cost]"  type="number"  class="form-control" placeholder="ค่าส่ง"><br/>


    <h2>สินค้า</h2>
    <table class="table">
        <thead>
            <th>สินค้า</th>
            <th>จำนวน</th>
            <th>ราคาต่อหน่วย</th>
        </thead>
    <?php for($i=0; $i < count($products); $i++) : ?>
        <tr>
            <td>
                <?php echo $products[$i]->name ; ?>

                <input type="hidden" value ="<?php echo $products[$i]->id; ?>" name="Product[<?php echo $i; ?>][id]"> 
                <input type="hidden" value ="<?php echo $products[$i]->name; ?>" name="Product[<?php echo $i; ?>][name]"> 
            </td>
            
            <td><input type="number" class="form-control" value ="0" name="Product[<?php echo $i; ?>][count]" placeholder="จำนวน"> </td>
            <td><input type="number" class="form-control" value ="<?php echo $products[$i]->price; ?>" name="Product[<?php echo $i; ?>][price]" placeholder="ราคาต่อชิ้น"></td>
        </tr>

    <?php endfor; ?>
    </table>
    <?= Html::submitButton() ?>
<?= Html::endForm() ?>







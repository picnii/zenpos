<?php 
;
use yii\helpers\Html;
use yii\helpers\Url;


?>




<?= Html::beginForm(['branch/posconfirm', 'id' => $model->id], $method = 'post') ?>

   

    <h2>สินค้า ของสาขา <?= $model->name ?></h2>
    <table class="table">
        <thead>
            <th>สินค้า</th>
            <th>จำนวนเดิม</th>
            <th>จำนวนใหม่</th>
            
        </thead>
    <?php for($i=0; $i < count($products); $i++) : ?>
        <tr>
            <td>
                <?php echo $products[$i]->name ; ?>

                <input type="hidden" value ="<?php echo $products[$i]->product_id; ?>" name="Product[<?php echo $i; ?>][id]"> 
            </td>
             <td><?php echo $products[$i]->count; ?></td>
            <td><input type="number" class="form-control" value ="<?php echo $products[$i]->count; ?>" name="Product[<?php echo $i; ?>][count]" placeholder="จำนวน"> </td>
            
        </tr>

    <?php endfor; ?>
    </table>
    <?= Html::submitButton('Save',['class'=> 'btn btn-success form-control']) ?>
<?= Html::endForm() ?>







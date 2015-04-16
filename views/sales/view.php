<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sales */

$this->params['breadcrumbs'] =  [
        [
            'label' => 'Dashboard',
            'url' => ['brand/view', 'id' => $id],
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        [
            'label' => 'Sales',
            'url' => ['sales/index', 'id' => $id],
            
        ],
        $model->id
    ];





$bill = json_decode($model->log);
if(isset($bill->retail_bills))
    $retail_bills  = $bill->retail_bills;
else
    $retail_bills = [];
if(isset($bill->wholesale_bills))
    $wholesale_bills = $bill->wholesale_bills;
else
    $wholesale_bills = [];


function getDetail($products)
{
    $txt = '<table class"table">';
 
    foreach ($products as $product) {
        # code...
        $txt .= '<tr>';
        $txt .= '<td>'.$product->name.'</td>';
        $txt .= '<td>X</td>';
        $txt .= '<td>'.$product->count.'</td>';
        $txt .= '</tr>';
    }
    $txt .= '</table>';
    return $txt;

}

function getCustomer($item)
{
    $txt = '<table class"table">';

    $txt .= '<tr><td>Bill To</td><td>'.$item->customer->bill_to.'<td></tr>';
    $txt .= '<tr><td>Ship To</td><td>'.$item->customer->ship_to.'<td></tr>';
    $txt .= '<tr><td>FOB</td><td>'.$item->customer->fob.'<td></tr>';
    $txt .= '<tr><td>Ship Date</td><td>'.$item->customer->ship_date.'<td></tr>';
    $txt .= '<tr><td>Tracking no.</td><td>'.$item->customer->tracking_no.'<td></tr>';
    $txt .= '</table>';
    return $txt;    
}

?>
<div class="sales-view">

    <h1>ID: <?= $model->id ?> : <?= $model->amount; ?></h1>
    
    <h2>Retail Bill</h2>
    <table class="table">
        <thead>
            <tr>    
                <th>Create Time</th>
                <th>Amount</th>
                <th>Subtotal</th>
                <th>Discount</th>
                <th>Tax Amount</th>
                <th>Detail</th>
            </tr>
        </thead>
        <?php foreach($retail_bills as $item ) :?>
        <tr >
            <td><?= $item->create_time ?></td>
            <td><?= $item->amount ?></td>
            <td><?= $item->payment_total->subtotal ?></td>
            <td><?= $item->discount ?></td>
            <td><?= $item->tax_amount ?></td>
            <td><?= getDetail($item->bill->products) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h2>Wholesale Bill</h2>
     <table class="table">
        <thead>
            <tr>    
                <th>Create Time</th>
                <th>Amount</th>
                <th>Customer</th>
                
                <th>Detail</th>
            </tr>
        </thead>
        <?php foreach($wholesale_bills as $item ) :?>
        <tr >
            <td><?= $item->create_time ?></td>
            <td><?= $item->amount ?></td>
            <td><?= getCustomer($item) ?></td>
            <td><?= getDetail($item->products) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    

    

</div>

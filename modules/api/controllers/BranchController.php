<?php

namespace app\modules\api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Session;
use app\models\Brand;
use app\models\BillInfo;
use app\models\Branch;
use app\models\Product;
use app\models\PaymentCredit;
use app\models\Inventory;
use app\models\Sales;
use app\models\Wholesale;
use yii\rest\ActiveController;

/**
 * BrandController implements the CRUD actions for Branch model.
 */
class BranchController extends ActiveController
{
    public $modelClass = 'app\models\Branch';
    public function actions()
	{
	    $actions = parent::actions();

	    // disable the "delete" and "create" actions
	    unset($actions['delete'], $actions['create']);

	    // customize the data provider preparation with the "prepareDataProvider()" method
	    $actions['view']['findModel'] = [$this, 'customFind'];

	    return $actions;
	}

	public function actionInfo()
	{
		 $session = new Session();
        $session->open();
        if( $session['branch_id'] > 0)
            $items = ['branch_id' => $session['branch_id'], 'status' => 'complete'];
        else
            $items = [ 'status' => 'error'];
        

        return $items;
	}

	public function actionLogout()
	{
		 $session = new Session();
        $session->open();
        $session['branch_id'] = '';
        $session->destroy();
        $items = [ 'status' => 'complete'];
        return $items;
	}

	public function actionSale($id)
	{
		$last_sales = Sales::find()->where(['branch_id' => $id])->orderBy('create_time DESC')->one();

		return $last_sales;
	}

	public function actionUpdatesale($id)
	{
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body);

		$sale = new Sales();
		$sale->amount = $data->amount;
		$sale->branch_id = $id;
		$sale->log = $data->log;
		$result = $sale->save();


		$branch = Branch::findOne($id);
		//if type_id = 4 mean ฝากขาย
		if($branch->branch_type_id == 4)
		{
			$branch->leftover += $sale->amount;
			$branch->save();	
		}

		return ["id"=> $id, "REQUEST" => $_REQUEST, "POST" => $_POST, 'BODY' => $data, 'sale'=> $sale, 'result'=> $result];
	}

	public function actionUpdateproduct($id)
	{
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body);

		$products = $data->products;
		$result = true;
		for($i =0; $i < count($products); $i++)
		{

			$inventory = Inventory::find()->where(['branch_id' => $id, 'product_id' => $products[$i]->id])->one();
			$inventory->count = $products[$i]->count;
			$result = $result && $inventory->save();

		}


		return ["id"=> $id, "REQUEST" => $_REQUEST, "POST" => $_POST, 'BODY' => $data,  'result'=> $result];
	}

	public function customFind($id, $action)
	{
		$session = new Session();
	    $session->open();
	    // prepare and return a data provider for the "index" action
	    if($session['branch_id'] != $id)
	    	return [
	    			'status'=> "error",
	    			"message"=> "Wrong password"
	    		];
	    $branch =  Branch::findOne($id);;
	    $brand = Brand::findOne($branch->brand_id);
	    $address = $branch->address;
	    $bill_info = BillInfo::find()->where(['brand_id' => $branch->brand_id])->one();
	    $credit_cards = PaymentCredit::find()->where(['brand_id' => $branch->brand_id])->one();
	    
	    $payments = [];
	    $payments['tax'] = $bill_info->tax_percent;
	    $payments['credits'] = [];
	    foreach ($credit_cards as $key => $value) {
	    	# code...
	    	$payments['credits'][] = $value;
	    }

	    $logo = Url::home(true).'uploads/'.$brand->logo;
	    return [
	    	'name'=>$branch->name,
	    	'logo'=> $logo,
	    	'address' => $address,
	    	'bill_info' => $bill_info,
	    	'inventories'=> $this->getProducts($id),
	    	'manager_password' => $branch->password_manager,
	    	'payments' => $payments,
	    ];
	}

	protected function getProducts($id)
	{
		$products = Inventory::find()->where(['branch_id'=> $id])->with('product')->all();
		//{"id":"1","name":"Js Sloane Heavywight 4oz.","type":"Pomade","price":690,"hasCondition":false,"minumWholeSales":12,"item_ranges":[{"from":12,"to":24,"price":520},{"from":36,"to":48,"price":500},{"from":60,"price":480}],"count":100,"code":"123456789","condition":null}
		/* Slow */
		$inventories = [];
		for($i = 0; $i < count($products); $i++)
		{
			$info = $products[$i]->productInfo;
			array_push($inventories, $info);
		}
		



		return $inventories;
	}

	public function checkAccess($action, $model = null, $params = [])
	{
	    // check if the user can access $action and $model
	    // throw ForbiddenHttpException if access should be denied

	   // if($_GET['password'] != $params['id'])
	    	//   throw new \yii\web\ForbiddenHttpException(403, 'Noaccess');
	}
	/*public function actionView($id)
	{
		return [
	    	"hi"=>'test'
	    ];
	}*/
}

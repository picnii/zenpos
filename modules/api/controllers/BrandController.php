<?php

namespace app\modules\api\controllers;

use Yii;
use app\models\Brand;
use app\models\Branch;
use app\models\Product;
use app\models\Inventory;
use app\models\Wholesale;
use yii\rest\ActiveController;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends ActiveController
{
    public $modelClass = 'app\models\Brand';
    public function actions()
	{
	    $actions = parent::actions();

	    // disable the "delete" and "create" actions
	    unset($actions['delete'], $actions['create']);

	    // customize the data provider preparation with the "prepareDataProvider()" method
	    $actions['view']['findModel'] = [$this, 'customFind'];

	    return $actions;
	}

	public function customFind($id, $action)
	{
	    // prepare and return a data provider for the "index" action
	    $brand =  Brand::findOne($id);;
	    return [
	    	'name'=>$brand->name,
	    	'email'=>$brand->email,
	    	'products'=> $this->getProducts($id),
	    ];
	}

	protected function getProducts($id)
	{
		$products = Product::find()->with('branches','inventories')->all();
		/* Slow */
		



		return $products;
	}
	/*public function actionView($id)
	{
		return [
	    	"hi"=>'test'
	    ];
	}*/
}

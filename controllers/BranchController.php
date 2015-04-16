<?php

namespace app\controllers;

use Yii;
use app\models\Branch;
use app\models\Inventory;
use app\models\Product;
use app\models\Bill;
use app\models\PriceList;
use app\models\BillPending;
use app\models\BillPendingSearch;
use app\models\Address;
use app\models\BranchSearch;
use app\models\BranchForm;
use app\models\BillPaymentForm;

use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

/**
 * BranchController implements the CRUD actions for Branch model.
 */
class BranchController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Branch models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new BranchSearch();
        $params = Yii::$app->request->queryParams;
        $params['BranchSearch']['brand_id'] = $id;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
    }

    /**
     * Displays a single Branch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function createOrUpdatePricelist($branch_id, $product_id, $price)
    {
        $pricelist = PriceList::find()->where(['branch_id'=> $branch_id, 'product_id'=> $product_id])->one();
        if($pricelist == null)
        {
            $pricelist = new PriceList();
            $pricelist->product_id = $product_id;
            $pricelist->branch_id = $branch_id;
        }
        $pricelist->price = $price;
        return $pricelist->save();
    }

    public function createOrUpdateInventory($branch_id, $product_id, $count, $price)
    {
        
        $inventory = Inventory::find()->where(['branch_id'=> $branch_id, 'product_id'=> $product_id])->one();
        if($inventory !== null)
            $inventory->count = $inventory->count + $count;
        else
        {
            $inventory = new Inventory();
            $inventory->branch_id = $branch_id;
            $inventory->product_id = $product_id;
            $inventory->count = $count;
        }
        
        return $inventory->save();
    }

    public function actionPosconfirm($id)
    {
        $model = $this->findModel($id);
        $products = Inventory::find()->joinWith('product')->where(['branch_id' => $id])->all();
        if(isset($_POST['Product']))
        {
            $output = $_POST['Product'];
            $result = true;
            for($i=0; $i < count($output); $i++)
            {
                $inventory = Inventory::find()->where(['branch_id' => $id, 'product_id' => $output[$i]['id']])->one();
                $inventory->count = $output[$i]['count'];
                $result = $result && $inventory->save();
            }
            $this->redirect(['branch/posconfirm', 'id' => $id]);
        }
        return $this->render('pos_confirm', [
            'model' => $model,
            'products' => $products
        ]);
        
    }

    public function actionPayment($id, $branch_id)
    {
        
        // $bill->subtotal - $bill_pending->amount
        $bill = Bill::findOne($id);
        $bill_pending = BillPending::find()->where(['branch_id' => $branch_id, 'bill_id' => $id])->one();
        $bill_pending->paid_amount = $bill->subtotal - $bill_pending->amount;

        if ($bill_pending->load(Yii::$app->request->post()) && $bill_pending->paid()) {
            $this->redirect(['branch/bills', 'id'=> $branch_id]);


        }

        return $this->render('payment', [
            'bill'=> $bill,
            'bill_pending' => $bill_pending

        ]);
    }

    public function actionBill($id, $branch_id = null)
    {
        //id = Bill Id
        $bill = Bill::findOne($id);
        $bill_pending = null;
        if($branch_id != null)
            $bill_pending = BillPending::find()->where(['branch_id' => $branch_id, 'bill_id' => $id])->one();
        
        return $this->render('bill', [
            'bill'=> $bill,
            'bill_pending' => $bill_pending
        ]);
//        $this->render('bill',[]);


    }

    public function actionBills($id)
    {
        //id = branch_id;
        $branch = $this->findModel($id);
        $searchModel = new BillPendingSearch();
        $params = Yii::$app->request->queryParams;
        $params['BranchSearch']['branch_id'] = $id;
        $dataProvider = $searchModel->search($params);

        
        return $this->render('bills', [
            'branch' => $branch,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPricelist_create($branch_id)
    {
        $branch = $this->findModel($branch_id);
        $model = new PriceList();
        $model->branch_id = $branch_id;
        $model->price = 0;
        if($model->load(Yii::$app->request->post()) && $model->save() )
        {
            $this->redirect(['pricelist', 'id' => $branch_id]);
        }
         return $this->render('_pricelist_form', [
            'branch' => $branch,
            'model' => $model
        ]); 
    }


    public function actionPricelist($id)
    {
        $branch = $this->findModel($id);
        $products = PriceList::loadProducts($id);
        if(isset($_POST['Product']))
        {
            $output = $_POST['Product'];
            for($i=0; $i < count($output); $i++)
            {
                $this->createOrUpdatePricelist($id, $output[$i]['id'], $output[$i]['price']);
            }
            $this->redirect(['branch/pricelist', 'id' => $id]);
        }
        return $this->render('price', [
            'branch' => $branch,
            'products' => $products
        ]); 

    }

    public function actionOrder($id)
    {
        $model = $this->findModel($id);
        $products = PriceList::find()->joinWith('product', 'FULL OUTER JOIN')->where(['branch_id' => $id])->all();
        //must have shiiping

        if(isset($_POST['Product']))
        {
            $output = $_POST['Product'];
            //$output = $_POST['Product'];
            $bill_info = $_POST['Bill'];
            $sum = 0;
            for($i=0; $i < count($output); $i++)
            {
                if($output[$i]['count'] > 0 && $this->createOrUpdateInventory($id, $output[$i]['id'],  $output[$i]['count'], $output[$i]['price']))
                    $sum += $output[$i]['count'] * $output[$i]['price'];

            }
            $sum += $bill_info['ship_cost'];
            $bill = new Bill();
            $bill->brand_id = $model->brand_id;
            $bill->subtotal = $sum;
            $bill->log = json_encode([
                'branch_id'=> $id,
                'products'=>$output,
                'bill'=>$bill_info
            ]);
            if($bill->save())
            {
                $bill_pending = new BillPending();
                $bill_pending->branch_id = $id;
                $bill_pending->bill_id = $bill->id;
                $bill_pending->amount = $sum;
                $bill_pending->save();
                
                $this->redirect(['branch/bill', 'id' => $bill->id, 'branch_id' => $id]);
            }

            //send data to bill page?
        }
        else
            $output = [];
       


       return $this->render('order', [
            'model' => $model,
            'output' => $output,
            'products' => $products
        ]); 
    }

    /**
     * Displays a single Branch model.
     * @param integer $id
     * @return mixed
     */
    public function actionLogin($id)
    {
        $session = new Session();
        $session->open();
        if($session['branch_id'] && $session['branch_id'] >0)
        {
            $branch = $this->findModel($session['branch_id']);
            if($branch->branch_type_id == 4)
                    return $this->redirect(['branch/posconfirm', 'id'=>$branch->id]);
            return $this->redirect('http://localhost/npop.in.th/inventory/#/');   
        }
            

        $branch_form = new BranchForm();

        if ($branch_form->load(Yii::$app->request->post())) {
            $branch = $branch_form->login();
            if($branch && $branch !== null)
            {
                //if branch_type 
                $session['branch_id'] = $branch->id;
                if($branch->branch_type_id == 4)
                    return $this->redirect(['branch/posconfirm', 'id'=>$branch->id]);
               
                
                return $this->redirect('http://localhost/npop.in.th/inventory/#/load');   
            }
             
        }
        return $this->render('login', [
            'model' => $branch_form,
            'brand_id' => $id,
        ]);
    }

    public function actionLogout()
    {
        $session = new Session();
        $session->open();
        $branch_id = $session['branch_id'] ;
        $session['branch_id'] = '';
        $branch = $this->findModel($branch_id);
        //$session->destroy();
        return $this->redirect(["branch/login", "id"=> $branch->brand_id]);   
    }

    public function actionInfo()
    {
        $session = new Session();
        $session->open();
        if( $session['branch_id'] > 0)
            $items = ['branch_id' => $session['branch_id'], 'status' => 'complete'];
        else
            $items = [ 'status' => 'error'];
        \Yii::$app->response->format = 'json';
        return $items;
        //print_r(["test" => "ABC", "Session" => $session['branch_id'], 'sessions'=> $session]);
    }


    public function actionClear()
    {
        $session = new Session();
        $session->open();
        $session['branch_id'] = '';
        $session->destroy('branch_id');
        print_r(["test" => "ABC", "Session" => $session['branch_id'], 'sessions'=> $session]);
    }

    /**
     * Creates a new Branch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Branch();
        $model->brand_id = $id;
        
        $address = new Address();
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = $model->create_time;
        if ($model->load(Yii::$app->request->post())) {
            $address->load(Yii::$app->request->post());
            if($address->save())
            {
                $model->address_id = $address->id;
                if($model->save())
                    return $this->redirect(['index', 'id' => $id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'address' => $address,
            'id'=>$id

        ]);
        
    }

    public function actionInventory($id)
    {
        $query = Inventory::find();
        $branch = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere([
            'branch_id' => $id,
        ]);
        $inventories = Inventory::find()->where(['branch_id'=>$id])->all();
         return $this->render('inventory', [
            'dataProvider' => $dataProvider,
            'inventories' => $inventories,
            'branch_id' => $id,
            'branch' => $branch,
        ]);
    }

    public function actionInventory_update($product_id, $branch_id)
    {
        $inventory = Inventory::find()->where(['product_id' => $product_id, 'branch_id' => $branch_id])->one();
        if($inventory->load(Yii::$app->request->post()) && $inventory->save())
        {
            return $this->redirect(['inventory', 'id' => $branch_id]);
        }
        return $this->render('inventory_update', [
            'model' => $inventory

        ]);
    }

    public function actionInventory_create($branch_id)
    {
        $inventory = new Inventory();
        $inventory->branch_id = $branch_id;
        $inventory->update_time  = date('Y-m-d H:i:s');
        if($inventory->load(Yii::$app->request->post()) && $inventory->save())
        {
            
            return $this->redirect(['inventory', 'id' => $branch_id]);
        }
        return $this->render('inventory_create', [
            'model' => $inventory

        ]);
    }

    /**
     * Updates an existing Branch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $address = $this->findAddress($model->address_id);
        if ($model->load(Yii::$app->request->post())) {
             $address->load(Yii::$app->request->post());
             if($address->save())
            {
                $model->address_id = $address->id;
                if($model->save())
                    return $this->redirect(['index', 'id' => $model->brand_id]);
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'address' => $address
            ]);
        }
    }

    /**
     * Deletes an existing Branch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Branch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAddress($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.xxx');
        }
    }
}

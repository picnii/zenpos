<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\WholesaleForm;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new ProductSearch();
        $searchModel->brand_id = $id;

        $params = Yii::$app->request->queryParams;
        //$dataProvider = $searchModel->search($params);
        $params['ProductSearch']['brand_id'] = $id;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$id
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Product();
        $model->brand_id = $id;
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = $model->create_time;

        $wholesale = new WholesaleForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $wholesale->load(Yii::$app->request->post());
            if($wholesale->create($model->id))
                return $this->redirect(['index', 'id' => $id]);
        } 
       return $this->render('create', [
            'model' => $model,
            'wholesale' => $wholesale,
            'id' => $id,
        ]);
        
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $wholesale = new WholesaleForm();
        $wholesale->loadWholesale($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $wholesale->load(Yii::$app->request->post());
            if($wholesale->update($model->id))
                return $this->redirect(['index', 'id' => $id]);
            return $this->redirect(['view', 'id' => $model->id]);
        } 
            return $this->render('update', [
                'model' => $model,
                'wholesale' => $wholesale,
            ]);
        
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);
        $brand_id = $model->brand_id;
        $model->delete();

        return $this->redirect(['index', 'id' => $brand_id]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

use Yii;
use app\models\Brand;
use app\models\BillInfo;
use app\models\Branch;
use app\models\LoginForm;
use app\models\BrandSearch;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
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
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brand model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $loginModel = new LoginForm();
        $branches = Branch::find()->where(["brand_id" => $id])->all();
        if(!Yii::$app->user->isGuest)
            return $this->render('dashboard', [
                    'model' => $this->findModel($id),
                    'id'=> $id,
                    'branches'=> $branches,
                ]);

        $err = "";
        if ( $loginModel->load(Yii::$app->request->post())  ) {
            $err = "";
            
            if($loginModel->login())
                return $this->render('dashboard', [
                    'model' => $this->findModel($id),
                    'id'=> $id,
                    'branches'=> $branches,
                ]);
        }
         return $this->render('view', [
            'model' => $this->findModel($id),
            'loginModel' => $loginModel,
            'err' => $err
        ]);
        
       
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = $model->create_time;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->repassword = $model->password;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->update_time = date('Y-m-d H:i:s');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Brand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionBillinfo($id)
    {
        $brand = $this->findModel($id);
        $model = BillInfo::find()->where(['brand_id' => $id])->one();
        if($model == null)
            $model = new BillInfo();
        $model->brand_id = $id;
        if (($brand->password == $brand->repassword) && $model->load(Yii::$app->request->post())) {
           

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file ) {                
                $brand->logo =  $model->file->baseName . '.' . $model->file->extension;
                $model->file->saveAs('uploads/' .$brand->logo);

                if($model->save() && $brand->save())
                    $this->redirect(['view', 'id' => $id]);
            }



        }
        $brand->repassword = $brand->password;

        return $this->render('_bill_info_form', [
            'model' => $model,
            'brand' => $brand
            ]);
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

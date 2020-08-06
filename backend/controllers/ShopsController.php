<?php

namespace backend\controllers;

use Yii;
use common\models\Shops;
use common\models\ShopsSearch;
use common\models\OrderSearch;
use common\models\GoodsSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopsController implements the CRUD actions for Shops model.
 */
class ShopsController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionStatus($id="")
    {
        $this->layout=false;
        
        if ($data=Yii::$app->request->post()) {
            $model=Shops::findOne($data['id']);
            $model->status_info=$data['status_info'];
            $model->status=$data['status'];
            if($model->update(true, ['status','status_info']))
            {
                echo "1";
                return false;
            }else{
              echo "2";
              return false;
            }
        }
        return $this->render('status', ["id"=>$id]);
    }

     //店铺选择列表
    public function actionShopsSelect()
    {
        
        $searchModel = new ShopsSearch();
       	$searchModel->shop_id="1";//不包括店铺1
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('shops-select', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Shops models.
     * @return mixed
     */
    public function actionIndex($status="")
    {   
        $searchModel = new ShopsSearch();
        if($status!="")
        {
            $searchModel->status=$status;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shops model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $searchModel = new OrderSearch();
        $searchModel->shop_id=$model->shop_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $goodsModel = new GoodsSearch();
        $goodsModel->shop_id=$model->shop_id;
        $goodsDataProvider = $goodsModel->search(Yii::$app->request->queryParams);

        

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'goodsModel' => $goodsModel,
            'goodsDataProvider' => $goodsDataProvider,
        ]);
    }

    /**
     * Creates a new Shops model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shops();

        if ($model->load(Yii::$app->request->post()) ) {
            $isshop=Shops::find()->where(["user_id"=>$model->user_id])->count();
            if($isshop!=0)
            {
                Yii::$app->getSession()->setFlash('success', '添加失败，此用户已有店铺');
                
                return $this->render('create', [
                    'model' => $model,
                ]);
                //return $this->redirect(["shops/create"]);
            }
           // $this->dump($model->getErrors());
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->shop_id]);    
            }else{
                $this->dump($model->getErrors());
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Shops model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->shop_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Shops model.
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
     * Finds the Shops model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shops the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shops::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

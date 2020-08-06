<?php

namespace shop\controllers;

use Yii;
use common\models\RobBuy;
use common\models\Shops;
use common\models\Goods;
use common\models\RobBuySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RobBuyController implements the CRUD actions for RobBuy model.
 */
class RobBuyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RobBuy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user_id=Yii::$app->user->identity->id;
        $shop=Shops::findOne(["user_id"=>$user_id]);
        $searchModel = new RobBuySearch();
        $searchModel->shop_id=$shop->shop_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

   

    /**
     * Creates a new RobBuy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $user_id=Yii::$app->user->identity->id;
        $shop=Shops::findOne(["user_id"=>$user_id]);
        $model = new RobBuy();
        
        if ($data=Yii::$app->request->post()) {
            //$this->dump($data);
            $goods=Goods::findOne($data['RobBuy']['goods_id']);
            if($goods->shop_id!=$shop->shop_id)
            {
                return false;
                die("未知错误");
            }
            $model->shop_id=$shop->shop_id;    
            $model->goods_id=$data['RobBuy']['goods_id'];  
            $model->num=$data['RobBuy']['num'];  
            $model->price=$data['RobBuy']['price'];  
            $model->start_time=strtotime($data['start_time']);    
            $model->end_time=strtotime($data['end_time']);    

            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RobBuy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user_id=Yii::$app->user->identity->id;
        $shop=Shops::findOne(["user_id"=>$user_id]);
        if ($data=Yii::$app->request->post()) {
            //$this->dump($data);
            $goods=Goods::findOne($data['RobBuy']['goods_id']);
            if($goods->shop_id!=$shop->shop_id)
            {
                return false;
                die("未知错误");
            }
            $model->shop_id=$shop->shop_id;    
            $model->goods_id=$data['RobBuy']['goods_id'];  
            $model->num=$data['RobBuy']['num'];  
            $model->price=$data['RobBuy']['price'];  
            $model->start_time=strtotime($data['start_time']);    
            $model->end_time=strtotime($data['end_time']);    

            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RobBuy model.
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
     * Finds the RobBuy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RobBuy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RobBuy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

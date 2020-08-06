<?php

namespace shop\controllers;

use Yii;
use common\models\Order;
use common\models\OrderGoods;
use common\models\OrderSearch;
use common\models\UserAddress;
use common\models\Goods;
use common\models\Shops;
use common\models\User;
use common\models\Express;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
     public $enableCsrfValidation = false;
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

     public function actionOrderStatus($order_id="")//发货
    {
        $this->layout=false;
        if($data=Yii::$app->request->post()){
           
            $user_id=Yii::$app->user->identity->id;
            $shop=Shops::findOne(["user_id"=>$user_id]);
            $order=Order::findOne($data['order_id']);
            //$this->dump($shop);
            if($order->shop_id!=$shop->shop_id)
            {
                $res["success"]=true;
                $res["message"]="发货失败";
                return json_encode($res);
            }
            $order->express_num=$data["express_num"];
            $order->express_type=$data["express_type"];
            $order->status=2;
            if($order->update(true,["express_num","express_type",'status']))
            {
                $res["success"]=true;
                $res["message"]="发货成功";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="发货失败";
                return json_encode($res);
            }
           
        }else{
            $express=Express::find()->all();
            return $this->render("order-status",[
                "order_id"=>$order_id,
                "express"=>$express,
            ]);  
        }

     
    
    }
    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex($status="")
    {
        $user_id=Yii::$app->user->identity->id;
        $shop=Shops::findOne(["user_id"=>$user_id]);
        
        $searchModel = new OrderSearch();
        $searchModel->status=$status;
      
        $searchModel->shop_id=$shop->shop_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatus($id)
    {   
        $model=$this->findModel($id);
        $model->status="2";
        $model->save();       
        return $this->redirect(['index']);
    }
    public function actionCrefund($order_id)
    {   
        $user_id=Yii::$app->user->identity->id;
        $shop=Shops::findOne(["user_id"=>$user_id]);
        $model=Order::findOne($order_id);
        if($model->shop_id!=$shop->shop_id)
        {
            $res["success"]=false;
            $res["message"]="未知错误";
            return json_encode($res);
        }

        $model->refund_is_shop="1";
        if($model->update(true,["refund_is_shop"]))  
        {
            $res["success"]=true;
            $res["message"]="操作成功";
            return json_encode($res);
        } else{
            $res["success"]=false;
            $res["message"]="操作失败";
            return json_encode($res);
        }    
        //return $this->redirect(['index']);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model=$this->findModel($id);
      
        $shops=Shops::findOne($model->shop_id);
        $user=User::findOne($model->user_id);

        $goods=OrderGoods::find()->where(["order_id"=>$model->order_id])->all();
        
        return $this->render('view', [
            'model' => $model,
      
            'goods' => $goods,
            'shops' => $shops,
            'user' => $user,
        ]);
    }

    

  

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace admin\controllers;

use Yii;
use common\models\OrderSeckill;
use common\models\Express;

use common\models\OrderSeckillSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\OrderRefund;
/**
 * OrderSeckillController implements the CRUD actions for OrderSeckill model.
 */
class OrderSeckillController extends Controller
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

    /**
     * Lists all OrderSeckill models.
     * @return mixed
     */
    public function actionIndex($status="")
    {
        $searchModel = new OrderSeckillSearch();
        $searchModel->status=$status;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderSeckill model.
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
     * Creates a new OrderSeckill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderSeckill();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrderSeckill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OrderSeckill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
  

    /**
     * Finds the OrderSeckill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderSeckill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderSeckill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
  
  
    
    public function actionOrderStatus($order_id="")//发货
    {
        $this->layout=false;
        if($data=Yii::$app->request->post()){
           
            $user_id=Yii::$app->user->identity->id;
            //$shop=Shops::findOne(["user_id"=>$user_id]);
            $order=OrderSeckill::findOne($data['order_id']);
            /*$this->dump($shop);
            if($order->shop_id!=$shop->shop_id)
            {
                $res["success"]=true;
                $res["message"]="发货失败";
                return json_encode($res);
            }*/
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
  
   public function actionOrderRefund($order_id="")//退款
    {

        
        $this->layout=false;
        if($data=Yii::$app->request->post()){
            
            $user_id=Yii::$app->user->identity->id;
            $order=OrderSeckill::findOne($data['order_id']);
            $order->refund_status_remark=$data['refund_status_remark'];
            if($data['status']==1)
            {
                $result=false;
                if($order->pay_type=="1")
                {
                  	$result=$orderRefund->refundSubmitAlipay($order->order_id);//支付宝退款
                    
                }else{
                    $result=$orderRefund->refundSubmitWx($order->order_id);//微信退款
                }
                
                if($result)
                {
                    $order->status=5;  
                    $order->update(true,['status',"refund_status_remark"]);  
                    $res["success"]=true;
                    $res["message"]="操作成功";
                    return json_encode($res);
                }else{
                    $res["success"]=false;
                    $res["message"]="操作失败";
                    return json_encode($res);
                }
                //$order->status=5;    
                
            }else{
                $order->status=6;    
            }
           

            if($order->update(true,['status',"refund_status_remark"]))
            {

                $res["success"]=true;
                $res["message"]="操作成功";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="操作失败";
                return json_encode($res);
            }
           
        }else{
            return $this->render("order-refund",[
                "order_id"=>$order_id,
                
            ]);  
        }
    }





}

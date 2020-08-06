<?php

namespace backend\controllers;

use Yii;
use common\models\Express;
use common\models\OrderFreeTake;
use common\models\OrderUser;
use common\models\OrderFreeTakeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderFreeTakeController implements the CRUD actions for OrderFreeTake model.
 */
class OrderFreeTakeController extends Controller
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
	public function actionOrderStatus($order_id="")//发货
    {
        $this->layout=false;
        if($data=Yii::$app->request->post()){
           
            $user_id=Yii::$app->user->identity->id;
            //$shop=Shops::findOne(["user_id"=>$user_id]);
            $order=OrderFreeTake::findOne($data['order_id']);
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
     * Lists all OrderFreeTake models.
     * @return mixed
     */
    public function actionIndex($status="")
    {
        $searchModel = new OrderFreeTakeSearch();
        if($status!="")
        {
          	$searchModel->status="1";
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderFreeTake model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      	$model=$this->findModel($id);
      	$orderUser=OrderUser::find()->with(["user"])->where(["order_id"=>$model->order_id])->all();
      
        return $this->render('view', [
            'model' => $model,
            'orderUser' => $orderUser,
        ]);
    }

   
    /**
     * Finds the OrderFreeTake model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderFreeTake the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderFreeTake::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

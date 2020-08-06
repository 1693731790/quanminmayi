<?php

namespace af\controllers;

use Yii;
use common\models\Order;
use common\models\OrderGoods;
use common\models\OrderSearch;
use common\models\UserAddress;
use common\models\Goods;
use common\models\Shops;
use common\models\User;
use common\models\UserCardLog;
use common\models\UserAuth;
use common\models\Express;
use common\models\Wxrefund;
use common\models\Liguanjia;
use common\models\WaitWallet;
use common\models\Yunzhonghe;
use Omnipay\Omnipay;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\OrderRefund;
use common\models\Supplier;


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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
   public function actionSubmitYzhOrder($order_id)//重新提交云中鹤订单
    {
     	 
         $order=Order::findOne($order_id);
         $order->status="1";
         if($order->shop_id=="1"&&$order->is_upagent_buy!="1")
         {   

           $yunzhonghe=new Yunzhonghe();
		   $res=$yunzhonghe->getSubmit($order->order_sn);  //提交订单
           if($res->RESPONSE_STATUS=="true")
           {
             $resSub=$yunzhonghe->getThirdOrder($order_sn); //确认提交订单
             $order->status="2";
             $order->order_yzh_sn=$res->RESULT_DATA->order_key;   
             
             $order->update(true,["status","order_yzh_sn"]);
             $res["success"]=true;
             $res["message"]="成功";
             return json_encode($res);
             
           }else{
             $order->yzh_order_fail_code=$res->ERROR_MESSAGE; 
             $order->update(true,["yzh_order_fail_code"]);
             
             $res["success"]=false;
             $res["message"]="失败，".$res->ERROR_MESSAGE;
             return json_encode($res);
           }
           

         }
     
    
    }
   

    
    public function actionOrderStatus($order_id="")//发货
    {
        $this->layout=false;
        if($data=Yii::$app->request->post()){
           
            $user_id=Yii::$app->user->identity->id;
            //$shop=Shops::findOne(["user_id"=>$user_id]);
            $order=Order::findOne($data['order_id']);
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
    /**
     * Lists all Order models.
     * @return mixed
     */
  
    public function actionIndex($status="",$user_id='',$is_seckill="",$error="")
    {
        $searchModel = new OrderSearch();
        $searchModel->status=$status;
        if($status=="4")
        {
           // $searchModel->refund_is_shop="1";
        }
        if($user_id!="")
        {
            $searchModel->user_id=$user_id;
        }
       if($is_seckill!="")
       {
        	 $searchModel->is_seckill=1;
       }
       if($error!="")
       {
        	 $searchModel->error=1;
       }
      
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

  

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
     public function getNewStockById($goods,$num,$address)
      {
            
            $region=explode("-", $address->region_id);
            $area=$region[0]."_".$region[1]."_".$region[2];
            
            $yunzhonghe=new Yunzhonghe();
            $res=$yunzhonghe->getGoodsStock($goods->jdgoods_id,$num,$area);
            //$this->dump($res);
            if($res->RESPONSE_STATUS=="true"&&$res->RESULT_DATA->stock_status==true)
            {
                return true;
            }else{
                return false;
            }
          
     
      }
   public function actionGroup($order_sn="")
    {   
        $modelOne=Order::findOne(["order_sn"=>$order_sn]);
    if(!empty($modelOne))
    {   
     	$model=$this->findModel($modelOne->order_id);
       // $userAddress=UserAddress::findOne($model->address_id);
        $shops=Shops::findOne($model->shop_id);
        $user=User::findOne($model->user_id);
        $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$model->user_id])->one();
        

        $goods=OrderGoods::find()->asArray()->where(["order_id"=>$model->order_id])->all();
        
        foreach($goods as $key=>$val)
        {
            $goodsDetail=Goods::findOne($val['goods_id']);
            if($goodsDetail->shop_id=="1"&&$goodsDetail->jdgoods_id!="")
            {
                $res=$this->getNewStockById($goodsDetail,$val['num'],$userAddress);
                if(!$res)
                {
                    $goods[$key]["jdstock"]="京东商品库存不足";
                }else{
                    $goods[$key]["jdstock"]="有货";
                }
            }
            if($goodsDetail->source_id!="")
            {
              	$goods[$key]["source"]=Supplier::find()->asArray()->where(["id"=>$goodsDetail->source_id])->one();
            }else{
              	$goods[$key]["source"]="云中鹤";
            }
        }
        //$this->dump($goods);
        return $this->render('view', [
            'model' => $model,
          //  'userAddress' => $userAddress,
            'goods' => $goods,
            'shops' => $shops,
            'user' => $user,
            'userAuth' => $userAuth,
            
        ]);
    }else{
      	return $this->render('group', [
            "order_sn"=>$order_sn,
        ]);
    }
     
    }
    public function actionView($id)
    {   
        $model=$this->findModel($id);
       // $userAddress=UserAddress::findOne($model->address_id);
        $shops=Shops::findOne($model->shop_id);
        $user=User::findOne($model->user_id);
        $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$model->user_id])->one();
        

        $goods=OrderGoods::find()->asArray()->where(["order_id"=>$model->order_id])->all();
        
        foreach($goods as $key=>$val)
        {
            $goodsDetail=Goods::findOne($val['goods_id']);
            if($goodsDetail->shop_id=="1"&&$goodsDetail->jdgoods_id!="")
            {
                $res=$this->getNewStockById($goodsDetail,$val['num'],$userAddress);
                if(!$res)
                {
                    $goods[$key]["jdstock"]="京东商品库存不足";
                }else{
                    $goods[$key]["jdstock"]="有货";
                }
            }
            if($goodsDetail->source_id!="")
            {
              	$goods[$key]["source"]=Supplier::find()->asArray()->where(["id"=>$goodsDetail->source_id])->one();
            }else{
              	if($goodsDetail->source=="jindong")
                {
                    $goods[$key]["source"]="云中鹤-京东";
                }else if($goodsDetail->source=="wangyi")
                {
                  	$goods[$key]["source"]="云中鹤-网易";
                }else if($goodsDetail->source=="system")
                {
                  	$goods[$key]["source"]="云中鹤-系统";
                }else if($goodsDetail->source=="provider")
                {
                  	$goods[$key]["source"]="云中鹤-供货商";
                }
              
              	
            }
        }
        //$this->dump($goods);
        return $this->render('view', [
            'model' => $model,
          //  'userAddress' => $userAddress,
            'goods' => $goods,
            'shops' => $shops,
            'user' => $user,
            'userAuth' => $userAuth,
            
        ]);
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

    public function actionOrderRefund($order_id="")//退款
    {
      
        $this->layout=false;
        if($data=Yii::$app->request->post()){
            
            $user_id=Yii::$app->user->identity->id;
            $order=Order::findOne($data['order_id']);
            $order->refund_status_remark=$data['refund_status_remark'];
            if($data['status']==1)
            {
                $result=false;
                $orderRefund=new OrderRefund();
                if($order->pay_type=="1")
                {
                  	$result=$orderRefund->refundSubmitAlipay($order->order_id);//支付宝退款
                    
                }else if($order->pay_type=="6"){
                   	$user=User::findOne($order->user_id);
                  	$user->recharge_fee=round($user->recharge_fee+$order->total_fee,2);
                  	if($user->update(true,["recharge_fee"]))
                    {
                    	$result=true;
                        $userCardLog=new UserCardLog();
                        $userCardLog->user_id=$order->user_id;
                        $userCardLog->type="3";
                        $userCardLog->fee=$order->total_fee;
                        $userCardLog->card_num="";
                        $userCardLog->create_time=time();
                     
                        if(!$userCardLog->save())
                        {
                            throw new \yii\db\Exception("保存失败");
                        } 
                      	
                    }
                }else{
                    $result=$orderRefund->refundSubmitWx($order->order_id);//微信退款
                }
               // $result=true;
                if($result)
                {
                    $order->status=5;  
                    $order->update(true,['status',"refund_status_remark"]);  
                  	//删除上级用户的待收入金额
                  	$user=User::findOne($order->user_id);
                    if($user->user_parent_id!="")
                    {
                    	$parentUser=User::findOne($user->user_parent_id);  
                    	$waitWallet=WaitWallet::find()->where(["order_sn"=>$order->order_sn])->all();
                        $waitWalletFee=WaitWallet::find()->where(["order_sn"=>$order->order_sn])->sum("fee");
                        if(!empty($waitWallet))
                        {
                          	foreach($waitWallet as $val)
                            {
                                $waitWalletOne=WaitWallet::findOne($val->wid);
                              	$waitWalletOne->delete();
                            }
                        }
                       $parentUser->wait_wallet-=$waitWalletFee;
                       $parentUser->update(true,["wait_wallet"]);
                    }
                  	
                  
                  
                  
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

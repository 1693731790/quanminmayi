<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\GoodsSeckill;
use common\models\SpikeTime;
use common\models\UserAddress;
use common\models\OrderSeckill;



/**
 * Site controller
 */
class SeckillController extends CommonController
{
      public function actionIndex($time_id="")
      {  
          $this->layout="nofooter";
          $time=date("H",time());
          if($time_id=="")
          {
                $spikeTimeOne=SpikeTime::findOne(["hour"=>$time.":00"]);
                $time_id=$spikeTimeOne->id;
          }
          
          $time=date("H",time());
          $datetime=date("Y-m-d",time());
          $start_time=$datetime." 00:00:00";
          $end_time=$datetime." 23:59:59";
          $spikeTime=SpikeTime::find()->orderBy("hour asc")->all();
          $GoodsModel=GoodsSeckill::find();
          $goods=$GoodsModel->where(["status"=>"200"])->andFilterWhere(['between','start_time',strtotime($start_time),strtotime($end_time)])->andFilterWhere(["hour"=>$time_id])->orderBy("create_time desc")->limit(5)->all();
   
       // die();
          //$time=date("H",time());
         //$this->dump($GoodsModel->createCommand()->getRawSql());
        // $this->dump($goods);
          return $this->render("index",[
                "spikeTime"=>$spikeTime,
                "time"=>$time,
                "goods"=>$goods,
                "time_id"=>$time_id,
            
          ]);
      }
      public function actionStockCheck($goods_id,$num)
      {
            $model=GoodsSeckill::findOne($goods_id);
            
            if($model->surplus>=$num)
            {
                $res["success"]=true;
                return json_encode($res);
            }else{
                $res["success"]=false;
                return json_encode($res);
            }

      }
      public function actionDetail($goods_id)
      {  
          $this->layout="nofooter";
          
          $model=GoodsSeckill::findOne($goods_id);
          $goods_img=json_decode($model->goods_img);
          $model->goods_img=$goods_img;
          //$this->dump($model);
          $spikeTimeOne=SpikeTime::findOne($model->hour);
          $datetime=date("Y-m-d",time());
          $start_time=strtotime($datetime." ".$spikeTimeOne->hour);
          $seckillok="0";
          /*echo $start_time."--".time();
        die();*/
          if($start_time<time())
          {
             $seckillok="1";
          }
          //$this->dump($seckillok);
          return $this->render("detail",[
                "seckillok"=>$seckillok,
                "model"=>$model,
            
          ]);
      }
  
      public function actionGoodsList($page)
      { 
      
          $page=($page-1)*5;
          $model=GoodsSeckill::find();
          $goods=$model->asArray()->where(["status"=>"200"])->orderBy("create_time desc")->offset($page)->limit(5)->all();
          $str=""; 
          foreach($goods as $goodsVal)
          {
              $width=round(($goodsVal['stock']-$goodsVal['surplus'])/$goodsVal['stock']*100,0);
              
              $str.='<div class="pageone"><a href="'.Url::to(["seckill/detail","goods_id"=>$goodsVal['goods_id']]).'"><div class="leftpic">
                  <img class="leftpict" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"/></div><div class="rightwenzi"><div class="rightwenzione">'.$goodsVal['goods_name'].'</div><div class="rightwenzitwo">'.$goodsVal['desc'].'</div><div class="rightwenzithree">¥'.$goodsVal['old_price'].'<span class="price">¥'.$goodsVal['price'].'</span></div><div class="rightwenzifour"><div class="righttitle">已抢'.($goodsVal['stock']-$goodsVal['surplus']).'件</div><div class="progress"><div class="bar" style="width:'.$width.'%;"></div></div><div class="righttitlethree">立即抢购</div></div></div></a></div>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
          
      }

      public function actionAddOrder()//添加订单
      {
          if($data=Yii::$app->request->get()){
              //$this->dump($data);
              
              $user_id=Yii::$app->user->identity->id;
              $goods=GoodsSeckill::findOne($data["goods_id"]);
              
              $spikeTimeOne=SpikeTime::findOne($goods->hour);
              $datetime=date("Y-m-d",time());
              $start_time=strtotime($datetime." ".$spikeTimeOne->hour);
             
              if($start_time>time())
              {
                    return $this->render("message",[
                        "message"=>"秒杀未开始",
                    
                    ]);
              }
              $address=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->one();
              return $this->render("add-order",[
                    "goods"=>$goods,
                    "address"=>$address,
                    "num"=>$data['goodsnum'],
              ]);
          }else{
              return $this->redirect(['detail', 'goods_id' => $data['goods_id']]);
          } 
      }
        public function actionConfirmAddOrder($goods_id,$aid,$num,$remarks="")//确认添加订单
        {
            $model=new OrderSeckill();
            $res=$model->addOrder($goods_id,$aid,$num,$remarks);
            if($res)
            {
                return $this->redirect(['pay-seckill/order-pay', 'order_id' => $model->order_id]);  
            }else{
                return $this->render("message",[
                        "message"=>"下单失败",
                    
                    ]);
            }
        }
}

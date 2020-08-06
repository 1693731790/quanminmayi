<?php
namespace mall\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\GoodsSeckill;
use common\models\SpikeTime;
use common\models\UserAddress;
use common\models\OrderSeckill;
use common\models\Goods;
use common\models\Config;
use common\models\GoodsFavorite;
use common\models\GoodsCate;
use common\models\GoodsAttrKey;
use common\models\GoodsAttrVal;
use common\models\GoodsSku;
use common\models\Shops;
use common\models\Order;
use common\models\Region;


/**
 * Site controller
 */
class SeckillController extends CommonController
{
      public function actionIndex($time_id="",$token="")
      {  
          $this->layout="nofooter";
          $time=date("H",time()).":00";
          if($time_id!="")
          {
                $spikeTimeOne=SpikeTime::findOne($time_id);
                $time_id=$spikeTimeOne->id;
                $time=$spikeTimeOne->hour;
          }
          $datetime=date("Y-m-d",time());
          $start_time=strtotime($datetime." ".$time);
          $end_time=strtotime($datetime." ".$time)+3559; 
          
         // $end_time=$datetime." 23:59:59";
          
          $spikeTime=SpikeTime::find()->orderBy("hour asc")->all();
          $goodsModel=Goods::find();
          $goods=$goodsModel->where(["status"=>"200","is_seckill"=>"1"])->andFilterWhere(['between','seckill_start_time',$start_time,$end_time])->orderBy("create_time desc")->limit(5)->all();
    //  $this->dump($goodsModel->createCommand()->getRawSql());
        // die();
        //$time=date("H",time());
        
        // $this->dump($goods);
          return $this->render("index",[
                "spikeTime"=>$spikeTime,
                "time"=>$time,
                "goods"=>$goods,
                "time_id"=>$time_id,
                "token"=>$token,
            
          ]);
      }

      public function actionGoodsList($page,$time_id="")
      { 
          $time=date("H",time()).":00";
          if($time_id!="")
          {
                $spikeTimeOne=SpikeTime::findOne($time_id);
                $time_id=$spikeTimeOne->id;
                $time=$spikeTimeOne->hour;
          }
          $datetime=date("Y-m-d",time());
          $start_time=strtotime($datetime." ".$time);
          $end_time=strtotime($datetime." ".$time)+3559; 

          $page=($page-1)*5;
          $model=Goods::find();
          $goods=$model->asArray()->where(["status"=>"200","is_seckill"=>"1"])->andFilterWhere(['between','seckill_start_time',$start_time,$end_time])->orderBy("create_time desc")->offset($page)->limit(5)->all();
          $str=""; 
          foreach($goods as $goodsVal)
          {
              $width=round(($goodsVal['stock']-$goodsVal['surplus'])/$goodsVal['stock']*100,0);
              
              $str.='<div class="pageone"><a href="'.Url::to(["seckill/detail","goods_id"=>$goodsVal['goods_id']]).'"><div class="leftpic">
                  <img class="leftpict" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"/></div><div class="rightwenzi"><div class="rightwenzione">'.$goodsVal['goods_name'].'</div><div class="rightwenzitwo">'.$goodsVal['desc'].'</div><div class="rightwenzithree">¥'.$goodsVal['seckill_price'].'<span class="price">¥'.$goodsVal['old_price'].'</span></div><div class="rightwenzifour"><div class="righttitle">已抢'.($goodsVal['stock']-$goodsVal['surplus']).'件</div><div class="progress"><div class="bar" style="width:'.$width.'%;"></div></div><div class="righttitlethree">立即抢购</div></div></div></a></div>';
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
          
      }

   
      public function actionDetail()
      {
        
          error_reporting(0);
          $getData=Yii::$app->request->get();
          if($getData["goods_id"]=="")
          {
                return $this->render('message', [
                        "message"=>"此商品错误,请选择其他商品",
                    ]);
          }
          
          $goods_id=$getData["goods_id"];
          
         
          $model=Goods::findOne($goods_id);
          $seckill_start_time=$model->seckill_start_time;
          $seckill_end_time=$model->seckill_end_time;
        
          
          $goods_img=json_decode($model->goods_img);
          $this->layout="nofooter";
          
           
          if($model->is_agent_buy=="1")
          {
            return $this->redirect(['user-upgrade/detail',"goods_id"=>$model->goods_id])->send();   
            die();
          }

          if(empty($model)||$model->is_seckill!="1"||$model->issale!=1)
          {
              return $this->render('message', [
                        "message"=>"商品已下架,请选择其他商品",
                    ]);
          }
          
		 
          if($model->source!="qmmy")
          {
                if(!$model->updateGoods())
                {
                    return $this->render('message', [
                        "message"=>"商品已下架,请选择其他商品",
                    ]);
                }
                
          }
          
         
          $config=Config::findOne(1);
           
        
       	  if($seckill_end_time<time())
          {
           		$model->is_seckill="0"; 
          }
         
          $model->browse=$model->browse+1;
          $model->update(true, ['browse',"is_seckill"]);
          
          //$oneDeductions=0;
          
          //if($model->shop_id=="1"||$model->shop_id=="2"){  //&&$model->is_agent_buy!="1"
          //      $oneDeductions=round($model->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                
          //}
          
          if($model->status!="200")
          { 
              exit("未知错误");
              return false;
          }

          
          $attrData=[];
          $goodsSkuData=[];
          $goodsStock="";
          $goodsKey=GoodsAttrKey::find()->asArray()->where(["goods_id"=>$goods_id])->all();
                
          //获取所有attrkey和attrVal
          foreach ($goodsKey as $key => $value) {
                $attrData[$key]["attrkey"]=$value["attr_key_name"];
                $attrData[$key]["attrkeyid"]=$value["attr_key_id"];
                $GoodsAttrVal=GoodsAttrVal::find()->asArray()->where(["attr_key_id"=>$value["attr_key_id"]])->select(['attr_id','attr_val_name'])->orderBy(['attr_id'=>"asc"])->all();
                  
                $goodsSkuData[]=$GoodsAttrVal;
                foreach ($GoodsAttrVal as $valkey => $valval) {
                      $attrData[$key]["attrval"][]=$valval;
                }
                 
          }

          $goodsStock=GoodsSku::find()->where(["goods_id"=>$goods_id])->sum("stock");//所有规格的库存
                
         
          $model->goods_img=$goods_img;
           
          
          $searchLink=yii::$app->params['webLink']."/seckill/detail.html?goods_id=".$getData["goods_id"];
        
          
          ob_start();
          \PHPQRCode\QRcode::png($searchLink,false,'L', 4, 2);
          $imageString = base64_encode(ob_get_contents());
          ob_end_clean();
          $resQrcode='data:image/png;base64,'.$imageString;
          if($model->jdis_update_goods_thums=="1"||$model->shop_id!="1")
          {	
            	$shareImg=Yii::$app->params['webLink'].$model->goods_thums;
          }else{
           		 $shareImg=$model->goods_thums;
          }
         
          return $this->render('detail', [
              'model' => $model,
              "goodsStock"=>$goodsStock,
              "attrData"=>$attrData,
              "seckill_start_time"=>$seckill_start_time,
              "seckill_end_time"=>$seckill_end_time,
              "searchLink"=>$searchLink,
              "resQrcode"=>$resQrcode,
              "shareImg"=>$shareImg,
            //  "oneDeductions"=>$oneDeductions,
              //"searchLink"=>$searchLink,
              //"resQrcode"=>$resQrcode,
              //"code"=>isset($getData["code"])?$getData["code"]:"",
              //"isGuest"=>yii::$app->user->isGuest,
          
              
          ]);
        
      }
  
 

       public function actionAddOrder()//添加订单
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }

          if($data=Yii::$app->request->post()){
           // $this->dump($data);
              $config=Config::findOne(1);            
              if($data["user_id"]=="")
              {
                    $user_id=Yii::$app->user->identity->id;  
              }else{
                    $user_id=$data["user_id"];
              }
              
              $shop=Shops::findOne($data["shop_id"]);
              $goods=Goods::findOne($data["goods_id"]);
             
             // $this->dump($agent);

              
              
              //计算订单金额
               $totalFee=round(($goods->seckill_price*$data['goodsnum']+$goods->freight),2);
              
              //计算可以使用话费抵扣的金额
              
             
              $address=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->one();

             // $this->dump($myTelFee);
              $yunfeiFee=0;
              $totalFee=0;
              $addressList=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->all();
              $region=Region::find()->where(["parent_id"=>"0"])->all();
              return $this->render("add-order",[
                    "shop"=>$shop,
                    "goods"=>$goods,
                    "config"=>$config,
                    "address"=>$address,
                    "addressList"=>$addressList,
                    "yunfeiFee"=>$yunfeiFee,
                	"region"=>$region,
                    "num"=>$data['goodsnum'],
                   
                    
                   
              ]);
          }else{
              return $this->redirect(['detail', 'goods_id' => $data['goods_id']]);
          } 
      }

      public function actionConfirmAddOrder()//确认添加订单
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }
          if($data=Yii::$app->request->post()){
              //$this->dump($data);
              if($data["is_seckill"]=="1")
              {
                    $seckill=true;
                    $goods=Goods::findOne($data["goods_id"]);
                    if($goods->is_seckill!="1"||$goods->seckill_start_time>time()||$goods->seckill_end_time<time())
                    {
                        $seckill=false;
                    }

                    if(!$seckill)
                    {
                        return $this->render('message', [
                            "message"=>"商品未知错误,请选择其他商品",
                        ]);
                    }
              }
              $model = new Order();
              
              $orderok=$model->addOrder($data);

              if($orderok)
              {
                   return $this->redirect(['pay/order-pay', 'order_id' => $model->order_id]);  
              }else{
                   return $this->render('message', [
                        "message"=>"商品接口出错,请选择其他商品",
                   ]);
              }
          }
      }

      public function actionGetGoodsStock()
      {
        
            $data=Yii::$app->request->get();
            $goods=Goods::findOne($data["goods_id"]);
            $address=UserAddress::findOne($data["address_id"]);
            $region=explode("-", $address->region_id);
            $area=$region[0]."_".$region[1]."_".$region[2];
            
            $yunzhonghe=new Yunzhonghe();
            $res=$yunzhonghe->getGoodsStock($goods->jdgoods_id,$data["num"],$area);
            //$this->dump($res);
            if($res->RESPONSE_STATUS=="true"&&$res->RESULT_DATA->stock_status==true)
            {
                
                $result["success"]=true;
                return json_encode($result);
            }else{
                $result["success"]=false;
                $result["message"]="该商品库存不足";
                return json_encode($result);
            }
          
      }

}

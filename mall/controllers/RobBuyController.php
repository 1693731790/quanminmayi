<?php
namespace mall\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\RobBuy;
use common\models\Goods;
use common\models\Shops;
use common\models\Order;
use common\models\UserAddress;
use common\models\GoodsAttrKey;
use common\models\GoodsAttrVal;
use common\models\GoodsSku;
use common\models\GoodsComment;





/**
 * Site controller
 */
class RobBuyController extends CommonController
{
     public $enableCsrfValidation = false;
     public function actionConfirmAddOrder()//确认添加订单
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }
          if($data=Yii::$app->request->post()){
              //$this->dump($data);
              $model = new Order();
              $orderok=$model->addRobOrder($data);

              if($orderok)
              {
                  return $this->redirect(['pay/order-pay', 'order_id' => $model->order_id,"rob_id"=>$data['rob_id']]);  
              }else{
                  return $this->redirect(['detail', 'goods_id' => $data['goods_id']]);
              }
          }
      }
      public function actionAddOrder()//添加订单
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }

          if($data=Yii::$app->request->post()){
            //$this->dump($data);
              $user_id=Yii::$app->user->identity->id;
              $shop=Shops::findOne($data["shop_id"]);
              $goods=Goods::findOne($data["goods_id"]);
              $robBuy=RobBuy::findOne($data['rob_id']);
              $norob['success']=false;
              $message="";
              if($robBuy->start_time>time())
              {
                  $norob['success']=true;
                  $message="未到秒杀时间";
              }
              if($robBuy->end_time<time())
              {
                  $norob['success']=true;
                  $message="秒杀已结束";
              }
              if($robBuy->num==0)
              {
                  $norob['success']=true;
                  $message="秒杀商品已售完";
              }
              if($norob['success'])
              {
                  return $this->redirect(['detail', 'rob_id' => $robBuy->rob_id,"msg"=>$message]);
              }
              if($data["skuPath"]!="")
              {
                  $attr_path=substr($data["skuPath"],0,strlen($data["skuPath"])-1);
                  $sku=GoodsSku::find()->where(["attr_path"=>$attr_path])->one();  
              }else{
                  $sku="";
              }
              $address=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->one();
              
              //$this->dump($sku);
              return $this->render("add-order",[
                    "shop"=>$shop,
                    "goods"=>$goods,
                    "sku"=>$sku,
                    "address"=>$address,
                    "num"=>$data['goodsnum'], 
                    "robBuy"=>$robBuy,
                    
              ]);
          }else{
              return $this->redirect(['detail', 'goods_id' => $data['goods_id']]);
          } 
      }
    public function actionDetail($rob_id,$msg="")
      {
         
          $this->layout="nofooter";
          $robBuy=RobBuy::findOne($rob_id);
          $goods_id=$robBuy->goods_id;
          
          $model =Goods::findOne($goods_id);
          $goods_img=json_decode($model->goods_img);
          $model->browse=$model->browse+1;
          $model->update(true, ['browse']);
          
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
          $comment=GoodsComment::find();
          
          $goodsComment=$comment->with(["user",'userAuth'])->where(["goods_id"=>$goods_id])->limit(2)->all();
          $countComment=$comment->where(["goods_id"=>$goods_id])->count();
          $goodComment=$comment->where(["goods_id"=>$goods_id,"type"=>"1"])->count();

          
          $goodCommentRate=0;
          if($countComment>0&&$goodsComment>0)
          {
              $goodCommentRate=round($goodComment/$countComment*100);  
          }
          
          // $this->dump($goods_img);
          // $this->dump($model->goods_img);
          $model->goods_img=$goods_img;
          $norob['success']=false;
          
          if($robBuy->start_time>time())
          {
              $norob['success']=true;
              $message="未到秒杀时间";
          }
          if($robBuy->end_time<time())
          {
              $norob['success']=true;
              $message="秒杀已结束";
          }
          if($robBuy->num==0)
          {
              $norob['success']=true;
              $message="秒杀商品已售完";
          }
          if($norob['success'])
          { 
              return $this->render('detail-norob', [
                  'model' => $model,
                  'goodsComment' => $goodsComment,
                  "countComment"=>$countComment,
                  "goodsStock"=>$goodsStock,
                  "goodCommentRate"=>$goodCommentRate,
                  "attrData"=>$attrData,
                  "message"=>$message,

              ]);    
          }

          if($model->issale!=1)
          { 
              return $this->render('detail-nosale', [
                  'model' => $model,
                  'goodsComment' => $goodsComment,
                  "countComment"=>$countComment,
                  "goodsStock"=>$goodsStock,
                  "goodCommentRate"=>$goodCommentRate,
                  "attrData"=>$attrData,
              ]);
          }
          return $this->render('detail', [
              'model' => $model,
              'goodsComment' => $goodsComment,
              "countComment"=>$countComment,
              "goodsStock"=>$goodsStock,
              "goodCommentRate"=>$goodCommentRate,
              "attrData"=>$attrData,
              "robBuy"=>$robBuy,
              "msg"=>$msg,
              
          ]);
        
      }

    public function actionIndex()
    {
          $this->layout="nofooter";
          $robgoods=RobBuy::find()->with(["goods"])->where([">","end_time",time()])->orderBy("start_time asc")->limit(10)->all();
          //$this->dump(RobBuy::find()->all());
          return $this->render("index",[
             
              "robgoods"=>$robgoods,
          ]);
    }

    public function actionRobBuyList($page="")
    {
       
        $page=($page-1)*10;
        $model=RobBuy::find();
        $robgoods=$model->with(["goods"])->where([">","end_time",time()])->orderBy("start_time asc")->offset($page)->limit(10)->all();
        $str=""; 
        
        foreach($robgoods as $robgoodsVal)
        {
           
            $str.='<li><a href="'.Url::to(["rob-buy/detail","rob_id"=>$robgoodsVal->rob_id]).'" class="clearfix"><div class="pic fl" style="background-image:url('.Yii::$app->params['imgurl'].$robgoodsVal->goods->goods_thums.')"></div><div class="text"><h2 class="title slh2">'.$robgoodsVal->goods->goods_name.'</h2><p class="price">秒杀价<span class="num">￥'.$robgoodsVal->price.'</span><span class="OriginalPrice">￥'.$robgoodsVal->goods->price.'</span></p><p class="price">开始时间 <span class="num">'.date("Y-m-d H:i",$robgoodsVal->start_time).'</span></p><p class="price">结束时间 <span class="num">'.date("Y-m-d H:i",$robgoodsVal->end_time).'</span></p><div class="skill-count clearfix radius-3"><span class="surplus fl">剩余'.$robgoodsVal->num.'件</span></div></div></a></li>';
            
        } 
        //$this->dump($str);
        echo $str;
        //return json_encode($orders);
       
    }

   
      

      
     

}

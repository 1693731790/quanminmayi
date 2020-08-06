<?php
namespace agent\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;

use common\models\Goods;
use common\models\GoodsCate;
use common\models\GoodsAttrKey;
use common\models\GoodsAttrVal;
use common\models\GoodsSku;



/**
 * Site controller
 */
class GoodsController extends Controller
{

      public $enableCsrfValidation = false;
      public function actionGoodsSelect($salecount="",$browse="",$new="",$searchKey="")
      {
          $this->layout="noleft";
          $orderby='browse DESC';
          if($salecount!="")
          {
               $orderby='salecount '.$salecount;
          }
          if($browse!="")
          {
               $orderby='browse '.$browse;
          }
          if($new!="")
          {
               $orderby='create_time '.$new;
          }
          //$this->dump($orderby);

          $model=Goods::find();
          $count=$model->where(["status"=>"200","issale"=>"1","shop_id"=>"1","is_agent_buy"=>"1"])->andFilterWhere(['like', 'goods_name', $searchKey])->count();
          $pagination = new Pagination(['totalCount' => $count,'pageSize'=>'20']);
          $goods=$model->where(["status"=>"200","issale"=>"1","shop_id"=>"1","is_agent_buy"=>"1"])->andFilterWhere(['like', 'goods_name', $searchKey])->orderBy($orderby)->offset($pagination->offset)->limit($pagination->limit)->all();

           
          
          return $this->render("goods-select",[
              "goods"=>$goods,
              "pagination"=>$pagination,
              "searchKey"=>$searchKey,
              
              "salecount"=>$salecount,
              "browse"=>$browse,
              "new"=>$new,
          ]);
      }
      
      public function actionConfirmAddOrder()//确认添加订单
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }
          if($data=Yii::$app->request->post()){
             // $this->dump($data);
              $model = new Order();
              $orderok=$model->addOrder($data);

              if($orderok)
              {
                  return $this->redirect(['pay/order-pay', 'order_id' => $model->order_id]);  
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
              $userCoupon=UserCoupon::find()->where(["user_id"=>$user_id,"shop_id"=>$shop->shop_id])->one();
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
                    "userCoupon"=>$userCoupon,
                    "num"=>$data['goodsnum'],  
              ]);
          }else{
              return $this->redirect(['detail', 'goods_id' => $data['goods_id']]);
          } 
      }
     
      public function actionGoodsDetail($goods_id)
      {
          
          
          $model =Goods::findOne($goods_id);
          $res=[];                   
          if($model->status!="200"||$model->issale!=1)
          { 
              $res["success"]=false;
              return json_encode($res);

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
          
          //$this->dump($attrData);
          $res["success"]=true;
          $res["data"]=$attrData;
          return json_encode($res);
          
              
          
          
      }

      public function actionGoodsSku($skuPath)
      { 
          $attr_path=substr($skuPath,0,strlen($skuPath)-1);
          $sku=GoodsSku::find()->asArray()->where(["attr_path"=>$attr_path])->one();
         // $this->dump($sku);
          return json_encode($sku);
      }


}

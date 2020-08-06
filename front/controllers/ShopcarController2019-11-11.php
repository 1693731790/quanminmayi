<?php
namespace front\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\UserAddress;
use common\models\GoodsShopcar;
use common\models\Goods;
use common\models\Shops;
use common\models\GoodsSku;
use common\models\Order;
use common\models\OrderAllPay;
use common\models\OrderGoods;
use common\models\Liguanjia;
use common\models\MobileApi;
use common\models\Config;
use common\models\User;
use common\models\Yunzhonghe;
use common\models\Region;




/**
 * 购物车
 */
class ShopcarController extends CommonController
{
      public $enableCsrfValidation = false;

      public function actionConfirmAddOrderAll()//确认添加订单
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }

          if($data=Yii::$app->request->post()){
             // $this->dump($data);
              
              $orderok=$this->addOrderAll($data);
              
              if($orderok)
              {
                  return $this->redirect(['pay/order-pay-all', 'order_all_id' => $orderok]);  
              }else{
                   return $this->render('/goods/message', [
                        "message"=>"京东商品出错,请选择其他商品",
                   ]);
              }
          }
      }
      public function addOrderAll($data)//批量合并添加订单
      {
          $config=Config::findOne(1);
          $userAddress=UserAddress::find()->asArray()->where(["aid"=>$data["address_id"]])->one();
          $transaction=Yii::$app->db->beginTransaction();
          try {

              $orderAll=new OrderAllPay();
              $orderAll->all_pay_sn=rand(100000,999999).Yii::$app->user->identity->id.time();
              if(!$orderAll->save())
              {
                  throw new \yii\db\Exception("保存失败");
              }
              foreach($data['data'] as $datakey=>$dataval)
              {
                  $model = new Order();
                  $total_fee=0;
                  $freight=0;
                  $xytotalFee=0;
                  $yunfeiFee=0;
                  foreach($dataval['goods'] as $goodskey=>$goodsval)
                  {
                      $sku=GoodsSku::findOne($goodsval["skuid"]);
                      $goods=Goods::findOne($goodsval["goods_id"]);
                     // $this->dump($goods->shop_id);
                      if($goods->shop_id=="1"&&$goods->is_agent_buy!="1")
                      {
                            $xytotalFee+=$goods['xy_price']; 
                            if($goodsval['skuid']=="")
                            {
                                $total_fee+=round($goods->price*$goodsval['num'],2);
                            }else{
                                $total_fee+=round($sku->price*$goodsval['num'],2);
                            }
                            //$freight+=$goods->freight; 
                      }else{
                          if($goodsval['skuid']=="")
                          {
                              $total_fee+=round($goods->price*$goodsval['num']+$goods->freight,2);
                          }else{
                              $total_fee+=round($sku->price*$goodsval['num']+$goods->freight,2);
                          }
                          $freight+=$goods->freight;
                      }
                        if(isset($data["telFeeDeductions"]))
                        {
                            //计算可以使用话费抵扣的金额
                              $telFeeDeductions=0;
                              if($goodsval["skuid"]!=""){
                                  $oneDeductions=round($goods->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                                  $telFeeDeductions=round($oneDeductions*$goodsval['num'],0);
                              }else{
                                  $oneDeductions=round($goods->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                                  $telFeeDeductions=round($oneDeductions*$goodsval['num'],0);
                              }

                              $mobileApi=new MobileApi();
                              $myTelFee=$mobileApi->getTelFare();//话费余额
                              $myUser=User::findOne(Yii::$app->user->identity->id);
                              $myUserGetCallFee=$myUser->get_call_fee;
                              $myUserTelFee=round($myTelFee+$myUserGetCallFee,2);

                              if($myUserTelFee<$telFeeDeductions&&$myUserTelFee>0)//话费少于可以抵扣金额并且大于0  
                              {
                                   $telFeeDeductions=$myUserTelFee;
                              }
                              if($myUserTelFee==0)//  
                              {
                                   $telFeeDeductions="0";
                              }


                              if($telFeeDeductions!="0") // 
                              {
                                  if($myUserGetCallFee>=$telFeeDeductions)
                                  {
                                    $myUser->get_call_fee=round($myUserGetCallFee-$telFeeDeductions,2);
                                    $myUser->update(true,["get_call_fee"]);
                                  }else{
                                    if($myUserGetCallFee!=0)
                                    {
                                      $myUser->get_call_fee=0;
                                      $myUser->update(true,["get_call_fee"]); 
                                      $mobileApiCallFee=$telFeeDeductions-$myUserGetCallFee;
                                    }else{
                                      $mobileApiCallFee=$myTelFee-$telFeeDeductions;
                                    }

                                    $reduceTelFare=$mobileApi->reduceTelFare("-".$mobileApiCallFee);
                                      if(!$reduceTelFare)
                                      {
                                          echo "话费扣除失败";
                                          die();
                                      }
                                  }
                              }

                              /*$mobileApi=new MobileApi();
                              $myTelFee=$mobileApi->getTelFare();//话费余额
                              if($myTelFee<=$telFeeDeductions)//话费少于可以抵扣金额，不能抵扣
                              {
                                   echo "无效的订单";
                                   die();
                              }else{
                                   $reduceTelFare=$mobileApi->reduceTelFare("-".$telFeeDeductions);
                                   if(!$reduceTelFare)
                                   {
                                       echo "话费扣除失败";
                                       die();
                                   }
                              }*/
                        }
                      
                  }
                 
                  if($xytotalFee!=0)
                  {
                  		//快递费注释 
                       /*if($xytotalFee<49)
                       {
                          $yunfeiFee=8;
                       }else if($xytotalFee>=49&&$xytotalFee<99)
                       {
                          $yunfeiFee=6;
                       }else if($xytotalFee>=99)
                       {
                          $yunfeiFee=0;
                       }*/
                      $freight=$yunfeiFee;
                      $total_fee+=$yunfeiFee;
                  } 

                
                  
                  $model->user_id=Yii::$app->user->identity->id;
                  $model->order_sn=rand(100000,999999).Yii::$app->user->identity->id.time();

                  

                  $model->shop_id=$dataval["shop_id"];
                  $model->total_fee=$total_fee;
                  if($telFeeDeductions!=0)
                  {
                      $model->telfare_fee=$telFeeDeductions;
                  }
                  $model->deliver_fee=$freight;
                  
		          $model->address_name=$userAddress['name'];
		          $model->address_phone=$userAddress['phone'];
		          $model->address_region=$userAddress['region'];
		          $model->address_region_id=$userAddress['region_id'];
		          $model->address_address=$userAddress['address'];

                  $model->remarks=$dataval["remarks"];
                  $model->create_time=time();
                  $model->order_all_pay_id=$orderAll->id;
                
                  if(!$model->save())
                  {
                      throw new \yii\db\Exception("保存失败");
                  }   
                  
                  foreach($dataval['goods'] as $ogoodskey=>$ogoodsval)
                  {  
                      $sku=GoodsSku::findOne($ogoodsval["skuid"]);
                      $goods=Goods::findOne($ogoodsval["goods_id"]);

                      $orderGoods=new OrderGoods();    
                      $orderGoods->order_id=$model->order_id;
                      $orderGoods->goods_id=$goods->goods_id;
                      $orderGoods->goods_name=$goods->goods_name;
                      $orderGoods->goods_thums=$goods->goods_thums;
                      if($ogoodsval['skuid']=="")
                      {
                          $orderGoods->attr_name="";
                          $orderGoods->price=$goods->price;
                      }else{
                          $orderGoods->attr_name=$sku->sku_name;
                          $orderGoods->price=$sku->price;
                      }
                    
                      $orderGoods->num=$ogoodsval['num'];

                      if(!$orderGoods->save())
                      {
                          throw new \yii\db\Exception("保存失败");
                      }
                      $goodsShopcar=GoodsShopcar::findOne($ogoodsval['shopcar_id']);
                      if(!$goodsShopcar->delete())
                      {
                          throw new \yii\db\Exception("保存失败"); 
                      }
                      if($ogoodsval["skuid"]!="")
                      {
                          $sku->stock=$sku->stock-1;
                          if(!$sku->save())
                          {
                              throw new \yii\db\Exception("保存失败");
                          }
                      }
                  }

                  

              }
              
              $transaction->commit();
              return $orderAll->id;

          }catch (\Exception $e) {
              $transaction->rollBack();
              //throw $e;
              return false;
              
          }
          
      }

      public function actionAddOrderAll()//合并添加订单
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }
          if($data=Yii::$app->request->post())
          {
              $user_id=Yii::$app->user->identity->id;
              $config=Config::findOne(1);
              if(empty($data['shopcar']))
              {
                  return $this->redirect(['shopcar/shopcar-list']);
              }
              //$this->dump($data);
              $shopcar=[];
              $isnull=false;
             //echo "<pre>";
              $xytotalFee=0;
              $yunfeiFee=0;
              $telFeeDeductions=0;
              foreach ($data["shopcar"] as $key => $datavalue) {
                $goods=[];

                 foreach ($datavalue as $keycar => $datavaluecar) {
                     
                      if(isset($datavaluecar["id"])&&$datavaluecar["id"]!="")
                      {
                          //$this->dump($keycar);
                          $isnull=true;
                          $shopcar[$key]["shop"]=Shops::find()->asArray()->where(['shop_id'=>$key])->select(["shop_id","name"])->one();
                          $goodsShopcar=GoodsShopcar::find()->asArray()->where(['goods_shopcar_id'=>$datavaluecar["id"]])->one();
                          $goodsData=Goods::find()->asArray()->where(["goods_id"=>$goodsShopcar['goods_id']])->one();//->select(["goods_id"])

                          if($goodsData['shop_id']=="1"&&$goodsData['is_agent_buy']!="1")
                          {
                             $xytotalFee+=$goodsData['xy_price'];  
                          }else{
                              $yunfeiFee+=$goodsData['freight'];
                          }
                          $goodsData["sku"]=GoodsSku::find()->asArray()->where(["attr_path"=>$goodsShopcar['skuPath']])->one();
                          $goodsData["shopcar_id"]=$datavaluecar["id"];
                          //var_dump($goodsData);
                          $goodsData["goodsnum"]=$datavaluecar["goodsnum"];
                          $goods[]=$goodsData;
                          $shopcar[$key]["shop"]["data"]=$goods;

                           //计算可以使用话费抵扣的金额
                           
                          if(!empty($goodsData["sku"])){
                              $oneDeductions=round($goodsData["profitFee"]*($config->goods_telfare_pct/100),0);//单一抵扣金额
                              $telFeeDeductions+=round($oneDeductions*$datavaluecar["goodsnum"],0);
                          }else{

                              $oneDeductions=round($goodsData['profitFee']*($config->goods_telfare_pct/100),0);//单一抵扣金额
                              $telFeeDeductions+=round($oneDeductions*$datavaluecar["goodsnum"],0);
                          }
                         
                      }
                  }
              }
             //$this->dump($telFeeDeductions);
             
             /* $mobileApi=new MobileApi();
              $myTelFee=$mobileApi->getTelFare();//话费余额
                
              if($myTelFee<=$telFeeDeductions)//话费少于可以抵扣金额，不能抵扣
              {
                   $telFeeDeductions=0;
              }*/
              $mobileApi=new MobileApi();
              $myTelFee=$mobileApi->getTelFare();//话费余额
              $myUser=User::findOne($user_id);
              $myTelFee=round($myTelFee+$myUser->get_call_fee,2);
              
              if($myTelFee<$telFeeDeductions&&$myTelFee>0)//话费少于可以抵扣金额并且大于0  
              {
                   $telFeeDeductions=$myTelFee;
              }
              if($myTelFee==0)//  
              {
                   $telFeeDeductions="0";
              }


              
              if(!$isnull)
              {
                  return $this->redirect(['shopcar/shopcar-list']);
              }

              //快递费注释 
              /*if($xytotalFee!=0)
              {
                 if($xytotalFee<49)
                 {
                    $yunfeiFee+=8;
                 }else if($xytotalFee>=49&&$xytotalFee<99)
                 {
                    $yunfeiFee+=6;
                 }else if($xytotalFee>=99)
                 {
                    $yunfeiFee+=0;
                 }
              } */
              
              
              $address=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->one();
			  $addressList=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->all();
			  $region=Region::find()->where(["parent_id"=>"0"])->all();
              //$this->dump($yunfeiFee);
              return $this->render("add-order-all",[
                    "shopcar"=>$shopcar,
                    "address"=>$address,
                    "region"=>$region,
                    "addressList"=>$addressList,
                    "yunfeiFee"=>$yunfeiFee,
                    "telFeeDeductions"=>$telFeeDeductions,
                    
                    
              ]);
             
          }
          return $this->redirect(['shopcar/shopcar-list']);
          
      }
      public function actionShopcarList()
      {
          error_reporting(0);
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $shops=GoodsShopcar::find()->asArray()->with(['shops'])->where(["user_id"=>$user_id])->groupBy('shop_id')->select(['shop_id'])->all();
          $goods=GoodsShopcar::find()->asArray()->where(["user_id"=>$user_id])->select(["goods_shopcar_id","goods_id"])->all();
          
          foreach($goods as $gk=>$goodsVal)
          {
                $goodsOne=Goods::findOne($goodsVal['goods_id']);
                if(!empty($goodsOne))
                {
                    if($goodsOne->shop_id=="1"&&$goodsOne->is_agent_buy=="0")
                    {
                        $goodsOne->updateGoods();
                    }    
                }else{
                    $goodsShopcarOne=GoodsShopcar::findOne($goodsVal["goods_shopcar_id"]);
                    $goodsShopcarOne->delete();
                }
                
          }
         
          foreach($shops as $key=>$val)
          {
              $shops[$key]["shopcar"]=GoodsShopcar::find()->asArray()->with(['goods','sku'])->where(["user_id"=>$user_id,'shop_id'=>$val["shop_id"]])->all();
          }
 		//$this->dump($shops);
          //$this->dump($shops);
          //$this->dump($shopcar);
          return $this->render("shopcar-list",[
                "shops"=>$shops,
          ]);
      }
      public function actionShopcarDelete($goods_shopcar_id)//删除购物车
      {
        
          if(yii::$app->user->isGuest)
          {
              return false;
          }
          $model=GoodsShopcar::findOne($goods_shopcar_id);
          $user_id=Yii::$app->user->identity->id;
         
          if(!empty($model))
          {
              if($model->user_id!=$user_id)
              {
                return false;
              }
              if($model->delete())
              {
                  return true;
              }else{
                  return false;
              }
          }else{
              return false;
          }
      }
      public function actionAddShopcar()//加入购物车
      {
          if(yii::$app->user->isGuest)
          {
              $res["success"]=false;
              $res['message']="您还没有登录,请登录";
              return json_encode($res);
          }
          $res=[];
          if($data=Yii::$app->request->get())
          {
              $goods=Goods::findOne($data["goods_id"]);
              if($goods->is_group=="1")
              {
                    $res["success"]=false;
                    $res['message']="该商品不支持加入购物车";
              }
              if($goods->is_agent_buy=="1")
              {
                    $res["success"]=false;
                    $res['message']="未知错误";
              }
              $model=new GoodsShopcar();
              if($model->addShopcar($data))
              {
                  $res["success"]=true;
                  $res['message']="加入购物车成功";
              }else{
                  $res["success"]=false;
                  $res['message']="加入购物车失败";
              }
              return json_encode($res);

              
          }
          $res["success"]=false;
          $res['message']="数据不正确";
          return json_encode($res);
      }

     public function actionGetNewStockById()
      {
            $data=Yii::$app->request->get();
            //$this->dump($data);
            $address=UserAddress::findOne($data["address_id"]);
            $region=explode("-", $address->region_id);
            $area=$region[0]."_".$region[1]."_".$region[2];
            $yunzhonghe=new Yunzhonghe();
            foreach($data["data"] as $key=>$val)
            {
                if($val["shop_id"]=="1")
                {
                    foreach($val["goods"] as $goodskey=>$goodsval)
                    {
                        $arr=array();
                        $goods=Goods::findOne($goodsval["goods_id"]);
                        if($goods->is_agent_buy!="1")
                        {
                           $res=$yunzhonghe->getGoodsStock($goods->jdgoods_id,$goodsval["num"],$area);
                          //	$this->dump($res);
				            if($res->RESPONSE_STATUS=="true"&&$res->RESULT_DATA->stock_status==true)
				            {
				            
				            }else{
				                $result["success"]=false;
                                $result["message"]=mb_substr($goods->goods_name, "0", "10", "utf-8")."商品库存不足";
                                return json_encode($result);
				            }
                        }
                    }
                }
            }
       		
            $result["success"]=true;
            return json_encode($result);
            
          
      }

}

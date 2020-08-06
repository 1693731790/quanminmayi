<?php
namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Agent;
use common\models\Goods;
use common\models\GoodsFavorite;
use common\models\GoodsCate;
use common\models\GoodsAttrKey;
use common\models\GoodsAttrVal;
use common\models\GoodsSku;
use common\models\GoodsComment;
use common\models\Order;
use common\models\Shops;
use common\models\ShopCoupon;
use common\models\UserCoupon;
use common\models\UserAddress;
use common\models\Config;
use common\models\MobileApi;
use common\models\User;
use common\models\Yunzhonghe;

/**
 * Site controller
 */
class GoodsController extends Controller
{
      public $enableCsrfValidation = false;
      public function actionIndex($search_key="",$page="",$goods_cate_id="",$goods_brand="",$isjd="",$isdigital="",$isdiscount="",$istodaynew="",$isselected="")
      {
       
          $model=Goods::find();
          $orderby='browse DESC';  
          if($page!="")
          {
                $page=($page-1)*30;
                $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(['like', 'goods_name', $search_key])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->select(["goods_id","salecount","goods_thums","goods_name","price","old_price","desc","shop_id","jdis_update_goods_thums"])->orderBy($orderby)->offset($page)->limit(30)->all();
          }else{
                $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(['like', 'goods_name', $search_key])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->select(["goods_id","salecount","goods_thums","goods_name","price","old_price","desc","shop_id","jdis_update_goods_thums"])->orderBy($orderby)->limit(30)->all();
          }
         // $this->dump($model->createCommand()->getRawSql());
          foreach ($goods as $key => $goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              $goods[$key]["favorite"]=$favorite;
             if($goods[$key]["shop_id"]!="1")
             {
              	$goods[$key]["goods_thums"]=yii::$app->params['webLink'].$goods[$key]["goods_thums"]; 
             }
              
          }
        
           $result["success"]=true;
           $result["message"]="获取成功";
           $result["data"]=$goods;
           $result["goods_cate_id"]=$goods_cate_id;	
           $result["search_key"]=$search_key;
           $result["goods_brand"]=$goods_brand;
           return json_encode($result);
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
           // $this->dump($res);
            if($res->RESPONSE_STATUS=="true"||$res->RESULT_DATA->stock_status==true)
            {
                
                $result["success"]=true;
                return json_encode($result);
            }else{
                $result["success"]=false;
                $result["message"]="该商品库存不足";
                return json_encode($result);
            }
          
      }
  	
      public function actionConfirmAddOrder()//确认添加订单
      {
         
          if($data=Yii::$app->request->get()){
              $this->dump($data);
              $model = new Order();
              
              $orderok=$model->addOrder($data);

              if($orderok)
              {
                  return $this->redirect(['pay/order-pay', 'order_id' => $model->order_id]);  
              }else{
                   return $this->render('message', [
                        "message"=>"京东商品接口出错,请选择其他商品",
                   ]);
              }
          }
      }

      public function actionAddOrder()//添加订单
      {
         if($data=Yii::$app->request->get()){  //user_id   shop_id   goods_id   skuPath  goodsnum
            //$this->dump($data);
              $config=Config::findOne(1);            
              $user_id=$data["user_id"];
              $shop=Shops::findOne($data["shop_id"]);
              $goods=Goods::findOne($data["goods_id"]);
              $userCoupon=UserCoupon::find()->where(["user_id"=>$user_id,"shop_id"=>$shop->shop_id])->andWhere([">","end_time",time()])->one();
             
             // $this->dump($agent);

              if($data["skuPath"]!="")
              {
                  $attr_path=substr($data["skuPath"],0,strlen($data["skuPath"])-1);
                  $sku=GoodsSku::find()->where(["attr_path"=>$attr_path])->one();  
              }else{
                  $sku="";
              }
              
              //计算订单金额
              if($sku!=""){
                  $totalFee=round(($sku->price*$data['goodsnum']+$goods->freight),2);
              }else{
                  $totalFee=round(($goods->price*$data['goodsnum']+$goods->freight),2);
              }
              //计算可以使用话费抵扣的金额
              
              $telFeeDeductions=0;
              if($sku!=""){
                  $oneDeductions=round($goods->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                  $telFeeDeductions=round($oneDeductions*$data['goodsnum'],0);
              }else{
                  $oneDeductions=round($goods->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                  $telFeeDeductions=round($oneDeductions*$data['goodsnum'],0);
              }

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


              if(!empty($userCoupon))
              {
                    if($totalFee<=$userCoupon->fee)
                      {
                        $userCoupon="";
                      }  
              }
              
              $address=UserAddress::find()->asArray()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->one();

              
              
             
             // $this->dump($myTelFee);
              //$yunfeiFee=0;
              //$totalFee=0;
              /*if($goods->shop_id=="1"&&$goods->is_agent_buy!="1")
              {
                 $totalFee=round($goods->xy_price*$data['goodsnum'],2);
                 if($totalFee<49)
                 {
                    $yunfeiFee=8;
                 }else if($totalFee>=49&&$totalFee<99)
                 {
                    $yunfeiFee=6;
                 }else if($totalFee>=99)
                 {
                    $yunfeiFee=0;
                 }
              }*/
           	              
           	  
              $shopArr["shop_id"]=$shop->shop_id;
              $shopArr["shop_name"]=$shop->name;
              
              $goodsArr["goods_name"]=$goods->goods_name;
              $goodsArr["goods_id"]=$goods->goods_id;
              $goodsArr["goods_thums"]=$goods->goods_thums;
              $goodsArr["price"]="$goods->price";
              
           	 // $this->dump($goods);
             
              $res["success"]=true;
              $res["message"]="成功";
              $res["data"]["shop"]=$shopArr;
              $res["data"]["goods"]=$goodsArr;
              $res["data"]["sku"]=$sku!=""?$sku->sku_name:"";
              //$res["data"]["config"]=$config;
              $res["data"]["address"]=$address;
              $res["data"]["yunfeiFee"]=$goods->freight;
           	  $res["data"]["num"]=$data['goodsnum'];
              $res["data"]["telFeeDeductions"]=$telFeeDeductions;
              $res["data"]["totalFee"]=$totalFee;
              return json_encode($res);
            /*  return $this->render("add-order",[
                    "shop"=>$shop,
                    "goods"=>$goods,
                    "sku"=>$sku,
                    "config"=>$config,
                    "address"=>$address,
                    "userCoupon"=>$userCoupon,
                     "yunfeiFee"=>$yunfeiFee,
                    "num"=>$data['goodsnum'],
                    "telFeeDeductions"=>$telFeeDeductions,
                    
                   
              ]);*/
          }else{
              $res["success"]=false;
              $res["message"]="失败";
              return json_encode($res);
          } 
      }
      
      public function actionFavorite($goods_id,$user_id)//收藏
      {
          $res=[];
          
          $isFavorite=GoodsFavorite::find()->where(["goods_id"=>$goods_id,"user_id"=>$user_id])->count();
          if($isFavorite>0)
          {
              $res["success"]=true;
              $res["message"]="您已经收藏过了";
              return json_encode($res);
          }
          $model=new GoodsFavorite();
          $model->goods_id=$goods_id;
          $model->user_id=$user_id;
          $model->create_time=time();
          if($model->save())
          {
              $res["success"]=true;
              $res["message"]="收藏成功";
              return json_encode($res);
          }else{
              $res["success"]=false;
              $res["message"]="收藏失败";
              return json_encode($res);
          }

      }
     
      public function actionDetail($goods_id,$user_id)
      {
          $model =Goods::findOne($goods_id);
		  $goods_img=json_decode($model->goods_img);                   
          if(empty($model))
          {
              $res["success"]=false;
              $res["message"]="商品已下架,请选择其他商品";
              return json_encode($res);
              
          }
       // $this->dump($model->source);
          if($model->source!="qmmy")
          {
                if(!$model->updateGoods())
                {
                  	$res["success"]=false;
                    $res["message"]="商品已下架,请选择其他商品";
                    return json_encode($res);
                   
                }
          }
          if($model->status!="200")
          { 
              $res["success"]=false;
              $res["message"]="商品已下架,请选择其他商品";
              return json_encode($res);
          }
          
          $shopCoupon=ShopCoupon::findOne(["shop_id"=>$model->shop_id]);
          $config=Config::findOne(1);
         
          $model->browse=$model->browse+1;
          $model->update(true, ['browse']);
          
          $oneDeductions=0;
          
          //if($model->shop_id=="1"||$model->shop_id=="2"){  //&&$model->is_agent_buy!="1"
           $oneDeductions=round($model->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                
          //}
          
          

          
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
          
          $goods["goods_id"]=$model->goods_id;
          $goods["goods_name"]=$model->goods_name;
          $goods["goods_keys"]=$model->goods_keys;
          $goods["price"]=number_format($model->price,2);
          $goods["old_price"]=number_format($model->old_price,2);
          $goods["desc"]=$model->desc;
          $goods["shop_id"]=$model->shop_id;
          $goods["salecount"]="$model->salecount";
        
          
          
          if($goods_img!="")
          {
            	$goods["goods_img"]=$goods_img;
            	$goods["jdis_update_goods_thums"]=1;
          }else{
          		$goods["goods_img"]=array($model->goods_thums);    
            	if($model->shop_id=="1"&&$model->jdis_update_goods_thums=="1")
                {
          			$goods["jdis_update_goods_thums"]=1;        
                }else{
                    $goods["jdis_update_goods_thums"]=0;        
                }
               
          }
          
		  $goods["cate_id1"]=GoodsCate::getCateName($model->cate_id1);
          $goods["cate_id2"]=GoodsCate::getCateName($model->cate_id2);
          $goods["cate_id3"]=GoodsCate::getCateName($model->cate_id3);
          
          // $this->dump($model->goods_img);
          if($model->jdis_update_goods_thums=="1"||$model->shop_id!="1")
          {	            	
            	$shareImg=Yii::$app->params['webLink'].$model->goods_thums;
            
          }else{
           		 $shareImg=$model->goods_thums;
          } 	
         
			
           $res["success"]=true;
           $res["message"]="成功";
           $res["data"]["goods"]=$goods;	
           $res["data"]["goodsStock"]=$goodsStock;	
           $res["data"]["attrData"]=$attrData;	
           $res["data"]["oneDeductions"]=$oneDeductions.".00";	
        
           $user=User::findOne($user_id);
           $res["data"]["searchLink"]=yii::$app->params['webLink']."/goods/detail.html?goods_sn=".$model->goods_sn."&code=".$user->invitation_code;	
           $res["data"]["searchImg"]=$shareImg;	
        
        //$searchLink=yii::$app->params['webLink']."/goods/detail.html?goods_sn=".$model->goods_sn."&code=".Yii::$app->user->identity->invitation_code;
           return json_encode($res);
        
         /* return $this->render('detail', [
              'model' => $model,
              "goodsStock"=>$goodsStock,
              "attrData"=>$attrData,
              "shopCoupon"=>$shopCoupon,
              "oneDeductions"=>$oneDeductions,
              
          ]);*/
        
      }

      public function actionGoodsSku($skuPath)
      { 
          $attr_path=substr($skuPath,0,strlen($skuPath)-1);
          $sku=GoodsSku::find()->asArray()->where(["attr_path"=>$attr_path])->one();
          
         // $this->dump($sku);
          return json_encode($sku);
      }

      public function actionGoodsComment($goods_id)
      {
         
          $this->layout="nofooter";
          $model=GoodsComment::find();
          $goodsComment=$model->with(["user",'userAuth'])->where(["goods_id"=>$goods_id])->orderBy("create_time desc")->limit(10)->all();

         
          $countComment=$model->where(["goods_id"=>$goods_id])->count();
          $goodComment=$model->where(["goods_id"=>$goods_id,"type"=>"1"])->count();


          $goodCommentRate=0;
          if($countComment>0&&$goodsComment>0)
          {
              $goodCommentRate=round($goodComment/$countComment*100);  
          }
          //$this->dump($countComment);
          return $this->render('goods-comment', [
              'model' => $model,
              "goods_id"=>$goods_id,
              'goodsComment' => $goodsComment,
              "countComment"=>$countComment,
              "goodCommentRate"=>$goodCommentRate,
              
          ]);
        
      }
      public function actionGoodsCommentList($goods_id,$page)
      {
          
          $page=($page-1)*10;
          $goodsComment=GoodsComment::find()->asArray()->with(["user",'userAuth'])->where(["goods_id"=>$goods_id])->orderBy("create_time desc")->offset($page)->limit(10)->all();
          $str=""; 
          
          foreach($goodsComment as $goodsCommentval)
          {
              if($goodsCommentval['userAuth']['identifier']!="")
              {
                  $username=$goodsCommentval['userAuth']['identifier'];
              }else{
                  $username="匿名用户";
              }
              $str.='<li><div class="user"><div class="pic"><img src="'.Yii::$app->params["imgurl"].$goodsCommentval['user']['headimgurl'].'" alt=""/></div><span>'.$username.'</span></div><p class="text">'.$goodsCommentval['content'].'</p><p class="date">'.date("Y-m-d H:i:s",$goodsCommentval['create_time']).'</p></li>';
              
          } 
         //$this->dump($str);
          echo $str;
        
      }
  
    
}

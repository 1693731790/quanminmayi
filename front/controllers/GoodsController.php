<?php
namespace front\controllers;
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
use common\models\UserAuth;
use common\models\Yunzhonghe;
use common\models\Region;
use common\models\Suibianda;


/**
 * Site controller
 */
class GoodsController extends Controller  //CommonController
{
  
  function beforeAction($action)
  {
        $data=Yii::$app->request->get();
        if(isset($data["token"])&&$data["token"]!="")
        {
            $token=$data["token"];
            $user=User::findIdentityByAccessToken($token,10);
            if($user){
                Yii::$app->user->login($user);   
            }
            if($token)
            {
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                            'name' => 'token',
                            'value' => $token,
                            'expire'=>time()+3600*24*7,
                ]));
            }
           /* var_dump(yii::$app->user->isGuest);
            die();*/
            return true;
        }else{
          	
             	return true; 
            
        }
        
    
  }
  	 public function actionShuma()
      {
          
        
          $model=Goods::find();
          
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["cate_id2"=>"17567"])->orderBy("ishome DESC")->limit(50)->all();  
            //$this->dump($goods);
                return $this->render("shuma",[
                    "goods"=>$goods,
                   
                ]);

          
      
      }
  	 public function actionBaihuo()
      {
          
        
          $model=Goods::find();
          
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["cate_id2"=>"17754"])->orderBy("ishome DESC")->limit(50)->all();  
            //$this->dump($goods);
                return $this->render("baihuo",[
                    "goods"=>$goods,
                   
                ]);

          
      
      }
  	 public function actionDianqi()
      {
          
        
          $model=Goods::find();
          
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["cate_id1"=>"17552"])->orderBy("ishome DESC")->limit(50)->all();  
            //$this->dump($goods);
                return $this->render("dianqi",[
                    "goods"=>$goods,
                   
                ]);

          
      
      }
      public $enableCsrfValidation = false;
      
  	  public function actionIndex($goods_cate_id="",$salecount="",$browse="",$new="",$goods_brand="",$isjd="",$isdigital="",$isdiscount="",$istodaynew="",$isselected="",$shop_id="",$shops_cate="",$shops_class="",$shops_limit="",$price1="",$price2="",$price3="",$price3_="")
      {   
          $this->layout="nofooter";
          $model=Goods::find();
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
          if($isjd!="")
          {
           	$shop_id=$isjd; 
          }
          if($price1=="1")
          {
          		$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","0","200"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else if($price2=="1")
          {
            	$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","200","500"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else if($price3=="1")
          {
            	$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","500","1000"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else if($price3_=="1")
          {
            	$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","1000","2000"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else{
           		$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all(); 
          }
        /*
        	 if($price1=="1")
          {
          		$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","0","200"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shop_id"=>$isjd,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else if($price2=="1")
          {
            	$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","200","500"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shop_id"=>$isjd,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else if($price3=="1")
          {
            	$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","500","1000"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shop_id"=>$isjd,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else if($price3_=="1")
          {
            	$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","1000","2000"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$shop_id,"shop_id"=>$isjd,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all();  
          }else{
           		$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->limit(30)->all(); 
          }
        */
          //$this->dump($isjd);
          //$this->dump($model->createCommand()->getRawSql());
          foreach ($goods as $key => $goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              $goods[$key]["favorite"]=$favorite;
          }
          if($isdiscount!="")
          {
            //$this->dump($goods);
                return $this->render("index-isdiscount",[
                    "goods"=>$goods,
                    "isdiscount"=>$isdiscount,
                ]);

          }
          if($isselected!="")
          {
            //$this->dump($goods);
                return $this->render("index-isselected",[
                    "goods"=>$goods,
                    "isselected"=>$isselected,
                ]);

          }
         if($istodaynew!="")
          {
            //$this->dump($goods);
                return $this->render("index-istodaynew",[
                    "goods"=>$goods,
                    "istodaynew"=>$istodaynew,
                ]);

          }
          if($isjd!="")
          {
            //$this->dump($goods);
                return $this->render("index-jd",[
                    "goods"=>$goods,
                    "isjd"=>$isjd,
                ]);

          }
          if($isdigital!="")
          {
            //$this->dump($goods);
                return $this->render("index-digital",[
                    "goods"=>$goods,
                    "isdigital"=>$isdigital,
                ]);

          }
          if($isdiscount!="")
          {
            //$this->dump($goods);
                return $this->render("index-discount",[
                    "goods"=>$goods,
                    "isdiscount"=>$isdiscount,
                ]);

          }
          
          return $this->render("index",[
              "goods"=>$goods,
              "goods_cate_id"=>$goods_cate_id,
              "salecount"=>$salecount,
              "browse"=>$browse,
              "new"=>$new,
              "goods_brand"=>$goods_brand,
            "shop_id"=>$shop_id,
            "shops_cate"=>$shops_cate,
            "shops_class"=>$shops_class,
            "shops_limit"=>$shops_limit,
            "price2"=>$price2,
            "price4"=>$price4,
              

          ]);
      }
	
  	  public function actionDetailContent($goods_id)//安卓调用商品H5详情页面
      {  
          $this->layout="nofooter";
          $model=Goods::findOne($goods_id);
      
          return $this->render("detail-content",[
                "model"=>$model,
               
          ]);
      }
  
      function actionGoodsList($page="",$goods_cate_id="",$salecount="",$browse="",$new="",$goods_brand="",$isjd="",$isdigital="",$isdiscount="",$istodaynew="",$isselected="",$shop_id="",$shops_cate="",$shops_limit="",$price1="",$price2="",$price3="",$price3_="",$shops_class="")
      {
          $page=($page-1)*30;
          $model=Goods::find();
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
          if($price1=="1")
          {
          		$goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","0","200"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->offset($page)->limit(30)->all();
          }else if($price2=="1")
          {
          		 $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","200","500"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->offset($page)->limit(30)->all();
          }else if($price3=="1")
          {
          		 $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","500","1000"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->offset($page)->limit(30)->all();
          }else if($price3_=="1")
          {
          		 $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andWhere(["between","price","1000","2000"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->offset($page)->limit(30)->all();
          }else{
         		 $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->andFilterWhere(["goods_brand"=>$goods_brand,"cate_id3"=>$goods_cate_id,"shop_id"=>$isjd,"shop_id"=>$shop_id,"shops_cate"=>$shops_cate,"shops_class2"=>$shops_class,"shops_limit"=>$shops_limit,"isdigital"=>$isdigital,"isdiscount"=>$isdiscount,'istodaynew'=>$istodaynew,'isselected'=>$isselected])->orderBy($orderby)->offset($page)->limit(30)->all(); 
          }
        
         
          
          $str=""; 
         
          foreach($goods as $key=>$goodsval)
          {
              $favorite=GoodsFavorite::find()->where(['goods_id'=>$goodsval['goods_id']])->count();
              if($isjd!="")
              {
                    $str.='<li><a href="'.Url::to(["goods/detail","goods_id"=>$goodsval["goods_id"]]).'"><div class="pilone"><div class="piloneone"><img class="pui" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"/></div><div class="pilonetwo">￥'.$goodsval['price'].'</div><div class="pilonethree">立即购买</div></div></a></li>';
              }else if($isdigital!=""){
                    if($key%2==0)
                    {
                        $str.='<div class="headertwo"><div class="headertwoone"><img class="shop-so" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"/></div><div class="headertwotwo"><div class="headerwenzi">'.$goodsval['goods_name'].'</div><div class="headerprice">促销价:&nbsp<span class="price">'.$goodsval['old_price'].'</span>元</div><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="headerbuy">立即购买</div></a></div></div>';
                    }else{
                        $str.='<div class="headerthree"><div class="headerthreetwo"><div class="headerwenzi">'.$goodsval['goods_name'].'</div><div class="headerprice">促销价:&nbsp<span class="price">'.$goodsval['price'].'</span>元</div><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="headerbuy">立即购买</div></a></div><div class="headerthreeone"><img class="shop-so" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"/></div></div>';
                    }
                    
              }else if($istodaynew!=""){
                    
                    $str.='<a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="pageone"><div class="leftpic"><img class="leftpict" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"/></div><div class="rightwenzi"><div class="rightwenzione">'.$goodsval['goods_name'].'</div><div class="rightwenzitwo">'.$goodsval['desc'].'</div><div class="rightwenzithree">¥'.$goodsval['old_price'].'<span class="price">¥'.$goodsval['price'].'</span></div><div class="rightwenzifour"><div class="righttitle">'.$goodsval['salecount'].'人已买</div><div class="righttitlethree">立即抢购</div></div></div></div></a>';
                   
                    
              }else if($isselected!=""){
                    
                    $str.='<li><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="spa"><img class="picee" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"><div class="titlewee">'.$goodsval["goods_name"].'<div class="pricee">¥'.$goodsval["price"].'&nbsp<span class="hahae">¥'.$goodsval["old_price"].'</span></div><div class="shopedsi">'.$goodsval["salecount"].'人已买</div></div></div></a></li>';
                   
                    
              }else if($isdiscount!=""){
                    
                    $str.='<div class="pageone"><a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="leftpic"><img class="leftpict" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"/></div><div class="rightwenzi"><div class="rightwenzione">'.$goodsval["goods_name"].'</div><div class="rightwenzitwo">'.$goodsval["desc"].'</div><div class="rightwenzithree">¥'.$goodsval["price"].'<span class="price">¥'.$goodsval["old_price"].'</span></div><div class="rightwenzifour"><div class="righttitle">已购买'.$goodsval["salecount"].'件</div><div class="righttitlethree">立即抢购</div></div></div></a></div>';
                   
                    
              }else{
                    $str.='<a href="'.Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']]).'"><div class="centers"><div class="centerone"><img class="centertwos" src="'.Yii::$app->params['imgurl'].$goodsval['goods_thums'].'"/></div><div class="centertwo"><div class="centertwoone">'.$goodsval['goods_name'].'</div><div class="centertwothree"><div class="centertwothrees">¥'.$goodsval['price'].'&nbsp&nbsp<span class="pi">¥'.$goodsval['old_price'].'</span></div></div><div class="centertwotwo">销量'.$goodsval['salecount'].'&nbsp&nbsp&nbsp 收藏'.$favorite.'</div></div></div></a>';
              }
              
              
          } 
          //$this->dump($str);
          echo $str;
          //return json_encode($orders);
         
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
                   return $this->render('message', [
                        "message"=>"商品接口出错,请选择其他商品",
                   ]);
              }
          }
      }

      public function actionAddOrder()//添加订单
      {
        $this->layout="nofooter";
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

              //话费余额开始
              $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
              $mobile=$userAuth->identifier;               
              $suibianda=new Suibianda($mobile);
              $callRes=$suibianda->getMoney();
              $myTelFee="0";

              if($callRes)
              {
                  $myTelFee=$callRes;
              }
             
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
              if($goods->is_group!="1")
              {
                	$address=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->one();
              }else{
                    $address=UserAddress::find()->where(["aid"=>1])->one();
              }
              
            

             // $this->dump($myTelFee);
              $yunfeiFee=0;
              $totalFee=0;
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
            $addressList=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->all();
			$region=Region::find()->where(["parent_id"=>"0"])->all();
              
              return $this->render("add-order",[
                    "shop"=>$shop,
                    "goods"=>$goods,
                    "sku"=>$sku,
                    "config"=>$config,
                    "address"=>$address,
                    "addressList"=>$addressList,
                    "region"=>$region,
                    "userCoupon"=>$userCoupon,
                     "yunfeiFee"=>$yunfeiFee,
                    "num"=>$data['goodsnum'],
                    "telFeeDeductions"=>$telFeeDeductions,
                    
                   
              ]);
          }else{
              return $this->redirect(['detail', 'goods_id' => $data['goods_id']]);
          } 
      }
      
      public function actionFavorite($goods_id)//收藏
      {
          if(yii::$app->user->isGuest)
          {
              return $this->redirect(['site/login']);
          }
          $res=[];
          $user_id=Yii::$app->user->identity->id;
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
     

      public function actionDetail()
      {
        
          error_reporting(0);
          $getData=Yii::$app->request->get();
          if($getData["goods_id"]==""&&$getData["goods_sn"]=="")
          {
           	 	return $this->render('message', [
                        "message"=>"此商品错误,请选择其他商品",
                    ]);
          }
          if($getData["goods_id"]=="")
          {
            	$goodsOne =Goods::findOne(["goods_sn"=>$getData["goods_sn"]]);
            	$goods_id=$goodsOne->goods_id;
          }else{
            	$goods_id=$getData["goods_id"];
          }
         
          $model=Goods::findOne($goods_id);
        
          $goods_img=json_decode($model->goods_img);
          $this->layout="nofooter";
        
        
           
          if($model->is_agent_buy=="1")
          {
            return $this->redirect(['user-upgrade/detail',"goods_id"=>$model->goods_id])->send();   
            die();
          }
          
          if(empty($model))
          {
               return $this->render('message', [
                        "message"=>"商品已下架,请选择其他商品",
                    ]);
          }
       
          //$this->dump($model->source);
          if($model->source!="qmmy"&&$model->shop_id=="1")
          {
            
                if(!$model->updateGoods())
                {
                    return $this->render('message', [
                        "message"=>"商品已下架,请选择其他商品",
                    ]);
                }
                
          }
       		   
          $shopCoupon=ShopCoupon::findOne(["shop_id"=>$model->shop_id]);
          $config=Config::findOne(1);
          
         
       
          $model->browse=$model->browse+1;
          $model->update(true, ['browse']);
          
          $oneDeductions=0;
          
          //if($model->shop_id=="1"||$model->shop_id=="2"){  //&&$model->is_agent_buy!="1"
                $oneDeductions=round($model->profitFee*($config->goods_telfare_pct/100),0);//单一抵扣金额
                
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
          $comment=GoodsComment::find();
          
          $goodsComment=$comment->with(["user",'userAuth'])->where(["goods_id"=>$goods_id])->limit(2)->all();
          $countComment=$comment->where(["goods_id"=>$goods_id])->count();
          $goodComment=$comment->where(["goods_id"=>$goods_id,"type"=>"1"])->count();

          
          $goodCommentRate=0;
          if($countComment>0&&$goodsComment>0)
          {
              $goodCommentRate=round($goodComment/$countComment*100);  
          }
          
        
         
          $model->goods_img=$goods_img;
           //$this->dump($goods_img);
          if($model->issale!=1)
          { 
              return $this->render('detail-nosale', [
                  'model' => $model,
                  'goodsComment' => $goodsComment,
                  "countComment"=>$countComment,
                  "goodsStock"=>$goodsStock,
                  "goodCommentRate"=>$goodCommentRate,
                  "attrData"=>$attrData,
                  "oneDeductions"=>$oneDeductions,
              ]);
          }
          $user_code="";
          if(yii::$app->user->isGuest)
          {
          		$searchLink=yii::$app->params['webLink']."/goods/detail.html?goods_id=".$getData["goods_id"];  
          }else{
           		$searchLink=yii::$app->params['webLink']."/goods/detail.html?goods_sn=".$model->goods_sn."&code=".Yii::$app->user->identity->invitation_code; 
            	$user_code=Yii::$app->user->identity->invitation_code;
          }
          
          // 获取收款二维码内容
         
         // $this->dump($searchLink); 
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
          $model->price=number_format($model->price,2);
          $model->old_price=number_format($model->old_price,2);
          $oneDeductions=$oneDeductions.".00";
          return $this->render('detail', [
              'model' => $model,
               'shareImg' => $shareImg,
              'goodsComment' => $goodsComment,
              "countComment"=>$countComment,
              "goodsStock"=>$goodsStock,
              "goodCommentRate"=>$goodCommentRate,
              "attrData"=>$attrData,
              "shopCoupon"=>$shopCoupon,
              "oneDeductions"=>$oneDeductions,
              "searchLink"=>$searchLink,
              "resQrcode"=>$resQrcode,
              "code"=>isset($getData["code"])?$getData["code"]:"",
              "isGuest"=>yii::$app->user->isGuest,
              "user_code"=>$user_code,
          
              
          ]);
        
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

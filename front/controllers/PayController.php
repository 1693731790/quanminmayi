<?php
namespace front\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Omnipay\Omnipay;
use yii\web\JSSDK;
use common\models\Shops;
use common\models\RobBuy;
use common\models\Order;
use common\models\OrderGoods;
use common\models\Goods;
use common\models\UserAddress;
use common\models\OrderAllPay;
use common\models\Yunzhonghe;
use common\models\WaitWallet;
use common\models\User;
use common\models\UserAuth;
use common\models\Config;
use common\models\Ronglian;
use common\models\UserCardLog;


/**
 * 支付控制器
 */
class PayController extends Controller
{

    public $enableCsrfValidation = false;
    public function actionYibao()
    {
        $res='succeess'.date("Y-m-d H:i:s").print_r($_REQUEST, true);
        file_put_contents("yibaopay.txt", $res);
    }

    public function actionOrderPayAll($order_all_id)
    {
        
        $orderData=Order::find()->asArray()->where(['order_all_pay_id'=>$order_all_id])->all();
        $countPrice=Order::find()->asArray()->where(['order_all_pay_id'=>$order_all_id])->sum('total_fee');
        $yunfeiPrice=Order::find()->asArray()->where(['order_all_pay_id'=>$order_all_id])->sum('deliver_fee');//运费
        $telfareFee=Order::find()->asArray()->where(['order_all_pay_id'=>$order_all_id])->sum('telfare_fee');//话费抵扣
        $yunzhonghe=new Yunzhonghe();
        $jdStatus=true;
        $jdStatusData=[];
        foreach($orderData as $key=>$vals)
        {
            $orderData[$key]['shop']=Shops::find()->asArray()->where(['shop_id'=>$vals['shop_id']])->one();
            $orderData[$key]['goods']=OrderGoods::find()->asArray()->where(['order_id'=>$vals['order_id']])->all();
			
            $region=explode("-", $vals->address_region_id);
            $area=$region[0]."_".$region[1]."_".$region[2];
            $goods=OrderGoods::find()->where(['order_id'=>$vals->order_id])->all();  
            foreach($goods as $goodsVal)
            {
                $goodsOne=Goods::findOne($goodsVal->goods_id);
                if($goodsOne->jdgoods_id!="")
                {
                      $statusRes=$yunzhonghe->getGoodsStatus($goodsOne->jdgoods_id);//
                      $stockRes=$yunzhonghe->getGoodsStock($goodsOne->jdgoods_id,$goodsVal->num,$area);
                      //$this->dump($statusRes);
                      if($stockRes->RESPONSE_STATUS=="true"&&$stockRes->RESULT_DATA->stock_status==false||$statusRes->RESPONSE_STATUS=="true"&&$statusRes->RESULT_DATA->status==false)
                      {
                          $jdStatus=false;
                          $jdStatusData[]="(".$goodsOne->goods_name.")该商品库存不足或已下架";
                      }
                }
           }
        }
        //$this->dump($jdStatus);
        if($jdStatus)
        {
            return $this->render("order-pay-all",[
                "orderData"=>$orderData,
                "countPrice"=>$countPrice,
                "telfareFee"=>$telfareFee,
                "yunfeiPrice"=>$yunfeiPrice,
                "order_all_id"=>$order_all_id,
                
            ]);
        }else{
            return $this->render("pay-message",[
                "jdStatusData"=>$jdStatusData,
            ]); 
        }
    
        
    }


    public function actionOrderPay($order_id,$rob_id="")
    {
        $order=Order::findOne($order_id);
        $shop=Shops::findOne($order->shop_id);
        $goods=OrderGoods::find()->where(['order_id'=>$order_id])->all();  
        $jdStatus=true;
        $jdStatusData=[];
        
        $region=explode("-", $order->address_region_id);
        $area=$region[0]."_".$region[1]."_".$region[2];
        $yunzhonghe=new Yunzhonghe();
        foreach($goods as $goodsVal)
        {
            $goodsOne=Goods::findOne($goodsVal->goods_id);
            if($goodsOne->jdgoods_id!="")
            {
                  $statusRes=$yunzhonghe->getGoodsStatus($goodsOne->jdgoods_id);//
                  $stockRes=$yunzhonghe->getGoodsStock($goodsOne->jdgoods_id,$goodsVal->num,$area);
                  //$this->dump($statusRes);
                  if($stockRes->RESPONSE_STATUS=="true"&&$stockRes->RESULT_DATA->stock_status==false||$statusRes->RESPONSE_STATUS=="true"&&$statusRes->RESULT_DATA->status==false)
                  {
                      $jdStatus=false;
                      $jdStatusData[]="(".$goodsOne->goods_name.")该商品库存不足或已下架";
                  }
            }
       }
       // $this->dump($jdStatusData);
       
        if($jdStatus)
        {
            return $this->render("order-pay",[
              "order"=>$order,
              "shop"=>$shop,
              "goods"=>$goods,
            ]);
        }else{
            return $this->render("pay-message",[
                "jdStatusData"=>$jdStatusData,
            ]); 
        }
        
    }

    public function actionGoPayAll($order_all_id,$pay_type,$openid="")//合并付款
    {
        
        $orderAll=OrderAllPay::findOne($order_all_id);
        $countPrice=Order::find()->asArray()->where(['order_all_pay_id'=>$order_all_id])->sum('total_fee');
        $countTelfare=Order::find()->asArray()->where(['order_all_pay_id'=>$order_all_id])->sum('telfare_fee');

        //$this->dump($countPrice);
        //1支付宝2微信
        if($pay_type=="1")
        {

            $gateway = Omnipay::create('Alipay_AopWap');
            $gateway->setSignType('RSA2'); //RSA/RSA2
            $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
            $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
            $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
            $gateway->setReturnUrl(Yii::$app->params['webLink'].'/user/order.html');
            $gateway->setNotifyUrl(Yii::$app->params['webLink']."/pay/alipay-all-notify.html");     
                        
            $countPrice=round($countPrice-$countTelfare,2);

            $request = $gateway->purchase();
            $request->setBizContent([
                'subject'      => '商城支付',
                'out_trade_no' => $orderAll->all_pay_sn,
                'total_amount' => $countPrice,
                'product_code' => 'QUICK_MSECURITY_PAY',
            ]);
            $response = $request->send();
            $redirectUrl = $response->getRedirectUrl();
            $response->redirect();
            /*$res['success']=true;
            $res['alipay']['order_string']=$response->getOrderString();
            $this->dump($res);
            //return $res;*/
        }else if($pay_type=='2')//微信h5支付
        {   
            $appid="app_id";
            $mchid="mch_id";
            $apikey="api_key";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-all-notify.html';
            $countPrice=round($countPrice-$countTelfare,2);
            $totalFee=$countPrice*100;
            $gateway    = Omnipay::create('WechatPay_Mweb');
            
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      => $orderAll->all_pay_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',

               // 'open_id'           => $openid,
            ];
           // $this->dump($order);
            $request  = $gateway->purchase($order);
            $response = $request->send();
            //$response->getData(); //For debug
            // $response->getCodeUrl(); //For Native Trade Type
            //$this->dump($response->getAppOrderData());
            $res["success"]=true;
            $res["payurl"]=$response->getData()["mweb_url"]."&redirect_url=".Yii::$app->params['webLink']."/user/order.html";
            return json_encode($res);
            //$response->isSuccessful();
        }else if($pay_type=='3')
        {
            if($_GET["code"]=="")
            {
                 $appid=Yii::$app->params['WECHAT']['app_id'];
                 $redirect_uri=urlencode(Yii::$app->params['webLink']."/pay/go-pay-all.html?order_all_id=".$order_all_id."&pay_type=3");
                 $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
                 header("Location:".$url);
                 die();
            }else{
                $code=$_GET["code"];
                $appid=Yii::$app->params['WECHAT']['app_id'];
                $secret=Yii::$app->params['WECHAT']['secret'];
                $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
                $res=file_get_contents($url);
                $res=json_decode($res); 
            }

            $appid="app_id";
            $mchid="mch_id";
            $apikey="api_key";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-all-notify.html';
            $countPrice=round($countPrice-$countTelfare,2);
            $totalFee=$countPrice*100;
            $gateway    = Omnipay::create('WechatPay_Js');
            
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      => $orderAll->all_pay_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',
 				'open_id' => $res->openid,
            
               // 'open_id'           => $openid,
            ];
           // $this->dump($order);
            $request  = $gateway->purchase($order);
            $response = $request->send();

            //$res["data"]=$response->getJsOrderData();
            /*$this->dump($response->getData()); //For debug
            $this->dump($response->getJsOrderData());*/
            return $this->render("wx-pay-jump",[
              "data"=>$response->getJsOrderData(),
            ]);
            

        }else if($pay_type=='4'){
        	$appid="app_id_app";
            $mchid="mch_id_app";
            $apikey="api_key_app";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-all-notify-app.html';
          
            $countPrice=round($countPrice-$countTelfare,2);
            $totalFee=$countPrice*100;
            $gateway    = Omnipay::create('WechatPay_App');
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      => $orderAll->all_pay_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',

               // 'open_id'           => $openid,
            ];
           // $this->dump($order);
            $request  = $gateway->purchase($order);
            $response = $request->send();
            //$response->getData(); //For debug
            // $response->getCodeUrl(); //For Native Trade Type
            //$this->dump($response->getAppOrderData());
            return json_encode($response->getAppOrderData());
        }else if($pay_type=='5')
        {
           
            $appid="xcx_id";
            $mchid="mch_id";
            $apikey="api_key";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-all-notify-xcx.html';
            $countPrice=round($countPrice-$countTelfare,2);
            $totalFee=$countPrice*100;
            $gateway    = Omnipay::create('WechatPay_Js');
            
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      => $orderAll->all_pay_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',
 				'open_id'           => $openid,
            ];
            //$this->dump($order);
            $request  = $gateway->purchase($order);
            $response = $request->send();
            //For debug
            // $response->getCodeUrl(); //For Native Trade Type
            
            return json_encode($response->getJsOrderData());
            
        }else if($pay_type=='6')//充值卡余额支付
        {   
            $countPrice=round($countPrice-$countTelfare,2);
            $totalFee=$countPrice;
          
          	$user_id=Yii::$app->user->identity->id;
            $user=User::findOne($user_id);
          	 
            if($user->recharge_fee<$totalFee)
            {
          		$res["success"]=false;
                $res["message"]="充值余额不足";
                return json_encode($res);    
            }
          
            $result=$this->payHandle($orderAll->all_pay_sn,"6","123456","all");//订单号，支付方式，流水号
          // $this->dump($result);
          	if($result)  
            {
          		$userCardLog=new UserCardLog();
                $userCardLog->type="2";
              	$userCardLog->user_id=$user_id;
                $userCardLog->fee=$totalFee;
                $userCardLog->order_sn=$orderAll->all_pay_sn;
                $userCardLog->create_time=time();
              	$userCardLog->save();
              //$this->dump($userCardLog->getErrors());
              
              	$user->recharge_fee=round($user->recharge_fee-$totalFee,2);
              	$user->update(true,["recharge_fee"]);
            }
          	
          	$res["success"]=true;
            $res["message"]="支付成功";
            return json_encode($res);    
          
            
          
        }

        
    }
    
    public function actionPayJump()//微信支付后跳转页面
    {
         return $this->render("pay-jump",[
              
            ]);
    }

    public function actionGoPay($order_id,$pay_type,$openid="")//单一支付
    {
         $order=Order::findOne($order_id);
        //1支付宝2微信
        if($pay_type=="1")
        {

            $gateway = Omnipay::create('Alipay_AopWap');
            $gateway->setSignType('RSA2'); //RSA/RSA2
            $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
            $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
            $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
            $gateway->setReturnUrl(Yii::$app->params['webLink'].'/pay/pay-jump.html');
            $gateway->setNotifyUrl(Yii::$app->params['webLink']."/pay/alipay-one-notify.html");    
            $request = $gateway->purchase();
            $total_fee=round($order->total_fee-$order->telfare_fee,2);
            $request->setBizContent([
                'subject'      => '商城支付',
                'out_trade_no' => $order->order_sn,
                'total_amount' => $total_fee,
                'product_code' => 'QUICK_MSECURITY_PAY',
            ]);
            $response = $request->send();
            $redirectUrl = $response->getRedirectUrl();
            $response->redirect();
            /*$res['success']=true;
            $res['alipay']['order_string']=$response->getOrderString();
            $this->dump($res);
            //return $res;*/
        }else if($pay_type=='2')//微信h5支付
        {
            
            $appid="app_id";
            $mchid="mch_id";
            $apikey="api_key";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-one-notify.html';
            
            $total_fee=round($order->total_fee-$order->telfare_fee,2);
            $totalFee=$total_fee*100;
            $gateway    = Omnipay::create('WechatPay_Mweb');
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      => $order->order_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',
                // 'open_id'           => $openid,
            ];
            
            $request  = $gateway->purchase($order);
            $response = $request->send();
            
            // $this->dump($response->getData()); //For debug
             //$this->dump($response->getCodeUrl()); //For Native Trade Type
            //$this->dump($response->getAppOrderData());
             $res["success"]=true;
             $res["payurl"]=$response->getData()["mweb_url"]."&redirect_url=".Yii::$app->params['webLink']."/pay/pay-jump.html";
             return json_encode($res);
            
            //$response->isSuccessful();
        }else if($pay_type=='3')//微信公众号支付
        {
            if($_GET["code"]=="")
            {
                 $appid=Yii::$app->params['WECHAT']['app_id'];
                 $redirect_uri=urlencode(Yii::$app->params['webLink']."/pay/go-pay.html?order_id=".$order_id."&pay_type=3");
                 $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
                 header("Location:".$url);
                 die();
            }else{
                $code=$_GET["code"];
                $appid=Yii::$app->params['WECHAT']['app_id'];
                $secret=Yii::$app->params['WECHAT']['secret'];
                $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
                $res=file_get_contents($url);
                $res=json_decode($res); 
            }
            
            $appid="app_id";
            $mchid="mch_id";
            $apikey="api_key";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-one-notify.html';
           // $this->dump($res);
            $total_fee=round($order->total_fee-$order->telfare_fee,2);
            $totalFee=$total_fee*100;
            $gateway    = Omnipay::create('WechatPay_Js');
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            /*$config="";
            $class=new JSSDK(Yii::$app->params['WECHAT']['app_id'],Yii::$app->params['WECHAT']['secret']);
            $config=$class->getSignPackage();*/

            $order = [
                'body'              => "商城支付",
                'out_trade_no'      => $order->order_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',
                'open_id'           => $res->openid,
            ];
            

            $request  = $gateway->purchase($order);
            $response = $request->send();
            //$res["data"]=$response->getJsOrderData();
            /*$this->dump($response->getData()); //For debug
            $this->dump($response->getJsOrderData());*/
            return $this->render("wx-pay-jump",[
              "data"=>$response->getJsOrderData(),
            ]);
            // $this->dump($response->getData()); //For debug
             //$this->dump($response->getCodeUrl()); //For Native Trade Type
            //$this->dump($response->getAppOrderData());
           /* $res["success"]=true;
            $res["data"]=$response->getJsOrderData();
            return json_encode($res);*/
            
            //$response->isSuccessful();
        }else if($pay_type=='4')
        {
         	$appid="app_id_app";
            $mchid="mch_id_app";
            $apikey="api_key_app";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-one-notify-app.html';
          
            $gateway    = Omnipay::create('WechatPay_App');
            $total_fee=round($order->total_fee-$order->telfare_fee,2);
            $totalFee=$total_fee*100;
      
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      =>  $order->order_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',

               // 'open_id'           => $openid,
            ];
           // $this->dump($order);
            $request  = $gateway->purchase($order);
            $response = $request->send();
            //$response->getData(); //For debug
            // $response->getCodeUrl(); //For Native Trade Type
            //$this->dump($response->getAppOrderData());
            return json_encode($response->getAppOrderData()); 
        }else if($pay_type=='5')//微信小程序支付
        {   
            $appid="xcx_id";
            $mchid="mch_id";
            $apikey="api_key";
            $notifyUrl=Yii::$app->params['webLink'].'/pay/wxpay-one-notify-xcx.html';
            $total_fee=round($order->total_fee-$order->telfare_fee,2);
            $totalFee=$total_fee*100;
            $gateway    = Omnipay::create('WechatPay_Js');
            
            $gateway->setAppId(Yii::$app->params['WECHAT'][$appid]);
            $gateway->setMchId(Yii::$app->params['WECHAT'][$mchid]);
            $gateway->setApiKey(Yii::$app->params['WECHAT'][$apikey]);
            $gateway->setNotifyUrl($notifyUrl);
            
            $order = [
                'body'              => "商城支付",
                'out_trade_no'      =>  $order->order_sn,
                'total_fee'         => $totalFee,
                'spbill_create_ip'  => Yii::$app->request->userIp,
                'fee_type'          => 'CNY',
				'open_id'           => $openid,
            ];
            //$this->dump($order);
            $request  = $gateway->purchase($order);
            $response = $request->send();
            //For debug
            // $response->getCodeUrl(); //For Native Trade Type
            
            return json_encode($response->getJsOrderData());
            /*$res["success"]=true;
            $res["payurl"]=$response->getData()["mweb_url"]."&redirect_url=".Yii::$app->params['webLink']."/user/order.html";
            return json_encode($res);*/
            //$response->isSuccessful();
        }else if($pay_type=='6')//充值卡余额支付
        {   
          	$user_id=Yii::$app->user->identity->id;
            $user=User::findOne($user_id);
          	$order=Order::findOne($order_id);
            if($order->status>0)
            {
          		$res["success"]=false;
                $res["message"]="订单正在处理,请耐心等待";
                return json_encode($res);    
            }
          	if($user->recharge_fee<$order->total_fee)
            {
          		$res["success"]=false;
                $res["message"]="充值余额不足";
                return json_encode($res);    
            }
            $result=$this->payHandle($order->order_sn,"6","123456","one");//订单号，支付方式，流水号
          	if($result)  
            {
          		$userCardLog=new UserCardLog();
                $userCardLog->type="2";
              	$userCardLog->user_id=$user_id;
                $userCardLog->fee=$order->total_fee;
                $userCardLog->order_sn=$order->order_sn;
                $userCardLog->create_time=time();
              	$userCardLog->save();
              	//$this->dump($userCardLog->getErrors());
              
              	$user->recharge_fee=round($user->recharge_fee-$order->total_fee,2);
              	$user->update(true,["recharge_fee"]);
            }
          	
          	$res["success"]=true;
            $res["message"]="支付成功";
            return json_encode($res);    
          
            
          
        }
    }
    // 微信异步通知商城购买商品单一支付 小程序/
    public function actionWxpayOneNotifyXcx()
    {
    	$gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']["xcx_id"]);
        $gateway->setMchId(Yii::$app->params['WECHAT']["mch_id"]);
        $gateway->setApiKey(Yii::$app->params['WECHAT']["api_key"]);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();
         
            
        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
           
            $order_sn=$data['out_trade_no'];
            $pay_type=5;
            $pay_num=$data['transaction_id'];
           
            $res=$this->payHandle($order_sn,$pay_type,$pay_num,"one");//订单号，支付方式，流水号
           
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
   
    }
      // 微信异步通知商城购买商品合并支付 小程序/
    public function actionWxpayAllNotifyXcx()
    {
       // Yii::info('支付宝异步通知','pay');
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']["xcx_id"]);
        $gateway->setMchId(Yii::$app->params['WECHAT']["mch_id"]);
        $gateway->setApiKey(Yii::$app->params['WECHAT']["api_key"]);
        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();
        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            
            $order_sn=$data['out_trade_no'];
            $pay_type=5;
            $pay_num=$data['transaction_id'];
           
           
            $res=$this->payHandle($order_sn,$pay_type,$pay_num,"all");//订单号，支付方式，流水号
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }
      
    // 微信异步通知商城购买商品单一支付 app/
    public function actionWxpayOneNotifyApp()
    {
    	$gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']["app_id_app"]);
        $gateway->setMchId(Yii::$app->params['WECHAT']["mch_id_app"]);
        $gateway->setApiKey(Yii::$app->params['WECHAT']["api_key_app"]);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();
         
            
        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
           
            $order_sn=$data['out_trade_no'];
            $pay_type=4;
            $pay_num=$data['transaction_id'];
           
            $res=$this->payHandle($order_sn,$pay_type,$pay_num,"one");//订单号，支付方式，流水号
           
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
   
    }

      // 微信异步通知商城购买商品合并支付 app/
    public function actionWxpayAllNotifyApp()
    {

       // Yii::info('支付宝异步通知','pay');
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']["app_id_app"]);
        $gateway->setMchId(Yii::$app->params['WECHAT']["mch_id_app"]);
        $gateway->setApiKey(Yii::$app->params['WECHAT']["api_key_app"]);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();
        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            
            $order_sn=$data['out_trade_no'];
            $pay_type=4;
            $pay_num=$data['transaction_id'];
           
           
            $res=$this->payHandle($order_sn,$pay_type,$pay_num,"all");//订单号，支付方式，流水号
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }


    // 微信异步通知商城购买商品单一支付/
    public function actionWxpayOneNotify()
    {
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']["app_id"]);
        $gateway->setMchId(Yii::$app->params['WECHAT']["mch_id"]);
        $gateway->setApiKey(Yii::$app->params['WECHAT']["api_key"]);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();
         
            
        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
           
            $order_sn=$data['out_trade_no'];
            $pay_type=2;
            $pay_num=$data['transaction_id'];
           
            $res=$this->payHandle($order_sn,$pay_type,$pay_num,"one");//订单号，支付方式，流水号
           
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
   
    }
     // 微信异步通知商城购买商品合并支付/
    public function actionWxpayAllNotify()
    {

       // Yii::info('支付宝异步通知','pay');
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']["app_id"]);
        $gateway->setMchId(Yii::$app->params['WECHAT']["mch_id"]);
        $gateway->setApiKey(Yii::$app->params['WECHAT']["api_key"]);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();
        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            
            $order_sn=$data['out_trade_no'];
            $pay_type=2;
            $pay_num=$data['transaction_id'];
          
            $res=$this->payHandle($order_sn,$pay_type,$pay_num,"all");//订单号，支付方式，流水号
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }
    

    // 支付宝异步通知商城购买商品单一支付
    public function actionAlipayOneNotify()
    {
       // Yii::info('支付宝异步通知','pay');
        $gateway = Omnipay::create('Alipay_AopApp');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
        $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
        $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
       
        $request = $gateway->completePurchase();
        $request->setParams($_POST);//Optional
         //$datas=$order_sn."--".$pay_type."--".$pay_num;
             $wxpayapps='succeess'.date("Y-m-d H:i:s").print_r($_POST, true);
             file_put_contents("alipay1.txt", $wxpayapps);
        try {
            $response = $request->send();
            if($response->isPaid()){
                // 订单支付成功
               // Yii::info(print_r(@$_POST,true),'pay');
                $order_sn=$_POST['out_trade_no'];
                $pay_type=1;
                $pay_num=$_POST['trade_no'];
                $res=$this->payHandle($order_sn,$pay_type,$pay_num,"one");//订单号，支付方式，流水号
                if($res){
                    return "success";
                }

            }else{
                /**
                 * Payment is not successful
                 */
                die('fail');
            }
        } catch (Exception $e) {
            /**
             * Payment is not successful
             */
            die('fail');
        }

    }

     // 支付宝异步通知商城购买商品合并支付
    public function actionAlipayAllNotify()
    {
       // Yii::info('支付宝异步通知','pay');
        $gateway = Omnipay::create('Alipay_AopApp');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
        $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
        $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
       

        $request = $gateway->completePurchase();
        $request->setParams($_POST);//Optional
        try {
            $response = $request->send();
            if($response->isPaid()){
                // 订单支付成功
                Yii::info(print_r(@$_POST,true),'pay');
                $order_sn=$_POST['out_trade_no'];
                $pay_type=1;
                $pay_num=$_POST['trade_no'];
                $res=$this->payHandle($order_sn,$pay_type,$pay_num,"all");//订单号，支付方式，流水号
                if($res){
                    return "success";
                }

            }else{
                /**
                 * Payment is not successful
                 */
                die('fail');
            }
        } catch (Exception $e) {
            /**
             * Payment is not successful
             */
            die('fail');
        }

    }

    function actionTest() 
    {
        //$res=$this->payHandle("1570246331560220353","1","123456789123","one");//订单号，支付方式，流水号
          /*$yunzhonghe=new Yunzhonghe();
          $res=$yunzhonghe->getGoodsStatus("1466571");     */
    }
     public function sendCodes($mobile,$title,$order_sn){ //发送短信
            
            $ronglian=new Ronglian();
            
            $code=$ronglian->sendTemplateSMS($mobile,array($title,$order_sn),"458576");
            
            if($code->statusCode=="000000"){
                 return true;
            }else{
                return false;
                
            }
    }
    function payHandle($order_sn,$pay_type,$pay_num,$isone)
    {
        $config=Config::findOne(1);
        if($isone=="one")//单条支付
        {
            $transaction=Yii::$app->db->beginTransaction();
            try {
                $order=Order::findOne(["order_sn"=>$order_sn]);
                $order->status="1";
                if($order->shop_id=="1"&&$order->is_upagent_buy!="1")
                {   
                   
                    /*$yunzhonghe=new Yunzhonghe();
                   
                    $res=$yunzhonghe->getSubmit($order_sn);  //提交订单
                    //  $this->dump($res);
                    if($res->RESPONSE_STATUS=="true")
                    {
                        $resSub=$yunzhonghe->getThirdOrder($order_sn); //确认提交订单
                        $order->status="2";
                        $order->order_yzh_sn=$res->RESULT_DATA->order_key;   
                    }else{
                        $order->yzh_order_fail_code=$res->ERROR_MESSAGE; 
                     }*/
                        
                }
                $order->pay_type=$pay_type;
                $order->pay_num=$pay_num;
                $order->pay_time=time();
             
                if(!$order->update(true,["pay_type","pay_num","status","pay_time","order_yzh_sn","yzh_order_fail_code"]))
                {
                    throw new \yii\db\Exception("保存失败");
                }

                //以下是支付完成增加上级用户待收入金额和钱包
                $user=User::findOne($order->user_id);
                if($user->user_parent_id!=""&&$order->is_upagent_buy!="1"&&$order->is_seckill!="1")
                {
                    $orderGoods=OrderGoods::findOne(["order_id"=>$order->order_id]);
                    //上级用户获得利润金额减去话费可抵扣金额的百分比奖励
                    $goods=Goods::findOne($orderGoods->goods_id);
					if($goods->is_group!="1")  //团购商品部支持分润
					{

	                    $telfareFee=round($goods->profitFee*$config->goods_telfare_pct/100,2);
	                    
	                    $plusFee=($goods->profitFee-$telfareFee)*$goods->parent_profit/100;
	                  
	                    if($plusFee>0){
	                  			//throw new \yii\db\Exception($plusFee);    
	                          $parentUser=User::findOne($user->user_parent_id);
	                          $waitWallet=new WaitWallet();
	                          if(!$waitWallet->addWallet($user->user_parent_id,3,$plusFee,$parentUser->wait_wallet,$order->order_id." ",$order->order_sn))
	                          {
	                              throw new \yii\db\Exception("保存失败");
	                          }
	                          if($plusFee>0)
	                          {
	                              $parentUser->wait_wallet+=$plusFee;
	                              if(!$parentUser->update(true,["wait_wallet"]))
	                              {
	                                  throw new \yii\db\Exception("保存失败");
	                              }    
	                          }
	                    }
	                }else{
	            		$UserAuthOne=UserAuth::find()->where(["user_id"=>$order->user_id,"identity_type"=>"phone"])->one();   
	            		//identifier
	            		if(!empty($UserAuthOne))
	            		{
	            			//$this->sendCodes($UserAuthOne->identifier,$goods->goods_name,$order->order_sn);
	            		}

	                }
                }
                

                $transaction->commit();
                return true;
            }catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
                return false;
                
            }   
        }else//合并支付
        { 
            $orderAll=OrderAllPay::findOne(["all_pay_sn"=>$order_sn]);
            $orderData=Order::find()->where(["order_all_pay_id"=>$orderAll->id])->select(["order_sn"])->all();
            $transaction=Yii::$app->db->beginTransaction();
            try {
                foreach ($orderData as $orderDataVal)
                {
                    $order=Order::findOne(["order_sn"=>$orderDataVal->order_sn]);
                    $order->pay_type=$pay_type;
                    
                    $order->status="1";
                    if($order->shop_id=="1"&&$order->is_upagent_buy!="1")
                    {
                     /*   $yunzhonghe=new Yunzhonghe();
                        $res=$yunzhonghe->getSubmit($order->order_sn);  
                       // $this->dump($res);
                        if($res->RESPONSE_STATUS=="true")
                        {
                            $resSub=$yunzhonghe->getThirdOrder($order->order_sn); 
                           
                            /*if($resSub->RESPONSE_STATUS!="true")
                            {
                                return false;
                            }*/
                        /*   $order->status="2";
                            $order->order_yzh_sn=$res->RESULT_DATA->order_key;   
                        }else{
                            $order->yzh_order_fail_code=$res->ERROR_MESSAGE; 
                         }*/
                    }

                    $order->pay_num=$pay_num;
                    $order->pay_time=time();
                   
                    if(!$order->update(true,["pay_type","pay_num","status","pay_time","order_yzh_sn","yzh_order_fail_code"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    } 

                    //以下是支付完成增加上级用户待收入金额和钱包
                    $user=User::findOne($order->user_id);
                    
                    if($user->user_parent_id!=""&&$order->is_upagent_buy!="1"&&$order->is_seckill!="1")
                    {
                     
                        $orderGoods=OrderGoods::find()->where(["order_id"=>$order->order_id])->all();
                        foreach ($orderGoods as $orderGoodsVal)
                        {
                            //上级用户获得利润金额减去话费可抵扣金额的百分比奖励
                            $goods=Goods::findOne($orderGoodsVal->goods_id);
                            $telfareFee=round($goods->profitFee*$config->goods_telfare_pct/100,2);
                            $plusFee=($goods->profitFee-$telfareFee)*$goods->parent_profit/100;
                            //throw new \yii\db\Exception($plusFee); 
                            if($plusFee>0){
                                  $parentUser=User::findOne($user->user_parent_id);
                                  $waitWallet=new WaitWallet();
                                  if(!$waitWallet->addWallet($user->user_parent_id,3,$plusFee,$parentUser->wait_wallet,$order->order_id." ",$order->order_sn))
                                  {
                                      throw new \yii\db\Exception("保存失败");
                                  }
                                  if($plusFee>0)
                                  {
                                      $parentUser->wait_wallet+=$plusFee;
                                      if(!$parentUser->update(true,["wait_wallet"]))
                                      {
                                          throw new \yii\db\Exception("保存失败");
                                      }    
                                  }
                            }
                        }
                        
                    }

                }
                
                $transaction->commit();
                return true;
            }catch (\Exception $e) {
                $transaction->rollBack();
                //throw $e;
                return false;
                
            }
        }
    }

}

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
use common\models\GoodsSeckill;
use common\models\OrderSeckill;



/**
 * 支付控制器
 */
class PaySeckillController extends Controller
{

    public $enableCsrfValidation = false;
    

    public function actionOrderPay($order_id)
    {
        $order=OrderSeckill::findOne($order_id);
        $goods=GoodsSeckill::findOne($order->goods_id);   
        return $this->render("order-pay",[
            "order"=>$order,
            "goods"=>$goods,
        
        ]);
    }

    
    public function actionGoPay($order_id,$pay_type)//单一支付
    {
         $order=OrderSeckill::findOne($order_id);
        //1支付宝2微信
        if($pay_type=="1")
        {

            $gateway = Omnipay::create('Alipay_AopWap');
            $gateway->setSignType('RSA2'); //RSA/RSA2
            $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
            $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
            $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
            $gateway->setReturnUrl(Yii::$app->params['webLink'].'/user/order.html');
            $gateway->setNotifyUrl(Yii::$app->params['webLink']."/pay-seckill/alipay-notify.html");    
            $request = $gateway->purchase();
            $total_fee=round($order->total_fee,2);
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
            $notifyUrl=Yii::$app->params['webLink'].'/pay-seckill/wxpay-notify.html';
            
            $total_fee=round($order->total_fee,2);
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
            $res["success"]=true;
            $res["payurl"]=$response->getData()["mweb_url"]."&redirect_url=".Yii::$app->params['webLink']."/user/order.html";
            return json_encode($res);
            
            //$response->isSuccessful();
        }else if($pay_type=='3')//微信公众号支付
        {
            if($_GET["code"]=="")
            {
                 $appid=Yii::$app->params['WECHAT']['app_id'];
                 $redirect_uri=urlencode(Yii::$app->params['webLink']."/pay-seckill/go-pay.html?order_id=".$order_id."&pay_type=3");
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
            $notifyUrl=Yii::$app->params['webLink'].'/pay-seckill/wxpay-notify.html';
           // $this->dump($res);
            $total_fee=round($order->total_fee,2);
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
            return $this->render("pay-jump",[
              "data"=>$response->getJsOrderData(),
            ]);
            // $this->dump($response->getData()); //For debug
             //$this->dump($response->getCodeUrl()); //For Native Trade Type
            //$this->dump($response->getAppOrderData());
           /* $res["success"]=true;
            $res["data"]=$response->getJsOrderData();
            return json_encode($res);*/
            
            //$response->isSuccessful();
        }
    }
    
    // 微信异步通知商城购买商品单一支付/
    public function actionWxpayNotify()
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
            $wxpayapps='succeess'.date("Y-m-d H:i:s").print_r($data, true);
            file_put_contents("wxpay.txt", $wxpayapps);
            $res=$this->payHandle($order_sn,$pay_type,$pay_num);//订单号，支付方式，流水号
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
   
    }
    

    // 支付宝异步通知商城购买商品单一支付
    public function actionAlipayNotify()
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
                $res=$this->payHandle($order_sn,$pay_type,$pay_num);//订单号，支付方式，流水号
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
        $res=$this->payHandle("4634824851557898884","1","123456789123");//订单号，支付方式，流水号
    }
    function payHandle($order_sn,$pay_type,$pay_num)
    {
        
            $order=OrderSeckill::findOne(["order_sn"=>$order_sn]);
            $order->status="1";
            $order->pay_type=$pay_type;
            $order->pay_num=$pay_num;
            $order->pay_time=time();
            if($order->update(true,["pay_type","pay_num","status","pay_time"]))
            {
                return true;
            }else{
                
                return false;
            }
       
    }

}

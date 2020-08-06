<?php
namespace common\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Omnipay\Omnipay;
use common\models\User;
use common\models\Order;
use common\models\OrderLogistics;
use common\models\Wallet;
use common\models\ReservationOrder;

/**
 * 公共支付控制器
 */
class PayController extends Controller
{

    public $enableCsrfValidation = false;

 // 支付宝异步通知（司机确认订单支付）
    // 支付宝异步通知（二维码）
    public function actionAlipayNotifyQrcodes()
    {
         Yii::info('支付宝二维码支付','pay');
        $gateway = Omnipay::create('Alipay_AopApp');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
        $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
        $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
        //$gateway->setNotifyUrl('https://m.chelunzhan.top/pay/alipay-notify');

        $request = $gateway->completePurchase();
        $request->setParams($_POST);//Optional
        try {
            $response = $request->send();
            if($response->isPaid()){
                // 订单支付成功
                Yii::info(print_r(@$_POST,true),'pay');
                $order_sn=$_POST['out_trade_no'];
                $pay_method=23;
                $pay_code=$_POST['trade_no'];
               
                $res=$this->payHandle($order_sn,$pay_method,$pay_code);
                if($res){
                     $this->driversure($order_sn);
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



    // 支付宝异步通知
    public function actionAlipayNotify()
    {
        Yii::info('支付宝app支付','pay');
        $gateway = Omnipay::create('Alipay_AopApp');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
        $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
        $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
        //$gateway->setNotifyUrl('https://m.chelunzhan.top/pay/alipay-notify');

        $request = $gateway->completePurchase();
      $ress='succeess'.date("Y-m-d H:i:s").print_r($request, true);
file_put_contents("paycgasa.txt", $ress);

        $request->setParams($_POST);//Optional
        try {
            $response = $request->send();
            if($response->isPaid()){
                // 订单支付成功
                Yii::info(print_r(@$_POST,true),'pay');

                $order_sn=$_POST['out_trade_no'];
                $pay_method=20;
                $pay_code=$_POST['trade_no'];
                $res=$this->payHandle($order_sn,$pay_method,$pay_code);
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

    // 支付宝异步通知（二维码）
    public function actionAlipayNotifyQrcode()
    {
         Yii::info('支付宝二维码支付','pay');
        $gateway = Omnipay::create('Alipay_AopApp');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
        $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
        $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
        //$gateway->setNotifyUrl('https://m.chelunzhan.top/pay/alipay-notify');

        $request = $gateway->completePurchase();
        $request->setParams($_POST);//Optional
        try {
            $response = $request->send();
            if($response->isPaid()){
                // 订单支付成功
                Yii::info(print_r(@$_POST,true),'pay');
                $order_sn=$_POST['out_trade_no'];
                $pay_method=23;
                $pay_code=$_POST['trade_no'];
                $res=$this->payHandle($order_sn,$pay_method,$pay_code);
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

    //订单支付成功后处理（被异步通知调用）
    protected function payHandle($order_sn,$pay_method,$pay_code=null){
        $order=Order::find()->where(['order_sn'=>$order_sn])->one();

        if($order->order_status==0){
            if($order->payOk($pay_method,$pay_code)){
                Yii::info('订单付款处理成功','pay');
                Yii::info(print_r(@$_POST,true),'pay');
                return true;
            }
        }
        if($order->order_status==7){
            $logistics=OrderLogistics::findOne(['order_id'=>$order->order_id]);
                    //$order->order_status=7;//待处理
                    $order->pay_status=1;//已支付
                    $order->onlinepay_code=$pay_code;
                    $order->pay_time=time();
                    $order->pay_method=$pay_method;
                    $order->save();
                       
            
            if($logistics->finish_pay_status==0){
                if($logistics->payOk($pay_method,$pay_code)){
                    Yii::info('订单finish付款处理成功','pay');
                    Yii::info(print_r(@$_POST,true),'pay');
                    return true;
                }else{
                    Yii::info('订单finish付款处理失败','pay');
                }
                Yii::info('订单finish状态异常','pay');

            }
        }

        Yii::info('订单付款处理失败','pay');
        return false;

    }

     // 司机确认送达
    public function driversure($order_sn){
           
        $order=Order::find()->joinWith('logistics')->where(['order_status'=>7,'{{%orders}}.order_sn'=>$order_sn])->one();
      
        $order->driverSure($order->logistics->receipt_photo);
      
       
    }

 // 司机支付微信支付异步通知（物流）
    public function actionWeixinNotifyOrders(){
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
        $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
        $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            
            $order_sn=$data['out_trade_no'];
            $pay_method=10;
           
            
           // $pay_code=$_POST['trade_no'];
            $res=$this->payHandle($order_sn,$pay_method);
            if($res){
                $this->driversure($order_sn);
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }
    // 微信支付（货到付款货主端支付）
    public function actionWeixinNotifyOrderHzs(){
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']['app_id_app_hz']);
        $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id_app_hz']);
        $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key_app_hz']);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            /*$ress='succeess'.date("Y-m-d H:i:s").print_r($data, true);
            file_put_contents("./paycgasa.txt", $ress);*/
            $order_sn=$data['out_trade_no'];
            $pay_method=10;
            //$pay_code=$_POST['trade_no'];
            //$this->driversure($order_sn);
            $res=$this->payHandle($order_sn,$pay_method);
            if($res){
                 $this->driversure($order_sn);
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }
    // 微信支付（货主端直接支付）
    public function actionWeixinNotifyOrderHz(){
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']['app_id_app_hz']);
        $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id_app_hz']);
        $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key_app_hz']);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            /*$ress='succeess'.date("Y-m-d H:i:s").print_r($data, true);
file_put_contents("./paycgasa.txt", $ress);*/
            $order_sn=$data['out_trade_no'];
            $pay_method=10;
            //$pay_code=$_POST['trade_no'];
            //
            $res=$this->payHandle($order_sn,$pay_method);
            if($res){
               
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }


    /*

// 微信支付异步通知（物流）
    public function actionWeixinNotifyOrder(){
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
        $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
        $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            
            $order_sn=$data['out_trade_no'];
            $pay_method=10;
           // $pay_code=$_POST['trade_no'];
            //$this->driversure($order_sn);
            $res=$this->payHandle($order_sn,$pay_method);
            if($res){
              //  $this->sendNoticeSuccess();//微信消息通知
                return "success";
            }
           
        }else{
            Yii::info('支付失败','pay');
        }
        
    }

    */

    // 微信支付异步通知（购物与充值）
    public function actionWeixinNotify(){
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
        $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
        $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

        if ($response->isPaid()) {
            //支付成功
            $data=$response->getRequestData();
            $order=Order::find()->where('order_sn=:order_sn',[':order_sn'=>$data['out_trade_no']])->one();
            if($order->payOk(10,$data['transaction_id'])){
                $this->sendNoticeSuccess();//微信消息通知
                return 'SUCCESS';
            }
        }else{
            Yii::info('支付失败','pay');
        }
        
    }


    //取消支付
    public function actionPaycancel($id){
        $this->layout='mui';
        $order=Order::findOne($id);
        return $this->render('paycancel',['order'=>$order]);
    }
    //支付失败
    public function actionPayfail($id){
        $this->layout='mui';
        $order=Order::findOne($id);
        return $this->render('payfail',['order'=>$order]);
    }
    //支付成功
    public function actionPayResult($id){
        $this->layout='mui';
        $order=Order::findOne($id);
        return $this->render('pay-result',['order'=>$order]);
    }

    //收银台去支付
    public function actionGo($id,$pay_method){
        switch($pay_method){
            case 10:
                return $this->redirect(['weixin-goods','id'=>$id]);
                break;
            case 20:
                return $this->redirect(['alipay-goods','id'=>$id]);
                break;
            case 30:
                return $this->redirect(['wallet-goods','id'=>$id]);
                break;
        }

    }

    //钱包余额购买商品
    public function actionWalletGoods($id)
    {
        $order=Order::findOne($id);
        if($order->order_status==0){
            $transaction=Yii::$app->db->beginTransaction();
            try{
                $wallet_pay=Wallet::pay($order->onlinepay_fee,3,$order->order_sn,$order->order_id,$order->user_id);
                if(!$wallet_pay){
                    throw new \yii\base\Exception('余额付款失败');
                }
                $order->wallet_fee=$order->onlinepay_fee;
                $order->onlinepay_fee=0;
                if(!$order->payOk(30)){
                    throw new \yii\base\Exception('订单处理失败');
                }
                $transaction->commit();
                return $this->redirect(['order/view','id'=>$id]);
            }catch(Exception $e){
                $transaction->rollBack();
                // throw $e;
            }
        }
        return $this->redirect(['order/view','id'=>$id]);
    }
    //支付宝购买商品
    public function actionAlipayGoods($id)
    {
        $order=Order::findOne($id);
        if($order->order_status!=0){
            return $this->redirect(['order/view','id'=>$id]);
        }
        $gateway = Omnipay::create('Alipay_AopWap');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId(Yii::$app->params['alipay']['app_id']);
        $gateway->setPrivateKey(Yii::$app->params['alipay']['private_key']);
        $gateway->setAlipayPublicKey(Yii::$app->params['alipay']['alipay_public_key']);
        $gateway->setReturnUrl('https://shop.chelunzhan.top/mobile/order/view?id='.$id);
        $gateway->setNotifyUrl('https://shop.chelunzhan.top/mobile/pay/alipay-notify');
        $request = $gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => $order->order_sn,
            'total_amount' => $order->onlinepay_fee,
            'subject'      => $order->info,
            'product_code' => 'QUICK_WAP_PAY',
        ]);

        $response = $request->send();

        $redirectUrl = $response->getRedirectUrl();
        return $this->redirect($redirectUrl);
    }

    //微信商城购买商品
    public function actionWeixinGoods($id)
    {
        $order=Order::findOne($id);
        $gateway    = Omnipay::create('WechatPay_Js');
        $gateway->setAppId(Yii::$app->params['WECHAT']['app_id']);
        $gateway->setMchId(Yii::$app->params['WECHAT']['mch_id']);
        $gateway->setApiKey(Yii::$app->params['WECHAT']['api_key']);
        $gateway->setNotifyUrl('https://shop.chelunzhan.top/pay/weixin-notify');

        $user=User::findOne(Yii::$app->user->id);
        $openid=$user->openid;
        $order = [
            'body'              => $order->info,
            'out_trade_no'      => $order->order_sn,
            'total_fee'         => $order->onlinepay_fee*100,
            'spbill_create_ip'  => Yii::$app->request->userIp,
            'fee_type'          => 'CNY',
            'open_id'           => $openid,
        ];

        $request  = $gateway->purchase($order);
        $response = $request->send();

        if($response->isSuccessful()){
            $data = $response->getJsOrderData(); //For WechatPay_Js
             return $this->render('weixin-goods', [
                'jsApiParameters' => json_encode($data),
            ]);
        }else{
            //echo '微信支付下单失败！';
            // $data = $response->getData(); //For debug
            //  var_dump($data);
        }

    }


}

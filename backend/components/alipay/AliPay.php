<?php
namespace    app\components\alipay;

class AliPay{
  
    
 
    public static  function pay(){
      
        $id = "1000";
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no =$id;
        
        //订单名称，必填
        $subject ="test";
        
        //付款金额，必填
        $total_amount =0.01;
        
        //商品描述，可空
        $body = "";
        
        //超时时间
        $timeout_express="1m";
        
        
      //  $config =
        
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        
        $payResponse = new  AlipayTradeService( $config );
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        
    }
}
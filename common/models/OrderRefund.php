<?php
namespace common\models;
use Yii;
use backend\components\alipay\aop\AopClient;
use backend\components\alipay\aop\request\AlipayTradeRefundRequest;

class OrderRefund 
{
    
function refundSubmitAlipay($order_id)
{
    
    $order=Order::findOne($order_id);
    $order_sn=$order->order_sn;
    $nonce_str=$this->getnonceStr();
    
    $out_trade_no = $order_sn;
    $out_refund_no =$order_sn.time().rand(10000,99999);
    $total_fee = round($order->total_fee-$order->telfare_fee,2);
    $refund_fee = round($order->total_fee-$order->telfare_fee,2);
    $aop = new AopClient ();
    $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
    $aop->appId = Yii::$app->params['alipay']['app_id'];
    $aop->rsaPrivateKey = Yii::$app->params['alipay']['private_key'];
    $aop->alipayrsaPublicKey=Yii::$app->params['alipay']['alipay_public_key'];
    $aop->apiVersion = '1.0';
    $aop->signType = 'RSA2';
    $aop->postCharset='utf-8';
    $aop->format='json';
    $request = new AlipayTradeRefundRequest();
    //$this->dump(json_decode($str));
    $request->setBizContent("{" .
    "\"out_trade_no\":\"$out_trade_no\"," .
    "\"refund_amount\":$refund_fee," .
    "\"refund_reason\":\"正常退款\"," .
    "\"out_request_no\":\"$out_refund_no\"," .
    "\"operator_id\":\"OP001\"," .
    "\"store_id\":\"NJ_S_001\"," .
    "\"terminal_id\":\"NJ_T_001\"" .
    "}");
    
    $result = $aop->execute($request); 
    //$this->dump($result);
    $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
    $resultCode = $result->$responseNode->code;
//    $this->dump($result);
    if(!empty($resultCode)&&$resultCode == 10000){
        return true;
    } else {
        return false;
    }

}

function refundSubmitWx($order_id)
{
    
    $order=Order::findOne($order_id);
    $order_sn=$order->order_sn;
  	if($order->order_all_pay_id!="")
    {
      	$allorder=OrderAllPay::findOne($order->order_all_pay_id);
      	$order_sn=$allorder->all_pay_sn;
    }
    
  
    //$this->dump($order_sn);
  
    $nonce_str=$this->getnonceStr();
    if($order->pay_type=="4")
    {
    	$appid = Yii::$app->params['WECHAT']['app_id_app'];  
    }else{
        $appid = Yii::$app->params['WECHAT']['app_id'];
    }
    
    
  	$mch_id = Yii::$app->params['WECHAT']['mch_id']; 
    $key = Yii::$app->params['WECHAT']['api_key']; 
    $apiclient_cert='./wxcert/apiclient_cert.pem';
    $apiclient_key='./wxcert/apiclient_key.pem';
    
    $out_trade_no = $order_sn;
    $out_refund_no =$order_sn.time().rand(10000,99999);
    $total_fee = round($order->total_fee-$order->telfare_fee,2)*100;
    $refund_fee =round($order->total_fee-$order->telfare_fee,2)*100;
    

    $ref = strtoupper(md5("appid=$appid&mch_id=$mch_id&nonce_str=$nonce_str&out_refund_no=$out_refund_no&out_trade_no=$out_trade_no&refund_fee=$refund_fee&total_fee=$total_fee&key=$key")); //sign加密MD5


    $refund = array(
    'appid' =>$appid, //应用ID，固定
    'mch_id' => $mch_id, //商户号，固定
    'nonce_str' => $nonce_str, //随机字符串
    'out_refund_no' => $out_refund_no, //商户内部唯一退款单号
    'out_trade_no' => $out_trade_no, //商户订单号,pay_sn码 
    'refund_fee' => $refund_fee, //退款金额
    'total_fee' => $total_fee, //总金额
    'sign' => $ref//签名
    );
    // $this->dump($refund);
    $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    ; //微信退款地址，post请求
    $xml = $this->arrayToXml($refund);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,1); //证书检查

    curl_setopt($ch, CURLOPT_SSLCERTTYPE,'pem');
    curl_setopt($ch, CURLOPT_SSLCERT,$apiclient_cert);
    curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'pem');
    curl_setopt($ch, CURLOPT_SSLKEY,$apiclient_key);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

    $data = curl_exec($ch);
    //将XML转为array        

    $objectxml = simplexml_load_string($data,'SimpleXMLElement',LIBXML_NOCDATA);//将文件转换成 对象
	/*echo "<pre>";
  	var_dump($objectxml);
  	die();*/
    if($objectxml->result_code=="SUCCESS")
    {
        return true;
    }else{
        return false;
    }
}

    function arrayToXml($data){
          if(!is_array($data) || count($data) <= 0){
            return false;
          }
          $xml = "<xml>";
          foreach ($data as $key=>$val){
            
              $xml.="<".$key.">".$val."</".$key.">";
            
          }
          $xml.="</xml>";
          return $xml;
    }

    function getnonceStr() {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        $length = 32;
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        // 随机字符串  
        return $str;

    }
   

}

<?php

namespace yii\web;

use Yii;


class Kdniao
{
  
   function shows($type,$number){
        
    $kgs = $type;//快递公司简称，官方有文档
    $number = $number;//快递单号//3832180245594
    $logisticResult =$this->getOrderTracesByJson($kgs,$number);
    $datakd = json_decode($logisticResult,true);
    /*echo "<pre>";
    var_dump($datakd);
    die();*/
    if($datakd['Success'] == true){//返回信息成功
        return $datakd;

    }
  }
   

/**
 * Json方式 查询订单物流轨迹
 */
function getOrderTracesByJson($kgs,$number){
    $requestData= "{'OrderCode':'','ShipperCode':'".$kgs."','LogisticCode':'".$number."'}";
    
    $datas = array(
        'EBusinessID' => "1531388",
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = $this->encrypt($requestData, "808f186c-a55d-4b6f-9866-5e15e210c5f8");
   
    $result=$this->sendPost("http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx", $datas);   
    
    //根据公司业务处理返回的信息......
    
    return $result;
}
 
/**
 *  post提交数据 
 * @param  string $url 请求Url
 * @param  array $datas 提交的数据 
 * @return url响应返回的html
 */
function sendPost($url, $datas) {
    $temps = array();   
    foreach ($datas as $key => $value) {
        $temps[] = sprintf('%s=%s', $key, $value);      
    }   
    $post_data = implode('&', $temps);
    $url_info = parse_url($url);
    if(empty($url_info['port']))
    {
        $url_info['port']=80;   
    }
    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
    $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
    $httpheader.= "Connection:close\r\n\r\n";
    $httpheader.= $post_data;
    $fd = fsockopen($url_info['host'], $url_info['port']);
    fwrite($fd, $httpheader);
    $gets = "";
    $headerFlag = true;
    while (!feof($fd)) {
        if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
            break;
        }
    }
    while (!feof($fd)) {
        $gets.= fread($fd, 128);
    }
    fclose($fd);  
    
    return $gets;
}

/**
 * 电商Sign签名生成
 * @param data 内容   
 * @param appkey Appkey
 * @return DataSign签名
 */
function encrypt($data, $appkey) {
    return urlencode(base64_encode(md5($data.$appkey)));
}

}

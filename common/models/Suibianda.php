<?php

namespace common\models;

use Yii;
define('URL','http://smms.sbdznkj.com:2018/SbdVoip');
define('PARENTID','08845a5e6349460b8465098304f2a1de');

/**
 * This is the model class for table "{{%goods_sku}}".
 *
 * @property integer $sku_id
 * @property integer $goods_id
 * @property string $attr_path
 * @property string $price
 * @property integer $stock
 */
class Suibianda extends \yii\base\Model
{
  	public $_token;
    private $mobile;
	
   /* public function init(){
        parent::init();
        $this->_token=$this->getToken();
    }*/
  	function __construct($mobile)
    {
    	$this->mobile=$mobile;
        $this->_token=$this->getToken($mobile);
    }
  //$res=$suibianda->callBack($calle164,$caller,);
  	public function callBack($Calle164,$Caller,$Longitude="",$Latitude="",$IpAddress="",$WxOpenId="")//打电话
    {
      	
      	  $url=URL."/call/callBack";
          $post_data=array('Calle164' =>$Calle164,"Caller"=>$Caller,"Longitude"=>$Longitude,"Latitude"=>$Latitude,"IpAddress"=>$IpAddress,"WxOpenId"=>$WxOpenId,);
      
          $arr_header=array("SDB-Authorization:".$this->_token);
      	//   	$post_data=json_encode($data);
		  
          $ch =curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch,CURLOPT_POST,1);
          curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
          curl_setopt($ch,CURLOPT_HTTPHEADER,$arr_header);
          $output = curl_exec($ch);
          curl_close($ch);
          $res=json_decode($output);
		  /*echo "<pre>";
      	  var_dump($res);
          die();*/
          if($res->errorCode==2000){
              return true;
          }else{
              return false;
          }

    }
  	
    public function getMoney()//获取用户信息
    {
      	  
      	  $url=URL."/userInfo/getBlance";
		  $arr_header=array("SDB-Authorization:".$this->_token);
      	             		  
          $ch =curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch,CURLOPT_POST,1);
          curl_setopt($ch,CURLOPT_HTTPHEADER,$arr_header);   
          $output = curl_exec($ch);
          curl_close($ch);
          $res=json_decode($output);
		  /*echo "<pre>";
      	  var_dump($res);
          die();*/
          if($res->errorCode==2000){
              return $res->json->Money;
          }else{
              return false;
          }

    }
  
  	public function register($Mobile)//注册
    {
      	
      	  $url=URL."/login/register";
          $post_data=array('Mobile' =>$Mobile,"ParentId"=>PARENTID,"Password"=>$Mobile);
                		  
          $ch =curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch,CURLOPT_POST,1);
          curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
          $output = curl_exec($ch);
          curl_close($ch);
          $res=json_decode($output);
		 
          if($res->errorCode==2000){
              return $res;
          }else{
              return false;
          }

    }
  
    public function callPay($money)//充值
    {
      	  $money=round($money,0);
      	  $url=URL."/pay/newPay";
          $post_data=array('money' =>$money,"shopMoney"=>0);
          $arr_header=array("SDB-Authorization:".$this->_token);
      	//   	$post_data=json_encode($data);
		  
          $ch =curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch,CURLOPT_POST,1);
          curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
          curl_setopt($ch,CURLOPT_HTTPHEADER,$arr_header);
          $output = curl_exec($ch);
          curl_close($ch);
          $res=json_decode($output);
		  /*echo "<pre>";
      	  var_dump($money);
          die();*/
          if($res->errorCode==2000){
              return true;
          }else{
              return false;
          }

    }
    //http://smms.sbdznkj.com:2018/SbdVoip/sign/getToken?Mobile=18336384270&ParentId=08845a5e6349460b8465098304f2a1de
    //http://smms.sbdznkj.com:2018/SbdVoip/sign/getToken?Mobile=18336384270&ParentId=08845a5e6349460b8465098304f2a1de
    public function getToken($mobile)//获取token
    {
        
        $url=URL."/sign/getToken";
        $post_data=array('Mobile' =>$mobile,"ParentId" =>PARENTID);
        //   	$post_data=json_encode($data);
      	
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
      	
      	if($res->errorCode==2000){
            return $res->data;
        }else{
            return false;
        }
        
      
		echo "<pre>";
      	var_dump($res);
        die();
      	
     /*   $options = array(
          'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' =>http_build_query($post_data),
            'timeout' => 60 // 超时时间（单位:s）
          )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
      
      */
        
    }

  
    
}

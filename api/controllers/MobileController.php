<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;

use common\models\CallLog;
use common\models\User;
use common\models\Config;
use common\models\UserCallfeeLog;


/**
 * Site controller
 */
class MobileController extends Controller
{
  	public function actionCallcs()//通话记录测试
    {   
      	$call_time="1";
      
      	$this->dump(round($call_time-"1.21",2));
    }
    public function actionGetCallFee($user_id)//获取用户话费
    {   
      	$user=User::findOne($user_id);
        if(!empty($user))
        {
        	$res["success"]=true;
        	$res["message"]="成功";
            $res["call_fee"]=$user->get_call_fee;
        	return json_encode($res); 	
        }else{
            $res["success"]=false;
        	$res["message"]="失败";
        	return json_encode($res); 	
        }
      	
    }
  	public function actionCallLog($user_id,$caller,$called,$start_time,$end_time,$guishudi,$mobile_ip,$openid,$lon,$lat)//通话记录
    {   
      	$config=Config::findOne(1);
      	$user=User::findOne($user_id);
      	//计算使用话费
      	if($call_time<60)
        {
         	$fee=round($config->call_price_m,2);
        }else{
         	if($call_time%60==0)
            {
             	$fee=round($call_time/60*$config->call_price_m,2);	 
            }else{
              	$fee=round(($call_time/60+1)*$config->call_price_m,2);	 
            }
        }
      	$balance=round($user->get_call_fee-$fee,2);
      	$user->get_call_fee=$balance;
      	$user->update(true,["get_call_fee"]);
        
      	$userCardLog=new UserCallfeeLog();
        $userCardLog->type="3";
        $userCardLog->user_id=$user_id;
        $userCardLog->fee=$fee;
        $userCardLog->card_num="";
        $userCardLog->order_sn="";
        $userCardLog->create_time=time();
        $userCardLog->save();	
        $start_times=strtotime($start_time);
        $end_times=strtotime($end_time);
        $call_time=$end_times-$start_times;
        $callLog=new CallLog();
        $callLog->user_id=$user_id;
        $callLog->caller=$caller;
        $callLog->called=$called;
        $callLog->start_time=$start_times;
        $callLog->end_time=$end_times;
        $callLog->call_time=$call_time;
      	$callLog->guishudi=$guishudi;
        $callLog->mobile_ip=$mobile_ip;
        $callLog->openid=$openid;
        $callLog->lon=$lon;
        $callLog->lat=$lat;
        $callLog->fee=$fee;
        $callLog->balance=$balance;
      	
      	if($callLog->save())
        {
        	$res["success"]=true;
        	$res["message"]="成功";
        	return json_encode($res); 	 
        }else{
         	$res["success"]=false;
        	$res["message"]="失败";
        	return json_encode($res); 	 
        }
      
        
      
    }
  	
  
  
    public function actionGetCallToken($mobile,$target_mobile)//打电话token
    {
        $res=[];
        $agent_id="9651";
        $act="call";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        if(empty($mobile))
        {
            $res["code"]="0";
            $res["message"]="手机号不能为空";
            return json_encode($res);
        }
        if(empty($target_mobile))
        {
            $res["code"]="0";
            $res["message"]="目标手机号不能为空";
            return json_encode($res);
        }
        $params="act=".$act."&agent_id=".$agent_id."&mobile=".$mobile."&target_mobile".$target_mobile.time().$key;
        $token=md5($params);
        $res["code"]="200";
        $res["message"]="请求成功";
        $res["result"]=$token;
        return json_encode($res);
      
    }

    public function actionGetBalanceToken($mobile)//查询余额token
    {
        $res=[];
        $agent_id="9651";
        $act="balance";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        if(empty($mobile))
        {
            $res["code"]="0";
            $res["message"]="手机号不能为空";
            return json_encode($res);
        }
        
        $params="act=".$act."&agent_id=".$agent_id."&mobile=".$mobile.time().$key;
        $token=md5($params);
        $res["code"]="200";
        $res["message"]="请求成功";
        $res["result"]=$token;
        return json_encode($res);
      
    }
    public function actionGetRegisterToken($name,$password,$code)//注册token
    {
        $res=[];
        $agent_id="9651";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        if(empty($name))
        {
            $res["code"]="0";
            $res["message"]="用户名不能为空";
            return json_encode($res);
        }
        if(empty($password))
        {
            $res["code"]="0";
            $res["message"]="密码不能为空";
            return json_encode($res);
        }
        if(empty($code))
        {
            $res["code"]="0";
            $res["message"]="验证码不能为空";
            return json_encode($res);
        }
        $params="agent_id=".$agent_id."&code=".$code."&name=".$name."&password=".$password.time().$key;
        $token=md5($params);
        $res["code"]="200";
        $res["message"]="请求成功";
        $res["result"]=$token;
        return json_encode($res);
      
    }

    public function actionGetVerifycodeToken($mobile)//短信验证码token
    {
        $res=[];
        $agent_id="9651";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        if(empty($mobile))
        {
            $res["code"]="0";
            $res["message"]="手机号不能为空";
            return json_encode($res);
        }
        
        $params="agent_id=".$agent_id."&mobile=".$mobile.time().$key;
        
        $token=md5($params);
        $res["code"]="200";
        $res["message"]="请求成功";
        $res["result"]=$token;
        return json_encode($res);
      
    }
    public function actionGetgetRechargeToken($mobile,$card_number,$card_password)//充值token
    {
        $res=[];
        $agent_id="9651";
        $act="recharge_card";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        if(empty($mobile))
        {
            $res["code"]="0";
            $res["message"]="手机号不能为空";
            return json_encode($res);
        }
        if(empty($card_number))
        {
            $res["code"]="0";
            $res["message"]="卡账号不能为空";
            return json_encode($res);
        }
        if(empty($card_password))
        {
            $res["code"]="0";
            $res["message"]="卡密码不能为空";
            return json_encode($res);
        }

        $params="act=".$act."&agent_id=".$agent_id."&mobile=".$mobile."&card_number=".$card_number."&card_password=".$card_password.time().$key;
        $token=md5($params);
        $res["code"]="200";
        $res["message"]="请求成功";
        $res["result"]=$token;
        return json_encode($res);
      
    }
    public function actionGetTime()//获取时间戳
    {
        $res["code"]="200";
        $res["message"]="请求成功";
        $res["result"]=time();
        return json_encode($res);
    }
   
}





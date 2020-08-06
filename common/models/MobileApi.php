<?php
namespace common\models;

use Yii;

class MobileApi 
{
   public function getTelFare()//获取话费余额
   {
        $user_id=Yii::$app->user->identity->id;
        $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
        $agent_id="9651";
        $act="balance";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        $mobile=$userAuth->identifier;
        $params="act=".$act."&agent_id=".$agent_id."&mobile=".$mobile.time().$key;
        $token=md5($params);
        $url="http://mp.d5dadao.com/api/appapi/query?act=balance"."&agent_id=".$agent_id."&mobile=".$mobile."&time=".time()."&token=".$token;
        $result=file_get_contents($url);
        $r=json_decode($result);
        $callFee=0;
        //$this->dump($r);
        if(!empty($r)&&$r->code=="4000")
        {
            $callFee=$r->data->balance;
        }
        return $callFee;
   }

   public function reduceTelFare($money)//获取话费余额
   {
        $user_id=Yii::$app->user->identity->id;
        $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
        $agent_id="9651";
        $act="recharge_deduct";
        $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
        $mobile=$userAuth->identifier;

        $params="act=".$act."&agent_id=".$agent_id."&mobile=".$mobile."&money=".$money.time().$key;
        $token=md5($params);
        $url="http://mp.d5dadao.com/api/appapi/query?act=recharge_deduct"."&agent_id=".$agent_id."&mobile=".$mobile."&money=".$money."&time=".time()."&token=".$token;
        $result=file_get_contents($url);
        $r=json_decode($result);
        $callFee=0;
        //$this->dump($r);
        if(!empty($r)&&$r->code=="3000")
        {
            return true;
        }else{
            return false;
        }
        
   }
}

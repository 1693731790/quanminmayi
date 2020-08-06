<?php

namespace common\models;

use Yii;
use yii\web\Rest;

class Ronglian
{
    function sendTemplateSMS($to,$datas,$tempId)
    {
        // 初始化REST SDK
        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
        $accountSid= '8aaf07085d106c7f015d214eaa43058a';
    //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        $accountToken= 'ea338ba90efd46b381c1382e7038390f';
    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        $appId='8aaf07086812057f016827832cc90a50';
        $serverIP='app.cloopen.com';
        $serverPort='8883';
        $softVersion='2013-12-26';
        
        $rest = new Rest($serverIP,$serverPort,$softVersion);
      	/*echo "<pre>";
      	var_dump($rest);
      die();*/
      $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);
        // 发送模板短信
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
		
         return $result;
    }
}

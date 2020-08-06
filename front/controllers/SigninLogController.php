<?php
namespace front\controllers;

use Yii;
use yii\web\Controller;
use common\models\SigninLog;
use common\models\User;
use common\models\Config;
use common\models\Suibianda;
use common\models\UserCallfeeLog;
use common\models\UserAuth;


/**
 * Site controller
 */
class SigninLogController extends CommonController
{
    function actionIndex()
    { 
        //$this->layout="newmain";
        $this->layout="nofooter";
        $user_id=Yii::$app->user->identity->id;
        $connection=Yii::$app->db;
        $MSql="select create_time from shop_signin_log where user_id=".$user_id." and DATE_FORMAT( from_unixtime(create_time), '%Y%m' ) = DATE_FORMAT( CURDATE( ) , '%Y%m' )";
        $MCommand=$connection->createCommand($MSql);
        $MRes=$MCommand->queryAll();


        $daySql="select count(*) as count from shop_signin_log where user_id=".$user_id." and to_days(from_unixtime(create_time)) = to_days(now())";
        $dayCommand=$connection->createCommand($daySql);
        $dayRes=$dayCommand->queryAll();
        
        $user=User::findOne($user_id);
      //  $this->dump($user);
        return $this->render('index', [
              "MRes"=>json_encode($MRes),
              "countFee"=>$user->signin_call_fee,
              "dayRes"=>$dayRes[0]["count"],
        ]);
        
    }
    function actionCreate()
    {
        $user_id=Yii::$app->user->identity->id;

        $connection=Yii::$app->db;
        $daySql="select count(*) as count from shop_signin_log where user_id=".$user_id." and to_days(from_unixtime(create_time)) = to_days(now())";
        $dayCommand=$connection->createCommand($daySql);
        $dayRes=$dayCommand->queryAll();
        //$this->dump($dayRes);
        if($dayRes[0]["count"]==0)
        {
            $config=Config::findOne(1);
            $user=User::findOne(["id"=>$user_id]);
            $user->signin_call_fee+=$config->signin_fee;
            $user->get_call_fee=round($user->get_call_fee+$config->signin_fee,2);
            $user->update(true,["signin_call_fee","get_call_fee"]);
          //$this->dump($config->signin_fee);
       		
          	$userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
            $suibianda=new Suibianda($userAuth->identifier);
            $suibianda->callPay($config->signin_fee);
          
            $userCallfeeLog=new UserCallfeeLog();
            $userCallfeeLog->create($user_id,$config->signin_fee,"",$user->get_call_fee,"5");
            
            $signinLog=new SigninLog();
            $signinLog->user_id=$user_id;
            $signinLog->create_time=time();
            $signinLog->fee=$config->signin_fee;
      
            if($signinLog->save())
            {
                $res["success"]=true;
                $res["message"]="成功";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="失败";
                return json_encode($res);
            }    
        }else{
            $res["success"]=false;
            $res["message"]="失败";
            return json_encode($res);
        }
        
    }
}

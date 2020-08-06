<?php
namespace mall\controllers;

use Yii;
use yii\web\Controller;
use common\models\SigninLog;
use common\models\User;
use common\models\Config;

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
              "countFee"=>$user->get_call_fee,
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
            $user->get_call_fee+=$config->signin_fee;
            $user->update(true,["get_call_fee"]);
            
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

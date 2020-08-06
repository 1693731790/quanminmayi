<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\helpers\FileHelper;
use common\models\Wallet;
use common\models\WaitWallet;
use common\models\User;
/**
 * Site controller
 */
class WalletController extends CommonController
{
       
  
      public function actionWalletInfo()//我的钱包明细
      {
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
         
          $model=Wallet::find()->where(["user_id"=>$user_id])->orderBy("wid desc")->limit(20)->all();
          return $this->render("wallet-info",[
                "model"=>$model,
          ]);
      }
    
      public function actionWalletInfoList($page)//我的钱包明细ajax
      {
          $user_id=Yii::$app->user->identity->id;
          $page=($page-1)*20;
          $model=Wallet::find()->where(["user_id"=>$user_id])->orderBy("wid desc")->offset($page)->limit(20)->all(); 
          
           $str=""; 
         
          foreach($model as $key=>$modelVal)
          {
               $fee=$modelVal->type=="-1"?"-".$modelVal->fee:"+".$modelVal->fee;
               if($key%2!=0)
               {
                    $str.='<div class="yieldbene"><div class="yieldbeneleft">'.yii::$app->params['wallet_type'][$modelVal->type].'</div><div class="yieldbeneright">'.$fee.'</div><div class="yieldbenetop">'.date("Y-m-d H:i:s",$modelVal->create_time).'</div></div>';
               }else{
                    $str.='<div class="yieldbenes"><div class="yieldbenelefts">'.yii::$app->params['wallet_type'][$modelVal->type].'</div><div class="yieldbenerights">'.$fee.'</div><div class="yieldbenetops">'.date("Y-m-d H:i:s",$modelVal->create_time).'</div></div>';
               }
               
          }
        
         echo $str;
      }
  
      public function actionWaitWalletInfo()//我的预收入钱包明细
      {
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
         
          $model=WaitWallet::find()->where(["user_id"=>$user_id])->orderBy("wid desc")->limit(10)->all();
          return $this->render("wait-wallet-info",[
                "model"=>$model,
          ]);
      }
    
      public function actionWaitWalletInfoList($page)//我的预收入钱包明细ajax
      {
          $user_id=Yii::$app->user->identity->id;
          $page=($page-1)*10;
          $model=WaitWallet::find()->where(["user_id"=>$user_id])->orderBy("wid desc")->offset($page)->limit(10)->all(); 
          
          $str=""; 
         
          foreach($model as $key=>$modelVal)
          {
               
               if($key%2!=0)
               {
                    $str.='<div class="yieldbene"><div class="yieldbeneleft">'.yii::$app->params['wait_wallet_type'][$modelVal->type].'</div><div class="yieldbeneright">'.$modelVal->fee.'</div><div class="yieldbenetop">'.date("Y-m-d H:i:s",$modelVal->create_time).'</div></div>';
               }else{
                    $str.='<div class="yieldbenes"><div class="yieldbenelefts">'.yii::$app->params['wait_wallet_type'][$modelVal->type].'</div><div class="yieldbenerights">'.$modelVal->fee.'</div><div class="yieldbenetops">'.date("Y-m-d H:i:s",$modelVal->create_time).'</div></div>';
               }
          }
        
         echo $str;
      }
     
}

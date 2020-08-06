<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\helpers\FileHelper;
use common\models\Goods;
use common\models\GoodsCate;
use common\models\Shops;
use common\models\Wallet;
use common\models\Order;
use common\models\User;
use common\models\UserBank;
use common\models\WithdrawCash;
use common\models\Express;
use common\models\GoodsFavorite;


/**
 * Site controller
 */
class WithdrawCashController extends CommonController
{
       
    public function actionWithdrawCashCreate()//申请提现
    {
      
        $user_id=Yii::$app->user->identity->id;
            $user=User::findOne($user_id);
            $res=[];
        if($data=Yii::$app->request->get()){
            $fee=(float)$data["fee"];
            $balance=(float)$user->wallet;
            if($fee>$balance)
                {
                    $res["success"]=false;
                            $res["message"]="提现金额不能大于余额";
                            return json_encode($res);
                }
                $withdrawCash=new WithdrawCash();
                $isok=$withdrawCash->cashAdd($data,$user_id);
            if($isok)
            {
                $res["success"]=true;
                            $res["message"]="提现申请已提交，等待审核";
                            return json_encode($res);
            }else{
                $res["success"]=false;
                            $res["message"]="提现申请提交失败";
                            return json_encode($res);
            }
                }
        
            $userBank=UserBank::find()->where(["user_id"=>$user_id])->all();
                return $this->render("withdraw-cash-create",[
                            "balance"=>$user->wallet,
                            "userBank"=>$userBank,
                    ]);
            }

      

        public function actionWithdrawCash()    //提现记录
        {
            $this->layout="nofooter";
            $user_id=Yii::$app->user->identity->id;
            $model=WithdrawCash::find()->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->limit(20)->all();
                $user=User::findOne($user_id);
            return $this->render("withdraw-cash",[
                    "model"=>$model,
                    "balance"=>$user->wallet,
                    
            ]);
        
        }
        public function actionWithdrawCashList($page)//异步加载提现记录
        {
            $page=($page-1)*20;
            $user_id=Yii::$app->user->identity->id;
                $model=WithdrawCash::find();
                $wallet=$model->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->offset($page)->limit(20)->all();
                $str=""; 
            
               foreach($wallet as $val)
                {
                        
                        $str.='<li> <span class="tit pl30">'.date("Y-m-d H:i:s",$val->create_time).'</span><span class="num1 pl18">'.$val->fee.'</span><span class="num2 pl20">'.Yii::$app->params["withdraw_cash_status"][$val->status].'</span></li>';
                        
                } 
                //$this->dump($str);
                echo $str;
                //return json_
                
        
        }

        public function actionWallet()//钱包列表
        {
            $this->layout="nofooter";
            $user_id=Yii::$app->user->identity->id;
            $model=Wallet::find()->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->limit(20)->all();
                $user=User::findOne($user_id);
            return $this->render("wallet",[
                    "model"=>$model,
                    "balance"=>$user->wallet,
                    
            ]);
        
        }
        public function actionWalletList($page)//异步加载钱包列表
        {
            $page=($page-1)*20;
            $user_id=Yii::$app->user->identity->id;
                $model=Wallet::find();
                $wallet=$model->where(["user_id"=>$user_id])->orderBy(['create_time'=>SORT_DESC])->offset($page)->limit(20)->all();
                $str=""; 
            
            foreach($wallet as $val)
                {
                        
                        $str.='<li> <span class="tit pl30">'.date("Y-m-d H:i:s",$val->create_time).'</span><span class="num1 pl18">'.$val->fee.'</span><span class="num2 pl20">'.Yii::$app->params["wallet_type"][$val->type].'</span></li>';
                        
                } 
                //$this->dump($str);
                echo $str;
                //return json_
                
        
        }

    function actionBaseimgupload()
    {
        if(yii::$app->user->isGuest)
        {
            return $this->redirect(['site/login']);
        }
        $userid=Yii::$app->user->identity->id;

        $dir='user/'. $userid;
        $directory = Yii::getAlias('@uploads/'.$dir);
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
        $filePath = $directory . DIRECTORY_SEPARATOR;

        //$path = '/upload/'.$dir.'/';
        
        $base64_image_content = $_POST['headimg'];
        //$output_directory = './uploads/headimg/'.date("Y-m-d",time()); //设置图片存放路径
        $output_directory =$filePath;

        // 检查并创建图片存放目录 
        if (!file_exists($output_directory)) {
            mkdir($output_directory, 0777);
        }
        $timepath=md5(time().rand(1000,9999).$userid);
        // 根据base64编码获取图片类型 
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $image_type = $result[2]; //data:image/jpeg;base64,
            $output_file = $output_directory . '/' . $timepath . '.' . $image_type;
            $path = '/uploads/'.$dir.'/'. $timepath . '.' . $image_type;
        }

        //将base64编码转换为图片编码写入文件 
        $image_binary = base64_decode(str_replace($result[1], '', $base64_image_content));
        if (file_put_contents($output_file, $image_binary)) {
           
            echo $path; //写入成功输出图片路径
        }
    }
     
     public function actionMessage()
        {
            //$this->layout="nofooter";
            
            return $this->render("message",[
            
                    
            ]);
        
        }
}

<?php
namespace mall\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Kdniao;
use yii\data\Pagination;
use common\models\User;
use common\models\UserAuth;
use yii\helpers\FileHelper;
use common\models\GoodsFavorite;
use common\models\ShopsFavorite;
use common\models\Goods;
use common\models\Shops;
use common\models\Order;
use common\models\OrderGoods;
use common\models\UserAddress;
use common\models\Sysarticle;
use common\models\UserMessage;
use common\models\RemindSendGoods;
use common\models\GoodsComment;
use common\models\Wallet;
use common\models\Region;
use common\models\Liguanjia;
use common\models\AgentMobileCardNum;
use common\models\Config;
use common\models\Agent;
use common\models\Yunzhonghe;
use common\models\WaitWallet;
use common\models\RechargeCard;
use common\models\UserCardLog;


/**
 * Site controller
 */
class UserController extends CommonController
{
      public $enableCsrfValidation = false;
  	 function actionSet()
      {
          $this->layout="nofooter";
          return $this->render("set",[
             

          ]);
      }
  
      public function actionIndex()
      {
        $user_id=Yii::$app->user->identity->id;
        
        $user=User::findOne($user_id);

        //话费余额开始
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
        $callFee="";
        //$this->dump($r);
        if(!empty($r)&&$r->code=="4000")
        {
            $callFee=$r->data->balance;
        }else{
            $callFee='0.01';
        }
        //$this->dump($user);
        //话费余额结束
        


        //话费余额结束

        return $this->render("index",[
              "callFee"=>$callFee,
              "wallet"=>$user->wallet,
              "waitWallet"=>$user->wait_wallet,
              "headimgurl"=>$user->headimgurl!=""?$user->headimgurl:"/uploads/qmmayilogo.png",
              "nickname"=>$user->nickname!=""?$user->nickname:$userAuth->identifier,
              "is_upgrade"=>$user->is_upgrade,
        ]);
      
      }
      public function actionMyCode()//我的二维码
      {
          $this->layout="nofooter";
          $searchLink=yii::$app->params['webLink']."/site/signup.html?code=".Yii::$app->user->identity->invitation_code;
        
          // 获取收款二维码内容
          ob_start();
          \PHPQRCode\QRcode::png($searchLink,false,'L', 4, 2);
          $imageString = base64_encode(ob_get_contents());
          ob_end_clean();

          $resQrcode='data:image/png;base64,'.$imageString; 

          $user_id=Yii::$app->user->identity->id;
          $user=User::findOne($user_id);
          return $this->render("my-code",[
                "resQrcode"=>$resQrcode,
                "headimgurl"=>$user->headimgurl!=""?$user->headimgurl:"/uploads/qmmayilogo.png",
                
          ]);
      
      }
      

      function actionOrder($status="",$iscomment="",$key="")//用户订单
      {
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $model=Order::find();
            
          if($key!="")
          {
              $order=$model->asArray()->where(["user_id"=>$user_id])->andWhere(["<>","status","-1"])->andFilterWhere(["status"=>$status])->andFilterWhere(["is_comment"=>$iscomment])->orderBy("order_id desc")->limit(30)->all();
              foreach($order as $orderkey=>$val)
              {
                
                  $orderGoods=OrderGoods::find()->asArray()->where(["order_id"=>$val['order_id']])->andFilterWhere(["like",'goods_name',$key])->all();
                  if(empty($orderGoods))
                  {
                    unset($order[$orderkey]);
                  }else{
                    $order[$orderkey]['orderGoods']=$orderGoods;
                    $order[$orderkey]['shops']=Shops::find()->asArray()->where(["shop_id"=>$val['shop_id']])->one();
                    //$this->dump(Shops::find()->asArray()->where(["shop_id"=>$val['shop_id']])->one());
                  }
              }
          }else{
              $order=$model->asArray()->with(["shops",'orderGoods'])->where(["user_id"=>$user_id])->andWhere(["<>","status","-1"])->andFilterWhere(["status"=>$status])->andFilterWhere(["is_comment"=>$iscomment])->orderBy("order_id desc")->limit(30)->all();  
          }
          

       //   $this->dump($order);
          return $this->render("order",[
              "order"=>$order,
              "status"=>$status,
              "key"=>$key
             

          ]);
      }
      function actionOrderDetail($order_id)//用户订单
      {
          $this->layout="nofooter";
          $order=Order::findOne($order_id);
          $orderGoods=OrderGoods::find()->with(["goods"])->where(["order_id"=>$order_id])->all();
          
        
          return $this->render("order-detail",[
              "order"=>$order,
            "orderGoods"=>$orderGoods,
              
             

          ]);
      }
    
    function actionOrderCancel($order_id)//用户取消订单
    {
          $user_id=Yii::$app->user->identity->id;
          $model=Order::findOne($order_id);
          if($model->user_id!=$user_id)
          {
                $res["success"]=false;
                $res["message"]="错误提示：无法操作";
                return json_encode($res);
          }
          $model->status="-1";
          if($model->update(true,["status"]))
          {
                $res["success"]=true;
                $res["message"]="取消成功";
                return json_encode($res);
          }else{
                $res["success"]=false;
                $res["message"]="取消失败";
                return json_encode($res);
          }
      
    }
    function actionOrderRefund($order_id="")//用户退货订单
    {
     
        if($data=Yii::$app->request->post()){
            $user_id=Yii::$app->user->identity->id;
            $order=Order::findOne($data['order_id']);   
          
      
            if($order->user_id!=$user_id||$order->status=="0"||$order->status=="3"||$order->status=="4"||$order->status=="5"||($order->status=="2"&&$order->shop_id=="1"))
            {
                $res["success"]=false;
                $res["message"]="错误提示：无法操作";
                return json_encode($res);
            }
            $order->status=4;
            $order->refund_remarks=$data["refund_remarks"];
            $order->refund_time=time();
            if($order->update(true,["status","refund_remarks","refund_time"]))
            {
                $res["success"]=true;
                $res["message"]="提交成功等待审核";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="提交失败";
                return json_encode($res);
            }

        }
        return $this->render("order-refund",[
            "order_id"=>$order_id,
        ]);
    }
     function actionAddressCreate($type="")// 弹窗添加收货地址
     {
        $this->layout="nofooter";
        
        if($data=Yii::$app->request->get()){
           
            if($data["isdefault"]==1)
            {
                $connection=Yii::$app->db;
                $sqlkey="UPDATE shop_user_address SET isdefault=0 WHERE user_id=".Yii::$app->user->identity->id;
                $command=$connection->createCommand($sqlkey);
                $command->execute();
            }
            $model=new UserAddress();
            
            $model->user_id=Yii::$app->user->identity->id;
            $model->name=$data["name"];
            $model->phone=$data["phone"];
            $model->region=$data["region"];
            $model->region_id=$data["region_id"];
            $model->address=$data["address"];
            $model->isdefault=$data["isdefault"];
            if($model->save())
            {
                $address=UserAddress::find()->asArray()->where(["aid"=>$model->aid])->one();
                $res["success"]=true;
                
                $res["message"]=$address;
                return json_encode($res);
            }else{
                $res["success"]=false;
                
                return json_encode($res);
            }
           
        }else{
             $region=Region::find()->where(["parent_id"=>"0"])->all();
            return $this->render("address-create",[
                "region"=>$region
            ]);  
        }

        
     }

      public function actionRegion($region_id="")
      {
          $region=Region::find()->asArray()->where(["parent_id"=>$region_id])->all();
         // $this->dump($region);
          //$this->dump(json_encode($region));
          return json_encode($region);
      }
     function actionAddressCreatef()// 添加收货地址
     {
        $this->layout="nofooter";
       $data=Yii::$app->request->get();
        if($data["name"]!=""){
           
            if($data["isdefault"]==1)
            {
                $connection=Yii::$app->db;
                $sqlkey="UPDATE shop_user_address SET isdefault=0 WHERE user_id=".Yii::$app->user->identity->id;
                $command=$connection->createCommand($sqlkey);
                $command->execute();
            }
            $model=new UserAddress();
            
            $model->user_id=Yii::$app->user->identity->id;
            $model->name=$data["name"];
            $model->phone=$data["phone"];
            $model->region=$data["region"];
            $model->region_id=$data["region_id"];
            $model->address=$data["address"];
            $model->isdefault=$data["isdefault"];
            if($model->save())
            {
                $address=UserAddress::find()->asArray()->where(["aid"=>$model->aid])->one();
                $res["success"]=true;
                
                $res["message"]=$address;
                return json_encode($res);
            }else{
                $res["success"]=false;
                
                return json_encode($res);
            }
           
        }else{
            $region=Region::find()->where(["parent_id"=>"0"])->all();
            return $this->render("address-createf",[
                "region"=>$region
            ]);  
        }

        
     }

    function actionAddressDelete($aid)//删除收藏的商品
    {
        $user_id=Yii::$app->user->identity->id;
        $model=UserAddress::findOne($aid);
        $res=[];
        if($model->user_id!=$user_id)
        {
            $res["success"]=false;
            $res["message"]="无效的操作";
            return json_encode($res);
        }
        if(empty($model))
        {
            $res["success"]=false;
            $res["message"]="无效的操作";
            return json_encode($res);
        }
        if($model->delete())
        {
            $res["success"]=true;
            $res["message"]="删除成功";
            return json_encode($res);
        }else{
            $res["success"]=false;
            $res["message"]="删除失败";
            return json_encode($res);
        }
    }
     function actionAddressList()// 收货地址列表
     {
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $model=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->all();
          return $this->render("address-list",[
                "model"=>$model,
          ]); 
     }
     function actionAbout()// 关于我们
     {
          $this->layout="nofooter";
          
          $model=Sysarticle::findOne(2);
          //$this->dump($model);
          return $this->render("about",[
                "model"=>$model,
          ]); 
     }

     function actionUserInfo()// 用户信息
     {
       $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $model=User::findOne($user_id);
          if($data=Yii::$app->request->get()){
                $model->nickname=$data["nickname"];
                //$model->realname=$data["realname"];
                if($model->update(true,['nickname']))
                {
                    return "修改成功";
                }else{
                    return "修改失败";
                }
           }
          //$this->dump($model);
          return $this->render("user-info",[
                "model"=>$model,
                "userimg"=>$model->headimgurl!=""?$model->headimgurl:"/uploads/qmmayilogo.png",
          ]); 
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
            if(isset($_POST['isuserpic'])&&$_POST['isuserpic']=="1")
            {
              $user = User::findOne(Yii::$app->user->identity->id);
              $user->headimgurl=$path;
              $user->save();
            }
            echo $path; //写入成功输出图片路径
        }
    }
     
       // 修改密码
    public function actionRepassword()
    {
        
        $user = User::findOne(Yii::$app->user->identity->id);
        if($data=Yii::$app->request->get()){
            
            $res=[];
            $res['errors']=[];

            $check_params=true;

            if(!isset($data['old_password'])){
                 $res['success']=false;
                 $res['message']="缺少必要参数：old_password";
                 return json_encode($res);
               
            }

            if(!isset($data['password'])){
                 $res['success']=false;
                 $res['message']="缺少必要参数：password";
                 return json_encode($res);
               
            }

            if(!isset($data['repassword'])){
                 $res['success']=false;
                 $res['message']="缺少必要参数：repassword";
                 return json_encode($res);
            }
          
            $old_password=$data['old_password'];
            $password=$data['password'];
            $repassword=$data['repassword'];
            if(!UserAuth::isPassword($password)){
                $res['success']=false;
                $res['message']="密码需由8—20位,由字母、数字组成";
                return json_encode($res);
            }

            if($password!==$repassword){
                $res['success']=false;
                $res['message']="两次输入的密码不一致";
                return json_encode($res);
            }

            $auth_phone=UserAuth::find()->where(['user_id'=>$user->id,'identity_type'=>'phone'])->one();
            if($auth_phone->validateCredential($old_password)){
                $user_auth_all=UserAuth::find()->where(['user_id'=>$user->id])->all();
                foreach($user_auth_all as $user_auth_model){
                    $user_auth_model->setCredential($password);
                    $user_auth_model->save();
                }
                \common\models\UserLog::create($user->id,3,'通过旧密码修改登录密码');
                $res['success']=true;
                $res['message']="操作成功";
               return json_encode($res);
            }else{
                $res['success']=false;
                $res['message']="原密码不正确";
               return json_encode($res);
            }
        }

        return $this->render('repassword', [
           // 'model' => $model,
        ]);
    }

    function actionRemindSendGoods()  //提醒发货
    {
          $user_id=Yii::$app->user->identity->id;
          $model=new RemindSendGoods();
          if($data=Yii::$app->request->get()){
                $remindSendGoods=RemindSendGoods::find()->where(["order_id"=>$data["order_id"],"user_id"=>$user_id])->one();
                $order=Order::find()->where(["order_id"=>$data["order_id"]])->one();
                
                if(!empty($remindSendGoods))
                {

                    return "您已经提醒过了";
                    die();
                }

                $model->user_id=$user_id;
                $model->shop_id=$order->shop_id;
                $model->order_id=$data['order_id'];
                $model->create_time=time();
                if($model->save())
                {
                    return "提醒成功";
                }else{
                    return "提醒失败";
                }
           }
    }

     function actionConfirmReceived()  //确认收货
    {
          $user_id=Yii::$app->user->identity->id;
          $res=[];
          if($data=Yii::$app->request->get()){
            
                $order=Order::find()->where(["order_id"=>$data["order_id"]])->one();
                if($order->status!="2")
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);
                }

                $shop=Shops::findOne($order->shop_id);
                $user=User::findOne($shop->user_id);
                if(empty($order))
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);
                }
                if($order->status!=2)
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);

                }
                if($order->user_id!=$user_id)
                {
                    $res['success']=false;
                    $res['message']="您没有权限操作";
                    return json_encode($res);

                }
            
            $transaction=Yii::$app->db->beginTransaction();
            try {  
                $order->status=3;
                if(!$order->update(true,["status"]))
                {
                    throw new \yii\db\Exception("保存失败");
                }
                $plusFee=$order->total_fee;
                $wallet=new Wallet();
                if(!$wallet->addWallet($user->id,1,$plusFee,$user->wallet,$order->order_id,$order->order_sn))
                {
                    throw new \yii\db\Exception("保存失败");
                }
                $config=Config::findOne(1);
                $myUser=User::findOne($user_id);
                //如果没有升级过则升级  升级加合伙人代理商分成开始
                if($order->is_upagent_buy=="1"&&$myUser->is_upgrade=="0")
                {
                    $myUser->is_upgrade="1";
                    if(!$myUser->update(true,["is_upgrade"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }

                    if($myUser->parent_id!="")//如果有上级代理
                    {
                        $parentUser=User::findOne($myUser->parent_id);
                        $parentAgent=Agent::findOne(["user_id"=>$myUser->parent_id]);  

                        //判断是合伙人还是代理商，代理商则查找上级，是合伙人直接分润，如果代理商没有上级合伙人则不分润  
                        if($parentAgent->type=="2")
                        {
                            //给上级代理商添加金额
                            if($config->agent_fee!="0")
                            {
                                //添加钱包记录
                                $wallet=new Wallet();
                                if(!$wallet->addWallet($parentUser->id,2,$config->agent_fee,$parentUser->wallet,$order->order_id,$order->order_sn))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                                //修改用户余额
                                $parentUser->wallet=round($parentUser->wallet+$config->agent_fee,2);
                                if(!$parentUser->update(true,["wallet"]))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                               
                            }
                            //如果代理商有上级合伙人
                            if($parentAgent->parent_id!="0")
                            {
                              if($config->partner_indirect_fee!="0")
                              {
                                $parentParentUser=User::findOne($parentAgent->parent_id);
                                //添加钱包记录
                                $wallet=new Wallet();
                                if(!$wallet->addWallet($parentParentUser->id,2,$config->partner_indirect_fee,$parentParentUser->wallet,$order->order_id,$order->order_sn))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                                //给合伙人添加金额
                                
                                $parentParentUser->wallet=round($parentParentUser->wallet+$config->partner_indirect_fee,2);
                                if(!$parentParentUser->update(true,["wallet"]))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                              }
                            }
                        }else if($parentAgent->type=="1"){

                            if($config->partner_direct_fee!="0")
                            {
                              //添加钱包记录
                              $wallet=new Wallet();
                              if(!$wallet->addWallet($parentUser->id,2,$config->partner_direct_fee,$parentUser->wallet,$order->order_id,$order->order_sn))
                              {
                                  throw new \yii\db\Exception("保存失败");
                              }
                              //修改用户余额
                              $parentUser->wallet=round($parentUser->wallet+$config->partner_direct_fee,2);
                              if(!$parentUser->update(true,["wallet"]))
                              {
                                  throw new \yii\db\Exception("保存失败");
                              }
                            }
                        }
                    }
                    
                    if($myUser->user_parent_id!="")//如果是用户分享的  用户直接推荐分成金额(购买大礼包)',
                    {
                          if($config->user_direct_fee!="0")
                          {
                            $userParentUser=User::findOne($myUser->user_parent_id);//用户分享的上级用户资料
                            //添加钱包记录
                            $wallet=new Wallet();
                            
                            if(!$wallet->addWallet($userParentUser->id,2,$config->user_direct_fee,$userParentUser->wallet,$order->order_id,$order->order_sn))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                            //修改用户余额
                            $userParentUser->wallet=round($userParentUser->wallet+$config->user_direct_fee,2);
                            
                            if(!$userParentUser->update(true,["wallet"]))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                          }
                    }
                    //$this->dump($myUser->user_parent_id!=""&&$myUser->parent_id==""); 
                    if($myUser->user_parent_id!=""&&$myUser->parent_id=="")//如果是用户分享的  用户直接推荐分成金额(购买大礼包)',
                    {
                        //$this->dump(123);
                          if($userParentUser->parent_id!="")//用户直接推荐分成金额(购买大礼包)  如果该用户有上级代理商
                          {
                                $userParentParentUser=User::findOne($userParentUser->parent_id);//用户直接推荐的上级代理用户信息
                                $userParentParentAgent=Agent::findOne(["user_id"=>$userParentUser->parent_id]);  //用户直接推荐的上级代理
                                //判断是合伙人还是代理商，代理商则查找上级，是合伙人直接分润，如果代理商没有上级合伙人则不分润  
                                if($userParentParentAgent->type=="2")
                                {
                                    //给上级代理商添加金额
                                    if($config->user_agent_fee!="0")
                                    {
                                        //添加钱包记录
                                        $wallet=new Wallet();
                                        if(!$wallet->addWallet($userParentParentUser->id,2,$config->user_agent_fee,$userParentParentUser->wallet,$order->order_id,$order->order_sn))
                                        {
                                            throw new \yii\db\Exception("保存失败");
                                        }
                                        //修改用户余额
                                        $userParentParentUser->wallet=round($userParentParentUser->wallet+$config->user_agent_fee,2);
                                        if(!$userParentParentUser->update(true,["wallet"]))
                                        {
                                            throw new \yii\db\Exception("保存失败");
                                        }
                                       
                                    }
                                    //如果代理商有上级合伙人
                                    if($userParentParentAgent->parent_id!="0")
                                    { 
                                        if($config->user_partner_fee!="0")
                                        {
                                          $userParentParentParentAgent=User::findOne($userParentParentAgent->parent_id);
                                          //添加钱包记录
                                          $wallet=new Wallet();
                                          if(!$wallet->addWallet($userParentParentParentAgent->id,2,$config->user_partner_fee,$userParentParentParentAgent->wallet,$order->order_id,$order->order_sn))
                                          {
                                              throw new \yii\db\Exception("保存失败");
                                          }
                                          //给合伙人添加金额
                                          
                                          $userParentParentParentAgent->wallet=round($userParentParentParentAgent->wallet+$config->user_partner_fee,2);
                                          if(!$userParentParentParentAgent->update(true,["wallet"]))
                                          {
                                              throw new \yii\db\Exception("保存失败");
                                          }
                                        }
                                    }
                                }else if($userParentParentAgent->type=="1"){

                                    //添加钱包记录
                                    $wallet=new Wallet();
                                    if(!$wallet->addWallet($userParentParentUser->id,2,$config->partner_direct_fee,$userParentParentUser->wallet,$order->order_id,$order->order_sn))
                                    {
                                        throw new \yii\db\Exception("保存失败");
                                    }
                                    //修改用户余额
                                    $userParentParentUser->wallet=round($userParentParentUser->wallet+$config->partner_direct_fee,2);
                                    if(!$userParentParentUser->update(true,["wallet"]))
                                    {
                                        throw new \yii\db\Exception("保存失败");
                                    }
                                }
                          }

                           
                    }


                }
                //升级加合伙人代理商分成结束
                
             //  throw new \yii\db\Exception("保存失败");


                //利润分成给合伙人开始
                if($order->is_upagent_buy!="1"&&$myUser->parent_id!="")//如果有上级代理
                {
                    $orderGoods=OrderGoods::find()->where(["order_id"=>$order->order_id])->all();
                    $partner_profit_pct_fee=0;
                    foreach($orderGoods as $orderGoodsVal)
                    {
                        $goods=Goods::findOne($orderGoodsVal->goods_id);
                       
                        $partner_profit_pct_fee+=round($goods->profitFee*($config->partner_profit_pct/100),2);
                    }
                    if($partner_profit_pct_fee>0)
                    {
                        $parentUser=User::findOne($myUser->parent_id);
                        $parentAgent=Agent::findOne(["user_id"=>$myUser->parent_id]); 
                        //判断是合伙人还是代理商，代理商则查找上级，是合伙人直接分润，如果代理商没有上级合伙人则不分润  
                        if($parentAgent->type=="2")
                        {
                            //如果代理商有上级合伙人
                            if($parentAgent->parent_id!="0")
                            {
                                $parentParentUser=User::findOne($parentAgent->parent_id);
                                //添加钱包记录
                                $wallet=new Wallet();
                                if(!$wallet->addWallet($parentParentUser->id,3,$partner_profit_pct_fee,$parentParentUser->wallet,$order->order_id,$order->order_sn))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                                //给合伙人添加金额
                                
                                $parentParentUser->wallet=round($parentParentUser->wallet+$partner_profit_pct_fee,2);
                                if(!$parentParentUser->update(true,["wallet"]))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                            }
                        }else if($parentAgent->type=="1"){
                            //添加钱包记录
                            $wallet=new Wallet();
                            if(!$wallet->addWallet($parentUser->id,3,$partner_profit_pct_fee,$parentUser->wallet,$order->order_id,$order->order_sn))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                            //修改用户余额
                            $parentUser->wallet=round($parentUser->wallet+$partner_profit_pct_fee,2);
                            if(!$parentUser->update(true,["wallet"]))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                        }
                    }
                    
                }
                //利润分成给合伙人结束

               // throw new \yii\db\Exception("保存失败2");

                //普通订单给上级代理商分红
                if($order->is_upagent_buy!="1")//如果不是大礼包商品
                {
                    $waitWallet=WaitWallet::find()->where(["order_sn"=>$order->order_sn])->all();
                    $waitWalletFee=WaitWallet::find()->where(["order_sn"=>$order->order_sn])->sum("fee");
                    if(!empty($waitWallet))
                    {
                        foreach($waitWallet as $waitWalletVal)
                        {
                            $waitWalletUser=User::findOne($waitWalletVal->user_id);
                            
                            $wallet=new Wallet();
                            if(!$wallet->addWallet($waitWalletVal->user_id,3,$waitWalletVal->fee,$waitWalletUser->wallet,$waitWalletVal->order_id,$waitWalletVal->order_sn))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }

                            WaitWallet::findOne($waitWalletVal->wid)->delete();
                        }
                        $waitWalletUser->wallet+=$waitWalletFee;
                        $waitWalletUser->wait_wallet-=$waitWalletFee;
                        if(!$waitWalletUser->update(true,["wallet","wait_wallet"]))
                        {
                            throw new \yii\db\Exception("保存失败");
                        }

                    }
                }
               // throw new \yii\db\Exception("保存失败1");
                //;

                $transaction->commit();

                $res['success']=true;
                $res['message']="操作成功";
                return json_encode($res);
              }catch (\Exception $e) {
                $transaction->rollBack();
                //throw $e;
                $res['success']=false;
                $res['message']="操作失败";
                return json_encode($res);
                
            }
          }
    }


   /* function actionConfirmReceived()  //确认收货
    {
          $user_id=Yii::$app->user->identity->id;
          $res=[];
          if($data=Yii::$app->request->get()){
                $order=Order::find()->where(["order_id"=>$data["order_id"]])->one();
                if($order->status!="2")
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);
                }

                $shop=Shops::findOne($order->shop_id);
                $user=User::findOne($shop->user_id);
                if(empty($order))
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);
                }
                if($order->status!=2)
                {
                    $res['success']=false;
                    $res['message']="未知错误";
                    return json_encode($res);

                }
                if($order->user_id!=$user_id)
                {
                    $res['success']=false;
                    $res['message']="您没有权限操作";
                    return json_encode($res);

                }
            
            $transaction=Yii::$app->db->beginTransaction();
            try {  
                $order->status=3;
                if(!$order->update(true,["status"]))
                {
                    throw new \yii\db\Exception("保存失败");
                }
                $plusFee=$order->total_fee;
                $wallet=new Wallet();
                if(!$wallet->addWallet($user->id,1,$plusFee,$user->wallet,$order->order_id,$order->order_sn))
                {
                    throw new \yii\db\Exception("保存失败");
                }
                $config=Config::findOne(1);
                $myUser=User::findOne($user_id);
                //如果没有升级过则升级  升级加合伙人代理商分成开始
                if($order->is_upagent_buy=="1"&&$myUser->is_upgrade=="0")
                {
                    $myUser->is_upgrade="1";
                    if(!$myUser->update(true,["is_upgrade"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }
                    if($myUser->parent_id!="")//如果有上级代理
                    {
                        $parentUser=User::findOne($myUser->parent_id);
                        $parentAgent=Agent::findOne(["user_id"=>$myUser->parent_id]);  

                        //判断是合伙人还是代理商，代理商则查找上级，是合伙人直接分润，如果代理商没有上级合伙人则不分润  
                        if($parentAgent->type=="2")
                        {
                            //给上级代理商添加金额
                            if($config->agent_fee!="0")
                            {
                                //添加钱包记录
                                $wallet=new Wallet();
                                if(!$wallet->addWallet($parentUser->id,2,$config->agent_fee,$parentUser->wallet,$order->order_id,$order->order_sn))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                                //修改用户余额
                                $parentUser->wallet=round($parentUser->wallet+$config->agent_fee,2);
                                if(!$parentUser->update(true,["wallet"]))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                               
                            }

                            //如果代理商有上级合伙人
                            if($parentAgent->parent_id!="0")
                            {
                                $parentParentUser=User::findOne($parentAgent->parent_id);
                                //添加钱包记录
                                $wallet=new Wallet();
                                if(!$wallet->addWallet($parentParentUser->id,2,$config->partner_indirect_fee,$parentParentUser->wallet,$order->order_id,$order->order_sn))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                                //给合伙人添加金额
                                
                                $parentParentUser->wallet=round($parentParentUser->wallet+$config->partner_indirect_fee,2);
                                if(!$parentParentUser->update(true,["wallet"]))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                            }
                        }else if($parentAgent->type=="1"){

                            //添加钱包记录
                            $wallet=new Wallet();
                            if(!$wallet->addWallet($parentUser->id,2,$config->partner_direct_fee,$parentUser->wallet,$order->order_id,$order->order_sn))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                            //修改用户余额
                            $parentUser->wallet=round($parentUser->wallet+$config->partner_direct_fee,2);
                            if(!$parentUser->update(true,["wallet"]))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                        }
                    }
                }
                //升级加合伙人代理商分成结束

                //利润分成给合伙人开始
                if($order->is_upagent_buy!="1"&&$myUser->parent_id!="")//如果有上级代理
                {
                    $orderGoods=OrderGoods::find()->where(["order_id"=>$order->order_id])->all();
                    $partner_profit_pct_fee=0;
                    foreach($orderGoods as $orderGoodsVal)
                    {
                        $goods=Goods::findOne($orderGoodsVal->goods_id);
                       
                        $partner_profit_pct_fee+=round($goods->profitFee*($config->partner_profit_pct/100),2);
                    }
                    if($partner_profit_pct_fee>0)
                    {
                        $parentUser=User::findOne($myUser->parent_id);
                        $parentAgent=Agent::findOne(["user_id"=>$myUser->parent_id]); 
                        //判断是合伙人还是代理商，代理商则查找上级，是合伙人直接分润，如果代理商没有上级合伙人则不分润  
                        if($parentAgent->type=="2")
                        {
                            //如果代理商有上级合伙人
                            if($parentAgent->parent_id!="0")
                            {
                                $parentParentUser=User::findOne($parentAgent->parent_id);
                                //添加钱包记录
                                $wallet=new Wallet();
                                if(!$wallet->addWallet($parentParentUser->id,3,$partner_profit_pct_fee,$parentParentUser->wallet,$order->order_id,$order->order_sn))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                                //给合伙人添加金额
                                
                                $parentParentUser->wallet=round($parentParentUser->wallet+$partner_profit_pct_fee,2);
                                if(!$parentParentUser->update(true,["wallet"]))
                                {
                                    throw new \yii\db\Exception("保存失败");
                                }
                            }
                        }else if($parentAgent->type=="1"){
                            //添加钱包记录
                            $wallet=new Wallet();
                            if(!$wallet->addWallet($parentUser->id,3,$partner_profit_pct_fee,$parentUser->wallet,$order->order_id,$order->order_sn))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                            //修改用户余额
                            $parentUser->wallet=round($parentUser->wallet+$partner_profit_pct_fee,2);
                            if(!$parentUser->update(true,["wallet"]))
                            {
                                throw new \yii\db\Exception("保存失败");
                            }
                        }
                    }
                    
                }
                //利润分成给合伙人结束

               // throw new \yii\db\Exception("保存失败2");


                $transaction->commit();

                $res['success']=true;
                $res['message']="操作成功";
                return json_encode($res);
              }catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
                $res['success']=false;
                $res['message']="操作失败";
                return json_encode($res);
                
            }
          }
    }*/

  

    function actionLogistics($order_id)
    {
        $model=Order::findOne($order_id);
       // $this->dump($model->shop_id==1);
        if($model->shop_id==1)
        {
            $liguanjia=new Yunzhonghe();
            $res=$liguanjia->getOrderTrack($model->order_sn);
            //$this->dump($res);
            return $this->render('logisticsjd', [
                "res"=>$res,  
            ]);    
        }else{
            $kdniao=New Kdniao();
            $datakd=$kdniao->shows($model->express_type,$model->express_num);
           // $this->dump($datakd);
            return $this->render('logistics', [
                'datakd' => $datakd,
            ]);    
        }
        
    }

    function actionCommentCreate()  //提交评价
    {
        
        $user_id=Yii::$app->user->identity->id;
        $res=[];
        if($data=Yii::$app->request->get()){
          $order=Order::findOne($data["order_id"]);
          $ordergoods=OrderGoods::find()->where(["order_id"=>$data["order_id"]])->all();
          if($order->user_id!=$user_id)
          {
              $res['success']=false;
              $res['message']="您没有权限操作";
              return json_encode($res);
          }
          foreach($ordergoods as $val)
          {
              $model=new GoodsComment();
              $commentResult=$model->createComment($data,$val->goods_id);      
              if(!$commentResult){
                  $res['success']=false;
                  $res['message']="未知错误";
                  return json_encode($res);
              }

          }
          $order->is_comment=1;
          $order->update(true,['is_comment']);

          $res['success']=true;
          $res['message']="评价成功";
          return json_encode($res);
        }
        

    }
    function actionComment($order_id="")  //评价
    {
        $this->layout="nofooter";
        return $this->render('Comment', [
            'order_id' => $order_id,
        ]);

    }

    function actionRecharge()  //话费充值
    {
      
        $this->layout="nofooter";
        $user_id=Yii::$app->user->identity->id;
        $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
        if($data=Yii::$app->request->get()){
           
            $card_number=$data["cardName"];
            $card_password=$data["cardPwd"];
            $agent_id="9651";
            $act="recharge_card";
            $key="511wHKsKOKY1AtdotV2xnO2xPFen90Zp";
            $mobile=$userAuth->identifier;
           
            $params="act=".$act."&agent_id=".$agent_id."&mobile=".$mobile."&card_number=".$card_number."&card_password=".$card_password.time().$key;
            $token=md5($params);
          // $this->dump($params);
            $url="http://mp.d5dadao.com/api/appapi/query?act=recharge_card"."&agent_id=".$agent_id."&mobile=".$mobile."&card_number=".$card_number."&card_password=".$card_password."&time=".time()."&token=".$token;
            $result=file_get_contents($url);
            $r=json_decode($result);
           // $this->dump($result);
            if(isset($r->code)&&$r->code==3000)
            {
                $user=User::findOne($user_id);
                if($user->parent_id=="")
                {
                    $agentMobileCardNum=AgentMobileCardNum::findOne(["card_num"=>$card_number]);
                   if(!empty($agentMobileCardNum))
                   {
                      $agentMobileCardNum->isuse="1";
                        $agentMobileCardNum->update(true,["isuse"]);
                        $user->parent_id=$agentMobileCardNum->user_id;
                        $user->update(true,["parent_id"]);
                    }
                    
                }

                $res['success']=true;
                $res['message']="充值成功";
                return json_encode($res);
            }else{
                $res['success']=false;
                $res['message']="充值失败";
                return json_encode($res);
            }
            
        }

        //$this->dump($userAuth);
        return $this->render('recharge', [
            "phone"=>$userAuth->identifier,
        ]);

    }
  
    function actionRechargeCard($card_num="",$password="")  //充值卡充值
    {
      	
        $this->layout="nofooter";
        $user_id=Yii::$app->user->identity->id;
        
        if($data=Yii::$app->request->post()){
            $cardNum=RechargeCard::find()->where(["card_num"=>$data["cardName"]])->one();
            if(empty($cardNum))
            {
                $res['success']=false;
                $res['message']="充值卡无效";
                return json_encode($res);
            }
           	$modelOne=RechargeCard::find()->where(["card_num"=>$data["cardName"],"password"=>$data["cardPwd"]])->one();
            if(!empty($modelOne))
            {
              	if($modelOne->is_use=="1")
                {
                    $res['success']=false;
                    $res['message']="充值卡已使用";
                    return json_encode($res);
                }
                $transaction=Yii::$app->db->beginTransaction();
        		try {
              
                    $user=User::findOne($user_id);
                    $user->recharge_fee=round($user->recharge_fee+$modelOne->fee,2);
                    if(!$user->update(true,["recharge_fee"]))
                    {
                      	throw new \yii\db\Exception("保存失败");
                    } 
                  
                  	$modelOne->is_use="1";
                    if(!$modelOne->update(true,["is_use"]))
                    {
                      	throw new \yii\db\Exception("保存失败");
                    } 
                  
                    $userCardLog=new UserCardLog();
                    $userCardLog->user_id=$user_id;
                    $userCardLog->type="1";
                    $userCardLog->fee=$modelOne->fee;
                    $userCardLog->card_num=$modelOne->card_num;
                    $userCardLog->create_time=time();
                   // $userCardLog->save();
                 // $this->dump($userCardLog->getErrors());
                    if(!$userCardLog->save())
                    {
                      	throw new \yii\db\Exception("保存失败");
                    } 
                   
                    $transaction->commit();
                    $res['success']=true;
                    $res['message']="充值成功";
                    return json_encode($res);

                }catch (\Exception $e) {
                    $transaction->rollBack();
                   // throw $e;
                    $res['success']=false;
                    $res['message']="充值失败";
                    return json_encode($res);
			    }
            }else{
                $res['success']=false;
                $res['message']="卡号或密码不正确";
                return json_encode($res);
            }
            
        }

        //$this->dump($userAuth);
       
        return $this->render('recharge-card', [
            "card_num"=>$card_num,
            "password"=>$password,
        ]);

    }


}

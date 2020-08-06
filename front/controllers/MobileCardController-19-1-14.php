<?php
namespace front\controllers;

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


/**
 * Site controller
 */
class UserController extends CommonController
{
      public $enableCsrfValidation = false;
      public function actionIndex()
      {
        $user_id=Yii::$app->user->identity->id;
        $users=User::findOne($user_id);

        $goodsFavorite=GoodsFavorite::find()->where(["user_id"=>$user_id])->count();
        $shopsFavorite=ShopsFavorite::find()->where(["user_id"=>$user_id])->count();

        $message=UserMessage::find()->where(["user_id"=>$user_id])->count();

        return $this->render("index",[
              "users"=>$users,
              "shopsFavorite"=>$shopsFavorite,
              "goodsFavorite"=>$goodsFavorite,
              "message"=>$message,
        ]);
      
      }


      

      function actionOrder($status="",$iscomment="",$key="")//用户订单
      {
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $model=Order::find();
          if($key!="")
          {
              $order=$model->asArray()->where(["user_id"=>$user_id])->andFilterWhere(["status"=>$status])->andFilterWhere(["is_comment"=>$iscomment])->orderBy("order_id desc")->limit(30)->all();
              foreach($order as $orderkey=>$val)
              {
                
                  $orderGoods=OrderGoods::find()->asArray()->where(["order_id"=>$val['order_id']])->andFilterWhere(["like",'goods_name',$key])->all();
                
                  if(empty($orderGoods))
                  {
                    unset($order[$orderkey]);
                  }else{
                    $order[$orderkey]['orderGoods']=$orderGoods;
                    $order[$orderkey]['shops']=Shops::find()->asArray()->where(["shop_id"=>$val['shop_id']])->one();
                  }
              }
          }else{
              $order=$model->asArray()->with(["shops",'orderGoods'])->where(["user_id"=>$user_id])->andFilterWhere(["status"=>$status])->andFilterWhere(["is_comment"=>$iscomment])->orderBy("order_id desc")->limit(30)->all();  
          }
          

          //$this->dump($order);
          return $this->render("order",[
              "order"=>$order,
              "status"=>$status,
              "key"=>$key
             

          ]);
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
          $user_id=Yii::$app->user->identity->id;
          $model=User::findOne($user_id);
          if($data=Yii::$app->request->get()){
                $model->nickname=$data["nickname"];
                $model->realname=$data["realname"];
                if($model->update(true,['nickname','realname']))
                {
                    return "修改成功";
                }else{
                    return "修改失败";
                }
           }
          //$this->dump($model);
          return $this->render("user-info",[
                "model"=>$model,
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
        $directory = Yii::getAlias('@upload/'.$dir);
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
            $path = '/upload/'.$dir.'/'. $timepath . '.' . $image_type;
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
                $plusFee=$order->total_fee+$order->goods_card_fee;
                $wallet=new Wallet();
                if(!$wallet->addWallet($user->id,1,$plusFee,$user->wallet,$order->order_id,$order->order_sn))
                {
                    throw new \yii\db\Exception("保存失败");
                }
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

  

    function actionLogistics($order_id)
    {
        $model=Order::findOne($order_id);
        if($model->shop_id==1)
        {
            $liguanjia=new Liguanjia();
            $res=$liguanjia->getOrderTrack($model->order_lgj_sn);
           // $this->dump($res);
            return $this->render('logisticsjd', [
                "res"=>$res,  
            ]);    
        }else{
            $kdniao=New Kdniao();
            $datakd=$kdniao->shows($model->express_type,$model->express_num);
            //$this->dump($str);
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
}

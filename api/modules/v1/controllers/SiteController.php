<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;
use common\models\UserAuth;
use common\models\User;
use common\models\App;
use common\models\Version;
use common\models\Ronglian;
use common\models\RonglianTest;
use common\models\UserLog;
use common\models\OrderUser;
use common\models\OrderFreeTake;
use common\models\Suibianda;

 /**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup'],
                'denyCallback' => function($rule, $action){  
                                        
                },  
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

   
    public function actions()
    {
        return [
            'error' => [
                //'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
   
    
     public function actionSendCode($mobile){
            if($mobile=="")
            {
                $res['success']=false;
                $res['message']="缺少参数mobile";
                return json_encode($res);
            }
            //初始化client,apikey作为所有请求的默认值
            $verifycode=rand(1000,9999);
            $cache=Yii::$app->cache;
            $key=$mobile.'_'.$verifycode;
            $cache->set($key,md5($verifycode),300);
            $ronglian=new Ronglian();
            
            $code=$ronglian->sendTemplateSMS($mobile,array($verifycode,'5'),"406686");
            
            if($code->statusCode=="000000"){
                 $res['success']=true;
                 $res['message']="验证码发送成功";
                 return json_encode($res);
                
            }else{
                $res['success']=false;
                 $res['message']="验证码发送失败，请稍后再试";
                 return json_encode($res);
                
            }
    }
    
      public function actionSendCodeTest($mobile){
            if($mobile=="")
            {
                $res['success']=false;
                $res['message']="缺少参数mobile";
                return json_encode($res);
            }
            //初始化client,apikey作为所有请求的默认值
            $verifycode=rand(1000,9999);
            $cache=Yii::$app->cache;
            $key=$mobile.'_'.$verifycode;
            $cache->set($key,md5($verifycode),300);
            $ronglian=new RonglianTest();
            
            $code=$ronglian->sendTemplateSMS($mobile,array($verifycode,'5'),"460328");
            
            if($code->statusCode=="000000"){
                 $res['success']=true;
                 $res['message']="验证码发送成功";
                 return json_encode($res);
                
            }else{
                $res['success']=false;
                 $res['message']="验证码发送失败，请稍后再试";
                 return json_encode($res);
                
            }
    }



    public function actionLogin($mobile="",$password="",$return_url=null,$openid=""){
      
      	if($openid!="")
        {
          	$userAuth=UserAuth::find()->where(["identity_type"=>"weixin","identifier"=>$openid])->one();
          	if($userAuth)
            {
             	 $user_id=$userAuth->user_id;
              	 $user=true;
                 $userMobile=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
                 $mobile=$userMobile->identifier;
            }else{
             	 $res['success']=false;
                 $res['message']="登陆失败,未注册";
                 return json_encode($res);
            }
        }else{
            $model = new Login();
            $model->identity_type='phone';
            if($mobile=="")
            {
                $res['success']=false;
                $res['message']="请输入手机号";
                return json_encode($res);
            }
            if($password=="")
            {
                $res['success']=false;
                $res['message']="请输入密码";
                return json_encode($res);
            }
            $model->identifier=$mobile;
            $model->credential=$password;
            $model->rememberMe=true;
			$user=$model->login();
          	$user_id=Yii::$app->user->identity->id;
            $userWeixin=UserAuth::find()->where(["identity_type"=>"weixin","user_id"=>$user_id])->one();
          	if(!empty($userWeixin))
            {
            	$openid=$userWeixin->identifier;
            }
            
        }
       // $this->dump($user);
        if($user){
            UserLog::create($user_id,1);
            $userOne=User::findOne($user_id);
          
          	$userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
            $suibianda=new Suibianda($userAuth->identifier);
            $suibianda->register($userAuth->identifier);
          
            if($userOne->free_take_order_sn!="")
            {
                    $orderFreeTake=OrderFreeTake::findOne(["order_sn"=>$userOne->free_take_order_sn]);
                    if(!empty($orderFreeTake))
                    {
                        $orderUser=new OrderUser();
                        $orderUser->order_id=$orderFreeTake->order_id;
                        $orderUser->user_id=$userOne->id;
                        $orderUser->create_time=time();
                        $orderUser->save();
                        $orderFreeTake->get_user_num=$orderFreeTake->get_user_num+1;
                      	$userOne->free_take_order_sn="";
                        $userOne->update(true,["free_take_order_sn"]);
                        if($orderFreeTake->get_user_num>=$orderFreeTake->user_num)
                        {
                            $orderFreeTake->status=1;
                        }
                        $orderFreeTake->update(true,["get_user_num","status"]);
                        
                    }
            }
            $result=[];
            $result['mobile']=$mobile;
            $result['user_id']=$user_id;
            $result['token']=$userOne->access_token;
            $result['openid']=$openid;
            $res['success']=true;
            $res['message']="登陆成功";
            $res['result']=$result;
            return json_encode($res);
           // $this->dump($user);
        }else{
            $res['success']=false;
            $res['message']="登陆失败";
            return json_encode($res);
        }
       
    }
 private function createNonceStr($length = 16) {  
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
    $str = "";  
    for ($i = 0; $i < $length; $i++) {  
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);  
    }  
    return $str.time();  
  }  
  
  	//绑定微信
    public function actionSignupWeixin()
    {
      	  $data=Yii::$app->request->get();
          $res=[];
  
         
          $check_params=true;
         if(!isset($data['user_id'])){
              $check_params=false;
              $res['message']='缺少必要参数：openid';
          }
          if(!isset($data['openid'])){
              $check_params=false;
              $res['message']='缺少必要参数：openid';
          }
          if(!isset($data['nickname'])){
              $check_params=false;
              $res['message']='缺少必要参数：nickname';
          }
          if(!isset($data['headimgurl'])){
              $check_params=false;
              $res['message']='缺少必要参数：headimgurl';
          }
          if(!$check_params){
              $res['success']=false;
              return json_encode($res);
          }
      $user_auth_openid=UserAuth::findOne(["identifier"=>$data['openid']]);
    
          
          if($user_auth_openid!=null){
                $res['success']=false;
                $res['message']="微信已占用";
                return json_encode($res);
          }
      	  $user_model=User::findOne($data['user_id']);
      	  $user_model->nickname=$data['nickname'];
          $user_model->headimgurl=$data['headimgurl'];
          if(!$user_model->update(true,["nickname","headimgurl"])){
           	 	 $res['success']=false;
                $res['message']="失败";
                return json_encode($res);
          }
          $openid=$data['openid'];  
             $user_auth_model_wx=new UserAuth();
             $user_auth_model_wx->user_id=$data['user_id'];
             $user_auth_model_wx->identity_type='weixin';
             $user_auth_model_wx->identifier=$data['openid'];
             $user_auth_model_wx->setCredential("123456789");
             if(!$user_auth_model_wx->save()){
               	$res['success']=false;
                $res['message']="失败";
                return json_encode($res);
             }   
             $res['success']=true;
                $res['message']="成功";
                return json_encode($res);
      	  

    }

    //用户注册
    public function actionSignupByPhone()
    {
        $data=Yii::$app->request->get();
        $res=[];
        
        $check_params=true;
        if(!isset($data['verifycode'])){
            $check_params=false;
            $res['message']='缺少必要参数：verifycode';
        }
        if(!isset($data['username'])){
            $check_params=false;
            $res['message']='缺少必要参数：username';
        }
        if(!isset($data['password'])){
            $check_params=false;
            $res['message']='缺少必要参数：password';
        }
        if(!isset($data['mobile'])){
            $check_params=false;
            $res['message']='缺少必要参数：mobile';
        }
        
              

        if(!$check_params){
            $res['success']=false;
            return json_encode($res);
        }

        $verifycode=$data['verifycode'];
        $phone=$data['mobile'];
        $username=$data['username'];
        $password=$data['password'];
      	
        
        if((!isset($data['openid']))||(!isset($data['nickname']))||(!isset($data['headimgurl']))){
            $res['success']=false;
            $res['message']="参数不正确";
            return json_encode($res);
        }
       

        if(strlen($username)<4){
            $res['success']=false;
            $res['message']="用户名至少4个字符";
            return json_encode($res);
        }

        $user_auth_username=UserAuth::findUserByUsername($username);
        if($user_auth_username!=null){
            $res['success']=false;
            $res['message']="用户名已占用";
            return json_encode($res);
           
        }

        if(!UserAuth::isPhone($phone)){
            $res['success']=false;
            $res['message']="手机号格式不正确";
            return json_encode($res);
        }
        $user_auth_phone=UserAuth::findUserByPhone($phone);
        if($user_auth_phone!=null){
            $res['success']=false;
            $res['message']="手机号已占用";
            return json_encode($res);
        }
        if(isset($data['openid']))
        {
        	$openid=$data['openid'];  
            $user_auth_openid=UserAuth::findUserByOpenid($openid);
            if($user_auth_openid!=null){
                $res['success']=false;
                $res['message']="微信已占用";//.$user_auth_openid->id
                return json_encode($res);
            }

        }
       
        $cache=Yii::$app->cache;

        $key=$phone.'_'.$verifycode;

       // $this->dump($key);
        if($cache->get($key)!==md5($verifycode)){
            $res['success']=false;
            $res['message']="手机验证码错误";
            return json_encode($res);
        }


        if(!UserAuth::isPassword($password)){
            
            $res['success']=false;
            $res['message']="密码不合法,密码8—20位,由字母、数字组成";
            return json_encode($res);
        }

            //开启事务保存数据
            $transaction=Yii::$app->db->beginTransaction();
            try{
                // 注册新用户
                $user_model=new User();
                $user_model->access_token=Yii::$app->security->generateRandomString() . '_' . time();
               if(isset($data['openid'])&&isset($data['nickname'])&&isset($data['headimgurl']))
               {
                 	 $user_model->nickname=$data['nickname'];
                     $user_model->headimgurl=$data['headimgurl'];
               }
                $user_model->invitation_code=$this->createNonceStr();
                if(!$user_model->save()){
                     throw new \yii\db\Exception('user信息保存失败');
                }
                               

                $user_auth_model_1=new UserAuth();

                $user_auth_model_1->user_id=$user_model->id;
                $user_auth_model_1->identity_type='phone';
                $user_auth_model_1->identifier=$phone;
                $user_auth_model_1->setCredential($password);
                $user_auth_model_1->save();
                if(!$user_auth_model_1->save()){
                     throw new \yii\db\Exception('手机号登录创建失败');
                }

                $user_auth_model=new UserAuth();
                $user_auth_model->user_id=$user_model->id;
                $user_auth_model->identity_type='username';
                $user_auth_model->identifier=$username;
                $user_auth_model->setCredential($password);
                if(!$user_auth_model->save()){
                     throw new \yii\db\Exception('用户名登录创建失败');
                }
              if(isset($data['openid']))
              {
                    $openid=$data['openid'];  
                    $user_auth_model_wx=new UserAuth();
                    $user_auth_model_wx->user_id=$user_model->id;
                    $user_auth_model_wx->identity_type='weixin';
                    $user_auth_model_wx->identifier=$openid;
                    $user_auth_model_wx->setCredential($password);
                    if(!$user_auth_model_wx->save()){
                         throw new \yii\db\Exception('用户名登录创建失败');
                    }

              }
                
               
               
                $transaction->commit();

                $login_model = new Login;
                $login_model->identity_type='phone';
                $login_model->identifier=$phone;
                $login_model->credential=$password;
                $user=$login_model->login();
                \common\models\UserLog::create($user_model->id,1,'新用户注册自动登录');

                return json_encode([
                    'success'=>true,
                    'message'=>'注册成功',
                    /*'user'=>[
                        'token'=>$user->access_token,
                    ],*/
                ]);
            }catch(\Exception $e){
                $transaction->rollBack();
               // throw $e;
                return json_encode([
                    'success'=>false,
                    'message'=>'注册失败，请稍后再试。',
                ]);
            }
    }

     //验证手机号是否可用
    public function actionCheckPhone($mobile)
    {
        $res=[];
       
        if(!isset($mobile)){
            $res['success']=false;
            $res['message']="缺少必要参数：mobile";
            return json_encode($res);
        }

        if(!App::isPhone($mobile)){
            $res=[
                'success'=>false,
                'message'=>'手机号格式不正确',
            ];
            return json_encode($res);
        }

        $UserAuth = UserAuth::find()->where(['identity_type'=>'phone','identifier'=>$mobile])->one();
        if($UserAuth==null){
            return json_encode(['success'=>true,'message'=>'手机号可用',]);
        }else{
            return json_encode(['success'=>false,'message'=>'手机号已注册',]);
        }
        
    }


    //验证用户名是否可用
    public function actionCheckUsername($username)
    {
        
            $res=[];
            
            if(!isset($username)){
                
                $res['success']=false;
                $res['message']='请输入手机号';
                return json_encode($res);
            }
          
            if(strlen($username)<4){
                $res=[
                    'success'=>false,
                    'message'=>'用户名不能少于4个字符',
                ];
                return json_encode($res);
            }

            $UserAuth = UserAuth::find()->where(['identity_type'=>'username','identifier'=>$username])->one();
            if($UserAuth==null){
                $res=[
                    'success'=>true,
                    'message'=>'用户名可用',
                ];
                return json_encode($res);
            }else{
                  $res=[
                    'success'=>false,
                    'message'=>'用户名已占用',
                ];
                return json_encode($res);
                
            }


    }

   

    

    public function actionLogout()
    {
       
        Yii::$app->user->logout();
        
        return $this->redirect(['index/index']);
        //return $this->goHome();
    }

}

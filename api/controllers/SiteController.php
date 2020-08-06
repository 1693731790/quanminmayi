<?php
namespace api\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Signup;
use common\models\Login;
use common\models\UserAuth;
use common\models\User;
use common\models\UserLog;
use common\models\Config;
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
   public function actionCallBack($calle164,$caller,$Longitude="",$Latitude="",$IpAddress="",$WxOpenId="",$user_id=""){//随便打  拨打电话
     		if($Longitude=="" || $Latitude=="" || $IpAddress=="" || $WxOpenId=="")
            {
              	$result['success']=false;
            	$result['res']="参数不正确";  
                return json_encode($result);
            }
            /*$user=User::findOne($user_id)
            if(!$user->get_call_fee>0){
             	$result['success']=false;
            	$result['res']="话费余额不足";  
                return json_encode($result);
            }*/
            
      		$suibianda=new Suibianda($caller);
       		$res=$suibianda->callBack($calle164,$caller,$Longitude,$Latitude,$IpAddress,$WxOpenId);
     		
     		if($res)
            {
              	
            	$result['success']="200";
            	$result['res']="电话接通中";  
            }else{
                $result['success']="0";
            	$result['res']="拨打失败";  
            }
            
            
            return json_encode($result);
            
    }
	 public function actionGetToken($mobile){//获取随便打token
      		$suibianda=new Suibianda($mobile);
       		
            $res['success']="200";
            $res['token']=$suibianda->_token;
            
            return json_encode($res);
            
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
    public function actionUpVersion(){
      		$config=Config::findOne(1);
            $res['success']=true;
            $res['message']="http://mapi.combj.top/".$config->appapk_url;
            $res['version']=$config->version;
            return json_encode($res);
            
    }
    public function actionAppDownloads(){
        $config=Config::findOne(1);
        
        $link=$config->appapk_url;
        $size=filesize ( ".".$link );
        $file = fopen ( ".".$link, "r" );    
        Header ( "Content-type: application/x-www-form-urlencoded" );    
        Header ( "Accept-Ranges: bytes" );  
        Header ( "Accept-Language: en-us" );  
        Header ( "Content-Length:".$size);  
        Header ( "Content-Disposition: attachment; filename=app.apk" );  
        Header ( "Accept-Length: " . filesize ( ".".$link ) );  
        echo fread ( $file, filesize ( ".".$link ) );    
        fclose ( $file );     
    }
    public function actionDownloads($appid){
        $app=Version::find()->where(['id'=>$appid])->one();
        $size=filesize ( ".".$app->link );
        $file = fopen ( ".".$app->link, "r" );    
        Header ( "Content-type: application/x-www-form-urlencoded" );    
        Header ( "Accept-Ranges: bytes" );  
        Header ( "Accept-Language: en-us" );  
        header ( "Content-Length:".$size);  
        Header ( "Content-Disposition: attachment; filename=app.apk" );  
        Header ( "Accept-Length: " . filesize ( ".".$app->link ) );  
        echo fread ( $file, filesize ( ".".$app->link ) );    
        fclose ( $file );     
    }
    
     public function actionSendCode(){
        
       if(Yii::$app->request->isGet){
            $post=Yii::$app->request->get();
            if(isset($post['phone'])){
               $phone=$post['phone'];
                //初始化client,apikey作为所有请求的默认值
                $verifycode=rand(1000,9999);
                $cache=Yii::$app->cache;
                $key=$phone.'_'.$verifycode;
                $cache->set($key,md5($verifycode),300);
                $ronglian=new Ronglian();
                $code=$ronglian->sendTemplateSMS($phone,array($verifycode,'5'),"406686");

                if($code->statusCode=="000000"){
                     $res['success']=true;
                     $res['message']="验证码发送成功";
                     return json_encode($res);
                    
                }else{
                    $res['success']=false;
                     $res['message']="验证码发送失败，请稍后再试";
                     return json_encode($res);
                    
                }
            }else{
                $res['success']=false;
                     $res['message']="验证码发送失败,缺少必要参数：phone";
                     return json_encode($res);
                
            }

        }
    }
    
    
    
     //通过手机号修改密码
    public function actionRepassword()
    {
       if($data=Yii::$app->request->get()){
           
            $res=[];
            if(!isset($data['verifycode'])){
                $res['success']=false;
                $res['message']="验证码不能为空";
                return json_encode($res);
            }
            if(!isset($data['phone'])){
                $res['success']=false;
                $res['message']="手机号不能为空";
                return json_encode($res);
            }
            if(!isset($data['password'])){
                $res['success']=false;
                $res['message']="密码不能为空";
                return json_encode($res);
            }

            if(!isset($data['repassword'])){
                $res['success']=false;
                $res['message']="确认密码不能为空";
                return json_encode($res);
            }
            
            $password=$data['password'];
            $repassword=$data['repassword'];
            $phone=$data['phone'];
            $verifycode=$data['verifycode'];
            $res=[];

            $user_auth_phone=UserAuth::findUserByPhone($phone);
            if($user_auth_phone==null){
                $res['success']=false;
                $res['message']="账号不存在";
                return json_encode($res);
                
            }

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

            $cache=Yii::$app->cache;
            $key=$phone.'_'.$verifycode;

            if($cache->get($key)!==md5($verifycode)){
                $res['success']=false;
                $res['message']="手机验证码已过期，请重试";
                return json_encode($res);
            }

            $user_id=$user_auth_phone->user_id;
            $user_auth_all=UserAuth::find()->where(['user_id'=>$user_id])->all();
            foreach($user_auth_all as $user_auth_model){
                $user_auth_model->setCredential($password);
                $user_auth_model->save();
            }

            $user_auth_phone->setCredential($password);
            if($user_auth_phone->save()){
                \common\models\UserLog::create($user_id,2,'通过手机号找回登录密码');
                $res['success']=true;
                $res['message']="密码修改成功";
            }else{
                $res['success']=false;
                foreach($user_auth_phone->errors as $v){
                    $res['message']=$v[0];
                }
            }
            return json_encode($res);
        }

        
    }



    public function actionLogin($return_url=null){
        $this->layout="nofooter";

        if(!yii::$app->user->isGuest)
        {
            return $this->redirect(['user/index']);
        }
        $model = new Login();
        $model->identity_type='phone';
        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())) {
              $model->rememberMe=true;
                if($user=$model->login()){
                   
                  UserLog::create(Yii::$app->user->identity->id,1);
                  return $this->redirect(['user/index']);
                   
                }
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);

    }

    public function actionSignup()
    {
        $this->layout="nofooter";
        
        if(!Yii::$app->user->isGuest){
            return $this->redirect('user/index');
        }
        return $this->render('signup', [

        ]);
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
        
        $invitation_code=null;
        $user_type=0;
              

        if(!$check_params){
            $res['success']=false;
            return json_encode($res);
        }

        $verifycode=$data['verifycode'];
        $phone=$data['phone'];
        $username=$data['username'];
        $password=$data['password'];
       

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

        $cache=Yii::$app->cache;

        $key=$phone.'_'.$verifycode;

        /*if($cache->get($key)!==md5($verifycode)){
            $res['success']=false;
            $res['message']="手机验证码错误";
           
            return json_encode($res);
        }*/


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
                // if(isset($data['open_id'])&&$data['open_id']!=null){
                //     $user_auth_model_wx=new UserAuth();
                //     $user_auth_model_wx->user_id=$user_model->id;
                //     $user_auth_model_wx->identity_type='weixin';
                //     $user_auth_model_wx->identifier=$data['open_id'];
                //     if(!$user_auth_model_wx->save()){
                //          throw new \yii\db\Exception('微信登录创建失败');
                //     }
                //     $wx_user=$data['wx_user'];
                //     $user_model->nickname=$wx_user['nickname'];
                //     $user_model->sex=$wx_user['sex'];
                //     $user_model->headimgurl=$wx_user['headimgurl'];
                //     $user_model->save();
                // }
               
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
                throw $e;
                return json_encode([
                    'success'=>false,
                    'message'=>'注册失败，请稍后再试。',
                ]);
            }
    }

     //验证手机号是否可用
    public function actionCheckPhone($phone)
    {
        $res=[];
        $res['errors']=[];
        if(!isset($phone)){
            $res['success']=false;
            $res['message']="缺少必要参数：phone";
            return json_encode($res);
        }

        if(!App::isPhone($phone)){
            $res=[
                'success'=>false,
                'message'=>'手机号格式不正确',
            ];
            return json_encode($res);
        }

        $UserAuth = UserAuth::find()->where(['identity_type'=>'phone','identifier'=>$phone])->one();
        if($UserAuth==null){
            return json_encode(['success'=>true,'message'=>'手机号可用',]);
        }else{
            return json_encode(['success'=>false,'message'=>'手机号已注册',]);
        }
        
    }


    //验证用户名是否可用
    public function actionCheckUsername($username=null)
    {
        if(Yii::$app->request->isPost){
            $data=Yii::$app->request->post();
            $res=[];
            $res['errors']=[];
            if(!isset($data['username'])){
                
                $res['success']=false;
                $res['message']='请检输入手机号';
                return $res;
            }
            $username=$data['username'];

            if(strlen($username)<4){
                $res=[
                    'success'=>false,
                    'message'=>'用户名不能少于4个字符',
                ];
                return $res;
            }

            $UserAuth = UserAuth::find()->where(['identity_type'=>'username','identifier'=>$username])->one();
            if($UserAuth==null){
                return [
                    'success'=>true,
                    'message'=>'用户名可用',
                ];
            }else{
                return [
                    'success'=>false,
                    'message'=>'用户名已占用',
                ];
            }

        }

    }

    public function actionLogout()
    {
       
        Yii::$app->user->logout();
        
        return $this->redirect(['index/index']);
        //return $this->goHome();
    }

}

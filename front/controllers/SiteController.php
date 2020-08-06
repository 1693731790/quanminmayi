<?php
namespace front\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Signup;
use common\models\Login;
use common\models\Config;
use common\models\UserAuth;
use common\models\User;
use common\models\App;
use common\models\Version;
use common\models\Ronglian;
use micsay\captcha\CaptchaBuilder;
use common\models\OrderFreeTake;
use common\models\GoodsFreeTake;
use common\models\OrderUser;
use common\models\UserLog;
use common\models\Suibianda;

/**
 * Site controller
 */
class SiteController extends Controller
{
  
  	  public function actionWxopenid()
      {
           if(isset($_GET['js_code']))
           {
                $jscode=$_GET['js_code'];
                $url="https://api.weixin.qq.com/sns/jscode2session?appid=".Yii::$app->params['WECHAT']["xcx_id"]."&secret=".Yii::$app->params['WECHAT']["xcx_secret"]."&js_code=".$jscode."&grant_type=authorization_code";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                $data = curl_exec($curl);
                $array=json_decode($data,true);
				curl_close($curl);
                
             	$openid=isset($array['openid'])?$array['openid']:$array['errcode'];
             	if($openid=="40029"){
                   $response["result"] = 0;
                   $response["msg"] = "invalid code";
                   $response["openid"] = $openid;
                   echo json_encode($response);
                }else{
                   $response["result"] = 1;
                   $response["msg"] = "user exist ok";
                   $response["openid"] = $openid;
                   echo json_encode($response);
                }
           }
              
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
           /* 'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup'],//
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
            ],*/
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

      //通过手机号修改密码
    public function actionFreeTake($order_sn)
    {
        $this->layout="nofooter";
        $order=OrderFreeTake::findOne(["order_sn"=>$order_sn]);
        $goodsOne=GoodsFreeTake::findOne($order->goods_id);
        $goods=GoodsFreeTake::find()->orderBy("goods_id desc")->limit(10)->all();
      	//$this->dump($goodsOne);
        return $this->render('free-take', [
            'order_sn' => $order_sn,
            'goodsOne' => $goodsOne,
            'goods' => $goods,
        ]);
    }

    public function actionSendCodes($mobile){
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
    public function actionUsercid($cid,$token)
    {
        if(!yii::$app->user->isGuest)
        {
            $user_id=Yii::$app->user->identity->id;
            $user=User::findOne($user_id);  
            $user->clientID=$cid.";".$token;
            $user->save();    
        }
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
    public function actionUsertype($phone){
      $user=UserAuth::find()->asArray()->where(["identifier"=>$phone])->one();
      if($user!="")
      {
            $username=User::findOne($user["user_id"]);
            if($username->user_type!="1")
            {
                echo  "2";
            }else{
                echo "1";
            }
      }else{
            echo "3";
      }
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
    
     public function actionSendcodeOld(){
        
       if(Yii::$app->request->isGet){
            $post=Yii::$app->request->get();
            if(isset($post['phone'])){
               $phone=$post['phone'];
                //初始化client,apikey作为所有请求的默认值
                $verifycode=rand(1000,9999);
                $cache=Yii::$app->cache;
                $key=$phone.'_'.$verifycode;
                $cache->set($key,md5($verifycode),300);
                $apikey=Yii::$app->params['yunpian']['apikey'];
                $clnt = YunpianClient::create($apikey);
                $param = [YunpianClient::MOBILE => $phone,YunpianClient::TEXT => '【车仑战云物流】您的验证码是'.$verifycode.'请在5分钟内输入，如非本人操作，请忽略。'];

                $r = $clnt->sms()->single_send($param);
                $code=$r->code();
                if($code==0){
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
       
        $this->layout="nofooter";
        if($data=Yii::$app->request->post()){
            
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

        return $this->render('repassword', [
           // 'model' => $model,
        ]);
    }



    public function actionLogin($return_url=null){
        $this->layout="nofooter";

        if(!yii::$app->user->isGuest)
        {
            return $this->redirect(['user/index']);
        }
       /* if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false)
        {
            if(isset($_GET["code"]))
            {
                $code=$_GET["code"];
                $appid=Yii::$app->params['WECHAT']['app_id'];
                $secret=Yii::$app->params['WECHAT']['secret'];
                $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
                $res=file_get_contents($url);
                $res=json_decode($res);
                
                $user_auth_wx=UserAuth::find()->where(["identity_type"=>"weixin"])->andWhere(["identifier"=>$res->openid])->one();
                //$this->dump($user_auth_wx);
                if(!empty($user_auth_wx))
                {
                      $login_model = new Login;
                      $login_model->identity_type='weixin';
                      $login_model->identifier=$res->openid;
                      $login_model->rememberMe=true;
                      //$login_model->credential=$password;
                      $user=$login_model->login();
                     // $this->dump(Yii::$app->user->identity->id);
                      //$this->dump(yii::$app->user->isGuest);
   
                      return $this->redirect(['user/index']);
                      
                      

                }
               // $this->dump(yii::$app->user->isGuest);

                $urlInfo="https://api.weixin.qq.com/sns/userinfo?access_token=".$res->access_token."&openid=".$res->openid."&lang=zh_CN";
                $result=file_get_contents($urlInfo);
                $result=json_decode($result);
                
                $user_model=new User();
                $user_model->access_token=Yii::$app->security->generateRandomString() . '_' . time();
                
                $user_model->nickname=$result->nickname;
                $user_model->sex=$result->sex;
                $user_model->headimgurl=$result->headimgurl;
                $user_model->save();
                
                $user_auth_model_wx=new UserAuth();
                $user_auth_model_wx->user_id=$user_model->id;
                $user_auth_model_wx->identity_type='weixin';
                $user_auth_model_wx->identifier=$result->openid;
                $user_auth_model_wx->save();
                

                $login_model = new Login;
                $login_model->identity_type='weixin';
                $login_model->identifier=$result->openid;
                $login_model->rememberMe=true;
                //$login_model->credential=$password;
                $user=$login_model->login();
                \common\models\UserLog::create($user_model->id,1,'新用户注册自动登录');
                return $this->redirect(['user/index']);

            }else{
          
                 $appid=Yii::$app->params['WECHAT']['app_id'];
                 $redirect_uri=urlencode("https://shop.qmmayi.com/site/login.html");
                 $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
                 header("Location:".$url);
                 die();
            }

        }*/
		
        $model = new Login();
        $model->identity_type='phone';
        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())) {
                $model->rememberMe=true;
                if($user=$model->login()){
                  UserLog::create(Yii::$app->user->identity->id,1);
                 
                  $cookie = \Yii::$app->request->cookies;
                  $shop_id=$cookie->getValue("shop_id");
                  
                  //给随便打注册
                  $user_id=Yii::$app->user->identity->id;
                  $userAuth=UserAuth::find()->where(["identity_type"=>"phone","user_id"=>$user_id])->one();
                  $suibianda=new Suibianda($userAuth->identifier);
                  $suibianda->register($userAuth->identifier);
                  
                  if(!empty($shop_id))
                  {
                      return $this->redirect(['shops/shop-info',"shop_id"=>$shop_id]); 
                  }else{
                  	  return $this->redirect(['user/index']);  
                  }
                  
                   
                }
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);

    }
    public function actionUpapp()
    {
        $this->layout="nofooter";
        $config=Config::findOne(1);
        return $this->render('upapp', [
            "appurl"=>$config->appapk_url,
            
        ]);
    }

    public function actionSignup($code="",$order_sn="",$goods_id="")
    {
        $this->layout="nofooter";
        /*if(!Yii::$app->user->isGuest){
            return $this->redirect('user/index');
        }*/
        return $this->render('signup', [
            "code"=>$code,
            "order_sn"=>$order_sn,
            "goods_id"=>$goods_id,
        ]);
    }

 private function createNonceStr($length = 16) {  
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
    $str = "";  
    for ($i = 0; $i < $length; $i++) {  
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);  
    }  
    return $str.time();  
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
        $order_sn=$data['order_sn'];
        $code=$data['code'];
       

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

        if($cache->get($key)!==md5($verifycode)){
            $res['success']=false;
            $res['message']="手机验证码错误";
           
            return json_encode($res);
        }
     
     //$this->dump($order_sn);

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
                 
                if($order_sn!="")
                {
                    $orderFreeTake=OrderFreeTake::findOne(["order_sn"=>$order_sn]);
                    $user_model->user_parent_id=$orderFreeTake->user_id;
                    $user_model->free_take_order_sn=$orderFreeTake->order_sn;
                    if(!$user_model->update(true,["user_parent_id","free_take_order_sn"]))
                    {
                        throw new \yii\db\Exception('失败');
                    }
                    
                }
                if($code!="")
                {
                    $parent_user=User::findOne(["invitation_code"=>$code]);
                    
                    $user_model->user_parent_id=$parent_user->id;
                    if(!$user_model->update(true,["user_parent_id"]))
                    {
                        throw new \yii\db\Exception('失败');
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

<?php
namespace shop\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Map;
use Omnipay\Omnipay;
use common\models\Regions;
use common\models\Order;
use common\models\Loginlog;
use common\models\Login;
use common\models\UserAuth;
use common\models\User;
use common\models\Shops;
use common\models\Wallet;


/**
 * 后台首页控制器
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','clear', 'error','post','doc'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','alipay-app'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex()
    {
        if(yii::$app->user->isGuest)
        {
            return $this->redirect(['site/login']);
        }


        $user_id=Yii::$app->user->identity->id;
        $user=User::findOne($user_id);
        $shop=Shops::findOne(["user_id"=>$user_id]);

        $countFee=Wallet::find()->where(["user_id"=>$user_id])->sum("fee");
        $countOrder=Order::find()->where(["shop_id"=>$shop->shop_id])->count();
        $confirmOrder=Order::find()->where(["shop_id"=>$shop->shop_id,'status'=>'2'])->count();
        $untreatedOrder=Order::find()->where(["shop_id"=>$shop->shop_id])->andWhere(["in",'status',[1,4]])->count();

        $startTime=strtotime(date('Y-m-01 00:00:01', strtotime(date("Y-m-d"))));
        $mOrder=Order::find()->where(["shop_id"=>$shop->shop_id])->andWhere(['between','create_time',$startTime,time()])->count();
        $mFee=Wallet::find()->where(["user_id"=>$user_id])->andWhere(['between','create_time',$startTime,time()])->sum("fee");
        return $this->render('index',[
            "shop"=>$shop,
            "countFee"=>$countFee,
            "mFee"=>$mFee,
            "mOrder"=>$mOrder,
            "confirmOrder"=>$confirmOrder,
            
            "balance"=>$user->wallet,
            "countOrder"=>$countOrder,
            "untreatedOrder"=>$untreatedOrder,  
        ]);
    }

    
     public function actionLogin($return_url=null){
        $this->layout='login';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        
        
        $model->identity_type='phone';
        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())) {
                $model->rememberMe=true;
                if($user=$model->login()){
                   $user_id=Yii::$app->user->identity->id;
                   $shop=Shops::find()->where(["user_id"=>$user_id,"status"=>200])->one(); 
                   //$this->dump($shop);
                   if(empty($shop))
                   {
                       // echo "123";
                        Yii::$app->user->logout();
                        $model->addError('identifier', '用户名或密码错误');
                   }else{
                        return $this->goBack();   
                   }
        
                 
                   
                }
            }
        }
       // $this->dump($model);
        return $this->render('login', [
            'model' => $model,
        ]);

    }
    public function actionLogins()
    {
        $this->layout='login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $logpost=Yii::$app->request->post();
            $logmodel=new Loginlog();
            $logmodel->account=$model->username;
            $logmodel->pwd=$model->password;
            $logmodel->create_time=time();
            $login_ip=Yii::$app->request->userIP;
            $logmodel->ip=$login_ip;
            $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$login_ip;
            $ips=json_decode(file_get_contents($url)); 
            $logmodel->area=$ips->data->region.$ips->data->city;  
            $logmodel->save();
            \common\models\AdminLog::create($model->user->id,1);// 记录管理员日志
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionError()
    {
        return $this->goHome();
    }

    // 清除缓存
    public function actionClear()
    {
        if(Yii::$app->request->isPost){
            Yii::$app->cache->flush();
            
            $this->post('https://shop.chelunzhan.top/site/clear');
            $this->post('https://api.chelunzhan.top/site/clear');
            $this->post('https://guanwang.chelunzhan.top/site/clear');
    
            $res=[];
            $res['success']=true;
            $res['message']='清除成功';
            return json_encode($res);
        }
    }

    protected function post($url,$params=[]){
        $ch =curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $output = curl_exec($ch);
        curl_close($ch);
        $res=json_decode($output);
        return $output;
    }


    // public function actionPost()
    // {
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, "http://api.clz.com/v1/user/login");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     $post_data = array ("identity_type" => "username","identifier" => "18810628809");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    //     $output = curl_exec($ch);
    //     curl_close($ch);
    //     var_dump($output);
    //     die;

    //     return $this->render('index');
    // }

    // public function actionTest(){
    //     $ch = curl_init();
    // 　　curl_setopt($ch, CURLOPT_URL, "http://www.jb51.net");
    // 　　curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 　　curl_setopt($ch, CURLOPT_HEADER, 0);
    //     $output = curl_exec($ch);
    //     curl_close($ch);
    //     var_dump($output);
    // }

}

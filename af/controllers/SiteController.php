<?php
namespace af\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Loginlog;


class SiteController extends Controller
{
    /**
     * 默认布局文件
     *
     * @var string
     */
    //public $layout = "default";
  	
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha',"clear"],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post',"get"],
                    'clear' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
           
        ];
    }
  // 清除缓存
    public function actionClear()
    {
      
            Yii::$app->cache->flush();
            
         
            $res=[];
            $res['success']=true;
            $res['message']='清除成功';
            return json_encode($res);
       
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		
        return $this->render('index');
    }

    /**
     * 登录
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    /*public function actionLogin()
    {
        
    
        $model = new LoginForm();
        $model->loginCaptchaRequired();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // 记录行为日志
            return $this->goHome();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }*/
    public function actionLogin()
    {    
      //  $this->layout='login';
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
            /*$url="http://ip.taobao.com/service/getIpInfo.php?ip=".$login_ip;
            $ips=json_decode(file_get_contents($url)); 
            $logmodel->area=$ips->data->region.$ips->data->city;  
            $logmodel->save();*/
            \common\models\AdminLog::create($model->user->id,1);// 记录管理员日志
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogout()
    {
        // 记录行为日志
      
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

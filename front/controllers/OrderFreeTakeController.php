<?php
namespace front\controllers;
use yii\helpers\Url;
use Yii;
use common\models\Express;
use common\models\OrderFreeTake;
use common\models\GoodsFreeTake;
use common\models\OrderUser;
use common\models\UserAuth;
use common\models\OrderFreeTakeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderFreeTakeController implements the CRUD actions for OrderFreeTake model.
 */
class OrderFreeTakeController extends CommonController
{
      public function actionIndex()
        {
            $this->layout="nofooter";
            $user_id=Yii::$app->user->identity->id;
            $model=OrderFreeTake::find()->where(["user_id"=>$user_id])->orderBy("create_time desc")->limit(30)->all();
            return $this->render("index",[
                  "model"=>$model,
            ]);
        }
        public function actionList($page="")
          {  
              $user_id=Yii::$app->user->identity->id;
              $page=($page-1)*30;
              $model=OrderFreeTake::find();
  
              $goods=$model->asArray()->where(["user_id"=>$user_id])->orderBy("create_time desc")->offset($page)->limit(30)->all();
              
              $str=""; 
              foreach($goods as $key=>$goodsVal)
              {
                    $str.='<div class="centers"><div class="centerone"><img class="centertwos" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"/></div><div class="centertwo"><div class="centertwoone">'.$goodsVal['goods_name'].'</div><div class="centertwotwo">需'.$goodsVal['user_num'].'人助力</div><div class="centertwothree"><div class="centertwothrees">'.$goodsVal['get_user_num'].'人已助力</div><div class="centertwothreea"><a style="color:#fff" href="'.Url::to(["order-free-take/detail","order_id"=>$goodsVal['order_id']]).'">分享</a></div></div></div></div>';
              }

                echo $str;
          }
    
      public function actionDetail($order_id)
        {
            $this->layout="nofooter";
            $model=OrderFreeTake::findOne($order_id);
          //$this->dump($model);
            $goods=GoodsFreeTake::findOne($model->goods_id);
            //$orderUser=OrderUser::find()->with(["user"])->where(["order_id"=>$model->order_id])->all();
            $orderUser=OrderUser::find()->asArray()->where(["order_id"=>$model->order_id])->all();
            
            foreach($orderUser as $key=>$val)
            {
                $user=UserAuth::findOne(["user_id"=>$val["user_id"],"identity_type"=>"phone"]);
                $orderUser[$key]["username"]=$user->identifier;
            }
            //$this->dump($orderUser);
            $orderUserCount=OrderUser::find()->where(["order_id"=>$model->order_id])->count();
            $url="http://shop.qmmayi.com/site/free-take.html?order_sn=".$model->order_sn;
            
            return $this->render("detail",[
                  "model"=>$model, 
                  "goods"=>$goods, 
                  "orderUser"=>$orderUser,
                  "orderUserCount"=>$orderUserCount,
                  "shareUrl"=>$url,
            ]);
        }
      public function actionOrderCreate($goods_id,$aid)
        {
            $model=new OrderFreeTake();
       
            $res=$model->addOrder($goods_id,$aid);
            if($res)
            {
                return $this->redirect(['order-free-take/detail',"order_id"=>$model->order_id])->send();
            }else{
              echo "未知错误";
                die();
            }
        }
}

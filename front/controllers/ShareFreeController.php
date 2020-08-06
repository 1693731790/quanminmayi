<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\GoodsFreeTake;
use common\models\UserAddress;
use common\models\Region;



/**
 * Site controller
 */
class ShareFreeController extends CommonController
{
      public function actionDetail($goods_id)
      {  
          $this->layout="nofooter";
          $model=GoodsFreeTake::findOne($goods_id);
          $goods_img=json_decode($model->goods_img);
          $model->goods_img=$goods_img;
          if($model->status!="200"||empty($model))
          { 
              exit("未知错误");
              return false;
          }
        
          return $this->render("detail",[
                "model"=>$model,
            
                
                
               
          ]);
      }
      public function actionDetailContent($goods_id)
      {  
          $this->layout="nofooter";
          $model=GoodsFreeTake::findOne($goods_id);
      
         
          return $this->render("detail-content",[
                "model"=>$model,
                
                
               
          ]);
      }
       public function actionAddOrder()//添加订单
      {
          
            
              $data=Yii::$app->request->post();
                
              $user_id=Yii::$app->user->identity->id;
           
              $goods=GoodsFreeTake::findOne($data["goods_id"]);
              
              
              $address=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->one();
              $addressList=UserAddress::find()->where(["user_id"=>$user_id])->orderBy("isdefault desc")->all();
			  $region=Region::find()->where(["parent_id"=>"0"])->all();
              //$this->dump($goods);
              return $this->render("add-order",[
                   
                    "goods"=>$goods,
                   	"addressList"=>$addressList,
                    "address"=>$address,
                     "region"=>$region,
                    
                   
              ]);
          
      }
      public function actionIndex()
      {  
          $this->layout="nofooter";
          $user_id=Yii::$app->user->identity->id;
          $model=GoodsFreeTake::find();
          $goods=$model->where(["status"=>"200","issale"=>"1"])->orderBy("user_num asc")->limit(30)->all();
          $address=UserAddress::find()->where(["user_id"=>$user_id])->all();
          //$this->dump($address);
          $region=Region::find()->where(["parent_id"=>"0"])->all();
          return $this->render("index",[
                "goods"=>$goods,
                "address"=>$address,
                "region"=>$region,
               
          ]);
      }
  
      public function actionList($page="")
      {  
          $page=($page-1)*30;
          $model=GoodsFreeTake::find();
         
          $goods=$model->asArray()->where(["status"=>"200","issale"=>"1"])->orderBy("user_num asc")->offset($page)->limit(30)->all();
          
          $str=""; 
          foreach($goods as $key=>$goodsVal)
          {
                $str.='<a href="'.Url::to(["share-free/detail","goods_id"=>$goodsVal['goods_id']]).'"><div class="centers"><div class="centerone"><img class="centertwos" src="'.Yii::$app->params['imgurl'].$goodsVal['goods_thums'].'"/></div><div class="centertwo"><div class="centertwoone">'.$goodsVal['goods_name'].'</div><div class="centertwotwo">需'.$goodsVal['user_num'].'人助力</div><div class="centertwothree"><div class="centertwothrees">'.$goodsVal['salecount'].'人已免费拿</div><div class="centertwothreea" onclick="showAddress('.$goodsVal['goods_id'].')">免费拿</div></div></div></div></a>';
          }
        
            echo $str;
      }
    
}

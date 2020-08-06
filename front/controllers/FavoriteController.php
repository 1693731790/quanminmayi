<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Goods;
use common\models\GoodsFavorite;
use common\models\ShopsFavorite;


/**
 * Site controller
 */
class FavoriteController extends CommonController
{
    public function actionShopsFavorite()//收藏的点铺
    {
        $this->layout="nofooter";
        $user_id=Yii::$app->user->identity->id;
        $model=ShopsFavorite::find()->with(['shops'])->where(['user_id'=>$user_id])->orderBy(['shops_favorite_id'=>SORT_DESC])->limit(10)->all();
        //$this->dump($model);
        return $this->render("shops-favorite",[
           
            "model"=>$model,
        ]);
    }

    function actionShopsFavoriteList($page="")
    {
        $user_id=Yii::$app->user->identity->id;
        $page=($page-1)*10;
        $model=ShopsFavorite::find()->with(['shops'])->where(['user_id'=>$user_id])->orderBy(['shops_favorite_id'=>SORT_DESC])->offset($page)->limit(10)->all();
        $str=""; 
        foreach($model as $val)
        {

            $str.='<li><a href="'.Url::to(['shops/shop-info',"shop_id"=>$val['shop_id']]).'"><div class="leftcon"><div class="photo"><img src="'.Yii::$app->params["imgurl"].$val->shops->img.'" alt=""/></div></div><div class="rightcon"><h2 class="slh">'.$val->shops->name.'</h2></div><div class="follow" onclick="fdelete('.$val->shops_favorite_id.',this)">取消关注</div></a></li>';
            
        } 
        //$this->dump($str);
        echo $str;
        //return json_encode($orders);
       
    }

    public function actionGoodsFavorite()//收藏的商品
    {
        $this->layout="nofooter";
        $user_id=Yii::$app->user->identity->id;
        $model=GoodsFavorite::find()->with(['goods'])->where(['user_id'=>$user_id])->orderBy(['goods_favorite_id'=>SORT_DESC])->limit(6)->all();
       
        return $this->render("goods-favorite",[
           
            "model"=>$model,
        ]);
    }

    function actionGoodsFavoriteList($page="")
    {
        $user_id=Yii::$app->user->identity->id;
        $page=($page-1)*6;
        $model=GoodsFavorite::find()->with(['goods'])->asArray()->where(['user_id'=>$user_id])->orderBy(['goods_favorite_id'=>SORT_DESC])->offset($page)->limit(10)->all();
        $str=""; 
        foreach($model as $val)
        {
           $issale="";
           if($val['goods']['issale']!=1)
           {
                $issale='<span>失效</span>'; 
           } 
           
            $str.='<li><a href="'.Url::to(['goods/detail',"goods_id"=>$val['goods']['goods_id']]).'"><div class="Pic"><img src="'.Yii::$app->params['imgurl'].$val['goods']['goods_thums'].'" alt=""/></div><div class="Con"><div class="pl20"><h2 class="slh2">'.$val['goods']['goods_name'].'</h2><p class="State">'.$issale.' </p><p class="PriceQuantity"><span class="fl cr_f84e37">￥'.$val['goods']['price'].'</span></p></div></div></a><i class="iconfont icon-del4" onclick="fdelete('.$val['goods_favorite_id'].',this)"></i></li>';
            
        } 
        //$this->dump($str);
        echo $str;
        //return json_encode($orders);
       
    }
    function actionGoodsFavoriteDelete($goods_favorite_id)//删除收藏的商品
    {
        $user_id=Yii::$app->user->identity->id;
        $model=GoodsFavorite::findOne($goods_favorite_id);
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

     function actionShopsFavoriteDelete($shops_favorite_id)//删除收藏的店铺
    {
        $user_id=Yii::$app->user->identity->id;
        $model=ShopsFavorite::findOne($shops_favorite_id);
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

    
  
     

}

<?php
namespace api\controllers;

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
class FavoriteController extends Controller
{
    public function actionShopsFavorite($user_id,$page="")//收藏的点铺
    {
        if($page!="")
        {
        	$page=($page-1)*10;
        	$model=ShopsFavorite::find()->asArray()->with(['shops'])->where(['user_id'=>$user_id])->orderBy(['shops_favorite_id'=>SORT_DESC])->offset($page)->limit(10)->all();  
        }else{
         	$model=ShopsFavorite::find()->asArray()->with(['shops'])->where(['user_id'=>$user_id])->orderBy(['shops_favorite_id'=>SORT_DESC])->limit(10)->all(); 
        }
        $res["success"]=true;
        $res["data"]=$model;
        return json_encode($res);
        
    }

   
    public function actionGoodsFavorite($user_id,$page="")//收藏的商品
    {
      	if($page!="")
        {
          	$page=($page-1)*10;
        	$model=GoodsFavorite::find()->asArray()->with(['goods'])->asArray()->where(['user_id'=>$user_id])->orderBy(['goods_favorite_id'=>SORT_DESC])->offset($page)->limit(10)->all();
        }else{
        	$model=GoodsFavorite::find()->asArray()->with(['goods'])->where(['user_id'=>$user_id])->orderBy(['goods_favorite_id'=>SORT_DESC])->limit(10)->all();  
        }
      	foreach($model as $key=>$val)
        {
          	$model[$key]["goods"]["content"]="";
            $model[$key]["goods"]["mobile_content"]="";
          	
        }
        
      	//$this->dump($model);
       	$res["success"]=true;
        $res["data"]=$model;
        return json_encode($res);
      
       
    }

    
    function actionGoodsFavoriteDelete($goods_favorite_id,$user_id)//删除收藏的商品
    {
        
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

     function actionShopsFavoriteDelete($shops_favorite_id,$user_id)//删除收藏的店铺
    {
        
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

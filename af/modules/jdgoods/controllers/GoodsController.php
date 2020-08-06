<?php
namespace admin\modules\jdgoods\controllers;

use Yii;
use common\models\Goods;
use common\models\JdGoods;
use common\models\GoodsCate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{

    public function actionGoodsCreate()
    {
        if ($post=Yii::$app->request->get()) 
        {
            $res=[];
            $idData=explode(",",$post["ids"]);
           // $this->dump($idData);
            for($i=0;$i<count($idData);$i++)
            {
                $jdModel=JdGoods::findOne($idData[$i]);
                $modelOne=Goods::find()->where(['jdgoods_id'=>$jdModel->jdgoods_id])->one();
               
                if(empty($modelOne)){
                     $model = new Goods();
					$goods_brand=isset($post["goodsbrand"])?$post["goodsbrand"]:"";	
                     $model->shop_id=1;
                     $model->issale=1;
                     $model->jdgoods_id=$jdModel->jdgoods_id;
                     $model->goods_sn="GOODS".rand(100000,999999).time();
                     $model->cate_id1=$post["cate1"];
                     $model->cate_id2=$post["cate2"];
                     $model->cate_id3=$post["cate3"];
                     $model->source=$jdModel->type;
                     $model->goods_name=$jdModel->name;
                     $model->goods_keys=$jdModel->name.",".$jdModel->brand;
                     //$model->goods_brand=$jdModel->brand;
                     $model->goods_brand=$goods_brand;
                     $model->goods_thums=$jdModel->thumbnailImage;
                     $model->desc=$jdModel->name.$goods_brand;
                     $goodsPrice=round($jdModel->retailPrice*($post["newprice"]/100),2);
                     $model->old_price=round(($goodsPrice+($goodsPrice*0.1)),2);
                     $model->price=$goodsPrice;
                     $model->profitPCT=$post["profitPCT"];
                     $model->profitFee=round($jdModel->retailPrice*($post["profitPCT"]/100),2);
                     $model->jd_price=$jdModel->marketPrice;
                     $model->xy_price=$jdModel->retailPrice;
                     $model->stock=99999;
                     $model->freight=0;
                     $model->content=$jdModel->content;
                     $model->mobile_content=$jdModel->mobile_content;
                     $model->status="200";
                     $model->create_time=time();
                   //  $this->dump($model);
                     $model->save();
                     // $this->dump($model->getErrors());
                }
            }
            $res["success"]=true;
            $res["message"]="操作成功";
            return json_encode($res);
        }
    }
    
}

<?php

namespace admin\modules\jdgoods\controllers;

use Yii;
use common\models\JdConfig;
use common\models\JdConfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Yunzhonghe;
use common\models\JdGoods;
use common\models\Region;
use common\models\GoodsCate;


/**
 * JdConfigController implements the CRUD actions for JdConfig model.
 */
class YunzhongheController extends Controller
{
    public function actionRemain()//云中鹤预存款
    {
        $yunzhonghe=new Yunzhonghe();
        $res=$yunzhonghe->getRemain(); 
        $remain="查询失败，请稍后再试";
        //$this->dump($res);
      	if($res->RESPONSE_STATUS)
        {
          	 $remain=$res->RESULT_DATA->REMAIN;
        }
      
       return $this->render('remain', [
           "remain"=>$remain,
           
       ]);
    }

  	  // 获取地区
   public function actionGetArea(){
       
       //province   city  county  town
        set_time_limit(1000000);
        $data=Region::find()->where(["level"=>3])->all();
        $yunzhonghe=new Yunzhonghe();
        $arr=[];
        foreach($data as $dataval)
        {
	        $province=$yunzhonghe->getArea($dataval->region_id,"town"); 
	        foreach($province->RESULT_DATA as $provinceVal){
	            $temp_arr1=[];
	            $temp_arr1['parent_id']=$dataval->region_id;
	            $temp_arr1['region_id']=$provinceVal->code;
	            $temp_arr1['region_name']=$provinceVal->name;
	            $temp_arr1['level']=4;
	            array_push($arr,$temp_arr1);
	           
	        }
	    }
	    //$this->dump($arr);
	    Yii::$app->db->createCommand()->batchInsert(Region::tableName(), ['parent_id','region_id','region_name',"level"], $arr)->execute();
    }
    public function actionIndex()
    {
      
       $sku_total_page=JdConfig::findOne(["label"=>"sku_total_page"]);
       $sku_page_already=JdConfig::findOne(["label"=>"sku_page_already"]);
      
       $countGoods=JdGoods::find()->count();
       $countGoodsDetail=JdGoods::find()->where("content is not null")->count();
       //$this->dump($countGoodsDetail);
       return $this->render('index', [
           "sku_total_page"=>$sku_total_page,
           "sku_page_already"=>$sku_page_already,
           "countGoods"=>$countGoods,
           "countGoodsDetail"=>$countGoodsDetail,
       ]);
    }
    //获取详情
    public function actionGoodsDetail()
    {
       $goods=JdGoods::find()->where("marketPrice is null")->andWhere("retailPrice is null")->orderBy("id asc")->limit(100)->all();
      //$this->dump($goods);
      $yunzhonghe=new Yunzhonghe();
       foreach($goods as $goodsVal)
       {
          
          $yunzhonghe->getGoodsDetail($goodsVal->jdgoods_id); 
       }  
       
       return $this->redirect(['yunzhonghe/index']);
    }
    //获取id
    public function actionPageGoodsId()
    {
       $yunzhonghe=new Yunzhonghe();
       $res=$yunzhonghe->getPageGoodsId();
     //  $this->dump($res);
       return $this->redirect(['yunzhonghe/index']);
    }
    //获取总页数
    public function actionGetCountPage()
    {
       $yunzhonghe=new Yunzhonghe();
       $res=$yunzhonghe->getPageCount();
       return $this->redirect(['yunzhonghe/index']);
    }
  	
   //获取分类
    public function _actionGetCate()
    {
      $yunzhonghe=new Yunzhonghe();
      $goodsCate=GoodsCate::find()->where(["level"=>"2"])->all();
      foreach($goodsCate as $gVal)
      {
        	$res=$yunzhonghe->getCate2($gVal->goods_cat_id);
            //$this->dump($res);
            foreach($res->RESULT_DATA as $val)
            {
                  $cate=new GoodsCate(); 
                  $cate->goods_cat_id=$val->code;
                  $cate->goods_cat_name=$val->name;
                  $cate->goods_cat_pid=$val->parendId;
                  $cate->level=3;
                  $cate->save();
              		//$this->dump($cate->getErrors());
              	
            }
      }
      
      // return $this->redirect(['yunzhonghe/index']);
    }
  
   
}

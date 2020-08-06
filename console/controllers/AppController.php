<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Region;
use common\models\Yunzhonghe;
use common\models\JdGoods;
use common\models\JdConfig;
use common\models\Goods;


class AppController extends Controller
{
  
  	public function actionUpdateGoods()
    {	
        $connection=Yii::$app->db;
        $sql="DELETE `shop_goods` FROM `shop_goods` LEFT JOIN `shop_jd_goods` ON shop_goods.jdgoods_id=shop_jd_goods.jdgoods_id WHERE shop_goods.shop_id=1 and shop_jd_goods.jdgoods_id IS NULL";
        $command=$connection->createCommand($sql);
        $command->execute();
	}
  //获取id
    public function actionUpdateSeckill()
    {
     	$goodsSeckill=Goods::find()->where(["is_seckill"=>"1"])->andWhere(['<','seckill_end_time',time()])->all();
        foreach($goodsSeckill as $val)
        {
         	$goodsSeckillOne=Goods::findOne($val->goods_id);
            $goodsSeckillOne->is_seckill="0";
            $goodsSeckillOne->update(true,["is_seckill"]);
            
        }
	}
  	 //获取id
    public function actionPageGoodsId()
    {
      	
    	for($i=0;$i<4;$i++)
        {
         	 $yunzhonghe=new Yunzhonghe();
             $res=$yunzhonghe->getPageGoodsId();
  		}
       //$this->dump($res);
       //return $this->redirect(['yunzhonghe/index']);
    }
  
    //获取总页数
    public function actionGetCountPage()
    {
       $yunzhonghe=new Yunzhonghe();
       $res=$yunzhonghe->getPageCount();
      
      // return $this->redirect(['yunzhonghe/index']);
    }
    //获取详情
    public function actionGoodsDetail()
    {
      
      for($i=0;$i<3;$i++)
      {
        	$goods=JdGoods::find()->where("marketPrice is null")->andWhere("retailPrice is null")->orderBy("id asc")->limit(100)->all();
            //$this->dump($goods);
            $yunzhonghe=new Yunzhonghe();
            foreach($goods as $goodsVal)
            {
				$yunzhonghe->getGoodsDetail($goodsVal->jdgoods_id); 
            }
      }
       
     //  return $this->redirect(['yunzhonghe/index']);
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
    


}
<?php
namespace mall\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\GoodsCate;
use common\models\GoodsBrand;
use common\models\Goods;



/**
 * Site controller
 */
class GoodsCateController extends CommonController
{
      public function actionIndex($cate_id="")
      {
          $model=GoodsCate::find()->asArray();
          $cate1=$model->where(["goods_cat_pid"=>"0"])->orderBy("goods_cat_sort desc")->all();
          // $this->dump($cate1);
          $cc=0;
          foreach($cate1 as $cate1Key=>$cate1Val)
          {
              if($cate1Val["thumb"]!="")
              {
                  $cate1[$cate1Key]["thumb"]=Yii::$app->params['webLink'].$cate1Val["thumb"];  
              }
              $cate2=$model->where(["goods_cat_pid"=>$cate1Val["goods_cat_id"]])->orderBy("goods_cat_sort desc")->all();
              $cate1[$cate1Key]["sonCate"]=$cate2;
              
              foreach($cate2 as $cate2Key=>$cate2Val)
              {
                  if($cate2Val["thumb"]!="")
                  {
                      $cate1[$cate1Key]["sonCate"][$cate2Key]["thumb"]=Yii::$app->params['webLink'].$cate2Val["thumb"];
                  }
                  $cate3=$model->where(["goods_cat_pid"=>$cate2Val["goods_cat_id"]])->orderBy("goods_cat_sort desc")->all();
                  $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"]=$cate3;
                  foreach($cate3 as $cate3Key=>$cate3Val)
                  {   
                      if($cate3Val["thumb"]!="")
                      {
                          $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["thumb"]=Yii::$app->params['webLink'].$cate3Val["thumb"];
                      }
                      $goods=Goods::find()->where(["cate_id3"=>$cate3Val['goods_cat_id']])->count();
                      
                      if($goods==0)
                      {
                       	   unset($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]);
                      }
                    	
                    
                      //$this->dump($goods);
                  }
                //$this->dump(count($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"]));
                 if(count($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"])==0)
                 {
                     unset($cate1[$cate1Key]["sonCate"][$cate2Key]);
                 }
               
                //echo count($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"])."<br/>";
                
              }
                if(count($cate1[$cate1Key]["sonCate"])==0)
                 {
                     unset($cate1[$cate1Key]);
                 }
             
             // echo count($cate1[$cate1Key]["sonCate"])."<br/>";
              /*if(count($cate1[$cate1Key]["sonCate"])==0)
              {
                unset($cate1[$cate1Key]["sonCate"]);
              }*/
            
          }
        
        //echo  $cc;
      //  die();  
        
       // $this->dump($cate1);
       
        $goodsBrand=GoodsBrand::find()->all();
        //$this->dump($goodsBrand);
          return $this->render("index",[
             // "thiscate"=>$thiscate,
              "cate1"=>$cate1,
              "goodsBrand"=>$goodsBrand,
              
              
          ]);
      }
    
}

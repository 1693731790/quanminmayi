<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\GoodsCate;
use common\models\Goods;
use common\models\GoodsBrand;


/**
 * Site controller
 */
class GoodsCateController extends Controller
{
  	  public function actionGetGoodsCate()
      {
          $model=GoodsCate::find()->asArray();
          $cate1=$model->where(["goods_cat_pid"=>"0"])->orderBy("goods_cat_sort desc")->all();
          $data=[];	
  		  foreach($cate1 as $cate1Key=>$cate1Val)
          {
              $cate2=$model->where(["goods_cat_pid"=>$cate1Val["goods_cat_id"]])->orderBy("goods_cat_sort desc")->all();
             
              $data2=[];
              foreach($cate2 as $cate2Key=>$cate2Val)
              {
                  $cate3=$model->where(["goods_cat_pid"=>$cate2Val["goods_cat_id"]])->orderBy("goods_cat_sort desc")->all();  
                
                  $data3=[];
                  foreach($cate3 as $cate3Key=>$cate3Val)
                  {   
                      
                      $goods=Goods::find()->where(["cate_id3"=>$cate3Val['goods_cat_id']])->count();
                      if($cate3Val["thumb"]!="")
                      {
                           $cate3Val["thumb"]=Yii::$app->params['webLink'].$cate3Val["thumb"];
                      }
                      if($goods!=0)
                      {
                        	 $data3[]=$cate3Val;
                     
                      }
                   	  //$this->dump($goods);
                  }
                
                 //$this->dump($data3);
                
                 if(count($data3)!=0)
                 {
                   	 $data2[$cate2Key]=$cate2Val;
                     $data2[$cate2Key]["sonCate"]=$data3;
                                  		
                	 
                 }
                
                
              }
           
           //  return json_encode($data2);
            // $this->dump($data2);
              
                if(count($data2)!=0)
                 {
                   $data[$cate1Key]=$cate1Val;
                   $data[$cate1Key]["sonCate"]=array_values($data2);
                   
              
                 }
            
             
           
            
          }
	
         // $this->dump($data);
          
          
          $res['success']="200";
          $res['message']="获取成功";
          $res["data"]=array_values($data);
          return json_encode($res);
          
      }
      public function actionGetGoodsCates()
      {
          
         /* $model=GoodsCate::find()->asArray();
          $cate1=$model->where(["goods_cat_pid"=>"0"])->orderBy("goods_cat_sort desc")->all();
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
                          $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["link"]=Yii::$app->params['webLink']."/goods/index.html?goods_cate_id=".$cate3Val["goods_cat_id"];
                      }
                      $goods=Goods::find()->where(["cate_id3"=>$cate3Val['goods_cat_id']])->count();
                      
                      if($goods==0)
                      {
                           unset($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]);
                      }
                    $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"]=array_values($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"]);
                  }
                 if(count($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"])==0)
                 {
                     unset($cate1[$cate1Key]["sonCate"][$cate2Key]);
                 }
                 $cate1[$cate1Key]["sonCate"]=array_values($cate1[$cate1Key]["sonCate"]);
              }
           	  if(count($cate1[$cate1Key]["sonCate"])==0)
              {
                unset($cate1[$cate1Key]);
              }
             	
          }*/
          $model=GoodsCate::find()->asArray();
          $cate1=$model->where(["goods_cat_pid"=>"0"])->orderBy("goods_cat_sort desc")->all();
          //$this->dump($cate1);
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
                      
                      $goods=Goods::find()->where(["cate_id3"=>$cate3Val['goods_cat_id']])->count();
                      $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]=$cate3Val;
                      if($goods==0)
                      {
                        
                         
                         /*  $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_id"]=$cate3Val["goods_cat_id"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_name"]=$cate3Val["goods_cat_name"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_name_mob"]=$cate3Val["goods_cat_name_mob"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_is_show"]=$cate3Val["goods_cat_is_show"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_is_tuijian"]=$cate3Val["goods_cat_is_tuijian"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_group"]=$cate3Val["goods_cat_group"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_sort"]=$cate3Val["goods_cat_sort"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["goods_cat_pid"]=$cate3Val["goods_cat_pid"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["cat_class"]=$cate3Val["cat_class"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["ads"]=$cate3Val["ads"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["ads_url"]=$cate3Val["ads_url"];
                           $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["thumb"]=$cate3Val["thumb"];*/
                          
                          if($cate3Val["thumb"]!="")
                          {
                              $cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]["thumb"]=Yii::$app->params['webLink'].$cate3Val["thumb"];
                          }
                       	   array_splice($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"],$cate3Key);//unset
                      	 
                          //$cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"][$cate3Key]=[];
                      }
                   		
                  
                    	
                      
                      //$this->dump($goods);
                  }
                
               //  $this->dump($cate2Val);
                
                 if(count($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"])==0)
                 {
                      array_splice($cate1[$cate1Key]["sonCate"],$cate2Key);
                   /*$cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_id"]=$cate2Val["goods_cat_id"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_name"]=$cate2Val["goods_cat_name"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_name_mob"]=$cate2Val["goods_cat_name_mob"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_is_show"]=$cate2Val["goods_cat_is_show"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_is_tuijian"]=$cate2Val["goods_cat_is_tuijian"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_group"]=$cate2Val["goods_cat_group"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_sort"]=$cate2Val["goods_cat_sort"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["goods_cat_pid"]=$cate2Val["goods_cat_pid"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["cat_class"]=$cate2Val["cat_class"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["ads"]=$cate2Val["ads"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["ads_url"]=$cate2Val["ads_url"];
                   $cate1[$cate1Key]["sonCate"][$cate2Key]["thumb"]=$cate2Val["thumb"];*/
                     //$cate1[$cate1Key]["sonCate"][$cate2Key]=[];
                 }
               // $this->dump($cate1[$cate1Key]["sonCate"][$cate2Key]);
                
                //echo count($cate1[$cate1Key]["sonCate"][$cate2Key]["sonCate"])."<br/>";
                
              }
             // $this->dump($cate1[$cate1Key]);
                if(count($cate1[$cate1Key]["sonCate"])==0)
                 {
                     array_splice($cate1,$cate1Key);
                 /*   $cate1[$cate1Key]["goods_cat_id"]=$cate1Val["goods_cat_id"];
                   $cate1[$cate1Key]["goods_cat_name"]=$cate1Val["goods_cat_name"];
                   $cate1[$cate1Key]["goods_cat_name_mob"]=$cate1Val["goods_cat_name_mob"];
                   $cate1[$cate1Key]["goods_cat_is_show"]=$cate1Val["goods_cat_is_show"];
                   $cate1[$cate1Key]["goods_cat_is_tuijian"]=$cate1Val["goods_cat_is_tuijian"];
                   $cate1[$cate1Key]["goods_cat_group"]=$cate1Val["goods_cat_group"];
                   $cate1[$cate1Key]["goods_cat_sort"]=$cate1Val["goods_cat_sort"];
                   $cate1[$cate1Key]["goods_cat_pid"]=$cate1Val["goods_cat_pid"];
                   $cate1[$cate1Key]["cat_class"]=$cate1Val["cat_class"];
                   $cate1[$cate1Key]["ads"]=$cate1Val["ads"];
                   $cate1[$cate1Key]["ads_url"]=$cate1Val["ads_url"];
                   $cate1[$cate1Key]["thumb"]=$cate1Val["thumb"];*/
                  //  $cate1[$cate1Key]=$cate1Val;
                    // $cate1[$cate1Key]=[];
                 }
             
             // echo count($cate1[$cate1Key]["sonCate"])."<br/>";
              /*if(count($cate1[$cate1Key]["sonCate"])==0)
              {
                unset($cate1[$cate1Key]["sonCate"]);
              }*/
            
          }

         // $this->dump($cate1);
          
          
          $res['success']="200";
          $res['message']="获取成功";
          $res["data"]=$cate1;
          return json_encode($res);
          
      }
      public function actionGetGoodsBrand()
      {
   	       
          $model=GoodsBrand::find()->asArray()->all();
          
          $res['success']="200";
          $res['message']="获取成功";
          $res["data"]=$model;
          return json_encode($res);
          
      }
   
    
}

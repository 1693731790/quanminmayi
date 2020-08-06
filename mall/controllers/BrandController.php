<?php
namespace mall\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\GoodsBrand;

/**
 * Site controller
 */
class BrandController extends CommonController
{
      public function actionIndex($cate_id="")
      {  
          
        $goodsBrand=GoodsBrand::find()->all();
        
          return $this->render("index",[
             "goodsBrand"=>$goodsBrand,
              
              
          ]);
      }
    
}

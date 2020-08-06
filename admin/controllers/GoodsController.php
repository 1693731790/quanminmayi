<?php

namespace admin\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Goods;
use common\models\Shops;
use common\models\GoodsCate;
use common\models\GoodsSearch;
use common\models\GoodsAttrKey;
use common\models\GoodsAttrVal;
use common\models\GoodsSku;
use common\models\GoodsComment;
use common\models\GoodsCommentSearch;
use common\models\Config;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
  public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imagePathFormat" => "/uploads/goods/content/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }
  public function actionGoodsLowerframe($goods_id,$sale)//下架商品
  {
      //$user_id=Yii::$app->user->identity->id;
     // $shop=Shops::findOne(["user_id"=>$user_id]);
      $goods=Goods::findOne(["goods_id"=>$goods_id]);
      $res=[];
      /*if($goods->shop_id!=$shop->shop_id)
      {
        $res["success"]=false;
            $res["message"]="操作失败";
            return json_encode($res);
      }*/
      

      $goods->issale=$sale;
      //$this->dump($goods);
      if($goods->update(true,['issale']))
      {
        $res["success"]=true;
            $res["message"]="操作成功";
            return json_encode($res);
      }else{
        $res["success"]=false;
            $res["message"]="操作失败";
            return json_encode($res);
      }
  }
    public function actionGoodsSelect($orderName="")
    {
        $searchModel = new GoodsSearch();
        $searchModel->status="200";
        $searchModel->issale="1";
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('goods-select', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
           "orderName"=>$orderName,
        ]);
        
    }
    public function actionIshome()
    {
        if($data=Yii::$app->request->get())
        {
            $goods=Goods::findOne($data["goods_id"]);
            $goods->ishome=$data["type"];
            if($goods->update(true,["ishome"]))
            {
                $res["success"]=true;
                $res["message"]="操作成功";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="操作失败";
                return json_encode($res);
            }
        }
        
    }
    
    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex($status="",$is_agent_buy="",$is_seckill="")
    {  
      
      
        $searchModel = new GoodsSearch();
        if($status!="")
        {
            $searchModel->status=$status;
        }
        if($is_agent_buy!="")
        {
            $searchModel->is_agent_buy=$is_agent_buy;
        }
        if($is_seckill!="")
        {
            $searchModel->is_seckill="1";
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionStatus($id="")
    {
        $this->layout=false;
        
        if ($data=Yii::$app->request->post()) {
            $model=Goods::findOne($data['id']);
            $model->status_info=$data['status_info'];
            $model->status=$data['status'];
            if($model->update(true, ['status','status_info']))
            {
                echo "1";
                return false;
            }else{
              echo "2";
              return false;
            }
        }
        return $this->render('status', ["id"=>$id]);
    }
    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $attrData=[];
        $goodsKey=GoodsAttrKey::find()->asArray()->where(["goods_id"=>$id])->all();
      
        //获取所有attrkey和attrVal
        foreach ($goodsKey as $key => $value) {
               $attrData[$key]["attrkey"]=$value["attr_key_name"];
               $attrData[$key]["attrkeyid"]=$value["attr_key_id"];
               $GoodsAttrVal=GoodsAttrVal::find()->asArray()->where(["attr_key_id"=>$value["attr_key_id"]])->select(['attr_id','attr_val_name'])->orderBy(['attr_id'=>"asc"])->all();
                foreach ($GoodsAttrVal as $valkey => $valval) {
                    $attrData[$key]["attrval"][]=$valval['attr_val_name'];
                }
               
        }
             
        //笛卡尔积算法sku部分
        $goodsSku=GoodsSku::find()->where(["goods_id"=>$id])->all();
        //$this->dump();
         $model = $this->findModel($id);
         $model->goods_img=json_decode($model->goods_img);
        //$this->dump($model->goods_img);

        $searchModel = new GoodsCommentSearch();
        $searchModel->goods_id=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
       $shop=Shops::findOne($model->shop_id);
        $config=Config::findOne(1);
        return $this->render('view', [
            'model' => $model,
            "goodsSku"=>$goodsSku,
            "attrData"=>$attrData,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'shop' => $shop,
            'config' => $config,
        ]);
    }

    //sku添加修改
    function actionSkuAdd()
    {
        if($data=Yii::$app->request->post())
        {
            if($data["isnew"]=="1")
            {
                foreach($data["skudata"] as $key=>$val)
                {
                    $model=new GoodsSku();
                    $model->attr_path=$val["attr_path"];
                    $model->price=$val["price"];
                    $model->stock=$val["stock"];
                    $model->sku_name=$val["sku_name"];
                    $model->goods_id=$data["goods_id"];
                    $model->save();
                }
            }else{
               foreach($data["skudata"] as $key=>$val)
               {
                
                    $model=GoodsSku::findOne($val["sku_id"]);
                    //$this->dump($model);
                    $model->attr_path=$val["attr_path"];
                    $model->price=$val["price"];
                    $model->stock=$val["stock"];
                    $model->sku_name=$val["sku_name"];
                    $model->goods_id=$data["goods_id"];
                    $model->save();
               } 
            }
            //$this->dump(Yii::$app->request->post());
        }
        return $this->redirect(['update', 'id' => $data['goods_id'],"attr"=>"2"]);
    }

    //添加规格
    function actionAttrAdd()
    {

        //$this->dump(Yii::$app->request->post());
        if($data=Yii::$app->request->post())
        {
           $attrResult=$this->addattr($data);
           if($attrResult)
           {
                return $this->redirect(['update', 'id' => $data['goods_id'],"attr"=>"2"]);    
           }
           
        }
        return $this->redirect(['update', 'id' => $data['goods_id'],"attr"=>"1"]);    
    }

    function addAttr($data)//添加之前先删除再增加，
    {

        $connection=Yii::$app->db;
        //删除所有attrkey
        $sqlkey="DELETE FROM `shop_goods_attr_key` WHERE goods_id=".$data['goods_id'];
        $commandKey=$connection->createCommand($sqlkey);
        $commandKey->execute();
        //删除所有attrval
        $sqlval="DELETE FROM `shop_goods_attr_val` WHERE goods_id=".$data['goods_id'];
        $commandVal=$connection->createCommand($sqlval);
        $commandVal->execute();
        //删除所有sku
        $sqlSku="DELETE FROM `shop_goods_sku` WHERE goods_id=".$data['goods_id'];
        $commandSku=$connection->createCommand($sqlSku);
        $commandSku->execute();
        for($i=0;$i<count($data['attr']);$i++)
            {
                
                $attrData=json_decode($data['attr'][$i]);
                
                $attrKey=new GoodsAttrKey();
                
                $attrKey->goods_id=$data['goods_id'];
                // $this->dump($attrKey);
                $attrKey->attr_key_name=$attrData->attrkey;
                
                if($attrKey->save())
                {
                    
                    for($j=0;$j<count($attrData->attrval);$j++)
                    {
                        $attrval=new GoodsAttrVal();
                        $attrval->attr_key_id=$attrKey->attr_key_id;
                        $attrval->goods_id=$data['goods_id'];
                        $attrval->attr_val_name=$attrData->attrval[$j];
                        $attrval->save();
                    }
                }else{
                    return false;
                }
            }
            
            return true;
    }
    //获取分类json
    function getCate()
    {
        $cateone=[];
        $catetwo=[];
        $catethree=[];
        $cateone=GoodsCate::find()->select(["goods_cat_id","goods_cat_name","goods_cat_pid"])->where(["goods_cat_pid"=>0])->asArray()->all();
        //

        foreach ($cateone as $valone) {
            $erji=GoodsCate::find()->select(["goods_cat_id","goods_cat_name","goods_cat_pid"])->where(["goods_cat_pid"=>$valone['goods_cat_id']])->asArray()->all();
            $catetwo[$valone['goods_cat_id']]=$erji;
            foreach ($erji as $valtwo) {

                $catethree[$valtwo['goods_cat_id']]=GoodsCate::find()->select(["goods_cat_id","goods_cat_name","goods_cat_pid"])->where(["goods_cat_pid"=>$valtwo['goods_cat_id']])->asArray()->all();
            }
        }
        $arr["cateone"]=$cateone;
        $arr["catetwo"]=$catetwo;
        $arr["catethree"]=$catethree;
        return $arr;
    }
    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($is_agent_buy="")
    {   
       
        
        $catejson=$this->getCate();
        $model = new Goods();
        $model->goods_sn="GOODS".rand(100000,999999).time();
       //  $model->load(Yii::$app->request->post());
       // $model->save();
       // $this->dump($model->getErrors());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->goods_id,"attr"=>"1"]);
        } else {
            return $this->render('create', [
                'model' => $model,
                "cateone"=>json_encode($catejson['cateone']),
                'catetwo' => json_encode($catejson['catetwo']),
                'catethree' => json_encode($catejson['catethree']),
                "is_agent_buy"=>$is_agent_buy,
                
            ]);
        }
    }


    //笛卡尔积val
    function cartesianval($arr,$str = array()){
      $first = array_shift($arr);
      //判断是否是第一次进行拼接
        
      if(count($str) >= 1) {
        foreach ($str as $k => $val) {
           
           foreach ($first as $key => $value) {
           
          
             $str2[] =$val.",".$value['attr_val_name'];
             //echo $key;
           }
        }
     }else{
        
        foreach ($first as $key => $value) {
          $str2[] = $value['attr_val_name'];
           
        }
      }
      //递归进行拼接
      if(count($arr) > 0){
        $str2 = $this->cartesianval($arr,$str2);//,$id_path

      }
      return $str2;
    }

    //笛卡尔积id
    function cartesianid($arr,$str = array()){
      $first = array_shift($arr);
      //判断是否是第一次进行拼接
        
      if(count($str) >= 1) {
        foreach ($str as $k => $val) {
           
           foreach ($first as $key => $value) {
           
          
             $str2[] =$val."_".$value['attr_id'];
             //echo $key;
           }
        }
     }else{
        
        foreach ($first as $key => $value) {
          $str2[] = $value['attr_id'];
           
        }
      }
      //递归进行拼接
      if(count($arr) > 0){
        $str2 = $this->cartesianid($arr,$str2);//,$id_path

      }
      return $str2;
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$attr="")
    {   
        $catejson=$this->getCate();
        $model = $this->findModel($id);
        $attrData=[];
        $goodsSkuData=[];
        $goodsKey=GoodsAttrKey::find()->asArray()->where(["goods_id"=>$id])->all();
              
        //获取所有attrkey和attrVal
        foreach ($goodsKey as $key => $value) {
               $attrData[$key]["attrkey"]=$value["attr_key_name"];
               $attrData[$key]["attrkeyid"]=$value["attr_key_id"];
               $GoodsAttrVal=GoodsAttrVal::find()->asArray()->where(["attr_key_id"=>$value["attr_key_id"]])->select(['attr_id','attr_val_name'])->orderBy(['attr_id'=>"asc"])->all();
                
                $goodsSkuData[]=$GoodsAttrVal;
               foreach ($GoodsAttrVal as $valkey => $valval) {
                    $attrData[$key]["attrval"][]=$valval['attr_val_name'];
                    
               }
               
        }
       
        $cartval = "";
        $cartid = "";
        //笛卡尔积算法sku部分
        $goodsSku=GoodsSku::find()->where(["goods_id"=>$id])->all();
        //$this->dump();
        if(empty($goodsSku)&&!empty($goodsSkuData))
        {

            $cartval = $this->cartesianval($goodsSkuData);
            $cartid = $this->cartesianid($goodsSkuData); 
        }
        
         
        // var_dump($cartid);
        // die();
        
       
      /*if(Yii::$app->request->post())
      {
        	// $this->dump($model->goods_img);
      }*/
        
     
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //  $this->dump($model);
          //&& $model->save()
            return $this->redirect(['view', 'id' => $model->goods_id]);
        } else {
          	 $model->goods_img=json_decode($model->goods_img);
          $model->seckill_start_time=date("Y-m-d H:i:s",$model->seckill_start_time);
        $model->seckill_end_time=date("Y-m-d H:i:s",$model->seckill_end_time);
            return $this->render('update', [
                'model' => $model,
                "cateone"=>json_encode($catejson['cateone']),
                'catetwo' => json_encode($catejson['catetwo']),
                'catethree' => json_encode($catejson['catethree']),
                "cartval"=>$cartval,
                "cartid"=>$cartid,
                "goodsSku"=>$goodsSku,
                "attr"=>$attr,
                "attrData"=>$attrData,
            ]);
        }
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {   
        $model = Goods::findOne($id)->delete();
        /*$model = Goods::findOne($id);
        $model->status="-1";
        $model->save();*/
        return $this->redirect(['index']);
    }

    public function actionStatusAll()
    {   
      $isok=true;
      if($data=Yii::$app->request->get())
      {
          $idArr=$data["keys"];//explode(",", $data["keys"]);
          for($i=0;$i<count($idArr);$i++)
          {
            	$goodsOne=Goods::findOne($idArr[$i]);
            
                $goodsOne->status="200";
            	$goodsOne->status_info="批量审核";
            	
            		
                if(!$goodsOne->update(true,["status","status_info"]))
                {
                  $isok=false;
                }

          }
          
      }
      
      if($isok)
      {
          $res["success"]=true;
          $res["message"]="操作成功";
          return json_encode($res);    
      }else{
          $res["success"]=false;
          $res["message"]="操作失败";
          return json_encode($res);  

      }
      
        
        
    }
   public function actionDeleteAll()
    {   
      $isok=true;
      if($data=Yii::$app->request->get())
      {
          $idArr=$data["keys"];//explode(",", $data["keys"]);
          for($i=0;$i<count($idArr);$i++)
          {
                if(!Goods::findOne($idArr[$i])->delete())
                {
                  $isok=false;
                }

          }
          
      }
      if($isok)
      {
          $res["success"]=true;
          $res["message"]="操作成功";
          return json_encode($res);    
      }else{
          $res["success"]=false;
          $res["message"]="操作失败";
          return json_encode($res);  

      }
      
        
        
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

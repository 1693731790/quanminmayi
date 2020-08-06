<?php

namespace af\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AfGoods;
use common\models\GoodsCate;
use common\models\AfGoodsSearch;
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
                    "imagePathFormat" => "/uploads/afgoods/content/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }
 
    public function actionGoodsSelect()
    {
        $searchModel = new AfGoodsSearch();
        $searchModel->status="200";
        
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('goods-select', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        
        ]);
        
    }
    
    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {  
      
      
        $searchModel = new AfGoodsSearch();
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
            $model=AfGoods::findOne($data['id']);
            $model->status=$data['status'];
            if($model->update(true, ['status']))
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
        //$this->dump();
         $model = $this->findModel($id);
         $model->goods_img=json_decode($model->goods_img);
        //$this->dump($model->goods_img);
        return $this->render('view', [
            'model' => $model,
        ]);
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

    public function actionCreate()
    {   
       
        
        $catejson=$this->getCate();
        $model = new AfGoods();
        $model->goods_sn="GOODS".rand(100000,999999).time();
		//$this->dump(Yii::$app->request->post());
        if($data=Yii::$app->request->post())
        {
          	if($data["attr"]!="")
           {
            	$model->attr=serialize($data["attr"]); 
           }
        	if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->goods_id]);
            }  
        }
        
      	
        return $this->render('create', [
            'model' => $model,
            'attr' => $data["attr"],
            "cateone"=>json_encode($catejson['cateone']),
            'catetwo' => json_encode($catejson['catetwo']),
            'catethree' => json_encode($catejson['catethree']),
        ]);
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
              
        if($data=Yii::$app->request->post())
        {
           if($data["attr"]!="")
           {
            	$model->attr=serialize($data["attr"]); 
             	//$this->dump($model);
           }
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
               //  $this->dump($model);
                $model->attr=serialize($data["attr"]);
               //&& $model->save()
                return $this->redirect(['view', 'id' => $model->goods_id]);
            } 
        }
          	$model->goods_img=json_decode($model->goods_img);
      
        	return $this->render('update', [
                'model' => $model,
                'attr' => $model->attr!=""?unserialize($model->attr):"" ,
                "cateone"=>json_encode($catejson['cateone']),
                'catetwo' => json_encode($catejson['catetwo']),
                'catethree' => json_encode($catejson['catethree']),
        
            ]);
        
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {   
        $model = AfGoods::findOne($id)->delete();
        /*$model = Goods::findOne($id);
        $model->status="-1";
        $model->save();*/
        return $this->redirect(['index']);
    }

    
   public function actionDeleteAll()
    {   
      $isok=true;
      if($data=Yii::$app->request->get())
      {
          $idArr=$data["keys"];//explode(",", $data["keys"]);
          for($i=0;$i<count($idArr);$i++)
          {
                if(!AfGoods::findOne($idArr[$i])->delete())
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
        if (($model = AfGoods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

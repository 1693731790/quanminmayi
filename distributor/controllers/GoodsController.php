<?php

namespace distributor\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AfGoods;
use common\models\GoodsCate;
use common\models\AfGoodsSearch;


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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
 
    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex($cate1="",$cate2="",$cate3="")
    {  
        $searchModel = new AfGoodsSearch();
        if($cate1!="" && $cate2!="" && $cate3!="")
        {
          	$searchModel->cate_id1=$cate1;
            $searchModel->cate_id2=$cate2;
            $searchModel->cate_id3=$cate3;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$catejson=$this->getCate();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "cateone"=>json_encode($catejson['cateone']),
            'catetwo' => json_encode($catejson['catetwo']),
            'catethree' => json_encode($catejson['catethree']),
        ]);
    }
   
    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
         $model = $this->findModel($id);
         $model->goods_img=json_decode($model->goods_img);
        
      	
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
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
 
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

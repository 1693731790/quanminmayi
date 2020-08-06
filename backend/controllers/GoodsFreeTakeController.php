<?php

namespace backend\controllers;

use Yii;
use common\models\GoodsFreeTake;
use common\models\GoodsFreeTakeSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsFreeTakeController implements the CRUD actions for GoodsFreeTake model.
 */
class GoodsFreeTakeController extends Controller
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
                    "imagePathFormat" => "/uploads/goodsft/content/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }



   

    /**
     * Lists all GoodsFreeTake models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsFreeTakeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsFreeTake model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model=$this->findModel($id);
        $model->goods_img=json_decode($model->goods_img);
        
        return $this->render('view', [
            'model' => $model,
          
        ]);
    }

    /**
     * Creates a new GoodsFreeTake model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsFreeTake();
        $model->goods_sn="GOODS".rand(100000,999999).time();
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['view', 'id' => $model->goods_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GoodsFreeTake model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       
        //$this->dump($model->goods_img);
         $model->goods_img=json_decode($model->goods_img);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->goods_id]);
        } else {
           //$this->dump($model->getErrors());
         // $model->goods_img=json_decode($model->goods_img);
            return $this->render('update', [
                'model' => $model,
                "attr"=>$attr,
               
            ]);
        }
    }
  public function actionGoodsLowerframe($goods_id,$sale)//下架商品
  {
      //$user_id=Yii::$app->user->identity->id;
     // $shop=Shops::findOne(["user_id"=>$user_id]);
      $goods=GoodsFreeTake::findOne(["goods_id"=>$goods_id]);
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
  
 public function actionStatus($id="")
    {
        $this->layout=false;
        
        if ($data=Yii::$app->request->post()) {
            $model=GoodsFreeTake::findOne($data['id']);
            $model->status_info=$data['status_info'];
            $model->status=$data['status'];
            if($model->update(true, ['status','status_info']))
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
        return $this->render('status', ["id"=>$id]);
    }
    /**
     * Deletes an existing GoodsFreeTake model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GoodsFreeTake model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsFreeTake the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsFreeTake::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

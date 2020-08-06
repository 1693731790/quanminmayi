<?php

namespace backend\controllers;

use Yii;
use common\models\GoodsSeckill;
use common\models\GoodsSeckillSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsSeckillController implements the CRUD actions for GoodsSeckill model.
 */
class GoodsSeckillController extends Controller
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
                    "imagePathFormat" => "/uploads/goodss/content/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }
    /**
     * Lists all GoodsSeckill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSeckillSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsSeckill model.
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
     * Creates a new GoodsSeckill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsSeckill();
		$model->goods_sn="GOODS".rand(100000,999999).time();
       /*$model->load(Yii::$app->request->post());
      $model->save();
      $this->dump($model);*/
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->goods_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GoodsSeckill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		$model->goods_img=json_decode($model->goods_img);
        $model->start_time=date("Y-m-d",$model->start_time);
        $model->end_time=date("Y-m-d H:i:s",$model->end_time);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->goods_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GoodsSeckill model.
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
     * Finds the GoodsSeckill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsSeckill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsSeckill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

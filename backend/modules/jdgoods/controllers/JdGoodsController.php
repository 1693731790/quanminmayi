<?php

namespace backend\modules\jdgoods\controllers;

use Yii;
use common\models\JdGoods;
use common\models\JdGoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GoodsCate;
use common\models\JdGoodsCate;

/**
 * JdGoodsController implements the CRUD actions for JdGoods model.
 */
class JdGoodsController extends Controller
{
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
    function getJdCate()
    {
        $cateone=[];
        $catetwo=[];
        $catethree=[];
        $cateone=JdGoodsCate::find()->select(["goods_cat_id","goods_cat_name","goods_cat_pid"])->where(["goods_cat_pid"=>0])->asArray()->all();
        //

        foreach ($cateone as $valone) {
            $erji=JdGoodsCate::find()->select(["goods_cat_id","goods_cat_name","goods_cat_pid"])->where(["goods_cat_pid"=>$valone['goods_cat_id']])->asArray()->all();
            $catetwo[$valone['goods_cat_id']]=$erji;
            foreach ($erji as $valtwo) {

                $catethree[$valtwo['goods_cat_id']]=JdGoodsCate::find()->select(["goods_cat_id","goods_cat_name","goods_cat_pid"])->where(["goods_cat_pid"=>$valtwo['goods_cat_id']])->asArray()->all();
            }
        }
        $arr["cateone"]=$cateone;
        $arr["catetwo"]=$catetwo;
        $arr["catethree"]=$catethree;
        return $arr;
    }
    /**
     * Lists all JdGoods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JdGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$catejson=$this->getCate();
        $jdcatejson=$this->getJdCate();
      	
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "cateone"=>json_encode($catejson['cateone']),
            'catetwo' => json_encode($catejson['catetwo']),
            'catethree' => json_encode($catejson['catethree']),
            "cate_cateone"=>json_encode($jdcatejson['cateone']),
            'cate_catetwo' => json_encode($jdcatejson['catetwo']),
            'cate_catethree' => json_encode($jdcatejson['catethree']),
        ]);
    }

    /**
     * Displays a single JdGoods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new JdGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JdGoods();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing JdGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing JdGoods model.
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
     * Finds the JdGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JdGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JdGoods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace admin\controllers;

use Yii;
use common\models\WithdrawCash;
use common\models\UserBank;
use common\models\WithdrawCashSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WithdrawCashController implements the CRUD actions for WithdrawCash model.
 */
class WithdrawCashController extends Controller
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

    /**
     * Lists all WithdrawCash models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawCashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WithdrawCash model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=WithdrawCash::find()->with('user')->where(['wid'=>$id])->one();
        if($model==null){
             throw new NotFoundHttpException('The requested page does not exist.');
        }
        $bank=UserBank::findone(["user_id"=>$model->user_id]);

        if($data=Yii::$app->request->post()){
            $model->cashExamine($data,$model->user_id);
            return $this->redirect(['view','id'=>$model->wid]);
        }
        
        return $this->render('view', [
            'model' => $model,
            "bank"=>$bank,
        ]);
    }


    /**
     * Creates a new WithdrawCash model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WithdrawCash();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->wid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WithdrawCash model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->wid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WithdrawCash model.
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
     * Finds the WithdrawCash model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WithdrawCash the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WithdrawCash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

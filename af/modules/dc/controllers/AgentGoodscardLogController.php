<?php

namespace admin\modules\dc\controllers;

use Yii;
use common\models\AgentGoodscardLog;
use common\models\AgentGoodscardLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AgentGoodscardLogController implements the CRUD actions for AgentGoodscardLog model.
 */
class AgentGoodscardLogController extends Controller
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
     * Lists all AgentGoodscardLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentGoodscardLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    /**
     * Finds the AgentGoodscardLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AgentGoodscardLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AgentGoodscardLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

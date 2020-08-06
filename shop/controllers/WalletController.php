<?php

namespace shop\controllers;

use Yii;
use common\models\Wallet;
use common\models\WalletSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WalletController implements the CRUD actions for Wallet model.
 */
class WalletController extends Controller
{
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

    /**
     * Lists all Wallet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user_id=Yii::$app->user->identity->id;
        $searchModel = new WalletSearch();
        $searchModel->user_id=$user_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Wallet model.
     * @param integer $id
     * @return mixed
     */
    
    /**
     * Finds the Wallet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wallet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wallet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

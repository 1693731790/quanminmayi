<?php

namespace agent\controllers;

use Yii;
use common\models\WithdrawCash;
use common\models\UserBank;
use common\models\User;
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
     * Lists all WithdrawCash models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawCashSearch();
        $user_id=Yii::$app->user->identity->id;
        $searchModel->user_id=$user_id;
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
        $user_id=Yii::$app->user->identity->id;
        if($model->user_id!=$user_id){
             throw new NotFoundHttpException('The requested page does not exist.');
        }

        $bank=UserBank::findone(["user_id"=>$model->user_id]);

       
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
        
        $user_id=Yii::$app->user->identity->id;
        $user=User::findOne($user_id);
        $res=[];
        if($data=Yii::$app->request->get()){
            $fee=(float)$data["fee"];
            $balance=(float)$user->wallet;
            if($fee>$balance)
            {
                $res["success"]=false;
                $res["message"]="提现金额不能大于余额";
                return json_encode($res);
            }
            $withdrawCash=new WithdrawCash();
            $isok=$withdrawCash->cashAdd($data,$user_id);
            if($isok)
            {
                $res["success"]=true;
                $res["message"]="提现申请已提交，等待审核";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="提现申请提交失败";
                return json_encode($res);
            }
        }
        
        $userBank=UserBank::find()->where(["user_id"=>$user_id])->all();
        return $this->render("create",[
            "balance"=>$user->wallet,
            "userBank"=>$userBank,
        ]);

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

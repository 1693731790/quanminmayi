<?php

namespace backend\modules\dc\controllers;

use Yii;
use common\models\MobileCardOrder;
use common\models\MobileCardOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Agent;
use common\models\User;
use common\models\UserAuth;
use common\models\MobileCard;
use common\models\MobileCardImg;
use common\models\MobileCardOrderDetail;
use common\models\AgentBalanceRecord;



/**
 * MobileCardOrderController implements the CRUD actions for MobileCardOrder model.
 */
class MobileCardOrderController extends Controller
{
    /**
     * Displays a single MobileCardOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $partner="";
        if($model->partner_id!="0")
        {
            $partner=Agent::find()->with(["phoneAuth"])->where(['user_id'=>$model->partner_id])->one();    
        }
        
       // $this->dump($partner);
        $agent=Agent::find()->with(["phoneAuth"])->where(['user_id'=>$model->agent_id])->one();
        $mobileDetail=MobileCardOrderDetail::find()->where(["mo_id"=>$model->mo_id])->all();
        $mobileImg=MobileCardImg::findOne($model->mi_id);

        return $this->render('view', [
            'model' => $model,
            'partner' => $partner,
            'agent' => $agent,
            'mobileDetail' => $mobileDetail,
            'mobileImg' => $mobileImg,
        ]);
    }
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
     * Lists all MobileCardOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MobileCardOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateStatus()
    {
        $res=[];
        if ($data=Yii::$app->request->get()) {
            $model = MobileCardOrder::findOne($data["mid"]);
            if(empty($model))
            {
                $res['success']=false;
                $res['message']="错误";
                return json_encode($res);
            }
            
            //开启事务保存数据
            $transaction=Yii::$app->db->beginTransaction();
            try{
                $model->status=$data["status"];
                $model->remarks=$data["remarks"];
                if(!$model->update(true,["status","remarks"]))
                {
                    throw new \yii\db\Exception("保存失败");
                }
                if($data["status"]=="-1"&&$model->type=="1")
                {
                    $myAgent=Agent::findOne(["user_id"=>$model->partner_id]);
                    $agentBalanceRecord=new AgentBalanceRecord();
                    if(!$agentBalanceRecord->add($myAgent->agent_id,$model->partner_id,"1",$model->total_fee,"添加代理审核拒绝退款"))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }
                    $myAgent->balance=round($myAgent->balance+$model->total_fee,2);
                    if(!$myAgent->update(true,["balance"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }

                }
                if($data["status"]=="1"&&$model->type=="1"&&$model->is_agent_id!="0")
                {
                    $agentModel=Agent::findOne($model->is_agent_id);
                    $agentModel->ispay="1";
                    if(!$agentModel->update(true,["ispay"]))
                    {
                        throw new \yii\db\Exception("保存失败");
                    }
                }


                $transaction->commit();
                $res['success']=true;
                $res['message']="操作成功";
                return json_encode($res);  
            }catch(\Exception $e){
                $transaction->rollBack();
                throw $e;

                $res['success']=false;
                $res['message']="操作失败";
                return json_encode($res);
               
            }
            
        }
        
    }



 

  
    /**
     * Finds the MobileCardOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MobileCardOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MobileCardOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

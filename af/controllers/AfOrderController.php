<?php

namespace af\controllers;

use Yii;
use common\models\AfOrder;
use common\models\AfOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Express;
/**
 * AfOrderController implements the CRUD actions for AfOrder model.
 */
class AfOrderController extends Controller
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
  
    public function actionOrderStatus($order_id="")//发货
    {
        $this->layout=false;
        $data=Yii::$app->request->get();
        if($data["express_num"]){
           
            $order=AfOrder::findOne($data['order_id']);
        
            $order->express_num=$data["express_num"];
            $order->express_type=$data["express_type"];
            $order->status=2;
            if($order->update(true,["express_num","express_type",'status']))
            {
                $res["success"]=true;
                $res["message"]="发货成功";
                return json_encode($res);
            }else{
                $res["success"]=false;
                $res["message"]="发货失败";
                return json_encode($res);
            }
           
        }else{
            $express=Express::find()->all();
            return $this->render("order-status",[
                "order_id"=>$order_id,
                "express"=>$express,
            ]);  
        }

     
    
    }
    /**
     * Lists all AfOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AfOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AfOrder model.
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
     * Finds the AfOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AfOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AfOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

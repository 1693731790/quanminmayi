<?php

namespace distributor\controllers;

use Yii;
use common\models\Distributor;
use common\models\AfGoods;
use common\models\Region;
use common\models\AfOrder;
use common\models\AfOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Express;
/**
 * AfOrderController implements the CRUD actions for AfOrder model.
 */
class OrderController extends Controller
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
	
   /**
     * Lists all AfOrder models.
     * @return mixed
     */
    public function actionCreate($goods_id="")
    {
        $data=Yii::$app->request->get();
        if($data["address_name"])
        {
        	$user_id=Yii::$app->user->identity->id;
            $distributor=Distributor::findOne(["user_id"=>$user_id]);
          	$afOrder=new AfOrder();
          	$result=$afOrder->create($data,$user_id,$distributor->d_id);
          	if($result)
            {
             	$res["success"]=true;
                $res["id"]=$result;
                $res["message"]="提交成功";
            }else{
                $res["success"]=false;
                $res["message"]="提交失败";
            }
            return json_encode($res);
          
          	

        }else{
          	$afGoods=AfGoods::findOne($goods_id);
          	 $region=Region::find()->where(["parent_id"=>"0"])->all();
            $afGoods->goods_img=json_decode($afGoods->goods_img);
        	return $this->render('create', [
                'afGoods' => $afGoods,
                'region' => $region,
            ]);  
        }
        
    }
  
      public function actionPay($order_id="")
      {
        if($data=Yii::$app->request->post())
        {
          	$afOrder=AfOrder::findOne($data["order_id"]);
          	$afOrder->status="1";
            $afOrder->pay_img=$data["pay_img"];
            if($afOrder->update(true,["status","pay_img"]))
            {
                $res["success"]=true;
                $res["message"]="提交成功";
            }else{
                $res["success"]=false;
                $res["message"]="提交失败";
            }
                return json_encode($res);
        }else{
         	 return $this->render('pay', [
                "order_id"=>$order_id
            ]);  
        }
        
         
      }

    public function actionRegion($region_id="")
      {
          $region=Region::find()->asArray()->where(["parent_id"=>$region_id])->all();
         // $this->dump($region);
          //$this->dump(json_encode($region));
          return json_encode($region);
      }

  
  
    /**
     * Lists all AfOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
      	$user_id=Yii::$app->user->identity->id;
        $distributor=Distributor::findOne(["user_id"=>$user_id]);
        $searchModel = new AfOrderSearch();
      
      	$searchModel->d_id=$distributor->d_id;
        $searchModel->user_id=$user_id;
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

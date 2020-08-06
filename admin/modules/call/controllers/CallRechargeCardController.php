<?php
namespace admin\modules\call\controllers;

use Yii;
use common\models\CallRechargeCard;
use common\models\CallRechargeCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RechargeCardController implements the CRUD actions for RechargeCard model.
 */
class CallRechargeCardController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }
	public function actionSetCallAgent()
    {
        if ($data=Yii::$app->request->get()) {
            $startId=$data["startId"]-1;
            $endId=$data["endId"]+1;
            $call_agent_id=$data["call_agent_id"];
            $connection=Yii::$app->db;
            $sql="UPDATE `shop_call_recharge_card` SET `call_agent_id`=".$call_agent_id." WHERE id>".$startId." and id<".$endId;
            $command=$connection->createCommand($sql);
            
            if($command->execute())
            {
                  $res["success"]=true;
                  $res["message"]="操作成功";
            }else{
                  $res["success"]=false;
                  $res["message"]="操作失败";
            }
            return json_encode($res);
           
        } else {
            return $this->render('set-call-agent', [
            
            ]);
        }
    }
    /**
     * Lists all RechargeCard models.
     * @return mixed
     */
    public function actionIndex($is_use="")
    {
        $searchModel = new CallRechargeCardSearch();
      	if($is_use!="")
        {
         	 $searchModel->is_use=$is_use;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
     public function actionQrcode($id)
    {
       $this->layout=false;
       $rechargeCard=CallRechargeCard::findOne($id);
       $searchLink=yii::$app->params['webLink']."/user/recharge-card.html?card_num=".$rechargeCard->card_num."&password=".$rechargeCard->password;
       // 获取收款二维码内容
       ob_start();
       \PHPQRCode\QRcode::png($searchLink,false,'L', 4, 2);
       $imageString = base64_encode(ob_get_contents());
       ob_end_clean();
	   $resQrcode='data:image/png;base64,'.$imageString; 
	   return $this->render('qrcode', [
          "resQrcode"=>$resQrcode,
        ]);
    }
    

    /**
     * Creates a new RechargeCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      	 
         if ($data=Yii::$app->request->get()) {
          	  for($i=0;$i<$data["num"];$i++)
              {
                	 $cardNum=$this->getRandNum();
                     $isExistence=CallRechargeCard::findOne(["card_num"=>$cardNum]);
                	 if($isExistence>0)
                     {
                      	continue; 
                     }
               		 $model = new CallRechargeCard();
                     $model->batch_num=$data["batch_num"];
					 $model->card_num=$cardNum;
                     $model->password=$this->getRandStr();
                     $model->fee=$data["fee"];
                	 $model->create_time=time();
                     $model->end_time=strtotime($data["end_time"]);
                	 $model->save();
                	//$this->dump($model->getErrors());
              }
           	$res["success"]=true;
            $res["message"]="成功";
            return json_encode($res);
          
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
   
	function getRandNum() {   //随机数
        $chars = "0123456789";
        $str = "";
        $length = 12;
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        // 随机字符串  
        return $str;

    }
  	function getRandStr() {   //随机字符串
        $chars = "0123456789";
        $str = "";
        $length = 6;
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        // 随机字符串  
        return $str;

    }
    

    /**
     * Deletes an existing RechargeCard model.
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
     * Finds the RechargeCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RechargeCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CallRechargeCard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

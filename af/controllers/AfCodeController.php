<?php

namespace af\controllers;

use Yii;
use common\models\AfCode;
use common\models\AfCodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AfCodeController implements the CRUD actions for AfCode model.
 */
class AfCodeController extends Controller
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
  	public function actionQrcode($id)
    {
       $this->layout=false;
       $afCode=AfCode::findOne($id);
       //$searchLink=yii::$app->params['webLink']."/af-code/af-code-show.html?number=".$afCode["number"];
       $searchLink=$afCode["number"];
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
  	public function actionDeleteAll()  
    {   
      $isok=true;
      if($data=Yii::$app->request->get())
      {
          $idArr=$data["keys"];//explode(",", $data["keys"]);
          for($i=0;$i<count($idArr);$i++)
          {
                if(!AfCode::findOne($idArr[$i])->delete())
                {
                  $isok=false;
                }

          }
      }
      if($isok)
      {
          $res["success"]=true;
          $res["message"]="操作成功";
          return json_encode($res);    
      }else{
          $res["success"]=false;
          $res["message"]="操作失败";
          return json_encode($res);  

      } 
        
    }
  
    /**
     * Lists all AfCode models.
     * @return mixed
     */
    public function actionIndex($goods_id="")
    {
        $searchModel = new AfCodeSearch();
      	$searchModel->goods_id=$goods_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AfCode model.
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
     * Creates a new AfCode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function randCode($length = 15)
    {
       	  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
          $str = "";  
          for ($i = 0; $i < $length; $i++) {  
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);  
          }  
          return $str.time();  
    }  
  	
  	public function actionSetDistributor()
    {
        if ($data=Yii::$app->request->get()) {
            $startId=$data["startId"]-1;
            $endId=$data["endId"]+1;
            $connection=Yii::$app->db;
            $sql="UPDATE `shop_af_code` SET `distributor_id`=".$data["distributor_id"]." WHERE id>".$startId." and id<".$endId;
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
            return $this->render('set-distributor', [
            
            ]);
        }
    }

  
    public function actionCreate()
    {
        

        if ($data=Yii::$app->request->get()) {
          
            $r=true;
        	for($i=0;$i<$data["codeNumber"];$i++)
            {
             	$model=new AfCode();
              	$model->batch_num=$data["batch_num"];
                $model->goods_id=$data["goods_id"];
                $model->number=$this->randCode();
                $model->status="0";
                $model->create_time=time();
                $model->save();
              
                if(!$model->save())
                {
                  	$r=false;
                }
            
            }
   
          if($r)
          {
           		$res["success"]=true;
                $res["message"]="添加成功";
          }else{
            	$res["success"]=false;
                $res["message"]="添加失败";
          }
          return json_encode($res);
          	
          	
           
        } else {
            return $this->render('create', [
            
            ]);
        }
    }

    /**
     * Updates an existing AfCode model.
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
     * Deletes an existing AfCode model.
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
     * Finds the AfCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AfCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AfCode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

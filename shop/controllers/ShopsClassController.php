<?php

namespace shop\controllers;

use Yii;
use common\models\ShopsClass;
use common\models\ShopsCate;
use common\models\Shops;
use common\models\SearchShopsClass;
use common\models\ShopsCateClass;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopsClassController implements the CRUD actions for ShopsClass model.
 */
class ShopsClassController extends Controller
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
	 public function actionIshome()
    {
        if($data=Yii::$app->request->get())
        { 
            $shopsCate=ShopsClass::findOne($data["id"]);
            $shopsCate->ishome=$data["type"];
          
            if($shopsCate->update(true,["ishome"]))
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
        
    }
  
  	public function actionCreateCate($id="")
    {
      	
        if($data=Yii::$app->request->post()){
              //$this->dump($data);
             // $shopsCateClass=ShopsCateClass::find()->where(["id"=>$data["class_id"]])->all();
              $connection=Yii::$app->db;
              //删除所有attrkey
              $sqlkey="DELETE FROM `shop_shops_cate_class` WHERE class_id=".$data['class_id'];
              $commandKey=$connection->createCommand($sqlkey);
              $commandKey->execute();
          	  for($i=0;$i<count($data["cate_id_str"]);$i++)
              {
                	$shopsCateClass=new ShopsCateClass();
                	$shopsCateClass->class_id=$data["class_id"];
                	$shopsCateClass->cate_id=$data["cate_id_str"][$i];
                	$shopsCateClass->save();
                	//$this->dump($shopsCateClass->getErrors());
              }
          	    return $this->redirect(['index']);
        } else {
            $user_id=Yii::$app->user->identity->id;
      	    $shop=Shops::findOne(["user_id"=>$user_id]);
        	$shopsCate=ShopsCate::find()->where(["shop_id"=>$shop->shop_id])->all();
           //$this->dump($shopsCate);
            $shopsCateClass=ShopsCateClass::find()->where(["id"=>$id])->all();
          	return $this->render('create-cate', [
            	"id"=>$id,
              "shopsCate"=>$shopsCate,
              "shopsCateClass"=>$shopsCateClass,
              
            ]);
        }
	    
    }
    /**
     * Lists all ShopsClass models.
     * @return mixed
     */
    public function actionIndex()
    {
      	$user_id=Yii::$app->user->identity->id;
      	$shop=Shops::findOne(["user_id"=>$user_id]);
        $class=ShopsClass::find()->asArray()->where(["shop_id"=>$shop->shop_id,"pid"=>0])->all();
        foreach($class as $key=>$val)
        {
         	$class[$key]["class"]=ShopsClass::find()->asArray()->where(["shop_id"=>$shop->shop_id,"pid"=>$val["id"]])->all(); 
        }
      	
        
	    //$this->dump($class);
        return $this->render('index', [
            'class' => $class,
        ]);
    }

    /**
     * Displays a single ShopsClass model.
     * @param integer $id
     * @return mixed
     */
   

    /**
     * Creates a new ShopsClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopsClass();
	
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
          	  $user_id=Yii::$app->user->identity->id;
      		  $shop=Shops::findOne(["user_id"=>$user_id]);
      
            return $this->render('create', [
                'model' => $model,
                'shop_id' => $shop->shop_id,
              
            ]);
        }
    }

    /**
     * Updates an existing ShopsClass model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
          $user_id=Yii::$app->user->identity->id;
      		  $shop=Shops::findOne(["user_id"=>$user_id]);
      
            
            return $this->render('update', [
                'model' => $model,
               'shop_id' => $shop->shop_id,
            ]);
        }
    }

    /**
     * Deletes an existing ShopsClass model.
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
     * Finds the ShopsClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopsClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopsClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

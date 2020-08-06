<?php

namespace shop\controllers;

use Yii;
use common\models\ShopsCate;
use common\models\Shops;
use common\models\ShopsCateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopsCateController implements the CRUD actions for ShopsCate model.
 */
class ShopsCateController extends Controller
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
     * Lists all ShopsCate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopsCateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopsCate model.
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
     * Creates a new ShopsCate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopsCate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
          	$user_id=Yii::$app->user->identity->id;
          	$shops=Shops::findOne(["user_id"=>$user_id]);
          	
            return $this->render('create', [
                'model' => $model,
              	"shop_id"=>$shops->shop_id,
            ]);
        }
    }
	 public function actionIshome()
    {
        if($data=Yii::$app->request->get())
        {
          
            $shopsCate=ShopsCate::findOne($data["id"]);
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
    /**
     * Updates an existing ShopsCate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShopsCate model.
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
     * Finds the ShopsCate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopsCate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopsCate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

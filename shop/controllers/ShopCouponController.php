<?php

namespace shop\controllers;

use Yii;
use common\models\ShopCoupon;
use common\models\Shops;

use common\models\ShopCouponSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopCouponController implements the CRUD actions for ShopCoupon model.
 */
class ShopCouponController extends Controller
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
     * Updates an existing ShopCoupon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $user_id=Yii::$app->user->identity->id;
        $shop=Shops::findOne(["user_id"=>$user_id]);
        $model = ShopCoupon::findOne(['shop_id'=>$shop->shop_id]);

        
        if ($data=Yii::$app->request->post()) {
            if(empty($model))
            {
                $model=new ShopCoupon();
            }
            $model->shop_id=$shop->shop_id;
            $model->fee=$data['fee'];
            $model->end_time=$data['end_time'];
            $model->save();
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
        
    }

    

    /**
     * Finds the ShopCoupon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopCoupon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopCoupon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

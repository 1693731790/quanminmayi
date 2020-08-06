<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use common\models\UserSearchCustomer;
use common\models\UserSearchDriver;
use common\models\UserSearchPartner;
use common\models\UserSearchCheck;
use common\models\Order;
use common\models\Integral;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
    // 
    
    public function actionXieyi($uid)
    {
        $this->layout=false;  
        $model=User::findOne($uid);
         return $this->render('xieyi', [
            'model' => $model,
        ]);
    }
    
    //客户列表
    public function actionUserSelect()
    {
        
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user-select', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    //客户列表
    public function actionCustomers()
    {

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('customers', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRealnameCheck()
    {
        $searchModel = new UserSearchCheck();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('realname-check', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    //实名认证通过
    public function actionRealnameOk($id)
    {
        $model = $this->findModel($id);
        $model->card_check_status=10;
        $model->realname_check_msg=null;
        switch($model->user_type){
            case 0:
            $model->is_customer=1;
            break;
            case 1:
            $model->is_driver=1;
            break;
            case 2:
            $model->is_partner=1;
            break;
        }
        $model->save();
       // var_dump($model->errors);
        $this->redirect(['realname-check']);
    }
    // 审核拒绝
    public function actionRealnameNo($id,$msg=null)
    {
        $model = $this->findModel($id);
        $model->card_check_status=-1;
        $model->realname_check_msg=$msg;
        $model->save();
        if(Yii::$app->request->isAjax){
            $res=[];
            $res['success']=true;
            return json_encode($res);
        }
        $this->redirect(['realname-check']);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionIntegral($id)
    {
         $model=Integral::find();
         $count=$model->where(["user_id"=>$id])->count();
         $pagination = new Pagination(['totalCount' => $count,'pageSize'=>'15']);
         $val=$model->where(["user_id"=>$id])->orderBy("id desc")->offset($pagination->offset)->limit($pagination->limit)->all();
     
         
        // $this->dump($val);
         return $this->render("integral",[
            "model"=>$val,
            
            "page"=>$pagination,          
            
         ]);
      
    }
    public function actionView($id)
    {
        $model=$this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

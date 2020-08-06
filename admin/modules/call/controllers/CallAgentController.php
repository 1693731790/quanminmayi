<?php

namespace admin\modules\call\controllers;

use Yii;
use common\models\CallAgent;
use common\models\SignupCallAgent;

use common\models\CallAgentSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class CallAgentController extends Controller
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
  
   //代理商列表
    public function actionSelect()
    {
       
        $searchModel = new CallAgentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('select', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
  
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CallAgentSearch();
      
        //$this->dump($searchModel);
      	if ($start_time!= ''&&$end_time!= '') {
         	 $searchModel->start_time=strtotime($start_time);
             $searchModel->end_time=strtotime($end_time."23:59:59");
        }
      	
      
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      	
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
   
  //修改状态
    public function actionStatus($user_id)
    {
     		$user=User::findOne($user_id);
         	$user->status="200";
            if($user->update(true,["status"]))
            {
            	$res['success']=true;
                $res['message']="修改成功";
				return json_encode($res);  
            }else{
             	$res['success']=false;
                $res['message']="修改失败";
			    return json_encode($res); 
            }
	
    }
  
	  //修改密码
    public function actionUpdatepwd($id="")
    {
       $data=Yii::$app->request->get();
       if(isset($data['password'])){
            $res=[];
           
            if(!isset($data['password'])){
                $res['success']=false;
                $res['message']="密码不能为空";
                return json_encode($res);
            }

            if(!isset($data['repassword'])){
                $res['success']=false;
                $res['message']="确认密码不能为空";
                return json_encode($res);
            }
            
            $password=$data['password'];
            $repassword=$data['repassword'];
         
            if($password!==$repassword){
                $res['success']=false;
                $res['message']="两次输入的密码不一致";
                return json_encode($res);
            }

            
            $user_id=$data['user_id'];
            $user=CallAgent::findOne($user_id);
         
            $user->setPassword($password);
       		$user->generateAuthKey();
            
            $user->save();
            

            $res['success']=true;
            $res['message']="密码修改成功";
          
            return json_encode($res);
        }

        return $this->render('updatepwd', [
            'user_id' => $id,
        ]);
    }
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      	$model=$this->findModel($id);
      
      //$this->dump($upconf);
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
        
        $model = new SignupCallAgent();
		//$model->setScenario('create');
                	
        if ($model->load(Yii::$app->request->post())) {
  			
            $user = $model->signup();
          //	$this->dump($user);
          	if ($user) {
            
                return $this->redirect(['view', 'id' => $user->id]);
            }
        } 
        return $this->render('create', [
            'model' => $model,
        ]);
        
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
         
          //$this->dump($model->getErrors());
          
          	
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
        if (($model = CallAgent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

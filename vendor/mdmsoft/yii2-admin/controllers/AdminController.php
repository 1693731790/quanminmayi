<?php
namespace mdm\admin\controllers;
use Yii;
use common\models\Admin; 
use common\models\AdminSearch; 
use yii\web\Controller;
use yii\web\NotFoundHttpException; 
use yii\filters\VerbFilter;
use yii\filters\AccessControl; 
use common\models\LoginForm; 
use backend\models\SignupForm;

class AdminController extends Controller
{
   public function beforeAction($action){
       // 判断是否登录
       if (Yii::$app->user->isGuest) {
           $session=Yii::$app->session;
           $session->setFlash('message','请登陆');
           // 没有登录,登录,登录后,返回
           Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl()); // 设置返回的url,登录后原路返回
           Yii::$app->user->loginRequired();
           Yii::$app->end();
       }
       return true;
   }

    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRepassword($id)
    {
        $model = $this->findModel($id);

        if ($r=Yii::$app->request->post()) {
        	
            $model->password_hash=Yii::$app->getSecurity()->generatePasswordHash($r["Admin"]['password_hash']);
             $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('repassword', [
                'model' => $model,
            ]);
        }
    }
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
    //启用账号
    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status=10;
        if ($model->save()) {
            Yii::$app->session->setFlash('msg','操作成功');
        } else {
            Yii::$app->session->setFlash('msg','操作失败');
        }
        return $this->redirect('index');
    }
    //禁用账号
    public function actionDisabled($id)
    {
        $model = $this->findModel($id);
        $model->status=0;
        if ($model->save()) {
            Yii::$app->session->setFlash('msg','操作成功');
        } else {
            Yii::$app->session->setFlash('msg','操作失败');
        }
        return $this->redirect('index');
    }


    /**
     * Deletes an existing Admin model.
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
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

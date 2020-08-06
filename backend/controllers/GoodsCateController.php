<?php

//namespace backend\controllers;
namespace backend\controllers;

use Yii;
use common\models\GoodsCate;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * CategoryController implements the CRUD actions for Category model.
 */
class GoodsCateController extends Controller
{

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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $arr= GoodsCate::find()->orderBy('goods_cat_sort desc')->asArray()->all();
        $cats_arr=GoodsCate::getCats($arr);
        $cats=GoodsCate::getCatsList($cats_arr);
        //$this->dump($cats);
        if(Yii::$app->request->isPost){
            $post=Yii::$app->request->post();

           
            if(isset($post['sort'])){
                // 排序
                $data=$post['sort'];
                foreach($data as $v){
                    $id=intval($v['goods_cat_id']);
                    $model=$this->findModel($id);
                    $model->goods_cat_sort=intval($v['goods_cat_sort']);
                    $model->save();
                }

                $arr= GoodsCate::find()->orderBy('goods_cat_sort desc')->asArray()->all();
                $cats=GoodsCate::getCats($arr);
                $cats=GoodsCate::getCatsList($cats);
                $result['success']=1;
                $result['cats']=json_encode($cats);

                return json_encode($result);

            }else{
                // 更改状态
                $id=intval($post['id']);
                $model=$this->findModel($id);
                if($model->goods_cat_is_show==1){
                    $model->goods_cat_is_show=0;
                    $result['goods_cat_is_show']=0;

                }else{
                    $model->goods_cat_is_show=1;
                    $result['goods_cat_is_show']=1;

                }
                $model->save();
                $result['success']=1;
                return json_encode($result);
            }

        }
       // $this->dump($cats);
        return $this->render('index',[
            'cats'=>$cats,

            ]);

    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid=0)
    {

         $model = new GoodsCate();
         $model->goods_cat_pid=intval($pid);
         $model->goods_cat_sort=0;
        if(Yii::$app->request->isPost){
            $model->setAttributes(Yii::$app->request->post());
            $model->goods_cat_is_show=1;
            $result=[];
            if($model->save()){
                $result['success']=1;
            }else{
                $errors=$model->errors;
                $result['success']=0;
                $result['errors']= $errors;
                foreach($errors as $v){
                    $result['msg']=$v[0];
                    break;
                }
            }
             return json_encode($result);
        }

        return $this->render('create', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    
        if(Yii::$app->request->isPost){
            $post=Yii::$app->request->post();
            $model = $this->findModel($post['goods_cat_id']);

            $result=[];
            if($post['goods_cat_pid']!=0&&$model->goods_cat_pid==0&&GoodsCate::find()->where('goods_cat_pid=:id',[':id'=>$model->goods_cat_id])->one()){
                $result['success']=0;
                $result['msg']= '存在子分类，不允许修改为二级分类';
                return json_encode($result);
            }
            $model->setAttributes(Yii::$app->request->post());
            
            if($model->save()){
                $result['success']=1;
            }else{
                $errors=$model->errors;
                $result['success']=0;
                $result['errors']= $errors;
                foreach($errors as $v){
                    $result['msg']=$v[0];
                    break;
                }
            }
             return json_encode($result);
        }

        $model = $this->findModel($id);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()

    {
        $id=intval($_POST['id']);

        $model=GoodsCate::findOne($id);
        $child=GoodsCate::find()->where('goods_cat_pid=:id',[':id'=>$id])->one();
        if(!$model||$child||!$model->delete()){
            $result['success']=0;
            $result['msg']='删除失败';
        }else{
            $result['success']=1;
            $result['msg']='已删除';

        }

        return json_encode($result);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsCate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

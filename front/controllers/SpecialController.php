<?php
namespace front\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Special;
use common\models\Goods;
use common\models\SpecialComment;
use common\models\SpecialFavorite;


/**
 * Site controller
 */
class SpecialController extends CommonController
{
      public function actionIndex()
      {
          
        
          $model=Special::find();
          $special=$model->asArray()->orderBy(['orderby'=>SORT_DESC])->limit(10)->all();
          foreach ($special as $key => $specialval)
          {

              $comment=SpecialComment::find()->where(['special_id'=>$specialval['special_id']])->count();
              $favorite=SpecialFavorite::find()->where(['special_id'=>$specialval['special_id']])->count();
              
              $special[$key]["comment"]=$comment;
              $special[$key]["favorite"]=$favorite;
          }  
               
          return $this->render("index",[
             
              "special"=>$special,
          ]);
      }

    function actionSpecialList($page="")
    {
       
        $page=($page-1)*10;
        $model=Special::find();
        $special=$model->asArray()->orderBy(['orderby'=>SORT_DESC])->offset($page)->limit(10)->all();
        $str=""; 
        foreach($special as $val)
        {
            $comment=SpecialComment::find()->where(['special_id'=>$val['special_id']])->count();
            $favorite=SpecialFavorite::find()->where(['special_id'=>$val['special_id']])->count();
            $str.='<li><div class="item"><a href="'.Url::to(['special/detail','id'=>$val['special_id']]).'"><div class="bt"><span>'.$val['name'].'</span></div><div class="pic"><img src="'.Yii::$app->params['imgurl'].$val['img'].'" alt="" /></div><div class="statusBar"><span><i class="iconfont icon-myon"></i>'.$val['browse'].'人浏览</span><span><i class="iconfont icon-collection"></i>'.$favorite.'</span><span><i class="iconfont icon-news"></i>'.$comment.'</span></div></a></div></li>';
            
        } 
        //$this->dump($str);
        echo $str;
        //return json_encode($orders);
       
    }

    public function actionFavorite($special_id="")
    {
        
        if(!yii::$app->user->isGuest)
        {
            $count=SpecialFavorite::find()->count();
            if($count>0)
            {
                echo "2";
                return false;
            }

            $model = new SpecialFavorite();
            $model->special_id=$special_id;
            $model->user_id=Yii::$app->user->identity->id;
            if($model->save())
            {
              echo "1";
              return false;
            }else{
              echo "4";
              return false;
            }
            
        }else{
            echo "3";
            return false;
        }
    }
     public function actionComment()
      {
          $data=Yii::$app->request->post();
          if(!yii::$app->user->isGuest)
          {
            
            $model = new SpecialComment();
            $model->special_id=$data["special_id"];
            $model->user_id=Yii::$app->user->identity->id;
            $model->content=$data['content'];
            $model->create_time=time();
            $model->save();  
          }
          
          return $this->redirect(['detail', 'id' => $data['special_id']]);
      }
      public function actionDetail($id)
      {
          $this->layout="nofooter";
          $model=Special::findOne($id);
          $model->browse=$model->browse+1;
          $model->save();
          $goods=Goods::findOne($model->goods_id);
          $cModel=SpecialComment::find();
          $count=$cModel->count();
          $pagination = new Pagination(['totalCount' => $count,'pageSize'=>'20']);
          
          $comment=$cModel->joinWith(["user"])->where(["special_id"=>$model->special_id])->offset($pagination->offset)->limit($pagination->limit)->all();
          
          //$this->dump($comment);
          return $this->render("detail",[
              "goods"=>$goods,
              "model"=>$model,
              "comment"=>$comment,
              "pagination"=>$pagination,
              "commentCount"=>$count,
          ]);
      }

      
     

}

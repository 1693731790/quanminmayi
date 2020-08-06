<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AcArticleCate;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            
            [
               "attribute"=>'article_id',
               'options'=>[
                    'width'=>'60',
                ],
            ],
           [
               "attribute"=>'agent_id',
               'options'=>[
                    'width'=>'100',
                ],
            ],
            'title',
            
           ['attribute'=>'cate_id',
                'format'=>'html',
                'value'=>function($model){
                    $cate=AcArticleCate::findOne($model->cate_id);
                    return $cate->name;
                },
               'filter'=>AcArticleCate::getCate(),
            ],
            
             ['attribute'=>'title_img',
                'format'=>'html',
                'value'=>function($model){
                    return Html::img($model->title_img,['width'=>110,'height'=>110]);
                },
            ],
            //'key',
            //'desc',
            // 'content:ntext',
            // 'ishot',
          	
             'author',
          
           ['attribute'=>'status',
                 'format' => 'raw',
                 'value'  => function($model){
                    if($model->status=="200")
                    {
                        return "已审核";
                    }else{
                        return "<a onclick='status(".$model->article_id.")' class='btn btn-sm btn-warning marr5' >确认审核</a>";
                    }
                    
                 },
                 'filter'=>["200"=>"已审核","0"=>"待审核"],
               'options'=>[
                    'width'=>'130',
                ],
            ],
             'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                    'update'=>function($url){
                        return Html::a('编辑',$url,['class'=>'btn btn-sm btn-warning marr5']);
                    },
                    'delete'=>function($url,$model){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5','data-method'=>'post','data-confirm'=>'确定要删除此项?']);
                    },
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
 
  function status(article_id)
  {
      $.get("<?=Url::to(['ac-article/status'])?>",{"article_id":article_id},function(r){
        if(r.success)
        {
            layer.msg(r.message);
            setTimeout(function(){
                window.location.reload();
              },2000)
              
            
        }else{
            layer.msg(r.message);
        }
          
      },'json')
  }
   
</script>


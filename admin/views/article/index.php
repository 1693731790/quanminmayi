<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

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

            'article_id',
            'title',
            
             ['attribute'=>'title_img',
                'format'=>'html',
                'value'=>function($model){
                    return Html::img($model->title_img,['width'=>110,'height'=>110]);
                },
            ],
            'key',
            //'desc',
            // 'content:ntext',
            // 'ishot',
          	
             'author',
          	 ['attribute'=>'ishot',
               'label' => '是否首页推荐',
                 'format' => 'raw',
                 'value'  => function($model){
                    if($model->ishot=="0")
                    {
                        return "<a onclick='lowerFrame(".$model->article_id.",1)' class='btn btn-sm btn-success marr5' >设为首页推荐</a>";
                    }else{
                        return "<a onclick='lowerFrame(".$model->article_id.",0)' class='btn btn-sm btn-warning marr5' >取消首页推荐</a>";
                    }
                    
                 },
                 'filter'=>["1"=>"是","0"=>"否"],
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
 
  function lowerFrame(article_id,sale)
  {
      $.get("<?=Url::to(['article/article-hot'])?>",{"article_id":article_id,"sale":sale},function(r){
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


<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AfCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品防伪码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="af-code-index">

  
    <?php //  echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="af-code-search">

    <div class="form-group field-afcodesearch-batch_num">
      <label class="control-label" for="afcodesearch-batch_num">批&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号:<input type="text" id="batch_num" ></label>
      <div class="help-block"></div>
    </div>
  	<div class="form-group field-afcodesearch-batch_num">
      <label class="control-label" for="afcodesearch-batch_num">经销商id:<input type="text" id="distributor_id" ></label>
      <div class="help-block"></div>
    </div>
  
  	<div class="form-group field-afcodesearch-batch_num">
      <label class="control-label" for="afcodesearch-batch_num">产&nbsp;&nbsp;品&nbsp;&nbsp;id:<input type="text" id="goods_id" ></label>
      <div class="help-block"></div>
    </div>
  	<div class="form-group field-afcodesearch-batch_num">
      <label class="control-label" for="afcodesearch-batch_num">状&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态:
      	<select id="status">
          <option value="">请选择</option>
          <option value="0">未使用</option>
          <option value="1">已使用</option>
        </select>
      </label>
      <div class="help-block"></div>
    </div>
    
    <div class="form-group">
        <button type="button" id="srarchExcel" class="btn btn-primary">按条件导出二维码</button>     
    </div>
  <script>
    
    	$(function(){
        	$("#srarchExcel").click(function(){
            	var batch_num=$("#batch_num").val();
                var distributor_id=$("#distributor_id").val();
                var goods_id=$("#goods_id").val();
                var status=$("#status option:selected").val(); 
              
              window.location.href="<?=Url::to(["excel-down/all"])?>"+"?batch_num="+batch_num+"&distributor_id="+distributor_id+"&goods_id="+goods_id+"&status="+status;
                
            })
        })
  </script>
   
</div>
    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('分配经销商', ['set-distributor'], ['class' => 'btn btn-success']) ?>
        <a class="btn btn-danger" href="<?=Url::to(["excel-down/all"])?>">导出二维码</a>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            'class' => 'yii\grid\CheckboxColumn',
            // 你可以在这配置更多的属性
           ],

            
            ["attribute"=>"id",
               'options'=>[
                    'width'=>'80',
                ],
             ],
           ["attribute"=>"batch_num",
               'options'=>[
                    'width'=>'300',
                ],
             ],
           ["attribute"=>"number",
               'options'=>[
                    'width'=>'300',
                ],
             ],
          ["attribute"=>"distributor_id",
               'options'=>[
                    'width'=>'100',
                ],
             ],
           ["attribute"=>"goods_id",
               'options'=>[
                    'width'=>'100',
                ],
             ],
           
            ["attribute"=>"status",
             'format' => 'raw',
              "value"=>function($model){
                	if($model->status=="1")
                    {
                     	return "已使用-<a class='btn btn-sm btn-success' href='".Url::to(["af-code-log/index","code_id"=>$model->id])."'>查看详情</a>"; 
                    }else{
                        return "未使用";
                    }
                  
                }, 
               'filter'=>["0"=>"未使用","1"=>"已使用"],
               'options'=>[
                    'width'=>'200',
                ],
             ],
             ['attribute'=>'',
              	"label"=>"二维码",
				'format' => 'raw',              
                'value'  => function($model){
                      return "<span class='btn btn-success' onclick='showQrcode(".$model->id.")'>查看</span>";
                 },
                 
            ],
            'create_time:datetime',
            
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{delete}',//
                'buttons'=>[
                    'view'=>function($url){
                        return Html::a('查看',$url,['class'=>'btn btn-sm btn-info marr5']);
                    },
                  'delete'=>function($url){
                        return Html::a('删除',$url,['class'=>'btn btn-sm btn-danger marr5']);
                    },
                    
                ],
                'options'=>[
                    'width'=>'200',
                ],
            ],
        ],
    ]); ?>
    <a class="btn btn-danger" onclick="deleteAll()">批量删除</a>
    
  
</div>


<script type="text/javascript">

  function showQrcode(id)
  {
    	layer.open({
            type: 2,
            title: '二维码',
            shadeClose: true,
            shade: 0.8,
            area: ['330px', '360px'],
            content: '<?=Url::to(["af-code/qrcode"])?>'+"?id="+id //iframe的url
       }); 
  }

  function deleteAll()
  {
      var keys = $('#w0').yiiGridView('getSelectedRows');
      
      $.get("<?=Url::to(['af-code/delete-all'])?>",{"keys":keys},function(r){
        layer.msg(r.message);
        if(r.success)
        {
              setTimeout(function(){
                window.location.reload();
              },2000)
              
        }
          
           
      },'json')

  }
 
   
 
</script>
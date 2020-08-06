<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AfCode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="af-code-form">

   <div class="form-group field-afcode-batch_num required ">
<label class="control-label" for="afcode-batch_num">生成数量</label>
<input type="text" id="codeNumber" class="form-control"  maxlength="50" aria-required="true" aria-invalid="false">

<div class="help-block"></div>
</div>


    <div class="form-group field-afcode-batch_num required ">
<label class="control-label" for="afcode-batch_num">批号</label>
<input type="text" id="batch_num" class="form-control"  maxlength="50" aria-required="true" aria-invalid="false">

<div class="help-block"></div>
</div>
    
    
    <div class="form-group field-afcode-goods_id required ">
<label class="control-label" for="afcode-goods_id">产品id</label>
<input type="text" id="goods_id" class="form-control"  aria-required="true" aria-invalid="false">

<div class="help-block"></div>
</div>  <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <span class="btn btn-warning" onclick="GoodsSelect()">选择产品</span>
               
                        
            </div>
           
        </div>
    </div>
  

  

    <div class="form-group">
        <button type="button" class="btn btn-success submit">添加</button>    
  </div>

</div>

<script>
  	$(function(){
    	$(".submit").click(function(){
        	var codeNumber=$("#codeNumber").val();
            var batch_num=$("#batch_num").val();
            var goods_id=$("#goods_id").val();
          	if(codeNumber=="")
            {
             	layer.msg("请输入生成数量");
              	return false;
            }
            if(batch_num=="")
            {
             	layer.msg("请输入批号");
              	return false;
            }
            if(goods_id=="")
            {
             	layer.msg("请选择产品");
              	return false;
            }
          	$.get("<?=Url::to(["af-code/create"])?>",{"codeNumber":codeNumber,"batch_num":batch_num,"goods_id":goods_id},function(r){
            		layer.msg(r.message);
              		if(r.success)
                    {
                     	setTimeout(function (){
                            window.location.reload();
                        }, 2000);
                    }
            },"json")
          
        })
    })
    function GoodsSelect()
    {

        layer.open({
          type: 2,
          title: '选择产品id',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['goods/goods-select'])?>" //iframe的url
        }); 
    }

</script>
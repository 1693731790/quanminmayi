<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AfCode */

$this->title = '分配经销商';

?>
<div class="af-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

   
<div class="af-code-form">

   <div class="form-group field-afcode-batch_num required ">
<label class="control-label" for="afcode-batch_num">起始ID</label>
<input type="text" id="startId" class="form-control"  maxlength="50" aria-required="true" aria-invalid="false">

<div class="help-block"></div>
</div>


    <div class="form-group field-afcode-batch_num required ">
<label class="control-label" for="afcode-batch_num">结束ID</label>
<input type="text" id="endId" class="form-control"  maxlength="50" aria-required="true" aria-invalid="false">

<div class="help-block"></div>
</div>
    
    
    <div class="form-group field-afcode-goods_id required ">
<label class="control-label" for="afcode-goods_id">经销商id</label>
<input type="text" id="call_agent_id" class="form-control"  aria-required="true" aria-invalid="false">

<div class="help-block"></div>
</div>  <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <span class="btn btn-warning" onclick="select()">选择经销商</span>
               
                        
            </div>
           
        </div>
    </div>
  

  

    <div class="form-group">
        <button type="button" class="btn btn-success submit">确定</button>    
  </div>

</div>
  
</div>
<script>
  	$(function(){
    	$(".submit").click(function(){
        	var startId=$("#startId").val();
            var endId=$("#endId").val();
            var call_agent_id=$("#call_agent_id").val();
          	if(startId=="")
            {
             	layer.msg("请输入防伪码起始ID");
              	return false;
            }
            if(endId=="")
            {
             	layer.msg("请输入防伪码结束ID");
              	return false;
            }
            if(call_agent_id=="")
            {
             	layer.msg("请选择代理商");
              	return false;
            }
          	$.get("<?=Url::to(["call-recharge-card/set-call-agent"])?>",{"startId":startId,"endId":endId,"call_agent_id":call_agent_id},function(r){
            		layer.msg(r.message);
              		if(r.success)
                    {
                     	setTimeout(function (){
                            window.location.href="<?=Url::to(["call-recharge-card/index"])?>";
                        }, 2000);
                    }
            },"json")
          
        })
    })
  
    function select()
    {

        layer.open({
          type: 2,
          title: '选择代理商',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['call-agent/select'])?>" //iframe的url
        }); 
    }

</script>


<?php
use yii\helpers\Html;
use yii\Helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = '充值';
$this->params['breadcrumbs'][] = ['label' => '合伙人/代理商', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="/static/region/area.js"></script>
<style type="text/css">
  .areaselect select{height:25px;}
</style>


<style type="text/css">
    #agent-level{width:500px;}
    .form-control {width:500px;}
</style>



<?php $form = ActiveForm::begin(["id"=>"agentform"]); ?>
<ul class="nav nav-tabs">
   
    <li class="active"><a href="#default-tab-1" data-toggle="tab">充值</a></li>
    
</ul>
   

<div class="tab-content" >
    <div class="tab-pane fade active in" id="default-tab-1">

 <div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">用户手机号</label>
    <input type="text" style="width:300px;" id="phone" class="form-control" aria-required="true" value="<?=$userAuthPhone?>" readonly="readonly">
    <div class="help-block"></div>
</div>

<div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">当前余额</label>
    <input type="text" style="width:300px;" id="phone" class="form-control" aria-required="true" value="<?=$agentBalance?>" readonly="readonly">
    <div class="help-block"></div>
</div>


<div class="form-group field-agent-name">
    <label class="control-label" for="agent-name">充值金额</label>
    <input type="number" style="width:300px;" id="fee" class="form-control" name="fee" maxlength="50" value="">

    <div class="help-block"></div>
</div>

        <div class="form-group ">
            
            <?= Html::button('确认', ['class' => 'btn btn-success agentsubmit']) ?>
        </div>

    </div>
   
    

   
  
    <?php ActiveForm::end(); ?> 
   
       
    </div>
</div>
 


<script type="text/javascript">


    $(function(){
        
        
        $(".agentsubmit").click(function(){
//          
            
            var check=true;
            var fee=$("#fee").val();
            var agent_id="<?=$agent_id?>";
            if(fee=="")
            {
                layer.msg("充值金额不能为空");
                check=false;
            }
            
            
            
            if(check)
            {
                $.post("<?=Url::to(['agent/recharge'])?>",{"fee":fee,"agent_id":agent_id},function(data){
                    if(data.success)
                    {
                        layer.msg(data.message);
                        setTimeout(function(){
                            window.location.reload();
                        },2000)
                        
                    }else{
                        layer.msg(data.message);
                    }
                },'json')   
            }
            
        })
    })
    
    
</script>
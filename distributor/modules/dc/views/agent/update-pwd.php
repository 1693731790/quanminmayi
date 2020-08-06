<?php
use yii\helpers\Html;
use yii\Helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = '修改代理商密码';
$this->params['breadcrumbs'][] = ['label' => '代理商列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(["id"=>"agentform"]); ?>
<ul class="nav nav-tabs">
   
    <li class="active"><a href="#default-tab-1" data-toggle="tab">修改密码</a></li>
    
</ul>
   


<!-- 
<div class="form-group field-agent-user_id required">
	<label class="control-label" for="agent-user_id">用户密码</label>
	<input type="password" id="agent-user_id" class="form-control" name="user_password" aria-required="true">
	
	<div class="help-block"></div>
</div> -->
<input type="hidden" name="agent_id" value="<?=$agent_id?>">


<div class="form-group field-agent-name">
	<label class="control-label" for="agent-name">新密码</label>
	<input type="text" id="agent-name" class="form-control" name="user_password" maxlength="50" value="">

	<div class="help-block"></div>
</div>


      <div class="form-group ">
            
            <?= Html::button('修改信息', ['class' => 'btn btn-success agentsubmit']) ?>
        </div>
  
    <?php ActiveForm::end(); ?> 
   
       
    </div>
</div>
 


<script type="text/javascript">


	$(function(){
		
		
		$(".agentsubmit").click(function(){
//			
			
			var check=true;
			var user_password=$("input[name=user_password]").val();
			if(user_password=="")
			{
				layer.msg("用户密码不能为空");
				check=false;
			}
			
			
			if(check)
			{
				$.post("<?=Url::to(['agent/update-pwd'])?>",$("#agentform").serialize(),function(data){
					if(data.success)
					{
						layer.msg(data.message);
						var url="<?=Url::to(["agent/view"])?>";
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
	
	function userid()
    {

        layer.open({
          type: 2,
          title: '选择上级代理商',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['agent/agent-select'])?>" //iframe的url
        }); 
    }
</script>
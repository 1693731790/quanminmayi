<?php
use yii\helpers\Html;
use yii\Helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = '添加代理商';
$this->params['breadcrumbs'][] = ['label' => '代理商列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
  .areaselect select{height:25px;}
</style>

<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<style type="text/css">
    #agent-level{width:500px;}
    .form-control {width:500px;}
</style>



<?php $form = ActiveForm::begin(["id"=>"agentform"]); ?>
<ul class="nav nav-tabs">
   
    <li class="active"><a href="#default-tab-1" data-toggle="tab">用户信息</a></li>
    <li ><a href="#default-tab-2" data-toggle="tab">购买电话卡</a></li>
   
</ul>
   

<div class="tab-content" >
    <div class="tab-pane fade active in" id="default-tab-1">
 
 

<div class="form-group field-agent-user_id required">
    <label class="control-label" for="agent-user_id">用户账号</label>
    <input type="text"  id="agent-user_id" class="form-control" name="user_username" aria-required="true">
    
    <div class="help-block"></div>
</div>

<div class="form-group field-agent-user_id required">
    <label class="control-label" for="agent-user_id">手机号</label>
    <input type="text"  id="agent-user_id" class="form-control" name="user_phone" aria-required="true">
    
    <div class="help-block"></div>
</div>

<div class="form-group field-agent-user_id required">
    <label class="control-label" for="agent-user_id">用户密码</label>
    <input type="password" id="agent-user_id" class="form-control" name="user_password" aria-required="true">
    
    <div class="help-block"></div>
</div>

<div class="form-group field-agent-level required">
    <label class="control-label" for="agent-level">等级</label>
    <select id="agent-level" class="form-control" name="Agent_level" aria-required="true">
        <?php foreach($agentGrade as $agentGradeVal):?>
         <option value="<?=$agentGradeVal->grade_id?>" num="<?=$agentGradeVal->gt_num?>" between_num="<?=$agentGradeVal->gt_num?>~<?=$agentGradeVal->lt_num?>"><?=$agentGradeVal->name?>---需要购买<?=$agentGradeVal->gt_num?>-<?=$agentGradeVal->lt_num?>的卡</option>
        <?php endforeach;?>
    </select>
    <div class="help-block"></div>
</div>   

<div class="form-group field-agent-name">
    <label class="control-label" for="agent-name">姓名</label>
    <input type="text" id="agent-name" class="form-control" name="user_name" maxlength="50">

    <div class="help-block"></div>
</div>

<div class="form-group field-agent-id_num">
    <label class="control-label" for="agent-id_num">身份证号</label>
    <input type="text" id="agent-id_num" class="form-control" name="Agent_id_num" maxlength="50">

    <div class="help-block"></div>
</div>

   

<div class="form-group field-agent-id_front">
    <label class="control-label" for="agent-id_front">身份证正面照</label>
    <input type="text" id="agent-id_front" class="form-control" name="Agent_id_front" readonly>
    <div class="help-block"></div>
</div>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_front" width="212" height="152"  src="/uploads/default.jpg" />  
         </div>
         <input  id="photo_file_id_front"  type="file" multiple="true" value="" />
    </div>
     <script>

            $("#photo_file_id_front").uploadify({

                'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'agent'])?>',

                'cancelImg': '/static/uploadify/uploadify-cancel.png',

                'buttonText': '上传图片',

                'fileTypeExts': '*.gif;*.jpg;*.png',

                'queueSizeLimit': 1,
                'fileObjName':'photo',
                'onUploadSuccess': function (file, data, response) {

                    $("#agent-id_front").val(data);

                    $("#id_front").attr('src', "<?=Yii::$app->params['imgurl']?>"+data).show();

                }

            });

        </script>
    
<div class="form-group field-agent-id_back">
    <label class="control-label" for="agent-id_back">身份证反面照</label>
    <input type="text" id="agent-id_back" class="form-control" name="Agent_id_back" readonly>

    <div class="help-block"></div>
</div>  
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_back" width="212" height="152"  src="/uploads/default.jpg" />  
         </div>
         <input  id="photo_file_id_back"  type="file" multiple="true" value="" />
    </div>
   
         <script>

                $("#photo_file_id_back").uploadify({

                    'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                    'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'agent'])?>',

                    'cancelImg': '/static/uploadify/uploadify-cancel.png',

                    'buttonText': '上传图片',

                    'fileTypeExts': '*.gif;*.jpg;*.png',

                    'queueSizeLimit': 1,
                    'fileObjName':'photo',
                    'onUploadSuccess': function (file, data, response) {

                        $("#agent-id_back").val(data);

                        $("#id_back").attr('src', "<?=Yii::$app->params['imgurl']?>"+data).show();

                    }

                });

            </script>
    
        <div class="form-group ">
            
            <?= Html::button('提交信息', ['class' => 'btn btn-success agentsubmit']) ?>
        </div>

    </div>
 <input type="hidden" id="onePrice" value="<?=$onePrice?>">  
    <div class="tab-pane fade " id="default-tab-2">
        <div class="col-md-10">
            <div class="panel panel-info">
              <div class="panel-heading">我的预存余额</div>
              <div class="panel-body">
                <div style="color:red;">
                    <?=$myAgent->balance?>
                </div>
               
              </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="panel panel-info">
              <div class="panel-heading">电话卡信息</div>
              <div class="panel-body">
                <table class="table table-bordered" style="float:left;" id="order_list">
                 
                  <tr>
                      <th>名称</th>
                      <th>购买数量</th>
                      <th>操作</th>
                  </tr>
                  
                </table>
                <div style="text-align: center;">
                    <span class="btn btn-success btn-sm" onclick="goodsSelect()"  >添加</span>
                </div>
                <div>
                    总金额：￥<span style="color:red" id="countPrice">0</span>
                </div>
              </div>
            </div>
       </div>

       <div class="col-md-10">
        <div class="panel panel-info">
          <div class="panel-heading">电话卡封面</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
            <?php foreach($mobileCardImg as $mobileCardImgVal):?> 
              <tr>
                  <th><input name="mi_id" type="radio" value="<?=$mobileCardImgVal->mi_id?>" /></th>
                  <td><img src="<?=$mobileCardImgVal->img?>" style="width:200px;height:100px;"></td>
              </tr> 
            <?php endforeach;?> 
            <tr>
                  <th><input name="mi_id" type="radio" value="0" />其他</th>
                  <td>手机号：<input type="text" name="phone" placeholder="如需定制封面，请输入联系方式"></td>
              </tr>  
            </table>
          </div>
        </div>
        
            
       </div>
    
       
        <div class="col-md-10">
            <?= Html::button('提交信息', ['class' => 'btn btn-success agentsubmit']) ?>
        </div>
    </div>


   
  
    <?php ActiveForm::end(); ?> 
   
       
    </div>
</div>
 


<script type="text/javascript">

function goodsSelect()
{

    layer.open({
      type: 2,
      title: '选择电话卡',
      shadeClose: true,
      shade: 0.8,
      area: ['800px', '90%'],
      content: "<?=Url::to(['mobile-card/mobile-card-select'])?>" 
    }); 
}

    $(function(){
        
        $(document).on("click",'.goodsDelete',function(){
            $(this).parent().parent().remove();
            var countNum=0;

            $("#order_list tr .num").each(function(r){
                countNum+=parseInt($(this).text());
                
            })
            var onePrice="<?=$onePrice?>";
            var countPrice=countNum*onePrice;
            
            $("#countPrice").text(countPrice);
        })
        $(".agentsubmit").click(function(){
            var check=true;
            var user_username=$("input[name=user_username]").val();
            var user_phone=$("input[name=user_phone]").val(); 
            var user_password=$("input[name=user_password]").val(); 
            if(user_username=="")
            {
                layer.msg("用户名不能为空");
                check=false;
            }
            if(user_phone=="")
            {
                layer.msg("用户手机号不能为空");
                check=false;
            }
            if(user_password=="")
            {
                layer.msg("用户密码不能为空");
                check=false;
            }
            var mi_id=$("input[type='mi_id']:checked").val();
            var phone=$("input[name=phone]").val(); 
            if(mi_id=="0"){
                if($data["phone"]=="")
                {
                    layer.msg("请输入电话号");
                    check=false;
                    
                }
            }
            var need_num=parseInt($("#agent-level option:selected").attr("num"));
            var between_num=$("#agent-level option:selected").attr("between_num");
            var countNum=0;
            $("#order_list tr .num").each(function(r){
                countNum+=parseInt($(this).text());
                
            })
            if(countNum==0)
            {
                layer.msg("请选择购买的话费充值卡");
                check=false;   
            }
          
            if(countNum<need_num)
            {
                layer.msg("开通的会员类型需要购买"+between_num+"个电话卡");
                check=false;
            }
            var onePrice="<?=$onePrice?>";
            var countPrice=countNum*onePrice;
            var agentBalance="<?=$myAgent->balance?>";
            if(agentBalance<countPrice)
            {
                layer.msg("您的预存余额不足");
                check=false;
            }

            
            if(check)
            {
                $.get("<?=Url::to(['agent/create'])?>",$("#agentform").serialize(),function(data){
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
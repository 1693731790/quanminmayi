<?php
use yii\helpers\Html;
use yii\Helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '合伙人/代理商', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
  select{height:25px;}
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
    
</ul>
   

<div class="tab-content" >
    <div class="tab-pane fade active in" id="default-tab-1">
 <div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">上级代理商（默认无）</label>
    <input type="text" style="width:300px;" id="shops-user_id" class="form-control" name="Agent_parent_id" aria-required="true" value="0" readonly="readonly">
    <span class="btn btn-success" onclick="userid()">选择代理商</span>
<div class="help-block"></div>
</div>
 

<div class="form-group field-agent-user_id required">
    <label class="control-label" for="agent-user_id">用户账号</label>
    <input type="text"  id="agent-user_id" class="form-control" name="user_username" aria-required="true">
    
    <div class="help-block"></div>
</div>
<div class="form-group field-agent-user_id required">
    <label class="control-label" for="agent-user_id">类型</label>
     <select name="type">
        <option value="1">合伙人</option>
        <option value="2">代理商</option>
    </select>
    
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
        <option value="0" >合伙人</option>
        <?php foreach($agentGrade as $agentGradeVal):?>
         <option value="<?=$agentGradeVal->grade_id?>" ><?=$agentGradeVal->name?></option>
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
   
    

   
  
    <?php ActiveForm::end(); ?> 
   
       
    </div>
</div>
 


<script type="text/javascript">



    $(function(){
        
        $(document).on("click",'.goodsDelete',function(){
            $(this).parent().parent().remove();
            var countPrice=0;

            $("#order_list tr .oneprice").each(function(r){
                var num=$(this).next().text();
                countPrice+=parseFloat($(this).text()*num);
                
            })
            
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
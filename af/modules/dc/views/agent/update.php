<?php
use yii\helpers\Html;
use yii\Helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = '修改代理商';
$this->params['breadcrumbs'][] = ['label' => '代理商列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="/static/region/area.js"></script></head>
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
    
</ul>
   


<!-- 
<div class="form-group field-agent-user_id required">
    <label class="control-label" for="agent-user_id">用户密码</label>
    <input type="password" id="agent-user_id" class="form-control" name="user_password" aria-required="true">
    
    <div class="help-block"></div>
</div> -->
<input type="hidden" name="agent_id" value="<?=$agent->agent_id?>">

<div class="form-group field-agent-level ">
    <label class="control-label" for="agent-level">等级</label>
    <select id="agent-level" class="form-control" name="Agent_level" aria-required="true">
        <?php foreach($agentGrade as $agentGradeVal):?>
         <option <?=$agentGradeVal->grade_id==$agent->level?'selected=selected':''?> value="<?=$agentGradeVal->grade_id?>" ><?=$agentGradeVal->name?></option>
        <?php endforeach;?>
    </select>
    <div class="help-block"></div>
</div>   

<div class="form-group field-agent-name">
    <label class="control-label" for="agent-name">姓名</label>
    <input type="text" id="agent-name" class="form-control" name="user_name" maxlength="50" value="<?=$user->realname?>">

    <div class="help-block"></div>
</div>

<div class="form-group field-agent-id_num">
    <label class="control-label" for="agent-id_num">身份证号</label>
    <input type="text" id="agent-id_num" class="form-control" name="Agent_id_num" maxlength="50" value="<?=$agent->id_num?>">

    <div class="help-block"></div>
</div>

   

<div class="form-group field-agent-id_front">
    <label class="control-label" for="agent-id_front">身份证正面照</label>
    <input type="text" id="agent-id_front" class="form-control" name="Agent_id_front" value="<?=$agent->id_front?>" readonly>
    <div class="help-block"></div>
</div>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_front" width="212" height="152"  src="<?=$agent->id_front!=''?$agent->id_front:'/uploads/default.jpg'?>" />  
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
    <input type="text" id="agent-id_back" class="form-control" name="Agent_id_back" value="<?=$agent->id_back?>" readonly>

    <div class="help-block"></div>
</div>  
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_back" width="212" height="152"  src="<?=$agent->id_back!=''?$agent->id_back:'/uploads/default.jpg'?>" />  
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
            
            <?= Html::button('修改信息', ['class' => 'btn btn-success agentsubmit']) ?>
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
            
            /*if(user_password=="")
            {
                layer.msg("用户密码不能为空");
                check=false;
            }*/
            
            
            
            if(check)
            {
                $.post("<?=Url::to(['agent/update'])?>",$("#agentform").serialize(),function(data){
                    if(data.success)
                    {
                        layer.msg(data.message);
                        var url="<?=Url::to(["agent/view"])?>";
                        setTimeout(function(){
                            window.location.href=url+"?agent_id="+data.datas.agent_id;  
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
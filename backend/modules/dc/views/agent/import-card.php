<?php
use yii\helpers\Html;
use yii\Helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = '导入充值卡';

$this->params['breadcrumbs'][] = $this->title;
?>


<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<style type="text/css">
    #agent-level{width:500px;}
    .form-control {width:500px;}
</style>

<?php $form = ActiveForm::begin(["id"=>"agentform"]); ?>
<ul class="nav nav-tabs">
   
    <li class="active"><a href="#default-tab-1" data-toggle="tab">导入充值卡</a></li>
    
</ul>
   

<div class="form-group field-agent-name">

    <div class="help-block"></div>
</div>

<div class="form-group field-agent-id_num">
    <label class="control-label" >代理商账号：<?=$userAuthPhone->identifier?></label>
    
    <div class="help-block"></div>
</div>

<div class="form-group field-agent-id_front">
    <label class="control-label" for="agent-id_front">上传excel</label>
    <input type="text" id="agent-id_front" class="form-control" name="excel"  readonly>
    <div class="help-block"></div>
</div>
    <div class="form-group">
         <input  id="photo_file_id_front"  type="file" multiple="true" value="" />
    </div>
     <script>

            $("#photo_file_id_front").uploadify({

                'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'agentmobilecardnum'])?>',

                'cancelImg': '/static/uploadify/uploadify-cancel.png',

                'buttonText': '上传',

                'fileTypeExts': '*.xls;*.xlsx;',

                'queueSizeLimit': 1,
                'fileObjName':'photo',
                'onUploadSuccess': function (file, data, response) {

                    $("#agent-id_front").val(data);


                }

            });

        </script>
    
    
   <div class="form-group ">
            
            <?= Html::button('提交', ['class' => 'btn btn-success agentsubmit']) ?>
        </div>
   
  
    <?php ActiveForm::end(); ?> 
   
       
    </div>
</div>
 


<script type="text/javascript">


    $(function(){
        
        
        $(".agentsubmit").click(function(){
            
            var check=true;
            var agent_id="<?=$agent_id?>";
            var excel=$("#agent-id_front").val();
            if(excel=="")
            {
                layer.msg("请上传excel");
                check=false;
            }
            if(check)
            {
                $.post("<?=Url::to(['agent/import-card'])?>",{"excel":excel,"agent_id":agent_id},function(data){
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
<?php
use yii\helpers\Html;
use yii\Helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Agent */

$this->title = '购买话费充值卡';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    #agent-level{width:500px;}
    .form-control {width:500px;}
</style>

<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<?php $form = ActiveForm::begin(["id"=>"agentform"]); ?>
<ul class="nav nav-tabs">
   
    <li class="active"><a href="#default-tab-1" data-toggle="tab">购买话费充值卡</a></li>
       
</ul>
   
<input type="hidden" id="onePrice" value="<?=$onePrice?>">  
<div class="tab-content" >

 
    <div class="tab-pane fade  active in" id="default-tab-1">
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
                    <span class="btn btn-success btn-sm" onclick="goodsSelect()">添加</span>
                </div>
                <div>
                    总金额：￥<span style="color:red" id="countPrice">0</span>
                </div>
              </div>
            </div>
       </div>
       <div class="col-md-10">
            <div class="panel panel-info">
              <div class="panel-heading">汇款信息</div>
                <div class="panel-body">
                <table class="table table-bordered" style="float:left;" id="order_list">
                 
                  <div class="form-group field-agent-pay_img">
                    <label class="control-label" for="agent-pay_img">汇款凭证</label>
                    <input type="text" id="agent-pay_img" class="form-control" name="pay_img" readonly>
                    <div class="help-block"></div>
                </div>
                <div class="form-group">
                    <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                        <img  id="pay_img" width="212" height="152"  src="/uploads/default.jpg" />  
                     </div>
                     <input  id="photo_file_pay_img"  type="file" multiple="true" value="" />
                </div>
     <script>

            $("#photo_file_pay_img").uploadify({

                'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'agent-remittance'])?>',

                'cancelImg': '/static/uploadify/uploadify-cancel.png',

                'buttonText': '上传图片',

                'fileTypeExts': '*.gif;*.jpg;*.png',

                'queueSizeLimit': 1,
                'fileObjName':'photo',
                'onUploadSuccess': function (file, data, response) {

                    $("#agent-pay_img").val(data);

                    $("#pay_img").attr('src', data).show();

                }

            });

        </script>
                  
                </table>
                
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
            var countNum=0;
            $("#order_list tr .num").each(function(r){
                countNum+=parseInt($(this).text());
                
            })
            if(countNum==0)
            {
                layer.msg("请选择购买的话费充值卡");
                check=false;   
            }
            var agent_pay_img=$("#agent-pay_img").val();
            
            if(agent_pay_img=="")
            {
                layer.msg("请上传汇款凭证");
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
            

            
            if(check)
            {
                $.get("<?=Url::to(['agent/mobile-card-create'])?>",$("#agentform").serialize(),function(data){
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
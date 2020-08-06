<?php
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '支付凭证';

?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <input type="hidden" id="pay_img" />

    <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                    <img  id="payImg" width="212" height="152"  src="/uploads/default.jpg" />  
                </div>
                <input  id="photo_file_pay_img"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>
  
    <script>

                        $("#photo_file_pay_img").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'aforder'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#pay_img").val(data);

                                $("#payImg").attr('src', data).show();

                            }

                        });

                    </script>
  
  <div class="btn btn-primary" onclick="submits()">提交</div>

</div>
<script>
   function submits()
  {
  	var pay_img=$("#pay_img").val();
    if(pay_img=="")
    {
     	layer.msg("请先上传支付凭证");
       return false;
    }
    $.post("<?=Url::to(['order/pay'])?>",{"pay_img":pay_img,"order_id":"<?=$order_id?>"},function(r){
      layer.msg(r.message);
      if(r.success)
      {              
          setTimeout(function(){
              window.location.href="<?=Url::to(['order/view'])?>"+"?id=<?=$order_id?>";
          },2000);

      }
     },'json')
  }
</script>
<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\SpikeTime;

/* @var $this yii\web\View */
/* @var $model common\models\GoodsSeckill */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<script src="/static/laydate/laydate.js"></script> <!-- 改成你的路径 -->
<style>
 
   #one,#two,#three{height: 35px;}
   .error{text-align: left;color:red;}
   .jq_uploads_img{height: 220px;width:100%;border:#ccc 1px solid;margin-bottom: 10px;}
</style>
<div class="goods-seckill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'goods_sn')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_keys')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'goods_thums')->textInput(['readonly' => 'readonly']) ?>

    <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                    <img  id="goods_thums" width="212" height="152"  src="<?=$model->isNewRecord?'/uploads/default.jpg':$model->goods_thums?>" />  
                </div>
                <input  id="photo_file_goods_thums"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>
    
    <div class="row">
            <div style="margin-left:10px;"><label>商品相册</label></div>
            <div class="col-md-10">  
                <div class="jq_uploads_img" >
                   <?php if($model->goods_img):?>
                      <?php for($i=0;$i<count($model->goods_img);$i++):?>
                        <span style="width: 150px; height: 100px;float: left; margin-left: 5px; margin-top: 10px;">  <img width="80" height="80" src="<?=$model->goods_img[$i]?>">  <input type="hidden" name="GoodsSeckill[goods_img][]" value="<?=$model->goods_img[$i]?>" />    <a href="javascript:void(0);">取消</a>  </span>
                       <?php endfor;?>                
                    <?php endif;?>
                </div>
                <input id="file_upload_goods_img" name="file_upload" type="file" multiple="true"  />
            </div>

    </div>        
         <div class="form-group"> 
            
        </div>   
   
                 <script>

                        $("#photo_file_goods_thums").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'goodss'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#goodsseckill-goods_thums").val(data);

                                $("#goods_thums").attr('src', data).show();

                            }

                        });

                    </script>
    
    
   
                  <script>
                    $("#file_upload_goods_img").uploadify({

                        'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                        'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'goodss'])?>',

                        'cancelImg': '/static/uploadify/uploadify-cancel.png',

                        'buttonText': '上传图片',

                        'fileTypeExts': '*.gif;*.jpg;*.png;',

                        'queueSizeLimit': 10,
                        'fileObjName':'photo',
                        'onInit': function () {            
                            $("#upload_excel-queue").hide();
                         },
                        'onUploadSuccess': function (file, data, response) {
                        

         var str = '<span style="width: 150px; height: 100px; float: left; margin-left: 5px; margin-top: 10px;">  <img width="80" height="80" src="' + data + '">  <input type="hidden" name="GoodsSeckill[goods_img][]" value="' + data + '" />    <a href="javascript:void(0);">取消</a>  </span>';

                            $(".jq_uploads_img").append(str);
                            
                        }
                        

                    });

                    $(document).on("click", ".jq_uploads_img a", function () {

                        $(this).parent().remove();

                    });
                    
             </script>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'old_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->textInput() ?>
  
    <?= $form->field($model, 'surplus')->textInput() ?>


    <?= $form->field($model, 'start_time')->textInput() ?>

    
      <?= $form->field($model, 'hour')->dropDownList(SpikeTime::getSpiketime()) ?>

  	<?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[]); ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
      //执行一个laydate实例
laydate.render({
  elem: '#goodsseckill-end_time', //指定元素
  type: 'datetime'
});
    //执行一个laydate实例
laydate.render({
  elem: '#goodsseckill-start_time' //指定元素
});
</script>

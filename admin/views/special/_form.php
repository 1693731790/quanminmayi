<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Special */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<div class="special-form">

    <?php $form = ActiveForm::begin(); ?>
    
<div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">商品ID</label>
    <input type="text" style="width:300px;" id="special-goods_id" class="form-control" name="Special[goods_id]" aria-required="true" value="<?=$model->goods_id?>" readonly="readonly">
    <span class="btn btn-success" onclick="goodsid()">选择商品</span>

    <div class="help-block"></div>
</div>
    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->textInput(['readonly' => 'readonly']) ?>

    <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                    <img  id="img" width="212" height="152"  src="<?=$model->isNewRecord?'/upload/default.jpg':$model->img?>" />  
                </div>
                <input  id="photo_file_img"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>
    <script>

                        $("#photo_file_img").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'special'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#special-img").val(data);

                                $("#img").attr('src', data).show();

                            }

                        });

                    </script>
    
    <?= $form->field($model, 'ishome')->checkBox() ?>
    <?= $form->field($model, 'browse')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'orderby')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[]); ?>
    

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    function goodsid()
    {

        layer.open({
          type: 2,
          title: '选择商品id',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['goods/goods-select'])?>" //iframe的url
        }); 
    }

</script>
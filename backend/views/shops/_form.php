<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Shops */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<div class="shops-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">用户 ID</label>
    <input type="text" style="width:300px;" id="shops-user_id" class="form-control" name="Shops[user_id]" aria-required="true" value="<?=$model->user_id?>" readonly="readonly">
    <span class="btn btn-success" onclick="userid()">选择用户</span>

    <div class="help-block"></div>
</div>


    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'truename')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'id_front')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_front" width="212" height="152"  src="<?=$model->isNewRecord?'/uploads/default.jpg':$model->id_front?>" />  
         </div>
         <input  id="photo_file_id_front"  type="file" multiple="true" value="" />
    </div>
   
                 <script>

                        $("#photo_file_id_front").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'shops'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#shops-id_front").val(data);

                                $("#id_front").attr('src', data).show();

                            }

                        });

                    </script>
    
    <?= $form->field($model, 'id_back')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_back" width="212" height="152"  src="<?=$model->isNewRecord?'/upload/default.jpg':$model->id_back?>" />  
         </div>
         <input  id="photo_file_id_back"  type="file" multiple="true" value="" />
    </div>
   
                 <script>

                        $("#photo_file_id_back").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'shops'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#shops-id_back").val(data);

                                $("#id_back").attr('src', data).show();

                            }

                        });

                    </script>

    <?= $form->field($model, 'img')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="photo" width="212" height="152"  src="<?=$model->isNewRecord?'/upload/default.jpg':$model->img?>" />  
         </div>
         <input  id="photo_file" name="photo_file" type="file" multiple="true" value="" />
    </div>
   
                 <script>

                        $("#photo_file").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'shops'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#shops-img").val(data);

                                $("#photo").attr('src', data).show();

                            }

                        });

                    </script>


    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    
<!-- <div class="form-group field-shops-delivery_time required">
    <label class="control-label" for="shops-delivery_time">承诺配送时间（小时）</label>
    <input type="text" id="shops-delivery_time" class="form-control" name="Shops[delivery_time]" maxlength="50" aria-required="true" value="<?=$model->delivery_time?>">

    <div class="help-block"></div>
</div>  -->
   

   

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    function userid()
    {

        layer.open({
          type: 2,
          title: '选择用户id',
          shadeClose: true,
          shade: 0.8,
          area: ['700px', '90%'],
          content: "<?=Url::to(['user/user-select'])?>" //iframe的url
        }); 
    }

</script>


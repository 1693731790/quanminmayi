<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MobileCard */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<div class="mobile-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_pic')->textInput(['readonly'=>true]) ?>
	
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="title_pic" width="212" height="152"  src="<?=$model->isNewRecord?'/uploads/default.jpg':$model->title_pic?>" />  
         </div>
         <input  id="photo_file_title_pic"  type="file" multiple="true" value="" />
    </div>
   
                 <script>

                        $("#photo_file_title_pic").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'mobilecard'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#mobilecard-title_pic").val(data);

                                $("#title_pic").attr('src', data).show();

                            }

                        });

                    </script>
    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

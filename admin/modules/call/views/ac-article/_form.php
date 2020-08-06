<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AcArticleCate;
/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
  
    <?= $form->field($model, 'cate_id')->dropDownList(AcArticleCate::getCate()) ?>

    <?= $form->field($model, 'title_img')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="title_img" width="212" height="152"  src="<?=$model->isNewRecord?'/upload/default.jpg':$model->title_img?>" />  
         </div>
         <input  id="photo_file_title_img"  type="file" multiple="true" value="" />
    </div>
   
                 
    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'file_url')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        
         <input  id="photo_file_file_url"  type="file" multiple="true" value="" />
    </div>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[]); ?>
   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>

                        $("#photo_file_title_img").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'article'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#acarticle-title_img").val(data);

                                $("#title_img").attr('src', data).show();

                            }

                        });
  					$("#photo_file_file_url").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'article'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传文件',

                            'fileTypeExts': '*.zip;*.rar;*.pdf;*.doc;*.docx;*.xlsx;*.xls;*.pptx;*.ppt;*.rtf',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#acarticle-file_url").val(data);

                            

                            }

                        });
                    </script>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_img')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="title_img" width="212" height="152"  src="<?=$model->isNewRecord?'/upload/default.jpg':$model->title_img?>" />  
         </div>
         <input  id="photo_file_title_img"  type="file" multiple="true" value="" />
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

                                $("#article-title_img").val(data);

                                $("#title_img").attr('src', data).show();

                            }

                        });

                    </script>
    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>


    

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[
		'clientOptions' => [
        //编辑区域大小
        
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
        //定制菜单
        'toolbars' => [
            [
               
                'fontsize',
                'bold',
              	'italic',  
                 '|',
                'forecolor',
              	'backcolor', '|',
                'lineheight', '|',
                'indent',
              	'|',
              	
              	'simpleupload', //单图上传
           		
              
              	
            ],
        ],
		]]); ?>
   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">

<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
  
<div class="user-form">

 
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
  	
  

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
    
   <?= $form->field($model, 'type')->dropDownList(['1' =>"公司","2"=>"个人"]) ?>
   <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>
   
  	<?= $form->field($model, 'id_front')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_front" width="212" height="152"  src="/upload/default.jpg" />  
         </div>
         <input  id="photo_file_id_front"  type="file" multiple="true" value="" />
    </div>
 
   <?= $form->field($model, 'id_back')->textInput(['readonly'=>true]) ?>
   <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="id_back" width="212" height="152"  src="/upload/default.jpg" />  
         </div>
         <input  id="photo_file_id_back"  type="file" multiple="true" value="" />
    </div>
  
   <?= $form->field($model, 'id_num')->textInput(['maxlength' => true]) ?>
   
   <?= $form->field($model, 'corp_code')->textInput(['readonly'=>true]) ?>
   <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="corp_code" width="212" height="152"  src="/upload/default.jpg" />  
         </div>
         <input  id="photo_file_corp_code"  type="file" multiple="true" value="" />
    </div>
   <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'realname')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'corp_name')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'contract')->textInput(['readonly'=>true]) ?>
   <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
            <img  id="contract" width="212" height="152" src="/upload/default.jpg" />  
         </div>
         <input  id="photo_file_contract"  type="file" multiple="true" value="" />
    </div>

    
    
     <div class="form-group">
        <?= Html::submitButton(isset($model->isNewRecord) ? '提交' : '提交', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>


                 <script>

                        $("#photo_file_id_front").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'callagent'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#signupcallagent-id_front").val(data);

                                $("#id_front").attr('src', data).show();

                            }

                        });
                   $("#photo_file_id_back").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'callagent'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#signupcallagent-id_back").val(data);

                                $("#id_back").attr('src', data).show();

                            }

                        });
                     $("#photo_file_corp_code").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'callagent'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#signupcallagent-corp_code").val(data);

                                $("#corp_code").attr('src', data).show();

                            }

                        });
                     $("#photo_file_contract").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'callagent'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#signupcallagent-contract").val(data);

                                $("#contract").attr('src', data).show();

                            }

                        });

                    </script>

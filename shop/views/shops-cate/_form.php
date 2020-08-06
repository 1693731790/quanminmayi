<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ShopsCate */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<div class="shops-cate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(!empty($shop_id)):?>
  	<input type="hidden" id="shopscate-shop_id" class="form-control" name="ShopsCate[shop_id]" value="<?=$shop_id?>">
	<?php endif;?>
    <?= $form->field($model, 'img')->textInput(['readonly' => 'readonly']) ?>

    <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                    <img  id="img" width="212" height="152"  src="<?=$model->isNewRecord?'':$model->img?>" />  
                </div>
                <input  id="photo_file_img"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>
   
  	
    <script>
      
      				 $("#photo_file_img").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'shopscate'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#shopscate-img").val(data);

                                $("#img").attr('src', data).show();

                            }

                        });

                      

                    </script>
    

    

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

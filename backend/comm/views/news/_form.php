<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUploadUI;
use dosamigos\fileupload\FileUpload;
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'news_cat_id')->dropdownList(\common\models\NewsCat::find()->select(['name', 'id'])->indexBy('id')->column(),
    ['prompt'=>'请选择栏目']) ?>

    <?= $form->field($model, 'thumb')->textInput(['readonly'=>true]) ?>
    <div class="form-group">
        <div style="border: 1px dashed #ccc;width:212px;height:152px;">
        <?php if($model->thumb):?>
            <img  src="<?=$model->thumb?>" id="photo" width="210" height="150">
        <?php else:?>
            <img  id="photo" width="210" height="150">
        <?php endif?>
        </div>
     </div>
    <div class="form-group">
        <?= FileUpload::widget([
            'model' => new common\models\File,
            'attribute' => 'imageFile',
            'url' => ['upload/image-upload','dir'=>'news/thumb'],
            'options' => ['accept' => 'image/*'],
            'clientOptions' => [
                'maxFileSize' => 2000000
            ],
            'clientEvents' => [
                'fileuploaddone' => 'function(e,data) {
                                        var res=JSON.parse(data.result).files[0];
                                        $("#news-thumb").val(res.url);
                                        $("#photo").attr("src",res.url);
                                    }',
                'fileuploadfail' => 'function(e, data) {
                                        console.log(e);
                                        console.log(data);
                                    }',
            ],
        ]); ?>
    </div>


    <?php //echo $form->field($model, 'thumb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[]); ?>


    <?php //echo  $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php //echo  $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

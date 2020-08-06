<?php
use yii\helpers\Url;
use common\models\ShopsClass;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 $parent=ShopsClass::find()->asArray()->where(["pid"=>0])->all();

/* @var $this yii\web\View */
/* @var $model common\models\ShopsClass */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript" src="/static/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" href="/static/uploadify/uploadify.css">
<div class="shops-class-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="form-group field-shopsclass-name required">
	<label class="control-label" for="shopsclass-name">上级分类</label>
    <br/>
	<select  name="ShopsClass[pid]">
      <option value="0">顶级分类</option>
       <?php foreach($parent as $val):?>
             
             <option value="<?=$val['id']?>"><?=$val['name']?></option>
        <?php endforeach;?>
     </select>


</div>
  <input type="hidden"  name="ShopsClass[shop_id]" value="<?=$shop_id?>">
    <?= $form->field($model, 'img')->textInput(['readonly' => 'readonly']) ?>

    <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <div style="border: 1px dashed #ccc;width:212px;height:152px;margin-bottom: 10px;">
                    <img  id="goods_thums" width="212" height="152"  src="<?=$model->isNewRecord?'/uploads/default.jpg':$model->img?>" />  
                </div>
                <input  id="photo_file_goods_thums"  type="file" multiple="true" value="" />
                        
            </div>
           
        </div>
    </div>
  
    <script>

                        $("#photo_file_goods_thums").uploadify({

                            'swf': '/static/uploadify/uploadify.swf?t=<{$nowtime}>',

                            'uploader': '<?=Url::to(["upload/imgs","dirpath"=>'shopclass'])?>',

                            'cancelImg': '/static/uploadify/uploadify-cancel.png',

                            'buttonText': '上传图片',

                            'fileTypeExts': '*.gif;*.jpg;*.png',

                            'queueSizeLimit': 1,
                            'fileObjName':'photo',
                            'onUploadSuccess': function (file, data, response) {

                                $("#shopsclass-img").val(data);

                                $("#goods_thums").attr('src', data).show();

                            }

                        });

                    </script>
    
    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

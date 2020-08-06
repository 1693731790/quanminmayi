<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\ShopsClass */

$this->title = '关联品牌';

?>
<div class="shops-class-create">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="shops-class-form">
  <?php $form = ActiveForm::begin(); ?>


    <div class="form-group">
        <div class="row">
            
            <div class="col-md-10">
                <?php foreach($shopsCate as $key=>$val):?>
                  <div style="width:150px;height:70px; float:left;margin:10px 10px 10px 10px;border:1px #ccc solid;">
                        <label>
                          
        							<input type="checkbox" name="cate_id_str[]" value="<?=$val->id?>">                  
                          
							<img src="<?=$val->img?>" style="height:50px;width:130px;" />
                          	&nbsp;&nbsp;&nbsp;&nbsp;<?=$val->title?>
                        </label>
                  </div>
              <?php endforeach;?>
                        
            </div>
           
        </div>
    </div>
  
      <input type="hidden" name="class_id" value="<?=$id?>">
    
	

    <div class="form-group">
        <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>


</div>

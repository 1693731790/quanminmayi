<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\ShopCoupon */

$this->title = '优惠券管理';

?>


<div class="shop-coupon-update">

    <h1><?=$this->title ?></h1>
	
	<div class="shop-coupon-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">优惠券金额</label>
    <input type="text" style="width:300px;"  class="form-control" name="fee" aria-required="true" value="<?=isset($model->fee)?$model->fee:''?>" >
   
    <div class="help-block"></div>
</div>

<div class="form-group field-shops-user_id required">
    <label class="control-label" for="shops-user_id">领取优惠券后有效期天数</label>
    <input type="text" style="width:300px;"  class="form-control" name="end_time" aria-required="true" value="<?=isset($model->end_time)?$model->end_time:''?>">
   
    <div class="help-block"></div>
</div>

    
    <div class="form-group">
        <?= Html::submitButton('确认', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    

</div>

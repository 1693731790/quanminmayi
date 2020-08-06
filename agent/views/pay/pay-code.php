<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\AgentGrade;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = "支付";

?>




<div class="page-content" >
    <div class="form-inline">
    <div class="panel panel-default">
        
        <div class="col-md-10">
            <div class="panel panel-info">
              <div class="panel-heading">请使用<?=$pay_type=="1"?'支付宝':'微信'?>扫码支付</div>
              <div class="panel-body">
                
                <img style="height: 200px;width:200px;" src="<?=$imgcode?>">
                
              </div>
             </div>
        </div>
    </div>
    </div>

</div>
<script type="text/javascript">
   
</script>





       
  
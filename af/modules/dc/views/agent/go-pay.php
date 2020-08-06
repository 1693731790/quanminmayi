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
              <div class="panel-heading">请选择支付方式</div>
              <div class="panel-body">
                
                <img onclick="gopay(1)" style="height: 100px;width:200px; cursor:pointer;" src="/static/alipay.jpg">
                <img onclick="gopay(2)" style="height: 100px;width:250px; cursor:pointer;" src="/static/wxpay.jpg">
              </div>
             </div>

        </div>
      

    </div>
    </div>

</div>
<script type="text/javascript">
    function gopay(type)
    {
        var url="<?=Url::to(["pay/go-pay-all","all_pay_sn"=>$all_pay_sn])?>";
        window.location.href=url+"&pay_type="+type;
    }
</script>





       
  
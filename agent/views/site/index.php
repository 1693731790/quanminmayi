<?php
use common\models\Count;
/* @var $this yii\web\View */

$this->title = '代理商首页';
// $this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .log{
        border:1px solid #ccc;
        padding:10px;
        padding-left: 20px;
    }
    .log li{
        line-height: 30px;
    }
</style>

<!-- begin row -->
<div class="row ">

    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>我的钱包余额：</h4>
                <p><?=$balance?></p>
            </div>
        </div>
    </div>
   
   
   
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>我的代理商总数</h4>
                <p><?=$agentNum?></p>    
            </div>
        </div>
    </div>
   
   
</div>

</div>
</div>
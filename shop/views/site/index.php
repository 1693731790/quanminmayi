<?php
use common\models\Count;
/* @var $this yii\web\View */

$this->title = '后台首页';
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
                <h4>可提现总金额(元):</h4>
                <p><?=$balance?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>累计总收入(元):</h4>
                <p><?=$countFee?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>本月收入(元):</h4>
                <p><?=empty($mFee)?"0":$mFee?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>待处理订单：</h4>
                <p><?=$untreatedOrder?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>待确认收货订单：</h4>
                <p><?=$confirmOrder?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>总订单量</h4>
                <p><?=$countOrder?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>本月销量</h4>
                <p><?=$mOrder==""?"0":$mOrder?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>访客</h4>
                <p><?=$shop->browse?></p>
                    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>已退款订单总数</h4>
                <p><?=Count::getOrderCount("",'5')?></p>
            </div>
        </div>
    </div>
    
   
</div>

</div>
</div>
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
                <h4>会员总数</h4>
                <p><?=Count::getUserCount()?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>店铺总数</h4>
                <p><?=Count::getShopsCount()?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>待审核店铺总数</h4>
                <p><?=Count::getShopsCount("0")?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>订单总数</h4>
                <p><?=Count::getOrderCount()?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>已完成订单总数</h4>
                <p><?=Count::getOrderCount("",'3')?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>待支付订单总数</h4>
                <p><?=Count::getOrderCount("",'0')?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>已支付订单总数</h4>
                <p><?=Count::getOrderCount("",'1')?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>退款中订单总数</h4>
                <p><?=Count::getOrderCount("",'4')?></p>
                    
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
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>订单总金额</h4>
                <p><?=Count::getOrderFeeCount()?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>已完成订单金额</h4>
                <p><?=Count::getOrderFeeCount("","3")?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>商品总数</h4>
                <p><?=Count::getGoodsCount()?></p>    
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>待审核商品总数</h4>
                <p><?=Count::getGoodsCount("","0")?></p>
            </div>
        </div>
    </div>
   
</div>

</div>
</div>
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
  .widget{padding:15px;margin-bottom: 20px;
    color: #fff;border-radius: 3px;
    overflow: hidden;}
  .widget-stats .stats-info h4 {
    font-size: 12px;
    margin: 5px 0;
    color: #fff;}
  .widget-stats .stats-info p {
    font-size: 24px;
    font-weight: 300;
    margin-bottom: 0;
   }
</style>

<!-- begin row -->
<div class="row ">

    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"></div>
            <div class="stats-info">
                <h4>会员总数</h4>
                <p></p>
            </div>
        </div>
    </div>
   
   
</div>


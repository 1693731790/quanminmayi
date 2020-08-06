<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\GoodsCate;

$this->title ="商品详情";
?>
<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js'></script>
<style type="text/css">
.PurchaseOperation .left li {width: 50%;}
.coupon{font-size: 0.6rem;height: 1rem;line-height: 1rem;color: #ff5c36;padding: 0 0.5rem;border: 1px solid #f84e37;border-radius:5px;margin-top: 5px;}
.contentimg img{width:100%;height:100%;display:block;}
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
}
  table tr td{border:0;height:100%;display:block;}
img  
{  
  display: block;
  width:100%;
  height:100%;
  outline-width:0px;  
  vertical-align:top;  
}
.img-adventure{
  margin-bottom:12%;
}
p#back-to-top{
     position: fixed;
    display: none;
    bottom: 3rem;
    right: 1rem;
        }
</style>
 <link rel="stylesheet" type="text/css" href="/webstatic/css/particularspage.css">
<div class="outer">
 <div class="new-img"></div>
 <div class="left_new">
  <div class="left-left"><img class="pi-im" src="/webstatic/images/leftjiantou_07.png"/></div>
  <div class="left-right">上拉查看商品详情</div>
 </div>
 <div class="img-adventure" style="margin-bottom: 3rem">
  <?=$model->content?>
 </div>

</div>

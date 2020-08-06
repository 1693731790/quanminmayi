<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\GoodsCate;
$this->title ="商品详情";
?>
<style type="text/css">
.PurchaseOperation .left li {width: 50%;}
</style>


<div class="Web_Box">
<i class="TransparentBut TransparentReturn iconfont icon-leftdot" onClick="history.go(-1)"></i>


  <div class="CommodityDetails hidden">
    <div class="ProPic swiper-container bg_fff">
      <div class="swiper-wrapper">
        <?php for($ii=0;$ii<count($model->goods_img);$ii++):?>
            <div class="swiper-slide"><img src="<?=Yii::$app->params['imgurl'].$model->goods_img[$ii]?>" alt=""/></div>
        <?php endfor;?>
      </div>
      <div class="swiper-pagination3 tc"></div>
    </div>
    <script>
  $(window).load(function(){
    var mySwiper = new Swiper('.swiper-container', {
    autoplay: 3000,//可选选项，自动滑动
    pagination : '.swiper-pagination3',
    loop : true,
    autoplayDisableOnInteraction : false
    })
    }) 
  
  </script> 
    <!--商品基础信息Start-->
    <div class="BasicInfo">
      <div class="pl20 pr20 bg_fff hidden">
        <h1 class="slh2"><?=$model->goods_name?></h1>
        <p class="Classify">分类：<?=GoodsCate::getCateName($model->cate_id1)?> > <?=GoodsCate::getCateName($model->cate_id2)?> > <?=GoodsCate::getCateName($model->cate_id3)?></p>
        <p class="Price"><span class="PresentPrice">￥<?=$model->price?></span><span class="OriginalPrice">￥<?=$model->old_price?></span></p>
        <p class="Freight"> <span class="cr_595757">运费：<?=$model->freight>=0?"免运费":$model->freight?></span> </p>
      </div>
      <!-- <div class="Service"> <i class="iconfont icon-genuine"></i> <span>正品保障</span> <i class="iconfont icon-freeshipping"></i> <span>全场包邮</span> </div> -->
    </div>
    <!--商品基础信息End--> 
   
    
    <!--商品评价Start-->
    <div class="CommodityEvaluation mt20 bor_b_dcdddd">
      <div class="tit">
        <h2>商品评价 (<?=$countComment?>)</h2>
        <div class="data">好评率<span class="cr_ff5c36"><?=$goodCommentRate?>%</span></div>
      </div>
      <div class="CommentList hidden">
        <ul>
          <?php foreach($goodsComment as $commentVal):?>
          <li>
            <div class="user">
              <div class="pic"><img src="<?=Yii::$app->params["imgurl"].$commentVal->user->headimgurl?>" alt=""/></div>
              <span><?=$commentVal->userAuth->identifier!=""?$commentVal->userAuth->identifier:'匿名用户'?></span> </div>
            <p class="text"><?=$commentVal->content?></p>
            <p class="date"><?=date("Y-m-d H:i:s",$commentVal->create_time)?></p>
          </li>
          <?php endforeach;?>
        </ul>
        <a href="<?=Url::to(["goods/goods-comment",'goods_id'=>$model->goods_id])?>"><div class="more">查看更多评价</div></a>
      </div>
    </div>
    <!--商品评价End--> 

    <!--上拉Start-->
    <div class="DetailsEntry"><span >上拉，查看商品详情</span></div>
    <!--上拉End--> 
    <!--商品详情Start-->
    <div id="">
      <?=$model->content?>
    </div>
    <!--商品详情End-->
    
  </div>
</div>
<div class="CommodityShelf"><?=$message?></div>
<div class="PurchaseOperation gd">
  <div class="left fl">
    <ul>
      <li><a href="<?=Url::to(['shop/shop-info',"shop_id"=>$model->shop_id])?>"><i class="iconfont icon-shop"></i> <span>店铺</span></a></li>
      <li><a href="javascript:;" onclick="goodsfavorite()"><i class="iconfont icon-classification"></i> <span>收藏</span></a></li>
    </ul>
  </div>
  <div class="right fr">
    <button type="button" class="but bg_ffbd0c">加入购物车</button>
    <button type="button" class="but bg_ff5c36" onClick="OpenPop('#PopBg,#AttributeSelectionPop')">立即购买</button>
    <div class="tm"></div>
  </div>
</div>
<!--弹窗-->

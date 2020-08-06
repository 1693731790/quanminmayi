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
  <!-- <i class="TransparentBut TransparentList iconfont icon-list"></i>
  <i class="TransparentBut TransparentCollection iconfont icon-collection"></i> -->
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
         <p class="Price"><span style="color:#ff5c36;font-size: 0.7rem;font-weight: 700;">剩余 <?=$robBuy->num?> 件</span></p>
        <p class="Classify">分类：<?=GoodsCate::getCateName($model->cate_id1)?> > <?=GoodsCate::getCateName($model->cate_id2)?> > <?=GoodsCate::getCateName($model->cate_id3)?></p>
        <p class="Price"><span class="PresentPrice">秒杀价￥<?=$robBuy->price?></span><span class="OriginalPrice">￥<?=$model->old_price?></span></p>

        <p class="Freight"> <span class="cr_595757">运费：<?=$model->freight>=0?"免运费":$model->freight?></span> </p>
      </div>
      <!-- <div class="Service"> <i class="iconfont icon-genuine"></i> <span>正品保障</span> <i class="iconfont icon-freeshipping"></i> <span>全场包邮</span> </div> -->
    </div>
    <!--商品基础信息End--> 
    <!--商品属性Start-->
    <div class="CommodityAttribute mt20" onClick="OpenPop('#PopBg,#AttributeSelectionPop')"> <span>请选择  规格  数量</span> <i class="iconfont icon-rightdot fr"></i> </div>
    <!--商品属性End--> 

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
<div class="PurchaseOperation gd">
  <div class="left fl">
    <ul>
  
      <li><a href="<?=Url::to(['shops/shop-info',"shop_id"=>$model->shop_id])?>"><i class="iconfont icon-shop"></i> <span>店铺</span></a></li>
      <li><a href="javascript:;" onclick="goodsfavorite()"><i class="iconfont icon-classification"></i> <span>收藏</span></a></li>
    </ul>
  </div>
  <div class="right fr">
    
    <button type="button" class="but bg_ff5c36" style="width: 9.2rem;" onClick="OpenPop('#PopBg,#AttributeSelectionPop')">立即购买</button>
  </div>
</div>

<script type="text/javascript">
  function goodsfavorite()//加入收藏
  {
      $.get("<?=Url::to(['goods/favorite'])?>",{"goods_id":"<?=$model->goods_id?>"},function(r){

          if(r.success==true)
          {
              layer.msg(r.message);
          }else{
              layer.msg(r.message);
          }
      },'json')
  }
</script>


<!--弹窗-->
<div class="PopBg disn" id="PopBg"></div>
<!--选择商品属性弹窗Start-->
<div class="AttributeSelectionPop disn" id="AttributeSelectionPop">
  <div class="BasicInfo">
  <i class="iconfont icon-close" onClick="ClosePop('#PopBg,#AttributeSelectionPop')"></i>
    <div class="pic"><img src="<?=Yii::$app->params['imgurl'].$model->goods_thums?>" alt=""/></div>
    <p class="Price fl skuprice">￥<?=$robBuy->price?></p>
    <p class="Stock c">库存<span class="ml20 skustock"><?=empty($goodsStock)?$model->stock:$goodsStock?></span></p>
    <?php if(!empty($attrData)):?>
    <p class="SelectedAttributes hidden slh">已选<span class="ml20" id="attrname"></span></p>
  <?php endif;?>
  </div>

    <?php foreach($attrData as $attrDatas):?>
        <div class="AttributeList attr">
          <h3><?=$attrDatas['attrkey']?></h3>
          <ul>
          <?php foreach($attrDatas['attrval'] as $attrDataVal):?>
            <li data-id="<?=$attrDataVal['attr_id']?>"><?=$attrDataVal['attr_val_name']?></li>
            
          <?php endforeach;?>
            <input type="hidden" name="attrname" value="">
            <input type="hidden" name="attrid" value="">
          </ul>
          
        </div>
    <?php endforeach;?>
<script type="text/javascript">
$(function(){
  $(".attr ul li").click(function(){
      $(this).parent().find("li").removeClass("on");
      $(this).addClass("on");

      var attrname=$(this).text();
      $(this).parent().find("input[name=attrname]").val(attrname);
      var attrid=$(this).attr('data-id');
      $(this).parent().find("input[name=attrid]").val(attrid);

      var attrstr="";
      $(".attr ul input[name=attrname]").each(function(r){
          attrstr+=this.value+" ";    
      })

      var checkall=true//是否全部选择
      var attridstr="";
      $(".attr ul input[name=attrid]").each(function(r){
          if(this.value=="")
          {
              checkall=false;
          }
          attridstr+=this.value+"_";
      })
      if(checkall)
      {
          $.get("<?=Url::to(["goods/goods-sku"])?>",{"skuPath":attridstr},function(data){
             // $(".skuprice").text("￥"+data.price);
              $(".skustock").text(data.stock);
             // $("input[name=price]").val(data.price);
          },'json')
      }
      //console.log(this.value)  
      //;

      $("#attrname").text(attrstr);
      $("input[name=skuPath]").val(attridstr);
  })

  $(".addorder").click(function(){
      var formok=true;
      $(".attr ul input[name=attrid]").each(function(r){
          if(this.value=="")
          {
              layer.msg("请选择规格");
              formok=false;
          }
      })
      var goodsnum=parseInt($("input[name=goodsnum]").val());
      var robnum=parseInt("<?=$robBuy->num?>");
      
      if(goodsnum>robnum)
      {
          layer.msg("剩余秒杀数量不足");
          formok=false;
      }
      
      if(formok)
      {
          $("#orderform").submit();  
      }
      
  })
 

})
  
</script>
<form id="orderform" action="<?=Url::to(['rob-buy/add-order'])?>" method="post">
  <input type="hidden" name="goods_id" value="<?=$model->goods_id?>">
  <input type="hidden" name="shop_id" value="<?=$model->shop_id?>">
  <input type="hidden" name="skuPath" value="">
  <input type="hidden" name="rob_id" value="<?=$robBuy->rob_id?>">
  
  <div class="Number">
    <h3>数量</h3>
    
    <div class="QuantityControl">

        <i class="iconfont icon-reduce fl no" id="min"></i>
        <span class="num fl"><input id="text_box" name="goodsnum" type="text" value="1" style="width:50px;height:25px;font-size:20px;text-align: center;border: none; color:#848181"/> </span>
        <i class="iconfont icon-increase fr " id="add"></i> 
        
    </div>
  </div>
</form>
  <div class="OperationButton">
    
    <button type="button" class="fr bg_ff5c36 addorder" style="width:100%">立即购买</button>
  </div>
</div>

<script>
  $(function(){
    var message="<?=$msg?>";
    if(message!="")
    {
      layer.msg(message);
    }
  })
$(document).ready(function(){
     //获得文本框对象
     var t = $("#text_box");
     
     
     //数量增加操作
     $("#add").click(function(){ 
        // 给获取的val加上绝对值，避免出现负数
        t.val(Math.abs(parseInt(t.val()))+1);
        if(t.val()>=1)
        {
              $("#min").removeClass("no");
        }
     }) 
     //数量减少操作
     $("#min").click(function(){
       if(t.val()>1)
       {
          t.val(Math.abs(parseInt(t.val()))-1); 
       }
       if(t.val()==1)
       {
            $(this).addClass("no");
       }else{
            $(this).removeClass("no");
       }
       
       
     })
});
</script>
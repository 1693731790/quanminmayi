<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title ="商品详情";
?>
<style type="text/css">
.PurchaseOperation .left li {width: 50%;}
.coupon{font-size: 0.6rem;height: 1rem;line-height: 1rem;color: #ff5c36;padding: 0 0.5rem;border: 1px solid #f84e37;border-radius:5px;margin-top: 5px;}
.contentimg img{width:100%;}
  table tr td{border:0}
  img  
{  
  outline-width:0px;  
  vertical-align:top;  
}
</style>

<div class="Web_Box">
  <i class="TransparentBut TransparentReturn iconfont icon-leftdot" onClick="history.go(-1)"></i>
  <!-- <i class="TransparentBut TransparentList iconfont icon-list"></i>
  <i class="TransparentBut TransparentCollection iconfont icon-collection"></i> -->
  <div class="CommodityDetails hidden">
    <div class="ProPic swiper-container bg_fff">
      <div class="swiper-wrapper" style="text-align:center;">
         <?php if($model->goods_img!=""):?>
        <?php for($ii=0;$ii<count($model->goods_img);$ii++):?>
            <div class="swiper-slide"><img src="<?=Yii::$app->params['imgurl'].$model->goods_img[$ii]?>" alt=""/></div>
        <?php endfor;?>
        <?php else:?>
            <div class="swiper-slide"><img src="<?=Yii::$app->params['imgurl'].$model->goods_thums?>" alt=""/></div>
        <?php endif;?>
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
        <p class="Price"><span class="PresentPrice">￥<?=$model->price?></span><span class="OriginalPrice">￥<?=$model->old_price?></span></p>
        
       
      </div>
      <!-- <div class="Service"> <i class="iconfont icon-genuine"></i> <span>正品保障</span> <i class="iconfont icon-freeshipping"></i> <span>全场包邮</span> </div> -->
    </div>
    
    <!--商品属性End--> 
   

    <!--上拉Start-->
    <div class="DetailsEntry"><span >上拉，查看商品详情</span></div>
    <!--上拉End--> 
    <!--商品详情Start-->
    <div class="contentimg" >
      <?=$model->content?>
    </div>
    <!--商品详情End-->
  </div>
</div>

<div class="PurchaseOperation gd">
  <div class="right fr" style="width:100%">
    <?php if($model->surplus==0||$model->surplus<0):?>
    <button type="button" class="but bg_ff5c36" onclick="goodsCheck(1)" style="width:100%">立即购买</button>
    <?php else:?>
    	<?php if($seckillok):?>
    		<button type="button" class="but bg_ff5c36" onClick="OpenPop('#PopBg,#AttributeSelectionPop')" style="width:100%">立即购买</button>
    	<?php else:?>
			<button type="button" class="but bg_ff5c36" onclick="goodsCheck(2)"  style="width:100%;background: #dddddd">未开始</button>
    	<?php endif;?>
    <?php endif;?>
  </div>
</div>





<!--弹窗-->
<div class="PopBg disn" id="PopBg"></div>
<!--选择商品属性弹窗Start-->
<div class="AttributeSelectionPop disn" id="AttributeSelectionPop">
  <div class="BasicInfo">
  <i class="iconfont icon-close" onClick="ClosePop('#PopBg,#AttributeSelectionPop')"></i>
    <div class="pic"><img src="<?=Yii::$app->params['imgurl'].$model->goods_thums?>" alt=""/></div>
    <p class="Price fl skuprice">￥<?=$model->price?></p>
    <p class="Stock c">库存<span class="ml20 skustock"><?=$model->surplus?></span></p>
   
  </div>

<form id="orderform" action="<?=Url::to(['seckill/add-order'])?>" method="post">
  <input type="hidden" name="goods_id" value="<?=$model->goods_id?>">
  
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


<script type="text/javascript">
function goodsCheck(type)
{
	if(type=="1")
	{
		layer.msg("库存不足,无法购买");
	}else if(type=="2"){
		layer.msg("秒杀时间未开始");
	}
}
$(function(){
  
  $(".addorder").click(function(){
      var num=$("input[name=goodsnum]").val();
      $.get("<?=Url::to(["seckill/stock-check"])?>",{"goods_id":"<?=$model->goods_id?>","num":num},function(r){
      		if(r.success)
      		{
      			//layer.msg("ok");  		
      			window.location.href="<?=Url::to(['seckill/add-order'])?>"+"?goods_id=<?=$model->goods_id?>&goodsnum="+num;
              	 
                 //$("#orderform").submit();
      		}else{
      			layer.msg("该商品库存不足");  		
      		}
      },"json")
          
      
      
  })
 

})
  
</script>


<script>
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
$(function(){
  $("table").width(0);
})
</script>

<script>

$(function(){
  $("table").width(0);
})
</script>
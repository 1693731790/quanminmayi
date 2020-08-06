<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\GoodsCate;
use yii\web\JSSDK;
$this->title ="商品详情";
$class=new JSSDK(Yii::$app->params['WECHAT']["app_id"],Yii::$app->params['WECHAT']["secret"]);
$wxconfig=$class->getSignPackage();
?>

<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>

<style type="text/css">
.PurchaseOperation .left li {width: 50%;}
.coupon{font-size: 0.6rem;height: 1rem;line-height: 1rem;color: #ff5c36;padding: 0 0.5rem;border: 1px solid #f84e37;border-radius:5px;margin-top: 5px;}
.contentimg img{width:100%;}
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

<?php if($code!=""&&strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false):?>
<a href="<?=Url::to(["site/upapp"])?>"><div class="zhuce"><span class="apii">下载APP&nbsp></span></div></a>
<a href="<?=Url::to(["site/signup","code"=>$code,"goods_id"=>$model->goods_id])?>"><div class="zhuce" style="top:2.3rem;"><span class="apii">注册&nbsp></span></div></a>
<a href="<?=Url::to(["site/login","goods_id"=>$model->goods_id])?>"><div class="zhuce" style="top:3.6rem;"><span class="apii">登录&nbsp></span></div></a>
<?php endif; ?>
<header>
  	  <?php if($code!=""&&strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false):?>
      	<a href="<?=Url::to(["index/index"])?>"><div class="_lefte"><img class="shopp" src="/webstatic/images/nva_03.png"/></div></a>
      <?php else:?>
       	<a href="javascript:;" onclick="javascript:history.go(-1)"><div class="_lefte"><img class="shopp" src="/webstatic/images/nva_03.png"/></div></a>
      <?php endif; ?>
        
</header>
<p id="back-to-top"><a href="#top"><img class="widgh-img" src="/webstatic/images/fanhuidingbu.png"/></a></p>
<div class="outer">
 <div class="index-banner">
    <ul class=" swiper-wrapper" >
        <?php if($model->goods_img!=""):?>
        <?php for($ii=0;$ii<count($model->goods_img);$ii++):?>
            <li class="first swiper-slide"><img class="img-s" src="<?=Yii::$app->params['imgurl'].$model->goods_img[$ii]?>"/></li>
        <?php endfor;?>
        <?php else:?>
            <li class="first swiper-slide"><img class="img-s" src="<?=Yii::$app->params['imgurl'].$model->goods_thums?>"/></li>
            
        <?php endif;?>  
        
     <div class="swiper-pagination3 tc"></div>
    </ul>
    <script>
      $(window).load(function(){
        var mySwiper = new Swiper('.index-banner', {
        autoplay: 3000,//可选选项，自动滑动
        pagination : '.swiper-pagination3',
        loop : true,
        autoplayDisableOnInteraction : false
        })
      }) 
    </script> 
 </div>
  <div class="color-say"></div>
  <div class="outertwo">
    <div class="outertwoone">
      <div class="outertwooneq"><?=$model->goods_name?></div>
      <div class="outertwoonew"><img class="pis" src="/webstatic/images/fenxiang1_03.jpg"/></div>
    </div>
    <div class="outertwotwo">¥<?=$model->price?>&nbsp<span class="haha">¥<?=$model->old_price?></span></div>
     <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')):?>
 	<!--<div class="outertwothree">使用话费抵扣:&nbsp&nbsp<span class="hahas">¥<?=$oneDeductions?></span></div>-->
  <?php else:?>
   <div class="outertwothree">使用话费抵扣:&nbsp&nbsp<span class="hahas">¥<?=$oneDeductions?></span></div>
  <?php endif;?>
   
    
    <div class="outertwofour">
      <div class="outertwofourone">销量：&nbsp<?=$model->salecount?><span class="outertwofourtwo"></span></div>
    </div>
    <div class="outertwofive" onClick="OpenPop('#PopBg,#AttributeSelectionPop')">
      <div class="outertwofiveone">请选择&nbsp&nbsp&nbsp规格&nbsp&nbsp&nbsp数量</div>
      <div class="outertwofiveone-img"><img class="pisss" src="/webstatic/images/leftjiantou_03.png"/></div>
    </div>
  </div>
        <div class="new-img"></div>
 <div class="left_new">
  <div class="left-left"><img class="pi-im" src="/webstatic/images/leftjiantou_07.png"/></div>
  <div class="left-right">上拉查看商品详情</div>
 </div>
 <div class="img-adventure" style="margin-bottom: 3rem">
  <?=$model->content?>
 </div>
  <div class="tanchubox">
     <div class="tanchubox-img">
        <div class="tanchubox-imging"><img class="pip" src="<?=$model->goods_thums?>"></div>
        <div class="tanchubox-title"><?=$model->goods_name?></div>

        <div class="tanchubox-price">
          <div class="tanchubox-pricenew">
               <!-- <div class="title-s">舒适轻薄，轻便舒适</div> -->
          ¥<?=$model->price?>&nbsp<span class="tanchubox-priceold">¥<?=$model->old_price?></span>
          </div>
          <div class="tanchubox-erweima">
            <img class="piv" src="<?=$resQrcode?>">
          </div>
        </div>
      <div class="tanchubox-close">  <img class="pi-ss" src="/webstatic/images/qwo.png"> </div> 
    </div>
  </div>
</div>
<div class="PurchaseOperation gd">
  <div class="left fl">
    <ul>
  
      <li><a href="<?=Url::to(['shops/shop-info',"shop_id"=>$model->shop_id])?>"><i class="iconfont icon-shop siseeee"></i> <span>店铺</span></a></li>
      <li><a href="javascript:;" onclick="goodsfavorite()"><i class="iconfont icon-classification siseeee"></i> <span>收藏</span></a></li>
    </ul>
  </div>
  <div class="right fr">
    <?php if($model->is_agent_buy!="1"): ?>
        <button type="button" class="but bg_ffbd0c" onClick="OpenPop('#PopBg,#AttributeSelectionPop')">加入购物车</button>
    <?php else:?>
        <button type="button" class="but bg_ffbd0c" style="background:#dedede" >加入购物车</button>    
    <?php endif;?>
    <button type="button" class="but bg_ff5c36" onClick="OpenPop('#PopBg,#AttributeSelectionPop')">立即购买</button>
  </div>
</div>
<script type="text/javascript">
  function coupon(shop_coupon_id){//领取优惠券
       $.get("<?=Url::to(['coupon/add-coupon'])?>",{"shop_coupon_id":shop_coupon_id},function(r){

          if(r.success==true)
          {
              layer.msg(r.message);
          }else{
              layer.msg(r.message);
          }
      },'json')
  }
  function goodsfavorite()//加入收藏
  {
      <?php if($code!=""&&strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false&&$isGuest):?>
        layer.msg("请先注册登录");
        return false;

      <?php endif;?>
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
<div class="fenxiang">
    <div class="fenxiang-img">
    <div class="fenxiangs">
    <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')===false):?>
        <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')): ?>  
          <div class="fenxiangsleft" id="share"><img class="partic" src="/webstatic/images/zlewm_03.png"></div>
        <?php endif;?>  
      <?php else:?>
      <div class="fenxiangsleft" id="searchwx"><img class="partic" src="/webstatic/images/zlewm_03.png"></div>
      <?php endif;?> 
          
      
    <div class="fenxiangsright"><img class="partics" src="/webstatic/images/zlewm_05.png"></div>
    </div>
    <div class="coloe">取消</div>
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
    <?php if($model->shop_id!="1"):?>
        <p class="Stock c">库存<span class="ml20 skustock"><?=empty($goodsStock)?$model->stock:$goodsStock?></span></p>
    <?php endif;?>
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
  
  
<script src="/hbuilderplusto/share/plusShare.js" type="text/javascript" charset="utf-8"></script>
<script>
    document.getElementById("share").addEventListener("click", function() {
        if(navigator.userAgent.indexOf("Html5Plus") > -1) {
            //5+ 原生分享
            window.plusShare({
                title: "全民蚂蚁商城",//应用名字
                content: "<?=$model->goods_name?>",
                href: "<?=$searchLink?>",//分享出去后，点击跳转地址
                thumbs: ["<?=$shareImg?>"] //分享缩略图
            }, function(result) {
                //分享回调
            });
        } else {
            //原有wap分享实现 
        }
    });
 

</script>
  
<script type="text/javascript">
$(function(){
  $("#searchwx").click(function(){
     wx.miniProgram.getEnv(function(res) {
       if(res.miniprogram){
         // true代表在小程序里

        // alert("<?=$shareImg?>");
		//alert("/pages/share/share?title=<?=$model->goods_name?>&shareurl=\"<?=$searchLink?>\"&imagelink=<?=$shareImg?>");
         <?php if($user_code!=""):?>
           wx.miniProgram.navigateTo({url:"/pages/share/share?title=<?=$model->goods_name?>&imagelink=<?=$shareImg?>&goods_sn=<?=$model->goods_sn?>&goods_id=<?=$model->goods_id?>&type=1&user_code=<?=$user_code?>&order_sn=no&price=<?=$model->price?>&old_price=<?=$model->old_price?>&salecount=<?=$model->salecount?>"});
         
         <?php else:?>
           wx.miniProgram.navigateTo({url:"/pages/share/share?title=<?=$model->goods_name?>&imagelink=<?=$shareImg?>&goods_sn=<?=$model->goods_sn?>&goods_id=<?=$model->goods_id?>&user_code=no&type=1&order_sn=no&price=<?=$model->price?>&old_price=<?=$model->old_price?>&salecount=<?=$model->salecount?>"});
         <?php endif;?>
        
         
       }else{
         //alert("小程序与1");
         //false代表在公众号里
     	layer.msg("点击右上角分享到微信");   
       }
     })
     
    //alert(123);
  })
  
  $(".tanchubox-close").click(function(){
     $(".fenxiang").hide();
    });

  $(".outertwoonew").click(function(){
     $(".fenxiang").show();
    });
  $(".fenxiangsright").click(function(){
     $(".tanchubox").show();
    });

 /*规格弹出框*/
  $(".outertwofiveone-img").click(function(){
     $(".box-show").show();
    });
   $(".box-bottom-cloes").click(function(){
     $(".box-show").hide();
    });

   $(".coloe").click(function(){
     $(".fenxiang").hide();
    });

    $(".tanchubox-close").click(function(){
         $(".tanchubox").hide();
    });
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
              $(".skuprice").text("￥"+data.price);
              $(".skustock").text(data.stock);
              $("input[name=price]").val(data.price);
          },'json')
      }
      //console.log(this.value)  
      //;

      $("#attrname").text(attrstr);
      $("input[name=skuPath]").val(attridstr);
  })

  $(".addorder").click(function(){
      <?php if($code!=""&&strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false&&$isGuest):?>
        layer.msg("请先注册登录");
        return false;

      <?php endif;?>
      var formok=true;
      $(".attr ul input[name=attrid]").each(function(r){
          if(this.value=="")
          {
              layer.msg("请选择规格");
              formok=false;
          }
      })
      if(formok)
      {
          $("#orderform").submit();  
      }
  })
  $(".addshopcar").click(function(){
      <?php if($code!=""&&strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')!==false&&$isGuest):?>
        layer.msg("请先注册登录");
        return false;
	
      <?php endif;?>
    <?php if($model->is_group=="1"):?>
        layer.msg("该商品不支持加入购物车");
        return false;
	
      <?php endif;?>
      var formok=true;
      $(".attr ul input[name=attrid]").each(function(r){
          if(this.value=="")
          {
              layer.msg("请选择规格");
              formok=false;
          }
      })
      if(formok)
      {
         $.get("<?=Url::to(["shopcar/add-shopcar"])?>",$("#orderform").serialize(),function(r){
              layer.msg(r.message);
        },'json')     
     }   
  })
})
/*返回顶部*/
$(function(){
        //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
        $(function () {
            $(window).scroll(function(){
                if ($(window).scrollTop()>100){
                    $("#back-to-top").fadeIn(1500);
                }
                else
                {
                    $("#back-to-top").fadeOut(1500);
                }
            });
 
            //当点击跳转链接后，回到页面顶部位置
            $("#back-to-top").click(function(){
                if ($('html').scrollTop()) {
                    $('html').animate({ scrollTop: 0 }, 100);//动画效果
                    return false;
                }
                $('body').animate({ scrollTop: 0 }, 100);
                return false;
            });
        });
    });
</script>
<form id="orderform" action="<?=Url::to(['goods/add-order'])?>" method="post">
  <input type="hidden" name="goods_id" value="<?=$model->goods_id?>">
  <input type="hidden" name="shop_id" value="<?=$model->shop_id?>">
  <input type="hidden" name="skuPath" value="">
  <div class="Number">
    <h3>数量</h3>
    <div class="QuantityControl">
        <i class="iconfont icon-reduce fl no" id="min"></i>
        <span class="num fl"><input id="text_box" name="goodsnum" readonly="readonly" type="text" value="1" style="width:50px;height:25px;font-size:20px;text-align: center;border: none; color:#848181"/> </span>
        <i class="iconfont icon-increase fr " id="add"></i> 
        
    </div>
  </div>
</form>
  <div class="OperationButton">
    <?php if($model->is_agent_buy!="1"): ?>
        <button type="button" class="fl bg_ffbd0c addshopcar">加入购物车</button>
    <?php else:?>
        <button type="button" class="fl bg_ffbd0c" style="background:#dedede">加入购物车</button>
    <?php endif;?>
    <button type="button" class="fr bg_ff5c36 addorder">立即购买</button>
  </div>
</div>
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
<script type="text/javascript">

            wx.config({
                debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId: '<?=$wxconfig["appId"]?>', // 必填，公众号的唯一标识
                timestamp: '<?=$wxconfig["timeStamp"]?>', // 必填，生成签名的时间戳
                nonceStr: '<?=$wxconfig["nonceStr"]?>', // 必填，生成签名的随机串
                signature: '<?=$wxconfig["signature"]?>',// 必填，签名，见附录1
                jsApiList: [
                    'onMenuShareAppMessage',
                    'onMenuShareTimeline',
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });
		 wx.ready(function(){
             
                  wx.onMenuShareAppMessage({
                       title: '全民蚂蚁商城', // 分享标题
                       desc:"<?=$model->goods_name?>",
	                   link: '<?=$searchLink?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	                   imgUrl: '<?=$shareImg?>', // 分享图标
                      success: function (res) {
                          alert('已分享');
                      },
                      cancel: function (res) {
                          alert('已取消');
                      },
                      fail: function (res) {
                          alert("分享失败");
                      }
                  });
                  //alert('已注册获取“发送给朋友”状态事件');
              	
              wx.onMenuShareTimeline({
                      title: '全民蚂蚁商城', // 分享标题
                       desc:"<?=$model->goods_name?>",
	                   link: '<?=$searchLink?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	                   imgUrl: '<?=$shareImg?>', // 分享图标
                  
                  success: function (res) {
                     alert('已分享');
                  },
                  cancel: function (res) {
                     alert('已取消');
                  },
                  fail: function (res) {
                     alert("分享失败");
                  }
              });
            });	
   			
              
            
           

          
        </script> 



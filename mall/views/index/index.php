<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="全民蚂蚁";
/*var_dump($goodsSeckill);
die();*/
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/reset_m.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/main.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/layout2015.css" charset="gbk">

<style>
  
 a:hover {
    color: #666;
} 
  .daojishi{background:none;padding:0;font-size:0.5rem;}
</style>

<!-- 头部 -->
<header class="module-layer">
    <div class="module-layer-content">
        <div class="module-layer-bg"></div>
        <div class="search-box-cover"></div>
        <p class="layer-logo"><img src="/webstatic/images/logo.png"></p>
        <h1 class="layer-head-name">
            <div class="pr search-box">
                <img id="searchSub" class="shop-search" src="/webstatic/images/icon_search.png"/>
                <input id="shop-input" type="text" placeholder="" />
            </div>
            <input type="hidden" id="searchType"  value="1">
        </h1>
        <p class="layer-login" > <a href="<?=Url::to(['shopcar/shopcar-list'])?>"><img class="che" src="/webstatic/images/tuiche.png"></a> </p>
    </div>
</header>
 <script type="text/javascript">
      function searchType(type)
      {
          $("#searchType").val(type);
      }
      $(function(){
        $("#searchSub").click(function(){
            var type=$("#searchType").val();
            
            var key=$("#shop-input").val();

            if(key=="")
            {
                layer.msg("请输入要搜索的内容");
                return false;
            }
            if(type==1)
            {
                var url="<?=Url::to(['search/goods'])?>";
                window.location.href=url+"?searchKey="+key;
            }else{
                var url="<?=Url::to(['search/shops'])?>";
                window.location.href=url+"?searchKey="+key;
            }
            
        })
    })
    </script> 

<div class="out">
    <div id="slideBox" class="slideBox">
        <div class="hd">
            <ul></ul>
        </div>
        <div class="bd">
            <ul>
                 <?php foreach($banner as $bannerval):?>
                <li>
                    <a class="pic" href="<?=$bannerval->url?>"><img src="<?=yii::$app->params['imgurl'].$bannerval->img?>"/></a>
                </li>
               <?php endforeach;?>
            </ul>
        </div>
    </div>
    <div class="pg-index">
        <div class="panelout">
            <div class="flex panelinn text-center">
               <div class="flexitem">
                    <a href="<?=URL::to(["goods/index","isselected"=>1])?>">
                        <img src="/webstatic/images/bna.jpg" alt="" width="40" class="inlineblock">
                        <p class="sizeq">精选商品</p>
                    </a>
                </div>
                <div class="flexitem">
                    <a href="<?=URL::to(["goods/index","istodaynew"=>1])?>">
                        <img src="/webstatic/images/bna2.jpg" alt="" width="40" class="inlineblock">
                        <p class="sizeq">今日上新</p>
                    </a>
                </div>
                <div class="flexitem">
                    <a href="<?=URL::to(["share-free/index"])?>">
                        <img src="/webstatic/images/bna3.jpg" alt="" width="40" class="inlineblock">
                        <p class="sizeq">免费拿</p>
                    </a>
                </div>
                <div class="flexitem">
                    <a href="<?=URL::to(["user-upgrade/goods"])?>">
                        <img src="/webstatic/images/bna4.jpg" alt="" width="40" class="inlineblock">
                        <p class="sizeq">大礼包</p>
                    </a>
                </div>
            </div>
            <div class="flex panelinn text-center">
                <div class="flexitem">
                    <a href="<?=URL::to(["goods/index","isdiscount"=>"1"])?>">
                        <img src="/webstatic/images/bna6.jpg" alt="" width="40" class="inlineblock">
                        <p class="sizeq">特价馆</p>
                    </a>
                </div>
                <div class="flexitem">
                    <a href="<?=URL::to(["goods/index","isdigital"=>"1"])?>">
                        <img src="/webstatic/images/bna5.jpg" alt="" width="40" class="inlineblock">
                        <p class="sizeq">数码馆</p>
                    </a>
                </div>
                <div class="flexitem">
                    <a href="<?=URL::to(["seckill/index"])?>">
                        <img src="/webstatic/images/qifusa.png" alt="" width="40" class="inlineblock">
                        <p class="sizeq">秒杀</p><!--企服  index/qifu-->
                    </a>
                </div>
                <div class="flexitem">
                    <a href="<?=URL::to(["signin-log/index"])?>">
                       <img src="/webstatic/images/bna7.jpg" alt="" width="40" class="inlineblock">
                        <p class="sizeq">免费领取话费</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="side">
        <div class="wrap">
            <div class="sucaihuo">
                <ul>
                 <?php foreach($article as $articleVal):?>
                    <li><a href="javascript:;" target="_blank"><?=$articleVal->title?></a></li>
                  <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>-->
    <div class="topt">
        <a style="display:block" href="<?=Url::to(["goods/index","isjd"=>"1"])?>"><div class="toppa"></div></a>
         <!-- <a href="miaosha.html" style="display: inline-block;">  -->
        <div class="toppb">
            <a style="display:block;color:#fff" href="<?=Url::to(["seckill/index"])?>">
            <div class="daojishi">
            本场距离结束剩
            </div>
            <div id="timer"></div>
          <div id="warring"></div>
      </a>
        </div>
         <!-- </a>  -->
        <div class="toppc"></div>
    </div>
    <div class="gifta">
    <div class="giftaimg">
         <!-- <img class="picq" src="./images/er_03.jpg"> -->
    </div>
    <ul>
        <?php foreach($goodsSeckill as $goodsSeckillKey=>$goodsSeckillVal):?>
          <?php
            $goodsSeckillEndTime=$goodsSeckillVal->seckill_end_time-time();
           ?>
        <input type="hidden" name="goodsSeckillKey" value="<?=$goodsSeckillEndTime?>">
        <li>
           <a style="display: block;" href="<?=Url::to(["seckill/detail","goods_id"=>$goodsSeckillVal->goods_id])?>">
          <div class="giftb">
             <img class="picw" src="<?=Yii::$app->params['imgurl'].$goodsSeckillVal->seckill_img?>">
            <div class="title">
                <div class="titlecopy">
                <?=$goodsSeckillVal->goods_name?>
                </div>
                <div class="price">¥<?=$goodsSeckillVal->seckill_price?>&nbsp<span class="haha">¥<?=$goodsSeckillVal->old_price?></span></div>
                <div class="shopping" id="timer<?=$goodsSeckillKey?>"><!-- <img class="picq" src="./images/picc_03.jpg"> --></div>
                <div class="shoped"><?=$goodsSeckillVal->salecount?>人已买</div>
            </div>
        </div></a>
        </li>

        <?php endforeach;?> 
       
        
        </ul>
    </div>
    <div class="change-content change-box">
    <div class="toutiao"></div>
        <div class="change-main">
            <div class="change-cut flex-row">
                <ul class="clearfix">
                   <?php foreach($goodsCate as $goodsCateVal):?> 
                    <li class="transition tab"><a href="<?=Url::to(["goods/index","goods_cate_id"=>$goodsCateVal['goods_cat_id']])?>"><?=$goodsCateVal['goods_cat_name']?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="contents clearfix">
                <div class="content flex-row" style="display: block;">
                <ul id="list_box">
                  <?php foreach($goods as $goodsVal):?>  
                    <li>
                      <a style="display: block;" href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal->goods_id])?>">
                    <div class="spa">
                        <img class="picee" src="<?=Yii::$app->params['imgurl'].$goodsVal->goods_thums?>">
                         <div class="titlewee">
                            <?=$goodsVal->goods_name?>
                            <div class="pricee">¥<?=$goodsVal->price?>&nbsp<span class="hahae">¥<?=$goodsVal->old_price?></span></div>
                        <div class="shopedsi"><?=$goodsVal->salecount?>人已买</div>
                        <div class="shoppingsan"><img class="pqc" src="/webstatic/images/picc_03.jpg"></div>
                        </div> 

                    </div>
                    </a>
                   </li>
                     <?php endforeach;?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
<!-- 购买名单-->  
<div id="callboard"> 
  <img class="piceeii" src="/webstatic/images/hongbao.png">
  <ul> 
   
    <?php foreach($newOrder as $newOrderVal):?>  
    <li style="width:95%;"> 
    <span style="color:white; width:95%;">恭喜用户<?=$newOrderVal['name']?>购买<?=$newOrderVal['goods_name']?>成功</span> 
    </li> 
   <?php endforeach;?>
    
  </ul> 
</div>   

<script src="/webstatic/js/TouchSlide.1.1.js"></script>
   
    <script>

function countDown( maxtime,fn ) {   
    var timer = setInterval(function() { 


        if( !!maxtime ){   
          var day = Math.floor(maxtime / 86400);
           var hour = Math.floor((maxtime % 86400) / 3600);
           var minutes = Math.floor((maxtime % 3600) / 60); 
           var seconds = Math.floor(maxtime%60);
         if(hour<10)
        {
         	 hour="0"+hour;
        } 
		if(minutes<10)
        {
         	 minutes="0"+minutes;
        }
         if(seconds<10)
        {
         	 seconds="0"+seconds;
        }
              
        msg ="<span class='timyu'>"+"秒杀"+"&nbsp&nbsp"+"</span>"+"<span class='timde'>"+hour+ ":"+"</span>"+"<span class='timde'>"+minutes +":"+"</span>"+"<span class='timde'>" + seconds +"</span>";
        fn( msg ); 
        --maxtime;   
      } else {   
        clearInterval( timer ); 
        window.location.reload();
        //fn("时间到，结束!");  
      }   
    }, 1000); 
  } 

  //var aTime = [100,200];
  //aTime=["62634", "1434"];
  var aTime = [];
  $("input[name='goodsSeckillKey']").each(function(){
       var second=$(this).val();
       aTime.push(parseInt(second));
    })
  //console.log(aTime);
      
 // var aTime = [1021,104];
  for ( var i = 0; i < aTime.length; i++ ) {
    (function (i) {
      var obj = 'timer' + i;
      countDown( aTime[i],function( msg ) { 
        document.getElementById(obj).innerHTML = msg; 
      }) 
    })(i)
  }


    </script>
   
    
    <script>
        (function (doc, win) {

            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
                };

            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <script type="text/javascript">

    function Textrolling(){
    t = parseInt(x.css('top'));
    y.css('top','19px');
    x.animate({
        top:t-19 + 'px'
    },'slow');//19为每个li的高度
    if(Math.abs(t) == h-19){//19为每个li的高度
        y.animate({
            top:'0px'
        },'slow');
        z=x;
        x=y;
        y=z;
    }
    setTimeout(Textrolling,3000);//滚动间隔时间 现在是3秒
}
    $(document).ready(function(){
    $('.swap').html($('.news_li').html());
    x = $('.news_li');
    y = $('.swap');
    h = $('.news_li li').length * 19;//19为每个li的高度
    setTimeout(Textrolling,1000);//滚动间隔时间 现在是3秒
})
        TouchSlide({
            slideCell: "#slideBox",
            titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
            mainCell: ".bd ul",
            effect: "leftLoop",
            autoPage: true, //自动分页
            autoPlay: true //自动播放2
        });
    </script>
    <!--  跑马灯 -->
    <script>
        $(function () {
            $('.sucaihuo').vTicker({
                showItems:1,
                pause: 1000
            });
        });
/*倒计时*/
    var maxtime = 17 * 60; 
    function CountDown() {
        if (maxtime >= 0) {
          minutes = Math.floor(maxtime / 60);
          seconds = Math.floor(maxtime % 60);
          if (minutes<10)
                {
            minutes="0"+minutes;
                }
                if (seconds<10)
                {
            seconds="0"+seconds;
                }
          msg ="<span class='tim'>"+"00"+ ":"+"</span>"+"<span class='tim'>"+minutes +":"+"</span>"+"<span class='tim'>" + seconds +"</span>";
          document.all["timer"].innerHTML = msg;
          //if (maxtime == 5 * 60)alert("距离结束仅剩5分钟");
            --maxtime;
        } else{
          clearInterval(timer);
         // alert("时间到，结束!");
        }
      }
      timer = setInterval("CountDown()", 1000); 
    </script>
      <script type="text/javascript"> 
   (function (win){ 
   var callboarTimer; 
   var callboard = $('#callboard'); 
   var callboardUl = callboard.find('ul'); 
   var callboardLi = callboard.find('li'); 
   var liLen = callboard.find('li').length; 
   var initHeight = callboardLi.first().outerHeight(true); 
   win.autoAnimation = function (){ 
   if (liLen <= 1) return; 
   var self = arguments.callee; 
   var callboardLiFirst = callboard.find('li').first(); 
   callboardLiFirst.animate({ 
   marginTop:-initHeight 
   }, 500, function (){ 
   clearTimeout(callboarTimer); 
   callboardLiFirst.appendTo(callboardUl).css({marginTop:0}); 
   callboarTimer = setTimeout(self,3000); 
   }); 
   } 
   callboard.mouseenter( 
   function (){ 
   clearTimeout(callboarTimer); 
   }).mouseleave(function (){ 
   callboarTimer = setTimeout(win.autoAnimation, 3000); 
   }); 
   }(window)); 
   setTimeout(window.autoAnimation, 3000); 
   </script>  
<script>
var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['index/goods-list'])?>",{"page":page},function(da){
             $('#list_box').append(da);                                      
    })
   
    
    off_on = true; //[重要]这是使用了 {滚动加载方法1}  时 用到的 ！！！[如果用  滚动加载方法1 时：off_on 在这里不设 true的话， 下次就没法加载了哦！]
};

$(window).scroll(function() {
    //当时滚动条离底部60px时开始加载下一页的内容
    if (($(window).height() + $(window).scrollTop() + 60) >= $(document).height()) {
        clearTimeout(timers);
        timers = setTimeout(function() {
            page++;
            
            LoadingDataFn();
        }, 300);
    }
});
  
$(function(){
   
<?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')):?>
    ws=plus.webview.currentWebview();    
    ws.setStyle({'popGesture':'none'});//ios关闭右划
<?php endif;?>
})   
  
</script>

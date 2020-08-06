<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title =$shop->name;
?>
<style type="text/css">
  header .SearchBox3 .InputBor { width: 13.1rem;}
  header .SearchBox .icon-search {right: -40px;}
</style>

<div class="Web_Box">
  <div class="StoreManagement">
    <header class="gd lt0 wauto"> <i class="iconfont icon-leftdot"></i>
      <div class="SearchBox SearchBox3 fl">
        <div class="fl xd">
      <div class="SearchType" id="SearchType" onclick="SearchType('#TypePop')"><span class="fl">商品</span><i class="iconfont icon-downdot"></i></div>
      <div class="TypePop disn" id="TypePop">
        <ul>
          <li onclick="searchType(1)"><i class="iconfont icon-home" ></i>商品</li>
          <li onclick="searchType(2)"><i class="iconfont icon-shop" ></i>店铺</li>
           <input type="hidden" id="searchType" value="1">
        </ul>
      </div>
      </div>

        
        <input class="InputBor" placeholder="请输入关键词搜索" name="" id="searchKey" value="" type="text">
        <i class="iconfont icon-search" id="searchSub"></i> </div>

      <script type="text/javascript">
      function searchType(type)
      {
          $("#searchType").val(type);
      }
      $(function(){
        $("#searchSub").click(function(){
            var type=$("#searchType").val();
            
            var key=$("#searchKey").val();

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
    </header>
    <div class="StoreInfo">
      <div class="Photo"><img src="<?=$shop->img!=""?Yii::$app->params['imgurl'].$shop->img:'/static/images/photo.png'?>" alt=""/></div>
      <div class="Con">
        <h1>店铺名称：<?=$shop->name?></h1>
        <p>店铺公告：<?=$shop->notice?></p>
      </div>
    </div>
    <!-- <div class="OperationEntry">
      <ul>
        <li><a href="ShopSetting.php"><span class="spantc"> <i class="iconfont icon-setup"></i> <span class="text">店铺设置</span> </span></a></li>
        <li><a href="ExtensionQRcode.php"><span class="spantc"> <i class="iconfont icon-extensionqrcode"></i> <span class="text">店铺二维码</span> </span></a></li>
        <li><a href="###"><span class="spantc"> <i class="iconfont icon-share"></i> <span class="text">分享店铺</span> </span></a></li>
      </ul>
    </div> -->
    <div class="Sort mt10">
      <ul class="ClassA">
        <li <?=$salecount!=""?'class="on"':''?> onclick="screening(1)" > <span class="spantc"> <span class="text">销量</span> <i class="iconfont icon-downdot"></i> </span> </li>
        <li <?=$browse!=""?'class="on"':''?> onclick="screening(2)" > <span class="spantc"> <span class="text">浏览量</span> <i class="iconfont icon-downdot"></i> </span> </li>
        <li <?=$new!=""?'class="on"':''?>  onclick="screening(3)" > <span class="spantc"> <span class="text">最新</span> <i class="iconfont icon-downdot"></i> </span> </li>
      </ul>
      
     
      
    </div>
    <div class="ProList bg_f5f5f5">
      <ul id="list_box">
        <li>
          <a href="CommodityDetails.php">
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl']?>/static/images/propic1_s.png" alt=""/></div>
            <div class="Con">
              <h2 class="slh2">KUYURA美肌护手霜（天然果香型）150ml（韩国直送）超出省略超出省略超出省略超出省略超出省略超出省略超出省略</h2>
              <p class="Price"><span>￥56.00</span><span class="ml40">佣金：</span><span class="cr_f84e37">￥2.65</span></p>
              <p class="Statistics"><span>剩余1799件</span><span class="ml15">销量645</span><span class="ml15">收藏334</span></p>
            </div>
          </a>
        </li>
        
      </ul>
    </div>
  </div>
</div>

<script type="text/javascript">
  function screening(type){
    var url;
    if(type==1)
    {
      url="<?=Url::to(['goods/index','shop_id'=>$shop_id,"salecount"=>"desc"])?>";
    }else if(type==2)
    {
      url="<?=Url::to(['goods/index','shop_id'=>$shop_id,"browse"=>"desc"])?>";
    }else if(type==3){
      url="<?=Url::to(['goods/index','shop_id'=>$shop_id,"new"=>"desc"])?>";
    }

    window.location.href=url;
  }

</script>
<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['shops/goods-list'])?>",{"page":page,"shop_id":"<?=$shop_id?>","salecount":"<?=$salecount?>","browse":"<?=$browse?>","new":"<?=$new?>"},function(da){
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
</script>
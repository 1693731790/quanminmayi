<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="搜索店铺";
?>
<style type="text/css">
.AttentionShop li .leftcon{padding-top: 0px;}
.AttentionShop li .rightcon h2{line-height: 2.575rem;}
.DistributionOrder { padding-top: 2.7rem;}
</style>

<div class="Web_Box nb">
  <div class="DistributionOrder">
    <div class="gd lt0 wauto z99">
      <header class="header2"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
        <div class="SearchBox SearchBox4 fl">
        <!--搜索类型切换（商品与店铺）Start-->
    <div class="fl xd">
      <div class="SearchType" id="SearchType" onClick="SearchType('#TypePop')"><span class="fl">商品</span><i class="iconfont icon-downdot"></i></div>
      <div class="TypePop disn" id="TypePop">
        <ul>
              <li onclick="searchType(1)"><i class="iconfont icon-home" ></i>商品</li>
              <li onclick="searchType(2)"><i class="iconfont icon-shop" ></i>店铺</li>
              <input type="hidden" id="searchType" value="1">
        </ul>
      </div>
      </div>
      <!--搜索类型切换（商品与店铺）End-->
          
          <input class="InputBor" placeholder="请输入关键词搜索" name="" id="searchKey" value="<?=$searchKey?>" type="text">
          <i class="iconfont icon-search" id="searchSub"></i> </div>

      </header>
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
    </div>
    <div class="ShopList" id="list_box">
<?php foreach($shops as $shopkey=>$shopsval):?>
      <li class="blist">
        <div class="StoreInfo">
          <div class="photo"> <img src="<?=Yii::$app->params['imgurl'].$shopsval['img']?>" alt=""/> </div>
          <div class="con">
            <h2><?=$shopsval['name']?></h2>
            <i class="iconfont icon-flagshipstore"></i> 
            <p>销量<?=$shopsval['salecount']?>   共<?=$shopsval['goodscount']?>件宝贝</p>
          </div>
          <div class="rightcon"><a href="<?=Url::to(['shops/shop-info',"shop_id"=>$shopsval['shop_id']])?>">进入店铺</a></div>
        </div>
        <div class="ProLists">
          <div class="phone_gdt">
            <ul >
              <?php foreach($shopsval['goods'] as $goodskey=>$goodsval):?>
                <li><a href="<?=Url::to(['goods/detail','goods_id'=>$goodsval['goods_id']])?>"><img src="<?=Yii::$app->params['imgurl'].$goodsval['goods_thums']?>" alt=""/> <span class="Price">￥<?=$goodsval['price']?></span> </a></li>
              <?php endforeach;?>
            </ul>
          </div>
        </div>
      </li>
  <?php endforeach;?>
    </div>
  </div>
</div>

<script>



var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['search/shops-list'])?>",{"page":page,"searchKey":"<?=$searchKey?>"},function(da){
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
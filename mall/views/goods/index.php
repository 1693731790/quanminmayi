<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品列表";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/spingliebiao.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />


<header class="module-layer">
    <div class="module-layer-content">
          <div class="headerone"><?php if(empty($_GET["token"])):?><i class="iconfont icon-back is" onclick="javascript:history.go(-1)"></i><?php endif;?> </div>
          <div class="headertwo"><a href="<?=Url::to(['goods/index'])?>"><img class="piccc" src="/webstatic/images/all_03.jpg"/></a></div>
          <div class="headerthree"><input id="searchKey" type="text" placeholder="搜索您想要的商品" name="key" value="" /><img class="shop-search" src="/webstatic/images/icon_search.png" id="searchSub" /></div>
          <input type="hidden" id="searchType" value="1">
    </div>
</header> 

<script type="text/javascript">
      
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
 
   
          
<div id="list_box">
<?php foreach($goods as $key=>$val):?>
  <a href="<?=Url::to(['goods/detail','goods_id'=>$val['goods_id']])?>">
<div class="<?=$key==0?'center':'centers'?>">
  <div class="centerone"><img class="centertwos" src="<?=Yii::$app->params['imgurl'].$val['goods_thums']?>"/></div>
  <div class="centertwo">
    <div class="centertwoone"><?=$val['goods_name']?></div>
    <div class="centertwothree"><div class="centertwothrees">¥<?=$val['price']?>&nbsp&nbsp<span class="pi">¥<?=$val['old_price']?></span></div><!-- <div class="centertwothreea"><img class="pic" src="images/shanchuu_03.jpg"/></div> --></div>
    <div class="centertwotwo">销量<?=$val['salecount']?>&nbsp&nbsp&nbsp 收藏<?=$val['favorite']?></div>
  </div>
</div>
</a>
<?php endforeach;?>
</div>
<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['goods/goods-list'])?>",{"page":page,"goods_cate_id":"<?=$goods_cate_id?>","goods_brand":"<?=$goods_brand?>"},function(da){
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
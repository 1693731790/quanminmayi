<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="升级大礼包";
?>


<div class="Web_Box nb">
  <div class="CommodityMana">
    <header class="header2 gd lt0 wauto"> 
      <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
      <div class="SearchBox SearchBox3 fl"> 
        <!--搜索类型切换（商品与店铺）Start-->
        <div class="fl xd">
          <div class="SearchType" id="SearchType" onClick="SearchType('#TypePop')"><span>商品</span><i class="iconfont icon-downdot"></i></div>
          <div class="TypePop disn" id="TypePop">
            <ul>
              <li onclick="searchType(1)"><i class="iconfont icon-home" ></i>商品</li>
              <li onclick="searchType(2)"><i class="iconfont icon-shop" ></i>店铺</li>
              <input type="hidden" id="searchType" value="1">
            </ul>
          </div>
        </div>
        <!--搜索类型切换（商品与店铺）End-->
        <input class="InputBor" placeholder="搜索您想要的商品" name="" id="searchKey" value="<?=$searchKey?>" type="text">
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
  
    <div class="SortBigBox">
      <div class="SortBox">
        <div class="Sort">
          <ul class="ClassA">
            <li <?=$salecount!=""?'class="on"':''?> onclick="screening(1)" > <span class="spantc"> <span class="text">销量</span> <i class="iconfont icon-downdot"></i> </span> </li>
            <li <?=$browse!=""?'class="on"':''?> onclick="screening(2)" > <span class="spantc"> <span class="text">浏览量</span> <i class="iconfont icon-downdot"></i> </span> </li>
            <li <?=$new!=""?'class="on"':''?>  onclick="screening(3)" > <span class="spantc"> <span class="text">最新</span> <i class="iconfont icon-downdot"></i> </span> </li>
          </ul>
          
        </div>
      </div>
    </div>
    <div class="ProList bg_f5f5f5">
      <ul id="list_box">
      <?php foreach($goods as $key=>$val):?>
        <li>
          <a href="<?=Url::to(['goods/detail','goods_id'=>$val['goods_id']])?>">
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$val['goods_thums']?>" alt=""/></div>
            <div class="Con">
              <h2 class="slh2"><?=$val['goods_name']?></h2>
              <p class="Price"><span class="cr_f84e37">￥<?=$val['price']?></span><span class="ml40" style="text-decoration:line-through;">￥<?=$val['old_price']?></span></p>
              <p class="Statistics"><span class="ml15">销量<?=$val['salecount']?></span><span class="ml15">收藏<?=$val['favorite']?></span></p>
            </div>
          </a>
          
        </li>
       <?php endforeach;?>
      </ul>
    </div>
  </div>
</div>


<script type="text/javascript">

  
  function screening(type){
    var url;
    if(type==1)
    {
      url="<?=Url::to(['user-upgrade/goods',"searchKey"=>$searchKey,"salecount"=>"desc"])?>";
    }else if(type==2)
    {
      url="<?=Url::to(['user-upgrade/goods',"searchKey"=>$searchKey,"browse"=>"desc"])?>";
    }else if(type==3){
      url="<?=Url::to(['user-upgrade/goods',"searchKey"=>$searchKey,"new"=>"desc"])?>";
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
    $.get("<?=Url::to(['user-upgrade/goods-list'])?>",{"page":page,"salecount":"<?=$salecount?>","browse":"<?=$browse?>","new":"<?=$new?>","searchKey":"<?=$searchKey?>","istodaynew":"<?=$istodaynew?>"},function(da){
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
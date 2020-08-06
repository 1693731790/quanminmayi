<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="今日上新";
?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/jinrishangxin.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />
<?php if(empty($_GET["token"])):?>

<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="is" src="/webstatic/images/black-img.png"/></div></a>
</header>
<?php endif;?>

<div class="header"><img class="le" src="/webstatic/images/xiajijingxuanF_02.png"/></div>
<div class="contents">
<div class="tba"><div class="tbas">今日上新</div></div>

            <div class="tab_css" id="tab1_content">  
            	<?php foreach($goods as $goodsKey=>$goodsVal):?>
            		<a href="<?=Url::to(["goods/detail","goods_id"=>$goodsVal["goods_id"]])?>">
                <div class="pageone">
	                <div class="leftpic">
	                 <img class="leftpict" src="<?=$goodsVal['goods_thums']?>"/>
	                </div>
	                <div class="rightwenzi">
	                	<div class="rightwenzione"><?=$goodsVal['goods_name']?></div>
	                	<div class="rightwenzitwo"><?=$goodsVal['desc']?></div>
	                	<div class="rightwenzithree">¥<?=$goodsVal['price']?><span class="price">¥<?=$goodsVal['old_price']?></span></div>
	                	<div class="rightwenzifour">
	                		<div class="righttitle"><?=$goodsVal['salecount']?>人已买</div>
		                	
		                	<div class="righttitlethree">立即抢购</div>
	                	</div>
	                </div>
                </div> 
                	</a> 
				<?php endforeach;?>

                

               
            </div>  

        </div>  

        





<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['goods/goods-list'])?>",{"page":page,"istodaynew":"<?=$istodaynew?>"},function(da){
             $('#tab1_content').append(da);                                      
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

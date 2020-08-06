<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '秒杀专区';
$navbar=0;

?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/miaosha.css">
<link rel="stylesheet" type="text/css" href="/webstatic/css/iconfont/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/webstatic/css/fontsizes/iconfont.css" />
<header>
         <a href="javascript:;" onclick="javascript:history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/></div></a>秒杀专区
</header>
<div id="content">  
            <div id="tab_bar">  
                <ul id="time_ul"> 
                  
                  <?php foreach($spikeTime as $spikeTimeKey=>$spikeTimeVal):?> 
                    <?php
                  		
                        $hour=explode(":", $spikeTimeVal->hour);
						if($hour[0]==$time)
                        {
                        
                          	if($spikeTimeKey<21)
                            {
                              $navbar=$spikeTimeKey+2;
                            }else{
                               $navbar=$spikeTimeKey;
                            }
                        }
                    ?>
                    <?php if($time_id==""):?>
                      <li style="<?=$hour[0]==$time?"color:#fff;border-bottom: solid #fff 2px;":""?>" id="<?=$spikeTimeKey?>">
                    <?php else:?>
                      <li style="<?=$spikeTimeVal->id==$time_id?"color:#fff;border-bottom: solid #fff 2px;":""?>"  id="<?=$spikeTimeKey?>">
                    <?php endif;?>  
                      <span onclick="golink(<?=$spikeTimeVal->id?>,<?=$spikeTimeKey?>)">
                        <span class="time"><?=$spikeTimeVal->hour?></span> 
                        <span class="timer">
                          
                           <?php if($hour[0]==$time):?>
                              抢购中
                           <?php elseif($hour[0]>$time):?>
                              即将开始 
                           <?php elseif($hour[0]<$time):?>
                              已开始    
                           <?php endif;?> 
                          
                        </span> 
                      </span>
                    </li>  
                  <?php endforeach;?>
                     
                </ul>  
            </div>  
            <script type="text/javascript">
             $(function(){
              
               <?php if($_GET['time_id']==""):?>
             
             	 	location.hash="#<?=$navbar?>";  
               <?php endif;?>
             })
              function golink(id,k)
              {
                  if(k<21)
                  {
                   	k=k+2; 
                  }
                  window.location.href="<?=Url::to(["seckill/index"])?>"+"?time_id="+id+"&#"+k;
              }
            </script>
             
            <div class="tab_css" id="tab1_content" style="display:block">  
                <?php foreach($goods as $goodsKey=>$goodsVal):?> 
                <div class="pageone">
                  <a href="<?=Url::to(["seckill/detail","goods_id"=>$goodsVal->goods_id])?>">
                  <div class="leftpic">
                  <img class="leftpict" src="<?=$goodsVal->goods_thums?>"/> 
                  </div>
                  <div class="rightwenzi">
                      <div class="rightwenzione"><?=$goodsVal->goods_name?></div>
                      <div class="rightwenzitwo"><?=$goodsVal->desc?></div>
                      <div class="rightwenzithree">¥<?=$goodsVal->old_price?>&nbsp<span class="price">¥<?=$goodsVal->price?></span></div>
                      <div class="rightwenzifour"><div class="righttitle">已抢<?=$goodsVal->stock-$goodsVal->surplus?>件</div>
                          <div class="progress">
                              <div class="bar" style="width:<?=round(($goodsVal->stock-$goodsVal->surplus)/$goodsVal->stock*100,0)?>%;"></div>
                          </div>
                          <div class="righttitlethree">立即抢购</div>
                      </div>

                  </div>
                  </a>
                </div>  
                <?php endforeach;?>
            </div>  
             
            
            
             
        </div>  



<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['seckill/goods-list'])?>",{"page":page},function(da){
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
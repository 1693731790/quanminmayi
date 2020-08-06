<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="钱包明细";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/zaitu.css">

<div class="Head88 " style="padding-bottom:68px;<?=$_GET["token"]!=""?"display:none":""?>">
  
   <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">钱包明细</h2>
  </header>
</div>
<div id="list_box">
<?php foreach ($model as $modelKey => $modelVal):?>
  <?php if ($modelKey%2!=0): ?>
      <div class="yieldbene">
        <div class="yieldbeneleft"><?=yii::$app->params['wallet_type'][$modelVal->type]?></div>
        <div class="yieldbeneright"><?=$modelVal->type=="-1"?"-".$modelVal->fee:"+".$modelVal->fee?></div>
        <div class="yieldbenetop"><?=date("Y-m-d H:i:s",$modelVal->create_time)?></div>
      </div>
  <?php else:?>    
      <div class="yieldbenes">
        <div class="yieldbenelefts"><?=yii::$app->params['wallet_type'][$modelVal->type]?></div>
        <div class="yieldbenerights"><?=$modelVal->type=="-1"?"-".$modelVal->fee:"+".$modelVal->fee?></div>
        <div class="yieldbenetops"><?=date("Y-m-d H:i:s",$modelVal->create_time)?></div>
      </div>
  <?php endif ?>
<?php endforeach ?>
</div>


<div style=" width: 80%;height: 2rem;margin-left: 10%;background: #fe5458;color: white;font-size: 0.8rem;border-radius: 2.2rem;text-align: center;line-height: 2rem;margin-top: 1rem;position:  fixed;bottom: 2%;"><a href="<?=Url::to(["withdraw-cash/withdraw-cash-create"])?>" style="color:#fff">申请提现</a></div>


<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['wallet/wallet-info-list'])?>",{"page":page},function(da){
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

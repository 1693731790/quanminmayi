<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="钱包记录";
?>

<div class="Web_Box nb">
  <div class="CommissionPresent">
    <div class="HeadBox">
      <div class="head">
        <div class="leftcon"><i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i><span>账户余额(元)</span></div>
        
      </div>
      <div class="con"><?=$balance?></div>
      
    </div>
    
    <div class="CommissionList">
      <div class="CommissionTabs">
        <ul>
          <li class="on"><i class="iconfont icon-all2"></i>时间</li>
          <li><i class="iconfont icon-profit"></i>金额</li>
          <li><i class="iconfont icon-withdrawcashicon"></i>状态</li>
        </ul>
      </div>
      <div class="list f22">
        <ul id="list_box">
          <?php foreach($model as  $val):?>
          <li> <span class="tit pl30"><?=date("Y-m-d H:i:s",$val->create_time)?></span><span class="num1 pl18"><?=$val->fee?></span><span class="num2 pl20"><?=Yii::$app->params["withdraw_cash_status"][$val->status]?></span></li>
         <?php endforeach;?>
        </ul>
      </div>
    </div>
  </div>
</div>


<script>


var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['my-shop/withdraw-cash-list'])?>",{"page":page},function(da){
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

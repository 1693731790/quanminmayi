<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="专题列表";
?>

<div class="Head88 pt88" style="padding-bottom:68px;">
  <header class="TopGd"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot"></i></span>
    <h2>专题列表</h2>
  </header>
  <div class="ThematicList">
    <ul id="list_box">
    <?php foreach($special as $key=>$val):?>
      <li>
        <div class="item">
          <a href="<?=Url::to(['special/detail','id'=>$val['special_id']])?>">
            <div class="bt"><span><?=$val['name']?></span></div>
            <div class="pic">
              <img src="<?=Yii::$app->params['imgurl'].$val['img']?>" alt="" />
            </div>
            <div class="statusBar">
              <span><i class="iconfont icon-myon"></i><?=$val['browse']?>人浏览</span><span><i class="iconfont icon-collection"></i><?=$val['favorite']?></span><span><i class="iconfont icon-news"></i><?=$val['comment']?></span><!-- <span class="good-num">2件商品</span> -->
            </div>
          </a>
        </div>
      </li>
    <?php endforeach;?>  
    </ul>
  </div>
</div>


<script>
var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['special/special-list'])?>",{"page":page},function(da){
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
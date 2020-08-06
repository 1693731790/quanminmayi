<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\GoodsCate;
$this->title ="商品评论";
?>

<div class="Head88 pt88">
  <header class="TopGd"> <i class="iconfont icon-leftdot"  onclick="javascript:history.go(-1)"></i>
    <h2>评论详情</h2>
  </header>
  <div class="CommodityEvaluation mt20 bor_b_dcdddd">
      <div class="tit">
        <h2>商品评价 (<?=$countComment?>)</h2>
        <div class="data">好评率<span class="cr_ff5c36"><?=$goodCommentRate?>%</span></div>
      </div>
      <div class="CommentList hidden">
        <ul id="list_box">
          <?php foreach($goodsComment as $commentVal):?>
          <li>
            <div class="user">
              <div class="pic"><img src="<?=Yii::$app->params["imgurl"].$commentVal->user->headimgurl?>" alt=""/></div>
              <span><?=$commentVal->userAuth->identifier!=""?$commentVal->userAuth->identifier:'匿名用户'?></span> </div>
            <p class="text"><?=$commentVal->content?></p>
            <p class="date"><?=date("Y-m-d H:i:s",$commentVal->create_time)?></p>
          </li>
          <?php endforeach;?>
        </ul>
        
      </div>
    </div>
  

</div>

<script>

var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['goods/goods-comment-list'])?>",{"page":page,"goods_id":"<?=$goods_id?>"},function(da){
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
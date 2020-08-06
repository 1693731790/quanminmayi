<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品收藏";
?>
<style type="text/css">
  .CollectingGoods{padding-top: 0px;}
</style>
<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd" style="background:#fc3b3e"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">商品收藏</h2>
  </header>
</div>
<div class="Web_Box nb">
  <div class="CollectingGoods">
    <!--全部商品Start-->
    <div class="ShopGoods EditPro hidden">
      <div class="ProList bg_f5f5f5">
        <ul id="list_box">
          <?php foreach($model as $key=>$modelval):?>
          <li>
            <a href="<?=Url::to(['goods/detail',"goods_id"=>$modelval->goods->goods_id])?>">
              <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$modelval->goods->goods_thums?>" alt=""/></div>
              <div class="Con">
                <div class="pl20">
                  <h2 class="slh2"><?=$modelval->goods->goods_name?></h2>
                  <p class="State"> <?=$modelval->goods->issale!=1?'<span>失效</span>':''?> </p>
                  <p class="PriceQuantity"><span class="fl cr_f84e37">￥<?=$modelval->goods->price?></span></p>
                </div>
              </div>
            </a>
            <i class="iconfont icon-del4" onclick="fdelete(<?=$modelval->goods_favorite_id?>,this)"></i>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
    <!--全部商品End--> 
    
    
  </div>
</div>


<script>
function fdelete(id,obj){
  $.get("<?=Url::to(['favorite/goods-favorite-delete'])?>",{"goods_favorite_id":id},function(r){
      layer.msg(r.message);
      if(r.success)
      {
          $(obj).parent().remove();
      }
  },'json')
}


var page = 1, //分页码
    off_on = false, //分页开关(滚动加载方法 1 中用的)
    timers = null; //定时器(滚动加载方法 2 中用的)

//加载数据
 function LoadingDataFn() {
    $.get("<?=Url::to(['favorite/goods-favorite-list'])?>",{"page":page},function(da){
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
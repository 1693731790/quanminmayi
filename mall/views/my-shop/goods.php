<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品列表";
?>
<style type="text/css">
.CommodityMana {padding-top:0px;}
.delete{position: absolute;right: 0.5rem;bottom:10px;height: 0.825rem; line-height:0.825rem;text-align:center;width:1.5rem ;font-size: 0.5rem;border-radius: 0.15rem;background:#d9544f; color:#fff;}
.xiajia{position: absolute;right: 2.5rem;bottom:10px;height: 0.825rem;line-height:0.825rem;text-align:center;width:1.5rem ;font-size: 0.5rem;border-radius: 0.15rem;background: #efad4d; color:#fff;}
</style>
<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot"></i></span>
    <h2>商品列表</h2>
  </header>
</div>
<div class="Web_Box nb">
  <div class="CommodityMana">
    
  
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
          <?php if($val['issale']=="1"):?>
            <span type="button" style="" class="xiajia" onclick="lowerFrame(<?=$val['goods_id']?>,this,'0')">下架</span>
          <?php else:?>  
            <span type="button" style="" class="xiajia" onclick="lowerFrame(<?=$val['goods_id']?>,this,'1')">上架</span>
          <?php endif;?>
          <span type="button" style="" class="delete" onclick="deleteGoods(<?=$val['goods_id']?>,this)">删除</span>

          
          
        </li>
       <?php endforeach;?>
        
      </ul>
    </div>
  </div>
</div>


<script type="text/javascript">
  function lowerFrame(goods_id,obj,sale)
  {
      $.get("<?=Url::to(['my-shop/goods-lowerframe'])?>",{"goods_id":goods_id,"sale":sale},function(r){
        if(r.success)
        {
            layer.msg(r.message);
            if(sale==1)
            {
                var str='<span type="button" style="" class="xiajia" onclick="lowerFrame('+goods_id+',this,0)">下架</span>'
            }else{
                var str='<span type="button" style="" class="xiajia" onclick="lowerFrame('+goods_id+',this,1)">上架</span>'
            }
            
            $(obj).after(str);
            $(obj).remove();
        }else{
            layer.msg(r.message);
        }
          
      },'json')
  }
  function deleteGoods(goods_id,obj){
    $.get("<?=Url::to(['my-shop/goods-delete'])?>",{"goods_id":goods_id},function(r){
        if(r.success)
        {
            layer.msg(r.message);
            $(obj).parent().remove();
        }else{
            layer.msg(r.message);
        }
          
    },'json')
  }
  function screening(type){
    var url;
    if(type==1)
    {
      url="<?=Url::to(['my-shop/goods',"salecount"=>"desc"])?>";
    }else if(type==2)
    {
      url="<?=Url::to(['my-shop/goods',"browse"=>"desc"])?>";
    }else if(type==3){
      url="<?=Url::to(['my-shop/goods',"new"=>"desc"])?>";
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
    $.get("<?=Url::to(['my-shop/goods-list'])?>",{"page":page,"salecount":"<?=$salecount?>","browse":"<?=$browse?>","new":"<?=$new?>"},function(da){
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
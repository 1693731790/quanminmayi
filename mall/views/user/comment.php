<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="商品评价";
?>

<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot"></i></span>
    <h2>商品评价</h2>
  </header>
</div>
<div class="Web_Box nb">
  <div class="Evaluate">
    <div class="score mt20">
      <div class="tit">是否好评</div>
      <div class="con">
      好评：<input type="radio" name="type" checked=checked value="1"> &nbsp;&nbsp; 差评：<input type="radio" name="type" value="2">
      </div>
    </div>
    <div class="score mt20">
      <div class="tit">商品评分</div>
      <div class="con">
      <i class="iconfont icon-star" onclick="score(this,1)"></i>
      <i class="iconfont icon-star" onclick="score(this,2)"></i>
      <i class="iconfont icon-star" onclick="score(this,3)"></i>
      <i class="iconfont icon-star" onclick="score(this,4)"></i>
      <i class="iconfont icon-star" onclick="score(this,5)"></i>
      <input type="hidden" name="goods_score">
      </div>

    </div>
   
    <div class="score mt30">
      <div class="tit">服务评分</div>
      <div class="con"> 
        <i class="iconfont icon-star" onclick="score(this,1)"></i>
        <i class="iconfont icon-star" onclick="score(this,2)"></i> 
        <i class="iconfont icon-star" onclick="score(this,3)"></i> 
        <i class="iconfont icon-star" onclick="score(this,4)"></i> 
        <i class="iconfont icon-star" onclick="score(this,5)"></i> 
        <input type="hidden" name="service_score">
      </div>
    </div>
    <div class="score mt30">
      <div class="tit">物流评分</div>
      <div class="con"> 
        <i class="iconfont icon-star" onclick="score(this,1)"></i> 
        <i class="iconfont icon-star" onclick="score(this,2)"></i> 
        <i class="iconfont icon-star" onclick="score(this,3)"></i> 
        <i class="iconfont icon-star" onclick="score(this,4)"></i> 
        <i class="iconfont icon-star" onclick="score(this,5)"></i> 
        <input type="hidden" name="time_score">
      </div>
    </div>
  </div>
  <div class="ShopScore bg_f8f8f8">
    <div class="EvaluationText bor_b_dcdddd">
      <textarea placeholder="填写评价" id="content"></textarea>
    </div>
    
  </div>
</div>
<div class="BottomGd">
  <button class="but_2 wauto" type="button" id="submit">发表评论</button>
</div>

<script type="text/javascript">
  function score(obj,num)
  {
      $(obj).parent().find('input').val(num);
  }
$(function(){
  $("#submit").click(function(){
    var type=$("input[name=type]:checked").val()
    var content=$("#content").val();
    var goods_score=$("input[name=goods_score]").val();
    var service_score=$("input[name=service_score]").val();
    var time_score=$("input[name=time_score]").val();
    
    var ischeck=true;
    if(content=="")
    {
      layer.msg("请填写评价内容");
      ischeck=false;
    }
    if(goods_score=="")
    {
      layer.msg("请选择商品评分");
      ischeck=false;
    }
    if(service_score=="")
    {
      layer.msg("请选择服务评分");
      ischeck=false;
    }
    if(time_score=="")
    {
      layer.msg("请选择物流评分");
      ischeck=false;
    }

    if(ischeck)
    {
      $.get("<?=Url::to(["user/comment-create"])?>",{"type":type,"goods_score":goods_score,"service_score":service_score,"time_score":time_score,"order_id":"<?=$order_id?>","content":content},function(r){
          if(r.success)
          {
              layer.msg(r.message);
              setTimeout(function(){
                  window.location.href="<?=Url::to(['user/order','status'=>'3','iscomment'=>'0'])?>";
              },2000);
              
          }else{
              layer.msg(r.message);  
          }
          
      },'json')
    }
  })

})
</script>
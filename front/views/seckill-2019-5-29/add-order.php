<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title ="提交订单";
?>
<style type="text/css">
.ConsigneeInfo .text1 .tel {width: 7.375rem;padding-left: 30px;}
</style>

<div class="Web_Box">
  <div class="ConfirmationOrder">
    <div class="ConsigneeInfo addressdiv">
      <?php if(!empty($address)):?>
      <input type="hidden" name="address_id" value="<?=$address->aid?>">
      <p class="text1"> <span class="name fl">收货人：<?=$address->name?> </span> <span class="tel fl"><?=$address->phone?></span> </p>
      <div class="Address-con">
        <span class="default fl" style="margin-top: 5px;">[默认地址]</span><div class="Address slh2"><?=$address->region?> &nbsp;&nbsp;<?=$address->address?></div>
      </div>
      <?php else:?>
        <div class="Address-con">
          <span class="default fl">[收货地址]</span>
          <div class="Address slh2">
            <span onclick="address()" style="display:inline-block;height: 30px;line-height:30px;text-align:center;font-size: 14px; width:85px;color: #FFF;background: #fd6847;border: 0;border-radius:5px;">填写地址</span>
          </div>
        </div>
      <?php endif;?>
      
    </div>
    <div class="ShopGoods EditPro bg_f5f5f5 hidden bor_b_dcdddd mt15">
    
      <div class="ProList bg_f5f5f5">
        <ul>
          <li>
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$goods->goods_thums?>" alt=""/></div>
            <div class="Con">
              
              <div class="pl20">
                <h2 class="slh2"><?=$goods->goods_name?></h2>
                <p class="PriceQuantity"><span class="fl cr_f84e37">￥<?=$goods->price?></span><span class="fr cr_282828">×<?=$num?></span></p>
              </div>
              
            </div>
          </li>
          
        </ul>
      </div>
    </div>
   
    <div class="OtherInfo bg_fff mt20">
      <ul>
        
        <li>
          <div class="tit">买家留言：</div>
          <div class="LeaveMessage">
            <input type="text" name="remarks" placeholder="选填,可填写您和卖家达成一致的要求">
          </div>
        </li>
        <li class="Total">合计：<span class="cr_fd6847">￥<span id="countFee">
          <?=round($goods->price*$num,2)?></span></span> </li>
      </ul>
    </div>
  </div>
   

</div>

<div class="BottomGd">
    <button class="but_2 wauto bg_898989" id="formsubmit" type="button">确定</button>
</div>
<script type="text/javascript">
 

  
  function address()
  {
      layer.open({
        type: 2,
        title: '添加收货地址',
        shadeClose: true,
        shade: 0.8,
        area: ['90%', '90%'],
        content: '<?=Url::to(["user/address-create"])?>' //iframe的url
      }); 
  }

  $(function(){
      $("#formsubmit").click(function(){
          var aid=$("input[name=address_id]").val();
          var remarks=$("input[name=remarks]").val();
          
          if(!aid)
          {
              layer.msg("请填写收货地址");
              return false;
          }

          window.location.href="<?=Url::to(['seckill/confirm-add-order'])?>"+"?goods_id=<?=$goods->goods_id?>&aid="+aid+"&num=<?=$num?>"+"&remarks="+remarks;
          
      })
  })
</script>
<!--右侧导航Start-->
<div class="rightnav">
  <ul>
    
    <li><i class="iconfont icon-back" onClick="javascript :history.back(-1);"></i></li>
  </ul>
</div>
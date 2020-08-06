<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title ="提交订单";
?>
<style type="text/css">
.ConsigneeInfo .text1 .tel {width: 7.375rem;padding-left: 30px;}
</style>
<form id="orderform" action="<?=Url::to(['rob-buy/confirm-add-order'])?>" method="post">
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
      <div class="Tit">
        <div class="ShopName"><span class="Name"><a href="<?=Url::to(['shops/shop-info','shop_id'=>$shop->shop_id])?>"><?=$shop->name?></a></span><i class="iconfont icon-franchisedstore"></i><i class="iconfont icon-rightdot"></i></div>
      </div>
      <div class="ProList bg_f5f5f5">
        <ul>
          <li>
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$goods->goods_thums?>" alt=""/></div>
            <div class="Con">
              
              <div class="pl20">
                <h2 class="slh2"><?=$goods->goods_name?></h2>
                <?php if($sku!=""):?>
                <p class="Attribute"><?=$sku->sku_name?></p>
                <?php endif;?>
                <p class="PriceQuantity"><span class="fl cr_f84e37">￥<?=$robBuy->price?></span><span class="fr cr_282828">×<?=$num?></span></p>
              </div>
            </div>
          </li>
          
        </ul>
      </div>
    </div>

    <input type="hidden" name="goods_id" value="<?=$goods->goods_id?>">
    <input type="hidden" name="shop_id" value="<?=$goods->shop_id?>">
    <input type="hidden" name="skuid" value="<?=$sku!=""?$sku->sku_id:''?>">
    <input type="hidden" name="num" value="<?=$num?>">
    <input type="hidden" name="rob_id" value="<?=$robBuy->rob_id?>">
   
    <div class="OtherInfo bg_fff mt20">
      <ul>
        <li>
          <div class="tit">配送方式</div>
          <div class="freight">快递 <?=$goods->freight!="0"?$goods->freight:'免邮'?></div>
          <i class="iconfont icon-rightdot2"></i> </li>
        <li>
          <div class="tit">买家留言：</div>
          <div class="LeaveMessage">
            <input type="text" name="remarks" placeholder="选填,可填写您和卖家达成一致的要求">
          </div>
        </li>
        <li class="Total"> 合计：<span class="cr_fd6847">￥
          <?=round($robBuy->price*$num+$goods->freight,2)?></span> </li>
      </ul>
    </div>


  </div>
</div>
</form>
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
          if(!$("input[name=address_id]").val())
          {
              layer.msg("请填写收货地址");
              return false;
          }
          $("#orderform").submit();
      })
  })
</script>
<!--右侧导航Start-->
<div class="rightnav">
  <ul>
    
    <li><i class="iconfont icon-back" onClick="javascript :history.back(-1);"></i></li>
  </ul>
</div>
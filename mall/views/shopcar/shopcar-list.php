<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="购物车列表";
?>
<style type="text/css">
  input[type=checkbox] {-webkit-appearance: checkbox;}
</style>

<form id="orderform" action="<?=Url::to(['shopcar/add-order-all'])?>" method="post">
<div class="Web_Box">
  <div class="ShoppingCartPage Head88" style="<?=$_GET["token"]!=""?"padding-top:0px;":""?>">
    <header class="TopGd" style="<?=$_GET["token"]!=""?"display:none":""?>"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
      <h2>购物车</h2>
      
    </header>

    <?php foreach($shops as $val):?>
    <!--店铺商品Start-->
    <div class="ShopGoods EditPro bg_f5f5f5 hidden bor_b_dcdddd mb10">
      <div class="Tit">
        <div class="ChoiceT shopgoodsall"> 
          <input type="checkbox" >
          
        </div>
        <div class="ShopName"><span class="Name"><a href="<?=Url::to(['shops/shop-info','shop_id'=>$val['shops']['shop_id']])?>"><?=$val['shops']['name']?></a></span><!--<i class="iconfont icon-flagshipstore"></i>--><i class="iconfont icon-rightdot"></i></div>
        <div class="EditBut">编辑</div>
      </div>
      <div class="ProList bg_f5f5f5">
        <ul>
          <?php foreach($val['shopcar'] as $shopcarval):?>
          <li>
            <div class="Choice checkbox_goods_shopcar_id"> 
                <input type="checkbox" class="goods_shopcar_id" onclick="checkboxprice(this)" name="shopcar[<?=$val['shops']['shop_id']?>][<?=$shopcarval['goods_shopcar_id']?>][id]" value="<?=$shopcarval['goods_shopcar_id']?>">

            </div>
            
            <div class="Pic"><img src="<?=Yii::$app->params['imgurl'].$shopcarval['goods']['goods_thums']?>" alt=""/></div>
            <div class="Con">
              <div class="Edit disn">
                <div class="DelBut" onclick='goodscardelete(<?=$shopcarval['goods_shopcar_id']?>,this)'>删除</div>
                <div class="QuantityControl tc " data-total='10'>
                 <i class="iconfont icon-reduce fl no"  onclick="goodsnumlt(this,'<?=empty($shopcarval['sku'])?$shopcarval['goods']['price']:$shopcarval['sku']['price']?>')"></i>
                  <input id="text_box" name="shopcar[<?=$val['shops']['shop_id']?>][<?=$shopcarval['goods_shopcar_id']?>][goodsnum]" type="text" value="<?=$shopcarval['goodsnum']?>" style="width:50px;height:25px;font-size:20px;text-align: center;border: none; color:#848181"/> 
                  <i class="iconfont icon-increase fr "  onclick="goodsnumgt(this,'<?=empty($shopcarval['sku'])?$shopcarval['goods']['price']:$shopcarval['sku']['price']?>')"></i> 
                </div>
                <div class="SelectedAttributes">
                  <p class="slh2"><?=$shopcarval['sku']['sku_name']?></p>
                  </div>
              </div>
              <div class="pl20">
                <a href="<?=Url::to(['goods/detail','goods_id'=>$shopcarval['goods']['goods_id']])?>">
                <h2 class="slh2"><?=$shopcarval['goods']['goods_name']?></h2>
                <p class="Attribute"><?=$shopcarval['sku']['sku_name']?></p>
                <p class="PriceQuantity"><span class="fl cr_f84e37">￥<span class="goodsprice"><?=empty($shopcarval['sku'])?number_format($shopcarval['goods']['price']*$shopcarval['goodsnum'],2):number_format($shopcarval['sku']['price']*$shopcarval['goodsnum'],2)?></span></span><span class="fr cr_282828 ">×<span class="goodsnum"><?=$shopcarval['goodsnum']?></span></span></p>
                </a>
              </div>
            </div>
           
          </li>
        <?php endforeach;?>
          
        </ul>
      </div>
    </div>
    <!--店铺商品End--> 
    <?php endforeach;?>
    
  </div>
</div>
</form>

<div class="ShopGoodsOperation BottomGd">
  <div class="left fl"> <input style="float:left;margin-top: 20px;" type="checkbox" id="checkboxall"> <span class="text">全选</span>
    <div class="Statistics fr tr">
      <p class="Total" style="line-height: 1.925rem;">合计：<span class="cr_f84e37">￥<span class="countprice">0</span></span></p>
      
    </div>
  </div>
  <div class="right fr">
    <button type="button" class="but bg_ffbd0c" onclick="shopcarSubmit()">结算</button>
  </div>
</div>


<script>
  function shopcarSubmit()
  {
      var ischeck=false;
      $(".checkbox_goods_shopcar_id input[type=checkbox]").each(function(r){
          if($(this).is(":checked"))
          {
              ischeck=true;
          }
          
      })
      if(!ischeck)
      {
          layer.msg("请选择需要购买的商品");
          return false;
      }
      $("#orderform").submit();
  }
  function goodsnumlt(obj,oneprice)//商品减少
  {   
     
      var t = $(obj).next();

      if(t.val()>1)
       {
          t.val(Math.abs(parseInt(t.val()))-1); 
          var goodsprice=$(obj).parent().parent().next().find('.goodsprice');
          var price=parseFloat(goodsprice.text())-parseFloat(oneprice);
          goodsprice.text(price.toFixed(2));

          $(obj).parent().parent().next().find('.goodsnum').text(t.val());
       }
       if(t.val()==1)
       {
            $(obj).addClass("no");
       }else{
            $(obj).removeClass("no");
       }
  }

  function goodsnumgt(obj,oneprice)//商品增加
  {
      var t = $(obj).prev();
      
      t.val(Math.abs(parseInt(t.val()))+1);
      var goodsprice=$(obj).parent().parent().next().find('.goodsprice');
      var price=parseFloat(goodsprice.text())+parseFloat(oneprice);
      goodsprice.text(price.toFixed(2));
      //alert(goodsprice.text());
      $(obj).parent().parent().next().find('.goodsnum').text(t.val());
      if(t.val()>=1)
      {
          $(obj).prev().prev().removeClass("no");
      }
       
  }

  $(function(){
    $(".shopgoodsall input").click(function(){//店铺全选
        var countprice=$(".countprice").text();
        if($(this).is(":checked")){

            $(this).parent().parent().next().find("ul li div input[type=checkbox]").each(function(r){
                if(!$(this).is(":checked"))
                {
                    var price=$(this).parent().parent().find('.Con').find('.pl20').find('.goodsprice').text();
                    countprice=parseFloat(countprice)+parseFloat(price);
                    $(".countprice").text(countprice.toFixed(2));  
                }
                
                $(this).prop("checked",true);

                
            })
        }else{

            $(this).parent().parent().next().find("ul li div input[type=checkbox]").each(function(r){
                if($(this).is(":checked"))
                {
                    var price=$(this).parent().parent().find('.Con').find('.pl20').find('.goodsprice').text();
                    countprice=parseFloat(countprice)-parseFloat(price);
                    $(".countprice").text(countprice.toFixed(2));
                }
                $(this).prop("checked",false);

            })
        }
        
    })

    $("#checkboxall").click(function(){//购物车全选
         var countprice=$(".countprice").text();
        if($(this).is(":checked")){

            

            $(".checkbox_goods_shopcar_id input[type='checkbox']").each(function(r){
                if(!$(this).is(":checked"))
                {
                  var price=$(this).parent().parent().find('.Con').find('.pl20').find('.goodsprice').text();
                  countprice=parseFloat(countprice)+parseFloat(price);
                  $(".countprice").text(countprice.toFixed(2));  
                }
                                
            })
            $("input[type='checkbox']").prop("checked",true);
        }else{
            $("input[type='checkbox']").prop("checked",false);
            $(".checkbox_goods_shopcar_id input[type='checkbox']").each(function(r){
                
                $(".countprice").text("0.00");
                
            })
        }
    })

      
    
  })
  function goodscardelete(goods_shopcar_id,obj){  //商品删除

    $.get("<?=Url::to(['shopcar/shopcar-delete'])?>",{"goods_shopcar_id":goods_shopcar_id},function(r){
      if(r)
      {
          $(obj).parent().parent().parent().remove();
          layer.msg("删除成功");
      }else{
          layer.msg("删除失败");
      }
    })
        //
  }
  function checkboxprice(obj){  //点击选择增加价格
      var countprice=$(".countprice").text();
      if($(obj).is(":checked")){


          var price=$(obj).parent().parent().find('.Con').find('.pl20').find('.goodsprice').text();
          countprice=parseFloat(countprice)+parseFloat(price);
          $(".countprice").text(countprice.toFixed(2));
          
          
      }else{
          var price=$(obj).parent().parent().find('.Con').find('.pl20').find('.goodsprice').text();
          countprice=parseFloat(countprice)-parseFloat(price);
          $(".countprice").text(countprice.toFixed(2));
          $("#checkboxall").prop("checked",false);
      }
  }
</script>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="申请提现";
?>
<style type="text/css">
.CommissionPresent .con li.BankCard .lefticon {width: 1rem;}
.CommissionPresent .con li.BankCard .con {width: 14rem;}
</style>

<div class="Web_Box">
  <div class="CommissionPresent">
    <div class="HeadBox">
      <div class="head">
        <div class="leftcon"><i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i> <span>账户余额(元)</span> </div>
        
      </div>
      <div class="con"><?=$balance?></div>
     
    </div>
    <div class="con bg_fff"> 
      <ul>
        <?php foreach($userBank as $val):?>
        <li class="BankCard">
          <div class="lefticon" style="text-align: center;"> 
            <input type="radio" name="bank_id" value="<?=$val->bank_id?>">
          </div>
          <div class="con">
            <p class="text1">户名：<?=$val->name?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  银行名称：<?=$val->bank_name?> </p>
            <p class="text2">手机号：<?=$val->phone?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  卡号：<?=$val->account?></p>
          </div>
        </li>
       <?php endforeach;?>

       <li class="lh70 f24 cr_898989">注：金额需大于100元才可提现。</li>
        <li class="CashWithdrawal">
          <div class="tit">提现金额</div>
          <div class="con">
            <input type="tel" class="inp" id="fee" placeholder="请输入提现金额">
          </div>
          <div class="fl GetVerificationCode">
            <button type="button" id="allfee">全额提出</button>
          </div>
        </li>
        <li class="CashWithdrawal">
          <div class="tit">联系电话</div>
          <div class="con">
            <input type="tel" class="inp" id="phone" placeholder="请输入联系电话">
          </div>
         
        </li>

      </ul>
    </div>
  </div>
  <div class="pl20 pr20 mt60">
    <button type="button" class="but_1 wauto" id="submit">申请提现</button>
  </div>
</div>
<script type="text/javascript">

  $(function(){
    $("#submit").click(function(){
        var bank_id=$("input[name='bank_id']:checked").val();
        var fee=parseFloat($("#fee").val());
        var phone=$("#phone").val();
        
        var ischeck=true;
        if(!bank_id)
        {
            layer.msg("请选择提现银行卡");
            ischeck=false;
        }
        if(!fee)
        {
            layer.msg("请填写提现金额");
            ischeck=false;
        }
         if(!phone)
        {
            layer.msg("请填写联系电话");
            ischeck=false;
        }
        var balance=parseFloat("<?=$balance?>");
        if(fee>balance)
        {
            layer.msg("提现金额不能大于余额");
            ischeck=false; 
        }
        if(ischeck)
        {
            $.get("<?=Url::to(['my-shop/withdraw-cash-create'])?>",{"bank_id":bank_id,"fee":fee,"phone":phone},function(r){
                if(r.success)
                {
                    layer.msg(r.message);
                    setTimeout(function(){
                      window.location.reload();
                    },1500);
                    
                }else{
                    layer.msg(r.message);
                }

            },'json')
        }

        

    })

    $("#allfee").click(function(){
        $("#fee").val("<?=$balance?>");
    })
  })
</script>
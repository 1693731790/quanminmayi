<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WithdrawCashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '申请提现';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
.form-control {width:300px;}
</style>




<div class="withdraw-cash-index" style="margin-left: 50px;">

    <h2><?= Html::encode($this->title) ?> </h2>
    <h4 style="color:red">我的余额：<?=$balance?></h4>
    注：金额需大于100元才可提现。
<div class="form-group field-withdrawcash-fee required" style="margin-top:15px;">
    <label class="control-label" for="withdrawcash-fee">选择银行卡</label>
    <?php foreach($userBank as $val):?>
    <div>
        <input type="radio" name="bank_id" value="<?=$val->bank_id?>">
        <span class="text1">
            户名：<?=$val->name?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
            银行名称：<?=$val->bank_name?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            手机号：<?=$val->phone?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            卡号：<?=$val->account?>
        </span>
        
    </div>
    <?php endforeach;?> 
    <div class="help-block"></div>
</div>
 
    
<div class="form-group field-withdrawcash-fee required">
    <label class="control-label" for="withdrawcash-fee">提现金额</label>
    <input type="text" id="fee" class="form-control"  aria-required="true">
    <div class="help-block"></div>
</div>
<div class="form-group field-withdrawcash-fee required">
    <label class="control-label" for="withdrawcash-fee">联系电话</label>
    <input type="text" id="phone" class="form-control"  aria-required="true">
    <div class="help-block"></div>
</div>

<div class="form-group">
        <button type="button" class="btn btn-success" id="submit">提交</button>   
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
            $.get("<?=Url::to(['withdraw-cash/create'])?>",{"bank_id":bank_id,"fee":fee,"phone":phone},function(r){
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
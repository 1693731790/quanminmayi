<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="添加银行卡";
?>
<script src="/static/region/area.js"></script></head>
<style type="text/css">
  .areaselect select{height:25px;}
</style>
<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot"></i></span>
    <h2>添加银行卡</h2>
  </header>
</div>
<div class="Web_Box">
  <div class="EditReceiptAddress">
      <ul>
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-user2"></i></div>
          <div class="fl w550">
            <input type="text" class="inp" name="name" placeholder="填写收货人姓名">
          </div>
        </li>
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-user2"></i></div>
          <div class="fl w550">
            <input type="text" class="inp" name="bank_name" placeholder="填写银行名称">
          </div>
        </li>
  
        <li class="sli">
          <div class="lefticon"> <i class="iconfont icon-detailedaddress"></i></div>
          <div class="fl w550">
            <input type="text" class="inp" name="account"  placeholder="填写银行账号">
          </div>
        </li>
        <li class="sli" >
          <div class="lefticon"> <i class="iconfont icon-tel"></i></div>
          <div class="fl w550 areaselect">
            <input type="tel" class="inp" name="phone"  placeholder="填写开户预留手机号">
            
          </div>
        </li>
       
      </ul>
    </div>
    
</div>
<div class="AddProductOperation BottomGd">
  
    <button class="but_2 wauto but submit" type="button">保 存</button>

</div>
<script type="text/javascript">
  $(function(){
      $(".submit").click(function(){
          var name=$("input[name=name]").val();
          var bank_name=$("input[name=bank_name]").val();
          var phone=$("input[name=phone]").val();
          var account=$("input[name=account]").val();
          var check=true;
          
          if(name=="")
          {
              layer.msg("姓名不能为空");
              check=false;
          }
          if(phone=="")
          {
              layer.msg("开户预留手机号不能为空");
              check=false;
          }
          if(bank_name=="")
          {
              layer.msg("银行名称不能为空");
              check=false;
          }
          if(account=="")
          {
              layer.msg("银行账号不能为空");
              check=false;
          }

          if(check)
          {
              $.get("<?=Url::to(['user-bank/bank-create'])?>",{"account":account,"bank_name":bank_name,"phone":phone,'name':name},function(r){
                  if(r.success)
                  {              
                      layer.msg("添加成功");        
                      setTimeout(function(){
                         
                          //console.log(str);
                         window.location.href="<?=Url::to(['user-bank/bank-list'])?>";
                      },1000);
                      
                      
                  }else{
                      layer.msg("添加失败");
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
  })
</script>

<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="用户反馈";
?>

<div class="Head88 " style="padding-bottom:68px;">
  
   <header class="TopGd" style="background: #fc3b3e;"> <span onclick="javascript:history.go(-1)" ><i class="iconfont icon-leftdot" style="color:#fff"></i></span>
    <h2 style="color:#fff">用户反馈</h2>
  </header>
</div>
<div class="FormFilling hidden mt20">
  <ul>
    <li class="inpcon">
      <textarea class="inp" id="content" placeholder="请输入反馈内容..."></textarea>
    </li>
    <li class="mb20 mt20"> <i class="lefticon iconfont icon-mobilephone"></i>
      <div class="rightcon w548">
        <input class="inp" type="text" id="phone" placeholder="输入您的联系方式：邮箱或手机号">
      </div>
    </li>
  </ul>
</div>
<div class="pl20 pr20 mt20">
  <button type="button" class="but_1 wauto" id="submit" style="background:#fc3b3e">提交</button>
  
</div>

<script type="text/javascript">
  $(function(){
      $("#submit").click(function(){

          var phone=$("#phone").val();
          var content=$("#content").val();
          
          var check=true;
          if(phone=="")
          {
              layer.msg("联系方式不能为空");
              check=false;
          }
          if(content=="")
          {
              layer.msg("反馈内容不能为空");
              check=false;
          }

          if(check)
          {
              $.get("<?=Url::to(['user-feedback/index'])?>",{"phone":phone,"content":content},function(r){
                  if(r.success)
                  {              
                      layer.msg("反馈成功");  
                      setTimeout(function(){window.location.reload();  },2000);    
                      
                      
                  }else{
                      layer.msg("添加失败");
                  }
              },'json')
          }
          //alert(province+"---"+city+"---"+county);
      })
  })
</script>

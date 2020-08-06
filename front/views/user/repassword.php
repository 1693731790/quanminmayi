<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="修改密码";
?>

<div class="Head88 pt88">
  <header class="TopGd"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
    <h2>修改密码</h2>
  </header>
  <div class="FormFilling hidden mt20">
    <ul>
      <li class="mb20"> <i class="lefticon iconfont icon-password"></i>
        <div class="rightcon w548">
          <input class="inp" type="text" name="old_password" placeholder="旧密码">
        </div>
      </li>
      <li class="mb20"> <i class="lefticon iconfont icon-password"></i>
        <div class="rightcon w548">
          <input class="inp" type="password" name="password"  placeholder="新密码">
        </div>
      </li>
      <li class="mb20"> <i class="lefticon iconfont icon-password"></i>
        <div class="rightcon w548">
          <input class="inp" type="password" name="repassword"  placeholder="确认密码">
        </div>
      </li>
    </ul>
  </div>
  <div class="pl20 pr20 mt20">
    <button type="button" class="but_1 wauto" id="submit">提交</button>
  </div>
</div>

<script type="text/javascript">
  $("#submit").click(function(){
    var old_password=$("input[name=old_password]").val();
    var password=$("input[name=password]").val();
    var repassword=$("input[name=repassword]").val();
    
    
    var ischeck=true;
    if(old_password=="")
    {
      layer.msg("请填写旧密码");
      ischeck=false;
    }
    if(password=="")
    {
      layer.msg("请填写新密码");
      ischeck=false;
    }
    if(repassword=="")
    {
      layer.msg("请填写确认密码");
      ischeck=false;
    }
    if(password!=repassword)
    {
      layer.msg("两次输入密码不一致");
      ischeck=false;
    }
    if(ischeck)
    {
      $.get("<?=Url::to(["user/repassword"])?>",{"old_password":old_password,"password":password,"repassword":repassword},function(res){
            if(res.success){
                layer.msg('重置成功');
                setTimeout(function(){window.location.reload();},2000);
                
            }else{
              layer.msg(res.message);
            }
      },'json')
    }
  })
</script>
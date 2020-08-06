<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="我的信息";
?>
<link rel="stylesheet" type="text/css" href="/webstatic/css/gerenxinxi.css">

<style type="text/css">
	.btn {
    width: 70%;
    height: 1.7rem;
    margin: 0 auto;
    z-index: 99999999999;
    border-radius: 30px;
    background: #ff6567;
    text-align: center;
    overflow: hidden;
    position: fixed;
    bottom: 30%;
    font-size: 0.8rem;
    left: 15%;
    color: white;
    line-height: 1.6rem;
}
  .aboutone {
    width: 26%;
  }
  .abouttwo {
    width: 17%;
  }
  
</style>
<header>
          <a href="javascript:;" onclick="javascript:history.go(-1)"><div class="_lefte"><<i class="iconfont icon-leftdot" style="color:#fff"></i></div></a>
          个人信息
</header>
<div class="clean">
	<div class="cleanone">个人头像</div>
	<div class="aboutthree">
		<i class="iconfont icon-next iu"></i>
	</div>
	<div class="cleantwoo" style="position:relative;">
		<img class="shops" id="head-img" src="<?=$userimg?>"/>
		 <input type="file" filenum="1" class="headimgfile" style="position:absolute;bottom:00px;right:00px;width:100%;height:100%; opacity:0; -webkit-opacity:0;">
	</div>
</div>
<script type="text/javascript" src="/static/js/LocalResizeIMG.js"></script>
<script type="text/javascript" src="/static/js/patch/mobileBUGFix.mini.js"></script>
<script type="text/javascript">
        // 头像上传
        $('.headimgfile').on('click',function(){
            var num = $(this).attr('filenum');
            var nextnum = parseInt(num) +1;
            $(this).localResizeIMG({
                width: 500,
                quality:0.6,
                success:function(result){
                    var img = new Image();
                    img.src = result.base64;
                     // 添加额外参数
                     $.post("<?=Url::to(['user/baseimgupload'])?>",{"headimg":result.base64,"isuserpic":"1"},function (data) {
                         // alert(data);
                            //$("<img />").attr("src", data).appendTo("body");
                         $('#head-img').attr('src',img.src);
                        
                        // console.log(data);
                    });
                   

                  //  console.log(result);
                }
            })
        })
    </script>


<div class="about">
	<div class="aboutone">昵称</div>
	<!-- <div class="abouttwo">小枫</div> -->
	<div class="aboutthree">
		<i class="iconfont icon-next iu"></i>
	</div>
	<div class="abouttwo"><input type="text" name="nickname" value="<?=$model->nickname?>"></div>
</div>
<div class="about">
	<div class="aboutone">真实姓名</div>
	<!-- <div class="abouttwo">小枫</div> -->
	<div class="aboutthree">
		<i class="iconfont icon-next iu"></i>
	</div>
	<div class="abouttwo"><input type="text" name="realname" value="<?=$model->realname?>"></div>
</div>
<div class="about">
	<div class="aboutone">登录密码</div>
	<!-- <div class="abouttwo">小枫</div> -->
	<div class="aboutthree">
		<i class="iconfont icon-next iu"></i>
	</div>
  <div class="abouttwo"><a href="<?=Url::to(["user/repassword"])?>">修改</a></div>
</div>

<div class="about">
	<div class="aboutone">我的分享码</div>
	<!-- <div class="abouttwo">小枫</div> -->
	<div class="aboutthree">
		<i class="iconfont icon-next iu"></i>
	</div>
  <div class="abouttwo"><a href="<?=Url::to(["user/my-code"])?>">查看</a></div>
</div>


<div class="btn" id="submit">保存</div>
<!-- <div class="cleann"><div class="cleanone">真实姓名</div><div class="cleantwo">张默<i class="iconfont icon-next iu"></i></div></div>
<div class="aboutt"><div class="aboutone">登录密码</div><div class="abouttwo">修改<i class="iconfont icon-next iu"></i></div></div> -->



<script type="text/javascript">
	$("#submit").click(function(){
		var nickname=$("input[name=nickname]").val();
		var realname=$("input[name=realname]").val();
		
		var ischeck=true;
		if(nickname=="")
		{
			layer.msg("请填写昵称");
			ischeck=false;
		}
		if(realname=="")
		{
			layer.msg("请填写真实姓名");
			ischeck=false;
		}
		if(ischeck)
		{
			$.get("<?=Url::to(["user/user-info"])?>",{"nickname":nickname,"realname":realname},function(r){
				layer.msg(r);
			})
		}
	})
</script>
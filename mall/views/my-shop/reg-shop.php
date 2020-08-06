<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="申请店铺";
?>
<script type="text/javascript" src="/static/uploadjs/lrz.bundle.js"></script>

<style type="text/css">
 .left_reg{ float: left;width: 3.5rem;height: 2.1rem;line-height: 2.1rem;font-size: 0.6rem;}

</style>
<div class="Head88 " style="padding-bottom:68px;">
  <header class="TopGd"> <span onclick="javascript:history.go(-1)"><i class="iconfont icon-leftdot"></i></span>
    <h2>申请店铺</h2>
  </header>
</div>
<div class="FormFilling hidden ">
  <ul>
    <li class="mb20">
      
      <div class="left_reg">店铺名称:</div>
      <div class="rightcon w548" style="width:11.3rem">
        <input class="inp" type="text" name="name" placeholder="输入店铺名称" >
      </div>
    </li>
    <li class="mb20">
      
      <div class="left_reg">店铺简介:</div>
      <div class="rightcon w548" style="width:11.3rem">
        <input class="inp" type="text" name="desc" placeholder="输入店铺简介" >
      </div>
    </li>
    <li class="mb20">
      
      <div class="left_reg">申请人姓名:</div>
      <div class="rightcon w548" style="width:11.3rem">
        <input class="inp" type="text" name="truename" placeholder="输入申请人姓名" >
      </div>
    </li>
    <li class="mb20">
      
      <div class="left_reg">电话:</div>
      <div class="rightcon w548" style="width:11.3rem">
        <input class="inp" type="text" name="tel" placeholder="输入电话" >
      </div>
    </li>
    <li class="mb20">
      
      <div class="left_reg">地址:</div>
      <div class="rightcon w548" style="width:11.3rem">
        <input class="inp" type="text" name="address" placeholder="输入详细地址" >
      </div>
    </li>
  
    <li class="mb20" style="height: 5.125rem; ">
      
      <div class="left_reg">身份证正面:</div>
      <div class="rightcon w548" style="width:11.3rem;height: 5.125rem; ">
          
          <div style="position:relative;height: 5.125rem; ">
                <img   style="border:1px #dbdbdb solid; height:100px;width:150px;" id="head-img1" src="/static/js/uploadimg/bg_01.png">
                <input type="hidden" name="id_front">
                <input type="file" filenum="1" class="id_front_img" style="position:absolute;bottom:00px;right:00px;width:100%;height:100%; opacity:0; -webkit-opacity:0;">
                 
          </div>

        
      </div>
    </li>
    <li class="mb20" style="height: 5.125rem; ">
      
      <div class="left_reg">身份证反面:</div>
      <div class="rightcon w548" style="width:11.3rem;height: 5.125rem; ">
          
          <div style="position:relative;height: 5.125rem; ">
                <img   style="border:1px #dbdbdb solid; height:100px;width:150px;" id="head-img2" src="/static/js/uploadimg/bg_02.png">
                <input type="hidden" name="id_back">
                <input type="file" filenum="2" class="id_back_img" style="position:absolute;bottom:00px;right:00px;width:100%;height:100%; opacity:0; -webkit-opacity:0;">
                
                
          </div>

        
      </div>
    </li>
    <li class="mb20" style="height: 5.125rem; ">
      
      <div class="left_reg">店铺头像:</div>
      <div class="rightcon w548" style="width:11.3rem;height: 5.125rem; ">
          
          <div style="position:relative;height: 5.125rem; ">
                <img   style="border:1px #dbdbdb solid; height:100px;width:150px;" id="head-img3" src="/static/js/uploadimg/bg_03.png">
                <input type="hidden" name="img">
                <input type="file" filenum="3" class="img_img" style="position:absolute;bottom:00px;right:00px;width:100%;height:100%; opacity:0; -webkit-opacity:0;">
                
          </div>

        
      </div>
    </li>


  </ul>
</div> 

<div class="pl20 pr20 mt20" style="margin-bottom: 150px;">
  <button type="button" class="but_1 wauto" onclick="submit()">提交</button>
</div>
<script type="text/javascript">
  function submit()
  {
      var check=true;
      var name=$("input[name=name]").val();
      var desc=$("input[name=desc]").val();
      var truename=$("input[name=truename]").val();
      var tel=$("input[name=tel]").val();
      var address=$("input[name=address]").val();
      var id_front=$("input[name=id_front]").val();
      var id_back=$("input[name=id_back]").val();
      var img=$("input[name=img]").val();
      if(name=="")
      {
          check=false;
          layer.msg("请输入店铺名称");
      }
      if(desc=="")
      {
          check=false;
          layer.msg("请输入店铺简介");
      }
      if(truename=="")
      {
          check=false;
          layer.msg("请输入申请人姓名");
      }
      if(tel=="")
      {
          check=false;
          layer.msg("请输入申请人电话");
      }
      if(address=="")
      {
          check=false;
          layer.msg("请输入申请人电话");
      }
      if(id_front=="")
      {
          check=false;
          layer.msg("请上传身份证正面照");
      }
      if(id_back=="")
      {
          check=false;
          layer.msg("请上传身份证反面照");
      }
      if(img=="")
      {
          check=false;
          layer.msg("请上传店铺头像");
      }
      if(check)
      {
          $.get("<?=Url::to(['my-shop/reg-shop'])?>",{"name":name,"desc":desc,"truename":truename,"tel":tel,"address":address,"id_front":id_front,"id_back":id_back,"img":img},function (data) {
                  if(data.success)
                  {
                    layer.msg(data.message);
                    setTimeout(function(){
                        window.location.reload();
                    },2000);
                  }else{
                    layer.msg(data.message);
                  }
          },'json');
      }
      
  }

</script>

    <script type="text/javascript" src="/static/js/LocalResizeIMG.js"></script>
    <script type="text/javascript" src="/static/js/patch/mobileBUGFix.mini.js"></script>
    <script type="text/javascript">
      	
        // 身份证正面上传
        $('.id_front_img').on('click',function(){
            /*alert("身份证图片");
            return false;*/

            var num = $(this).attr('filenum');
            var nextnum = parseInt(num) +1;
            $(this).localResizeIMG({
                width: 500,
                quality:0.6,
                success:function(result){
                    var img = new Image();
                    img.src = result.base64;
                     // 添加额外参数
                     $.post("<?=Url::to(['my-shop/baseimgupload'])?>",{"headimg":result.base64,"isuserpic":"1"},function (data) {
                         // alert(data);
                            //$("<img />").attr("src", data).appendTo("body");
                         $('#head-img'+num).attr('src',img.src);
                         //alert(data);
                         $('input[name=id_front]').val(data);
                        // console.log(data);
                    });
                   

                  //  console.log(result);
                }
            })
        })
        // 身份证反面上传
        $('.id_back_img').on('click',function(){
            var num = $(this).attr('filenum');
            var nextnum = parseInt(num) +1;
            $(this).localResizeIMG({
                width: 500,
                quality:0.6,
                success:function(result){
                    var img = new Image();
                    img.src = result.base64;
                     // 添加额外参数
                     $.post("<?=Url::to(['my-shop/baseimgupload'])?>",{"headimg":result.base64,"isuserpic":"1"},function (data) {
                         // alert(data);
                            //$("<img />").attr("src", data).appendTo("body");
                         $('#head-img'+num).attr('src',img.src);
                         //alert(data);
                         $('input[name=id_back]').val(data);
                        // console.log(data);
                    });
                   

                  //  console.log(result);
                }
            })
        })
        // 身份证反面上传
        $('.img_img').on('click',function(){
            var num = $(this).attr('filenum');
            var nextnum = parseInt(num) +1;
            $(this).localResizeIMG({
                width: 500,
                quality:0.6,
                success:function(result){
                    var img = new Image();
                    img.src = result.base64;
                     // 添加额外参数
                     $.post("<?=Url::to(['my-shop/baseimgupload'])?>",{"headimg":result.base64,"isuserpic":"1"},function (data) {
                         // alert(data);
                            //$("<img />").attr("src", data).appendTo("body");
                         $('#head-img'+num).attr('src',img.src);
                         //alert(data);
                         $('input[name=img]').val(data);
                        // console.log(data);
                    });
                   

                  //  console.log(result);
                }
            })
        })

    </script>

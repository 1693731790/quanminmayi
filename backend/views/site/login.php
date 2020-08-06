<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '管理员登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" type="text/css" href="/css/iconfont/iconfont.css" />
<style type="text/css">
    body{padding:0;margin:0; font-family:"微软雅黑";font-size:14px; background:#fff; color:#666; min-height:100%;min-width: 100%;overflow: hidden; background-image:url(/images/login_bg.jpg); background-repeat: no-repeat; }
    input,button,select {outline: none; border:0;font-family:Microsoft YaHei,"微软雅黑",SimSun,"宋体";}
    a { text-decoration: none; color: #787878; }
    .txt-c { text-align: center; }
    .fr{ float:right;}
    .fs16 { font-size: 16px; }
    .clr{ display:block;clear:both;width:0; height:0; overflow:hidden;}
    .clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden; overflow:hidden;}
    .radius-5{ -webkit-border-radius:5px; -moz-border-radius: 5px; border-radius: 5px; behavior: url(ie-css3.htc);zoom:1;}
    .login-form .form-item { margin-bottom: 15px; position: relative; }
    .login-form .form-item .iconfont { position: absolute; left: 14px; top: 14px; }
    .input-text{padding:6px 12px 6px 40px;height:28px;line-height:28px;border:1px #dbdbdb solid;background:#fff;font-family:"Microsoft Yahei","SimSun";font-size:14px; vertical-align:middle; color:#666; -webkit-transition: border 0.1s ease-out,box-shadow 0.2s linear; -khtml-transition: border 0.1s ease-out,box-shadow 0.2s linear; -moz-transition: border 0.1s ease-out,box-shadow 0.2s linear; -o-transition: border 0.1s ease-out,box-shadow 0.2s linear; transition: border 0.1s ease-out,box-shadow 0.2s linear; width: 300px;}
    textarea.input-text{ box-sizing:border-box; width:100%; resize:vertical; min-height:110px;}
    .input-text:focus{ color:#333; /*border-color:#82ccdc;*/ -moz-box-shadow:0px 0px 10px rgba(130,204,220,0.8); -webkit-box-shadow:0px 0px 10px rgba(130,204,220,0.8); box-shadow:0px 0px 10px rgba(130,204,220,0.8);}
    input.Validform_error,textarea.Validform_error{ border:1px #e9322d solid !important; -moz-box-shadow:0px 0px 10px rgba(255,0,0,0.5); -webkit-box-shadow:0px 0px 10px rgba(255,0,0,0.5); box-shadow:0px 0px 10px rgba(255,0,0,0.5); color:#e9322d;}
    .input-text[disabled]{ background:#f8f8f8; color:#aaa;}


    .btn-small{ font-size:12px; height:28px; line-height:28px;}
    .btn-middle{ font-size:16px; height:38px;line-height:38px;}
    .btn-big{ font-size:16px; height:43px; line-height:43px;}
    .btn-large{ font-size:18px; height:48px; line-height:48px;}

    .btn-yellow{border:1px #f1941b solid;color:#fff;background-color:#fea600;}
    .btn-yellow:hover{background-color:#f9a436; color:#fff;}
    .btn-yellow:active{background-color:#d17100; color:#fff;}

    /*登录*/
    .login { position: absolute; top: 50%; left: 50%; -webkit-transform: translate3d(-50%, -50%, 0px); -moz-transform: translate3d(-50%, -50%, 0px); -ms-transform: translate3d(-50%, -70%, 0px); -o-transform: translate3d(-50%, -50%, 0px); transform: translate3d(-50%, -50%, 0px); }
    .login img { width: 100%; height:100%; }
    .login .nr { width: 354px; padding: 30px 36px; background: #fff; -moz-border-radius: 20px; -webkit-border-radius: 20px; border-radius: 20px; }
    .login .nr h2 { font-size: 20px; color: #787878; text-align: center; overflow: hidden;white-space: nowrap;text-overflow: ellipsis; margin-bottom: 30px; font-weight: normal; }
    .login .nr .btn { width: 100%; -moz-border-radius: 20px; -webkit-border-radius: 20px; border-radius: 20px; }
    .login .nr a { color: #63bec9; }
</style>
    <div class="login">
        <div class="nr">
            <h2>管理员登录</h2>
            <div class="login-form">
                <?php $form = ActiveForm::begin(); ?>
                <div class="form-item">
                    <i class="iconfont icon-zhanghao"></i>
                    <?=Html::activeInput('text',$model,'username',['class'=>'input-text radius-5'])?>
                </div>
                <div class="form-item">
                    <i class="iconfont icon-mima"></i>
                    <?=Html::activeInput('password',$model,'password',['class'=>'input-text radius-5'])?>
                </div>
                <div class="form-item clearfix">
                   <!--  <a href="###" class="fr fs16">忘记密码</a> -->
                </div>
                <div class="form-item">
                    <button class="btn btn-middle btn-yellow " type="submit">登 录</button>
                </div>
                <div class="form-item txt-c">
                   <!--  <p class="fs16">还没有账户？<a href="###">立即注册？</a></p> -->
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>



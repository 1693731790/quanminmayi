<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title ="开店";
?>


<style>
body {
    padding:0;
   margin:0;
}
ul,li{ padding:0;margin:0;list-style:none}
a{
    text-decoration:none;
}
a:hover { text-decoration: none;}
ul,li{
    list-style:none;
}
.shoppingpin{
    width:100%;
    height:100%;
}
.beijingpin{
        width:100%;
        height:100%;
    }
    .beijinggpin{
        width:100%;
        margin: 0 auto;
        z-index:99999999999;
        text-align:center;
        overflow:hidden;
        position:fixed;
        font-size:0.6rem;
        bottom:9%;
        left:0;
        color:white;  
    }
     .foot_menu{
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 999;
    border-top: 1px solid #cecece;
}
.foot_menu ul{ overflow: hidden; background-color:white; padding-top:2%; padding-bottom: 1%;
    display: -webkit-box;
    display: -moz-box;
    display: -webkit-flex; Safari 
    display: -moz-flex;
    display: flex;
    flex-wrap: nowrap;
    -moz-justify-content: space-around;
    -webkit-justify-content: space-around;
    justify-content: space-around;
    -webkit-box-align: center;
    -moz-align-items: center;
    -webkit-align-items: center;
    align-items: center;
}
.foot_menu ul li{ text-align: center; width: 25%;}
.foot_menu ul li i{display: block; margin-bottom: .08rem;}
.foot_menu ul li img{ display: block; margin:0 auto; width:1.2rem;height: 1.0rem; }
.foot_menu ul li a{ color: #333333;
    font-size: 0.6rem;display: inline-block;}
.iq{
    display:block;
    margin-top:0.3rem;
}

</style>

<div class="shoppingpin"><img class="beijingpin" src="/webstatic/images/beijing.png"/>
<a href="<?=Url::to(["my-shop/index"])?>"><img class="beijinggpin" src="/webstatic/images/zlan.png"/></a>
</div>

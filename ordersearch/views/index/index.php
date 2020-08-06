<?php 
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '后台首页';
?>
    <div class="myheading">
        <nav class="navbar navbar-inner">
            <div class="container-fluid">
		
                <div class="navbar-header">
                    <!--nav troggle-->
                    
                    <!--nav troggle-->
                    <!--brand-->
                    <a class="navbar-brand" href="#">订单查询</a>
                    <!--brand-->
                </div>
		
                <!--nav links-->
                <div class="collapse navbar-collapse" id="hard-navbar">
		
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?= Url::to(['login/logout'])?>" class="atip" target="appiframe" data-toggle="tooltip" data-placement="bottom" data-title="首页"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                        <li class="dropdown">
                        
		
                            <ul class="dropdown-menu dropdown-menu-arrow-right" role="menu">
                               
                                <li><a href="<?= Url::to(['login/logout'])?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                 
                                 退出登录</a></li>
                            </ul>
                        </li>
                    </ul>
		
		
                </div>
                <!--nav links-->
            </div>
        </nav>
    </div>
		
    <!--main-->
    <div class="container-fluid mybody">
        <div class="main-wapper">
            <!--菜单-->
            <div id="siderbar" class="siderbar-wapper">
		
                <div class="panel-group menu" id="accordion" role="tablist" aria-multiselectable="true">
		
                    <div class="panel panel-inner">
                        <div class="panel-heading panel-heading-self" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a  href="<?=Url::to(["index/order-search"])?>" target="appiframe"  aria-expanded="true" aria-controls="collapseOne">
                                    <span class="glyphicon glyphicon-list-alt"></span> 订单查询
                                </a>
                            </h4>
                        </div>
                        
                    </div>
                  <div class="panel panel-inner">
                        <div class="panel-heading panel-heading-self" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a  href="<?=Url::to(["index/order-list","status"=>"7"])?>" target="appiframe"  aria-expanded="true" aria-controls="collapseOne">
                                    <span class="glyphicon glyphicon-list-alt"></span> 已兑换订单
                                </a>
                            </h4>
                        </div>
                        
                    </div>
                    <div class="panel panel-inner">
                        <div class="panel-heading panel-heading-self" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a  href="<?=Url::to(["index/order-list","status"=>"1"])?>" target="appiframe"  aria-expanded="true" aria-controls="collapseOne">
                                    <span class="glyphicon glyphicon-list-alt"></span> 未兑换订单
                                </a>
                            </h4>
                        </div>
                        
                    </div>
                  
		
                    
		
		
		
		
                </div>
		
            </div>
            <!--菜单-->
            <!--内容-->
            <div id="content" class="main-content">
		
                <iframe src="<?=Url::to(["index/order-search"])?>" style="width:100%;height: 100%;" id="appiframe" name="appiframe" frameborder="0"></iframe>
		
            </div>
            <!--内容-->
        </div>
		
    </div>
		
    <!--main-->


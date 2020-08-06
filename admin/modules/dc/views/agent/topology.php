<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\AgentGrade;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = "我的代理商";

?>
<style> 
    .panel-body{width:100%;height:auto;min-height: 500px;}
    
    .main{width:100%;margin-top:5px;}
    .main a{float:left;}
    .main .main_div{height:35px;width:100%;line-height:35px; background: #ccc;}
    .main ul{height:auto;min-height:100px;width:100%;margin-top: 8px;display: none; }  
    .main ul,li{  list-style:none;}
    .main div{float: left;}
       
    .a2{width:100%;height:35px;line-height:35px;float:left; margin-left: 30px;margin-top: 8px;border-bottom: 1px #ccc solid}
    .agent_info span{height: 35px;width: auto;min-width: 170px;display: block;float: left;text-align: center;}     
</style>  



<div class="page-content" >
    <div class="form-inline">
    <div class="panel panel-default">
        <div class="panel-heading"><?=$this->title?> </div>
        <div class="col-md-10">
            <div class="panel panel-info">
              <div class="panel-heading">代理商树形菜单</div>
              <div class="panel-body">
                <ul>
                <?php foreach($agent as $key=>$val):?>    
                    <li class="main clearfix" style="">  
                        <div class="main_div">
                            <a  class="btn-sm btn-success" style="height:35px;line-height: 25px;" href="javascript:;">收起/展开</a>
                            <div class="agent_info">
                                <span>ID：<?=$val["user_id"]?></span>
                                <span>代理等级：<?=AgentGrade::getGrade($val["level"])?></span>
                                <span>手机号：<?=$val["phoneAuth"]["identifier"]?></span>
                                <span>姓名：<?=$val["userName"]["realname"]?></span>
                                
                            </div>
                        </div>
                        <ul>  
                            <?php foreach($val['son'] as $sonkey=>$sonval):?>    
                                <li class="a2">  
                                    <div class="agent_info">
                                        <span>ID：<?=$sonval["user_id"]?></span>
                                        <span>代理等级：<?=AgentGrade::getGrade($sonval["level"])?></span>
                                        <span>手机号：<?=$sonval["phoneAuth"]["identifier"]?></span>
                                        <span>姓名：<?=$sonval["userName"]["realname"]?></span>
                                        
                                    </div>
                                </li> 
                               
                            <?php endforeach;?> 
                            
                        </ul>  
                    </li> 
                   <?php endforeach;?> 
                      
                    

                  </ul>  

              </div>
             </div>

        </div>
      
        <script>  
            $(document).ready(function () {  
                $(".main_div a").click(  
                        function () {  
                            $(this).parent().next().toggle();  
                        }  
                );  
            });  
          
           
            
            
        </script>  


    </div>
    </div>

</div>





       
  
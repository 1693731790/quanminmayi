<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\AgentGrade;
use yii\widgets\LinkPager;;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AgentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '待支付的代理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="col-md-10" style="padding:0px; ">
            <div class="panel panel-info">
              <div class="panel-heading">商品信息</div>
              <div class="panel-body">
                <table class="table table-bordered" style="float:left;">
                 
                  <tr>
                      <th>ID</th>
                      <th>用户ID</th>
                      <th>代理等级</th>
                      <th>真实姓名</th>
                      <th>用户手机号</th>
                      <th>操作</th>
                  </tr>
                  <?php foreach($agent as $val): ?>
                  <tr>
                      <th><?=$val->agent_id?></th>
                      <th><?=$val->user_id?></th>
                      <th><?=AgentGrade::getGrade($val->level)?></th>
                      <th><?=$val->userName->realname?></th>
                      <th><?=$val->phoneAuth->identifier?></th>
                      <th><a class="btn btn-success" href="<?=Url::to(['agent/go-pay','all_pay_sn'=>$val->orderAllPay->all_pay_sn])?>">去支付</a> <a class="btn btn-danger">删除</a></th>
                      
                  </tr>
                  <?php endforeach;?>
                </table>
              </div>
            </div>
    </div>
    <div class="col-md-10" style="padding:0px; ">
             <?=LinkPager::widget(["pagination"=>$pagination]);?>  
    </div>
</div>

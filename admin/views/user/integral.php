<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title ="积分列表";
$this->params['breadcrumbs'][] = ['label' => '积分列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="app">
    <div class="row">
             
       <div class="col-md-12">
        <div class="panel panel-info">
          <div class="panel-heading">积分详情</div>
          <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>积分类型</th>
                    <th>变动积分</th>
                    <th>之前积分</th>
                  <th>之后积分</th>
                    <th>订单id</th>
                    <th>订单号</th>
                    <th>创建时间</th>
                </tr>
                <?php foreach($model as $model):?>
                <tr>
                    <td><?=$model->id?></td>
                    <td><?=$model->type=="1"?"收入":"支出"?></td>
                    <td><?=$model->change_amount?></td>
                    <td><?=$model->before_amount?></td>
                    <td><?=$model->after_amount?></td>
                    <td><?=$model->order_id?></td>
                    <td><?=$model->order_sn?></td>
                    <td><?=date("Y-m-d H:i:s",$model->created_at)?></td>
                    
                    
                </tr>
                <?php endforeach?>
          </table>
           <div class="pagelist">
                    <?php 
                            echo LinkPager::widget([
                                    "pagination"=>$page,
                                    ]);
                            ?> 
                </div>
          </div>
        </div>
       </div>
    </div>

</div>
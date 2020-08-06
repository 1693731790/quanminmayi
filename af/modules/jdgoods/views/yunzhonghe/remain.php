<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\GoodsCate;


/* @var $this yii\web\View */
/* @var $model common\models\Order */


$this->params['breadcrumbs'][] = ['label' => '查看预存款余额', 'url' => ['index']];


?>
 
<div class="app" >

 <div class="col-md-12">
      <div class="panel panel-info">
      <div class="panel-heading">操作</div>
      <div class="panel-body">
        <table id="skuinput" class="table table-bordered " >
        <tr>
           <td>预存款余额</td>
           <td><?=$remain?></td>
          
        </tr>  
       
        </table>
     

      </div>
    </div>
    
   


   </div>
</div>

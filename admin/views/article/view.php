<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->article_id;
$this->params['breadcrumbs'][] = ['label' => '文章列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="app">
    <div class="row">
       <div class="col-md-10">
        <div class="panel panel-info">
          <div class="panel-heading">文章内容</div>
          <div class="panel-body">
            <table class="table table-bordered" style="float:left;">
              <tr>
                  <th width="20%" >标题</th>
                  <td width="80%" ><?=$model->title?></td>
              </tr>
               <tr>
                  <th width="20%" >会员头像</th>
                  <td width="80%" ><img src="<?=$model->title_img?>" alt="" width="55" height="55"></td>
              </tr>
              <tr>
                  <th width="20%" >关键字</th>
                  <td width="80%" ><?=$model->key?></td>
              </tr>
              <tr>
                  <th width="20%" >描述</th>
                  <td width="80%" ><?=$model->desc?></td>
              </tr>
              <tr>
                  <th width="20%" >作者</th>
                  <td width="80%" ><?=$model->author?></td>
              </tr>
                <tr>
                  <th width="20%" >添加时间</th>
                  <td width="80%" ><?=date("Y-m-d H:i:s",$model->create_time)?></td>
              </tr>
              <tr>
                  <th width="20%" >详细内容</th>
                  <td width="80%" >
                      <?=$model->content?>
                  </td>
              </tr>
             
            </table>
          </div>
        </div>
       </div>
    
       
    </div>

</div>
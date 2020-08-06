<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
$this->title =$model->name;
?>
<style type="text/css">
  .Head88 { margin-bottom: 64px; }
  .ThematicListArticle { margin-bottom: 15px; }
  .row-comment { background: #fff; padding: 20px 10px 0; }
  #comment .tit { margin-bottom: 5px; color: #F56A1F; font-size: 16px; }
  #comment .sub { padding:10px; border-bottom:1px solid #EAEAEA; }
  #comment .u img { border-radius: 100%; width: 34px; height: 34px; }
  #comment .sub .txt { width: 85%; }
  #comment .sub .text { border: 1px solid #f1f1f1; margin-bottom: 5px; }
  #comment .sub textarea { border: none; padding: 6px; width: 100%; overflow: auto; height: 40px; line-height: 28px; vertical-align: top; font-family: arial,simsun; }
  #comment .sub_btn, .replaying .btn { background: #FD7A0F; color: #fff!important; display: inline-block; border: none; padding: 0 10px; height: 30px; line-height: 30px; text-align: center; border-radius: 3px; vertical-align: top; }
  #comment .list li { padding: 10px; border-bottom: 1px solid #EAEAEA; }
  #comment .u img { border-radius: 100%; width: 34px; height: 34px; }
  #comment .list .txt { margin-left: 40px; }
  #comment .list .txt .t { color: #333; font-size: 14px; }
  #comment .list .txt .con { color: #888; font-size: 14px; }
  .gray9 { color: #999; }
  
  
 

.pagination li{float: left;}

</style>

<div class="Head88 pt88">
  <header class="TopGd"> <i class="iconfont icon-leftdot" onclick="javascript:history.go(-1)"></i>
    <h2>专题详情</h2>
  </header>
  <div class="ThematicListArticle">
    <div class="head">
      <h2><span><?=$model->name?></span></h2>
      <div class="clearfix">
        <p class="fl"><?=date("Y-m-d H:i:s",$model->create_time)?></p>
        <p class="BrowsingVolume fr"><?=$model->browse?>人浏览</p>
      </div>
    </div>
    <div class="nr text-box">
      <?=$model->content?>
    </div>
  </div>
  <div class="row-comment">
    <div id="comment">
      <div class="tit">评论(<?=$commentCount?>)</div>
      <div class="com-sub">
        
        <?php $form = ActiveForm::begin([
            "action"=>Url::to(['special/comment']),
            'options' => ['class' => 'sub clearfix'],
          ]); ?>
          <input type="hidden" name="special_id" value="<?=$model->special_id?>">
          <div class="fl u"><img src="/static/images/noavatar_middle.jpg" alt="" width="40" height="40"></div>
          <div class="txt fr">
            <div class="text mb10"><textarea name="content" placeholder="快来说上两句吧"></textarea></div>
            <div class="bot mb15">
              
               <?= Html::submitButton('提交评论',['class'=>'sub_btn']) ?>
            </div>
          </div>
      <?php ActiveForm::end(); ?>

      </div>
      <div class="list">
        <ul>
          <?php foreach($comment as $commentval):?>
          <li class="item" data-id="1580186">
            <div class="fl u"><img src="<?=$commentval['user']->headimgurl!=""?Yii::$app->params['imgurl'].$commentval['user']->headimgurl:"/static/images/noavatar_middle.jpg"?>" width="40" height="40" alt=""></div>
            <div class="txt">
              <div class="t clearfix"><?=$commentval['user']->username?>                       
                <span class="gray9 fr"><?=date("Y-m-d H:i:s",$commentval->create_time)?></span>
              </div>
              <div class="con ">
                <?=$commentval->content?>
                <div class="pic_wrap">
                  <ul class="plist clearfix"></ul>
                </div>
              </div>
            </div>
          </li>
          <?php endforeach;?>
        </ul>
       
    </div>
 <div class="page" style="text-align: center;"><?php 
              echo LinkPager::widget([
                  "pagination"=>$pagination,
                  ]);
              ?>  </div>
      </div>
  </div>

</div>

<div class="bottomShare">
  <ul class="clearfix">
    <li>
      <a href="javascript:;" onclick="favorite()">
        <i class="iconfont icon-collection"></i>
        <p>收藏</p>
      </a>
    </li>
    <!-- <li>
      <a href="###">
        <i class="iconfont icon-share"></i>
        <p>收藏</p>
      </a>
    </li> -->
  </ul>
</div>
<script type="text/javascript">
    function favorite(){
      $.get("<?=Url::to(['special/favorite'])?>",{"special_id":"<?=$model->special_id?>"},function(r){
          if(r=="1"){
              layer.msg("收藏成功");
          }else if(r=="2"){
              layer.msg("您已经收藏过了");
          }else if(r=="3"){
              layer.msg("您还没有登录");
              setTimeout(function(){window.location.href="<?=Url::to(['user/index'])?>"},2000);
          }else{
              layer.msg("收藏失败");
          }
      })
    }
</script>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '店铺品牌';
?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/Brand_life.css">
<?php if(empty($_GET["token"])):?>
<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<?php endif;?>
<div class="lifeheader">
	<img class="liferheaderimg" src="/webstatic/images/lifeeimg_01.png"/>
</div>



<div class="lifecontent">
	<div class="lifecontentright">
		<ul>
		<?php foreach($shopCate as $key=>$val):?>
          <li><a href="<?=Url::to(["goods/index","shop_id"=>$val->shop_id,"shops_cate"=>$val->id])?>"><img class="headerimg" src="<?=$val->img?>"/></a></li>
		<?php endforeach;?>
		</ul>
	</div>
</div>

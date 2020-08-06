<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '品牌生活';
?>

<link rel="stylesheet" type="text/css" href="/webstatic/css/Brand_life.css">
<?php if(empty($_GET["token"])):?>
<header>
         <a href="javascript:;" onclick="history.go(-1)"><div class="_lefte"><img class="header-img" src="/webstatic/images/back_jt_w.png"/><!-- <i class="iconfont icon-back is"></i> --></div></a>
</header>
<?php endif;?>
<div class="lifeheader">
	<img class="liferheaderimg" src="/webstatic/images/lifeeimg_01_add.png"/>
</div>



<div class="lifecontent">
	<div class="lifecontentright">
		<ul>
		<?php foreach($goodsBrand as $key=>$val):?>
          <li><a href="<?=Url::to(["goods/index","goods_brand"=>$val["id"]])?>"><img class="headerimg" src="<?=$val->img?>"/></a></li>
		<?php endforeach;?>
		</ul>
	</div>
</div>

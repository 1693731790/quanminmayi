<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use common\widgets\Nav;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\NavBar;
use backend\widgets\Breadcrumbs;
use common\widgets\Alert;
use dmstr\widgets\Menu;
use backend\assets\ColorAdminAsset;
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
    <!-- begin #page-container -->
    <div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
        <?php 
            $callback = function($menu){
                $data = json_decode($menu['data'], true); 
                $items = $menu['children']; 
                $return = [ 
                    'label' => $menu['name'], 
                    'url' => [$menu['route']], 
                ]; 
                //处理我们的配置 
                if ($data) { 
                    //visible 
                    isset($data['visible']) && $return['visible'] = $data['visible']; 
                    //icon 
                    isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon']; 
                    $data['class']='has-sub';
                    $return['options'] = $data;
                } 
                //没配置图标的显示默认图标 

                (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o'; 
                $items && $return['items'] = $items; 
                return $return; 
                }; 
                $top_navs=MenuHelper::getAssignedMenu(Yii::$app->user->id,null,$callback);
                $navs=$top_navs;
                if($this->context->module->id=='rbac'){
                    foreach($top_navs as $k=>$v){
                        if($v['label']=='权限管理'){

                            $navs=$v['items'];
                            $top_navs[$k]['is_active']=true;
                            break;
                        }
                    }
                }else if($this->context->module->id=='dc'){
                    foreach($top_navs as $k=>$v){
                        if($v['label']=='分销'){

                            $navs=$v['items'];
                            $top_navs[$k]['is_active']=true;
                            break;
                        }
                    }
                }else if($this->context->module->id=='jdgoods'){
                    foreach($top_navs as $k=>$v){
                        if($v['label']=='京东'){

                            $navs=$v['items'];
                            $top_navs[$k]['is_active']=true;
                            break;
                        }
                    }
                }else{
                    foreach($top_navs as $k=>$v){
                        if($v['label']=='网站功能'){
                             
                            $navs=$v['items'];
                            $top_navs[$k]['is_active']=true;
                            break;
                        }
                    }


                }

        ?>

        <?=$this->render('top',['top_navs'=>$top_navs])?>
        <?=$this->render('left',['navs'=>$navs])?>
        <!-- begin #content -->
        <div id="content" class="content">
            <!-- begin breadcrumb -->
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
               
            <!-- end breadcrumb -->
            
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
    
                            </div>
                            <h4 class="panel-title"><?=Html::encode($this->title)?></h4>
                        </div>
                        <div class="panel-body">
                           <?=$content?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end #content -->
        
        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
    

<?=$this->render('footer')?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

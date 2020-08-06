<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/static/ColorAdmin/V2.1/css/style.min.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet">
<link href="/static/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="/static/sinian-backend/iconfont.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/css/animate.min.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/css/style-responsive.min.css" rel="stylesheet">
<link href="/static/ColorAdmin/V2.1/css/theme/default.css" rel="stylesheet">
<link href="/static/node_modules/element-ui/lib/theme-color/index.css" rel="stylesheet">
<link href="/css/site.css" rel="stylesheet">

<script src="/static/ColorAdmin/V2.1/plugins/pace/pace.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/static/ColorAdmin/V2.1/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="/static/ColorAdmin/V2.1/js/apps.min.js"></script>
<script src="/static/node_modules/vue/dist/vue.js"></script>
<script src="/static/node_modules/element-ui/lib/index.js"></script>


<div class="category-index" style="margin-left:-200px;">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

<style type="text/css">
.label{cursor:pointer;}

    


</style>
<div id="app" class="app">

    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr class="text-c">
                <th width="80" class="text-center">ID</th>
                <th width="82">缩略图</th>
                <th style="text-align:left;padding-left: 40px;">分类名称</th>
                <th style="text-align:left;padding-left: 40px;">手机显示名称</th>
                <th width="150" class="text-center">是否推荐</th>
                <th width="40"><span class="btn size-S btn-success btn-sm" @click="saveSort">排序</span></th>
                <th width="280">操作</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-c" v-for="(cat,index) in cats">
                <td class="text-center" v-text="cat.goods_cat_id"></td>
                <td class="text-center"><img :src="cat.thumb" width="40" height="30" alt=""></td>
                <td v-if="cat.level==1" v-html="cat.goods_cat_name"  style="text-align:left;padding-left: 40px;"></td>
                <td v-if="cat.level==2" v-html="'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|----'+cat.goods_cat_name"  style="text-align:left;padding-left: 40px;"></td>
                <td v-if="cat.level==3" v-html="'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|----'+cat.goods_cat_name"  style="text-align:left;padding-left: 80px;"></td>
                <td v-html="cat.goods_cat_name_mob"  style="text-align:left;padding-left: 40px;"></td>
                <td class="text-center" title="点击更改状态">
                    <img src="/img/yes.gif" alt="显示" @click="changegoods_cat_is_show(cat.goods_cat_id,index)" v-if="cat.goods_cat_is_show==1">
                    <img src="/img/no.gif" alt="隐藏" @click="changegoods_cat_is_show(cat.goods_cat_id,index)" v-if="cat.goods_cat_is_show==0">
                </td>
                <td><input type="text" v-model="cat.goods_cat_sort" style="width: 40px;"></td>
                <td style="text-align: left;">
                <span @click="del(cat.goods_cat_id,index)" class="btn btn-danger btn-sm">删除</span>&nbsp;&nbsp;
                <span @click="edit(cat.goods_cat_id)" class="btn btn-sm btn-info">编辑</span>&nbsp;&nbsp;
                <span v-if="cat.level!=3" @click="add(cat.goods_cat_id)" class="btn btn-success btn-sm">添加子分类</span>&nbsp;&nbsp;
                </td>
            </tr>

        </tbody>
    </table>

</div>

<script>
    var vm = new Vue({
      el: '#app',
      data: function() {
         return {
            cats:<?=json_encode($cats)?>,
            temp:'',
          }
      },
      methods:{
        edit (id){
           location.href="<?=Url::to(['update','id'=>''])?>"+id;
        },
        add (goods_cat_pid){
            location.href="<?=Url::to(['create','pid'=>''])?>"+goods_cat_pid;
        },

        del (goods_cat_id,index){
             vm.$confirm('确定要删除此项吗？', '提示', {
              cancelButtonText: '取消',
              confirmButtonText: '确定',
              type: 'warning'
            }).then(() => {
                $.ajax({
                    url:'<?=Url::to(['delete'])?>',
                    data:{id:goods_cat_id},
                    type:'post',
                    success:function(data){
                        if(data.success==1){
                            vm.cats.splice(index,1);
                            vm.$notify({
                                message:data.msg,
                                type:'success'
                            });
                            
                        }else{
                            vm.$message({
                                message:data.msg,
                                type:'error',
                            });
                            location.reload();
                           
                        }
                    },
                    dataType:'json',
                });
            });
        },
        //显示／隐藏
        changegoods_cat_is_show (goods_cat_id,index){
            $.ajax({
                url:'',
                type:'post',
                data:{id:goods_cat_id},
                success:function(data){
                    if(data.success==1){
                        vm.cats[index]['goods_cat_is_show']=data.goods_cat_is_show;
                    }else{
                        layer.msg(data.msg);
                    }
                },
                dataType:'json',
            });
        },

        // 保存排序
        saveSort (){
            $.ajax({
                url:'',
                type:'post',
                data:{sort:vm.cats},
                success:function(data){
                    if(data.success==1){
                        var cats=data.cats;
                        vm.cats=JSON.parse(cats);
                        vm.$notify({
                            message:'操作成功',
                            type:'success'
                        });
                    }else{
                        vm.$notify({
                            message:data.msg,
                            type:'error'
                        });
                    }

                },
                dataType:'json',
            });

        },
        // end
      },
    })
  </script>


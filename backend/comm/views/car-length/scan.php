<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = '整车列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.table{table-layout:fixed}
.el-switch--wide,.save{display: none;}
input{width:100px;}</style>
<div class="car-length-index" id="app">
<p>
    <?= Html::a('添加整车', ['create'], ['class' => 'btn btn-success']) ?>
</p>
<table class="table table-bordered">
    <tr>
        <th width="60">车长</th><th width="80">车型</th><th>起步里程(km)</th><th>起步价(元)</th><th>载重体积(方)</th><th>载重量(kg)</th><th>超里程价(元/km)</th><th>司机提成(%)</th><th>合伙人提成(%)</th><th>是否启用</th><th width="150">操作</th>
    </tr>
    <tr v-for="(item,index) in list" :class="item.is_show==1?'':'active'">
        <td>{{item.length.length}}</td>
        <td>{{item.type.name}}</td>
        <td><span v-text="item.start_distance"></span><input type="hidden" v-model="item.start_distance"></td>
        <td><span v-text="item.start_fee"></span><input type="hidden" v-model="item.start_fee" ></td>
        <td><span v-text="item.car_volume"></span><input type="hidden" v-model="item.car_volume" ></td>
        <td><span v-text="item.car_weight"></span><input type="hidden" v-model="item.car_weight" ></td>
        <td><span v-text="item.price"></span><input type="hidden" v-model="item.price" ></td>
        <td><span v-text="item.driver_commission"></span><input type="hidden" v-model="item.driver_commission"></td>
        <td><span v-text="item.partner_commission"></span><input type="hidden" v-model="item.partner_commission" ></td>
        <td>
            <el-switch
            v-model="item.is_show"
            on-color="#13ce66"
            off-color="#ff4949"
            on-value=1
            off-value=0>
            </el-switch>
<img :src="item.is_show==1?'/img/yes.gif':'/img/no.gif'" alt="" @click="item.is_show=!item.is_show"></td>
        <td><button class="btn btn-sm btn-warning edit">编辑</button><button class="btn btn-sm btn-success save" @click="save(index)">保存</button></td>
    </tr>
</table>
</div>
<script>
    var vm=new Vue({
        el:'#app',
        data:{
            list:<?=json_encode($list)?>
        },
        methods:{
            save:function(index){
                $.post("<?=Url::to(['car-price/update-by-ajax'])?>",{data:this.list[index]},function(res){
                    layer.msg(res.message);
                    if(res.success){
                        var obj=$("table tr:eq("+(index+1)+")");
                        obj.children('td').children('input').attr('type','hidden');
                        obj.children('td').children('span').css('display','block');
                        obj.children('td').children('.edit').css('display','block');
                        obj.children('td').children('.save').css('display','none');
                        obj.children('td').children('img').css('display','block');
                        obj.children('td').children('.el-switch--wide').css('display','none');
                        vm.list=res.list;
                    }
                },'json');
            },
        },
    });

    $('td').on('click',function(){
        $(this).parent().children('td').children('input').attr('type','number');
        $(this).parent().children('td').children('span').css('display','none');
        $(this).parent().children('td').children('.edit').css('display','none');
       
        $(this).parent().children('td').children('.save').css('display','block');
         $(this).parent().children('td').children('img').css('display','none');
        $(this).parent().children('td').children('.el-switch--wide').css('display','block');
    });
</script>
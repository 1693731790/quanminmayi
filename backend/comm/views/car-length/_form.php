<?php
// 整车价格设置
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\RegionGroup;
use common\models\Price;
use common\models\CarType;
// 列出所有地区
$region_groups=RegionGroup::find()->where(['type'=>$model->type])->orderBy(['sort'=>SORT_DESC])->asArray()->all();
// 列出所有车型
$car_types=CarType::find()->where(['is_show'=>1,'type'=>$model->type])->orderBy(['sort'=>SORT_DESC,'id'=>SORT_ASC])->asArray()->all();
$price_list=[];

//地区与车型组合
foreach($region_groups as $k=>$v){
    $tmp=[];
    $tmp['group_id']=$v['group_id'];
    $tmp['group_name']=$v['group_name'];
    $tmp['total_distance']=$v['total_distance'];
    $tmp['car_types']=$car_types;
    foreach($tmp['car_types'] as $k2=>$v2){
        $price_model_tmp=Price::findOne(['group_id'=>$v['group_id'],'car_type_id'=>$v2['id'],'car_length_id'=>$model->id]);
        if($price_model_tmp==null){
            $tmp['car_types'][$k2]['is_show']=$car_types[$k2]['is_show']=false;
            $tmp['car_types'][$k2]['prices']['start_distance']=null;
            $tmp['car_types'][$k2]['prices']['start_weight']=null;
            $tmp['car_types'][$k2]['prices']['start_fee']=null;
            $tmp['car_types'][$k2]['prices']['start_fee_out']=null;
            $tmp['car_types'][$k2]['prices']['price']=null;
            $tmp['car_types'][$k2]['prices']['price_out']=null;
            $tmp['car_types'][$k2]['prices']['out_price']=null;
            $tmp['car_types'][$k2]['prices']['out_price_out']=null;
            $tmp['car_types'][$k2]['prices']['driver_income']=null;
        }else{
            $tmp['car_types'][$k2]['is_show']=$car_types[$k2]['is_show']=true;
            $tmp['car_types'][$k2]['prices']=json_decode($price_model_tmp->prices);
        }
    }
    array_push($price_list,$tmp);
} 


?>

<style>
    th{
        text-align:center;vertical-align:middle!important;
    }
    input{width:100px;};
</style>

<div class="note note-info">
    <h4>提示</h4>
    <ol>
        <li>所有文本框填写完整后方可提交表单。</li>
        <li>司机分成金额请用小数表示。例如5%则填写0.05即可。</li>
    </ol>
</div>

<div id="app">
<!--     {{type_list}} -->
<!--     {{price_list}} -->
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'length')->textInput(['maxlength' => true]) ?>
    <input type="hidden" name="prices" id="prices">

    <span v-for="(item,index) in type_list" :class="item.is_show?'btn btn-danger':'btn btn-default'" @click="handleSelect(index)" style="margin-right: 5px;">{{item.name}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!-- <a target="_blank" href="<?=Url::to(['/app/car-type2/create'])?>">添加新车型</a> -->
    <p class="text-danger" style="margin-top: 5px;">点击选择支持的车型</p>
    <div class="h10"></div>
    <div class="row">
        <div class="col-md-12" v-for="price_data in price_list">
            <div class="panel panel-info">
            <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title">{{price_data.group_name}}</h4>

            </div>
                <div class="panel-body">
                    <p><label for="">总公里数(km)&nbsp;&nbsp;</label><input type="text" v-model="price_data.total_distance"></p>
                    <table class="table table-bordered"  style="margin-bottom: 10px;">
                    <tr>
                        <th rowspan="2">车型</th><th rowspan="2">起步里程(km)</th><th rowspan="2">首重(kg)</th><th colspan="2">起步价</th><th colspan="2">超起步里程价(元/km)</th><th colspan="2">超出总公里后每公里价(元/km)</th><th rowspan="2">司机提成</th>
                    </tr>
                    <tr>
                     <th>基础价</th><th>超重每公斤增加(元/kg)</th><th>基础价</th><th>超重每公斤增加(元/kg)</th><th>基础价</th><th>超重每公斤增加(元/kg)</th>
                    </tr>
                        <tr v-for="(item,item_index) in price_data.car_types" v-if="type_list[item_index].is_show">
                            <td width="100">{{item.name}}</td>
                            <td><input type="number" step="0.01" v-model="item.prices.start_distance"></td>
                            <td><input type="number" step="0.01" v-model="item.prices.start_weight"></td>
                            <td><input type="number" step="0.01" v-model="item.prices.start_fee"></td>
                            <td><input type="number" step="0.01" v-model="item.prices.start_fee_out"></td>
                            <td><input type="number" step="0.01" v-model="item.prices.price"></td>
                            <td><input type="number" step="0.01" v-model="item.prices.price_out"></td>
                            <td><input type="number" step="0.01" v-model="item.prices.out_price"></td>
                            <td><input type="number" step="0.01" v-model="item.prices.out_price_out"></td>

                            <td><input type="number" step="0.01" v-model="item.prices.driver_income"><span class="text-danger">{{item.prices.driver_income*100}}%</span></td>

                        </tr>

                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="h10"></div>

    <div class="form-group text-center">
        <span class="btn btn-primary" @click="save()">提交</span>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<script>
var _csrf_backend = $('meta[name="csrf-token"]').attr('content');
var vm = new Vue({
    el:'#app',
    data:{
        type_list:<?=json_encode($car_types)?>,
        // type_checked:[],
        // type_checked_count:1,
        price_list:<?=json_encode($price_list)?>,
    },
    methods:{
        handleSelect(index){
            this.type_list[index].is_show=!this.type_list[index].is_show;
            this.price_list.forEach(function(v,k){
                v.car_types[index].is_show=vm.type_list[index].is_show;
            });
        },
        save(file, fileList) {
            var ok=true;
            $('#prices').val(JSON.stringify(vm.price_list));
            $('input').each(function(){
             if($(this).val()==''){
                ok=false;
             }
            });
            if(!ok){
                layer.msg('请将表单填写完整');
                return false;
            }
            
            $('form').submit();
        },
    },
    watch:{

    },

});

</script>
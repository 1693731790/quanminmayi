<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_cat".
 *
 * @property string $goods_cat_id
 * @property string $goods_cat_name
 * @property string $goods_cat_name_mob
 * @property integer $goods_cat_is_show
 * @property integer $goods_cat_is_tuijian
 * @property integer $goods_cat_group
 * @property integer $goods_cat_sort
 * @property string $goods_cat_pid
 */
class GoodsCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_cat_name'], 'required'],
            [['goods_cat_is_show', 'goods_cat_is_tuijian', 'goods_cat_group', 'goods_cat_sort', 'goods_cat_pid'], 'integer'],
            [['goods_cat_name', 'goods_cat_name_mob'], 'string', 'max' => 20],
            [['thumb'], 'string', 'max' => 255],
            [['ads','ads_url'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_cat_id' => '分类ID',
            'goods_cat_name' => '分类名称',
            'goods_cat_name_mob' => '手机显示名称',
            'goods_cat_is_show' => '是否推荐',
            //'goods_cat_is_tuijian' => '是否推荐',
            'goods_cat_group' => '分组',
            'goods_cat_sort' => '排序',
            'goods_cat_pid' => '父分类id',
            'ads' => '广告位',
            'ads_url' => '广告链接',
            'thumb' => '缩略图',
        ];
    }
    static function getIsArr(){
        $cache=Yii::$app->cache;
        return $cache->getOrSet('goods_cat_is_show_arr',function(){
            return self::find()->orderBy(['goods_cat_sort'=>SORT_DESC])->asArray()->all();
        },10);
    }
    static function getIsShowArr(){
        $cache=Yii::$app->cache;
        return $cache->getOrSet('goods_cat_is_show_arr',function(){
            return self::find()->where(['goods_cat_is_show'=>1])->orderBy(['goods_cat_sort'=>SORT_DESC])->asArray()->all();
        },3600);
    }

    static function getMergeCats($arr=null,$goods_cat_pid=0){
        if($arr==null){
            $arr=self::getIsShowArr();
        }
        $res=[];
        foreach($arr as $v){
            if($v['goods_cat_pid']==$goods_cat_pid){
                $tmp=$v;
                $tmp['children']=self::getMergeCats($arr,$v['goods_cat_id']);
                $res[]=$tmp;
            }
        }
        return $res;
    }

    static function getCatName($goods_cat_id){
        $cat=self::findOne($goods_cat_id);
        if(!empty($cat)){
            return $cat->goods_cat_name;
        }else{
            return null;
        }
    }

    static function getChild($goods_cat_pid=0){
        $cats= self::find()->where('goods_cat_pid=:id',[':id'=>$goods_cat_pid])->asArray()->all();
        $result=[];
         $result[]=['value'=>'0','label'=>'请选择'];
        foreach($cats as $v){
            $temp=[];
            $temp['value']=$v['goods_cat_id'];
            $temp['label']=$v['goods_cat_name'];
            $result[]=$temp;
        }
        return json_encode($result);
    }

    static function getCats($cats=null,$goods_cat_pid=0){
        if($cats==null){
            $cats=self::getArr();
        }
        $arr=[];
        foreach($cats as $v){
            if($v['goods_cat_pid']==$goods_cat_pid){
                $tmp=$v;
                $tmp['child']=self::getCats($cats,$v['goods_cat_id']);
                $arr[]=$tmp;
            }
        }
        return $arr;
    }

    static function getCatsOptions($goods_cat_pid=0){
        $cats = self::find()->orderBy('goods_cat_sort desc')->asArray()->all();
        $arr=[];
        if($goods_cat_pid==0){
           $arr[0]['label']=null;
           $arr[0]['value']=null;
        }
        foreach($cats as $v){
            if($v['goods_cat_pid']==$goods_cat_pid){
                $tmp['label']=$v['goods_cat_name'];
                $tmp['value']=$v['goods_cat_id'];
                $tmp['children']=self::getCatsOptions($v['goods_cat_id']);
                if(empty($tmp['children'])){
                    unset($tmp['children']);
                }
                $arr[]=$tmp;
            }
        }
        return $arr;
    }

    static function getCatsList($arr,$prefix=null,$prompt=null,$prefix2=null){
        $result=[];
        if(!empty($prompt)){
            $temp=[];
            $temp['goods_cat_id']='0';
            $temp['goods_cat_name']=$prompt;
            $temp['level']=1;
            $result[]=$temp;
        }
        foreach($arr as $v){
            $temp=[];
            $temp['goods_cat_id']=$v['goods_cat_id'];
            $temp['goods_cat_name']=$v['goods_cat_name'];
            $temp['goods_cat_name_mob']=$v['goods_cat_name_mob'];
            $temp['thumb']=$v['thumb'];
            $temp['goods_cat_sort']=$v['goods_cat_sort'];
            $temp['goods_cat_pid']=$v['goods_cat_pid'];
            $temp['goods_cat_is_show']=$v['goods_cat_is_show'];
            $temp['level']=1;

            $result[]=$temp;
            foreach($v['child'] as $c){
	            $temp=[];
	            $temp['goods_cat_id']=$c['goods_cat_id'];
	            $temp['goods_cat_name']=$prefix.$c['goods_cat_name'];
                $temp['goods_cat_name_mob']=$c['goods_cat_name_mob'];
                $temp['thumb']=$c['thumb'];
	            $temp['goods_cat_sort']=$c['goods_cat_sort'];
	            $temp['goods_cat_pid']=$c['goods_cat_pid'];
	            $temp['goods_cat_is_show']=$c['goods_cat_is_show'];
	            $temp['level']=2;
	            $result[]=$temp;
	            	foreach($c['child'] as $cc){
		            	$temp=[];
		            	$temp['goods_cat_id']=$cc['goods_cat_id'];
		            	$temp['goods_cat_name']=$prefix.$prefix2.$cc['goods_cat_name'];
                        $temp['goods_cat_name_mob']=$cc['goods_cat_name_mob'];
                        $temp['thumb']=$cc['thumb'];
		            	$temp['goods_cat_sort']=$cc['goods_cat_sort'];
		            	$temp['goods_cat_pid']=$cc['goods_cat_pid'];
		            	$temp['goods_cat_is_show']=$cc['goods_cat_is_show'];
		            	$temp['level']=3;
		            	$result[]=$temp;
	            	}
            }
        }

        return $result;
    }

    static function getOptions($prefix=null,$prompt=null,$prefix2=null){
        $arr= self::find()->orderBy('goods_cat_sort desc')->asArray()->all();

        $cats_arr=self::getCats($arr);

        $options=self::getCatsList($cats_arr,$prefix,$prompt,$prefix2);

       return $options;
    }
    
    static function getNav(){
        return self::find()->where('goods_cat_pid!=0 and goods_cat_is_show=1')->orderBy('goods_cat_pid desc')->addOrderBy('goods_cat_sort desc')->all();
    }

    static function getParentsToArray($cat_id){
        $arr=[];
        $cat=self::findOne($cat_id);
        if($cat==null){
            return $arr;
        }
        if($cat->goods_cat_pid==0){
            $arr[]=strval($cat_id);
            return $arr;
        }
        $parent=self::find()->where('goods_cat_id=:cat_id',[':cat_id'=>$cat->goods_cat_pid])->one();
        if($parent==null){
            $arr[]=strval($cat_id);
            return $arr;
        }
        if($parent->goods_cat_pid==0){
            $arr[]=strval($parent->goods_cat_id);
            $arr[]=strval($cat_id);
            return $arr;
        }
        $arr[]=strval($parent->goods_cat_pid);
        $arr[]=strval($parent->goods_cat_id);
        $arr[]=strval($cat_id);
        return $arr;
    }


    static function getCateName($cate_id)
    {
        $model=self::findOne($cate_id);
       	if(!empty($model))
        {
          	return $model->goods_cat_name;
        }else{
          	return "";
        }
        
    }

	
}

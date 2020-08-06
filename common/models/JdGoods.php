<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jd_goods}}".
 *
 * @property integer $id
 * @property integer $jdgoods_id
 * @property string $name
 * @property string $brand
 * @property string $type
 * @property string $thumbnailImage
 * @property integer $productCate
 * @property string $productCode
 * @property string $status
 * @property string $marketPrice
 * @property string $retailPrice
 * @property string $productPlace
 * @property string $features
 * @property integer $tax
 * @property string $imageUrl
 * @property integer $orderSort
 * @property string $content
 * @property string $mobile_content
 * @property integer $create_time
 */
class JdGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%jd_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jdgoods_id'], 'required'],
            [['jdgoods_id', 'productCate', 'tax', 'orderSort', 'create_time'], 'integer'],
            [['marketPrice', 'retailPrice',"profitPCT"], 'number'],
            [['imageUrl', 'content', 'mobile_content',"features"], 'string'],
            [['name', 'brand', 'thumbnailImage'], 'string', 'max' => 200],
            [['type', 'productCode'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
            [['productPlace'], 'string', 'max' => 255],
            [['jdgoods_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jdgoods_id' => '京东商品ID',
            'name' => '商品名称',
            'brand' => '商品品牌',
            'type' => '类型',
            'thumbnailImage' => '主图',
            'productCate' => '商品分类',
            'productCode' => '商品型号',
            'status' => '状态',
            'marketPrice' => '市场价',
            'retailPrice' => '协议价',
            'profitPCT' => '利润百分比',
            'productPlace' => '商品产地',
            'features' => '简要描述',
            'tax' => '商品税率',
            'imageUrl' => '图片链接',
            'orderSort' => '图片排序',
            'content' => '详细内容',
            'mobile_content' => '手机版详细内容',
            'create_time' => '创建时间',
        ];
    }
}

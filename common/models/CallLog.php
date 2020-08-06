<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%call_log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $caller
 * @property string $called
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $call_time
 * @property string $guishudi
 * @property string $mobile_ip
 * @property string $openid
 * @property string $lon
 * @property string $lat
 * @property string $fee
 * @property string $balance
 */
class CallLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%call_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'caller', 'called', 'start_time', 'end_time', 'call_time', 'guishudi', 'mobile_ip', 'openid', 'lon', 'lat', 'fee', 'balance'], 'required'],
            [['user_id', 'start_time', 'end_time', 'call_time'], 'integer'],
            [['fee', 'balance'], 'number'],
            [['caller', 'called'], 'string', 'max' => 11],
            [['guishudi', 'mobile_ip'], 'string', 'max' => 100],
            [['openid'], 'string', 'max' => 50],
            [['lon', 'lat'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'caller' => '主叫号码',
            'called' => '被叫号码',
            'start_time' => '起始时间',
            'end_time' => '结束时间',
            'call_time' => '通话时长',
            'guishudi' => '归属地',
            'mobile_ip' => '手机ip',
            'openid' => '微信id',
            'lon' => '经度',
            'lat' => '纬度',
            'fee' => '话费',
            'balance' => '剩余话费',
        ];
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%special_favorite}}".
 *
 * @property integer $special_favorite_id
 * @property integer $special_id
 * @property integer $user_id
 */
class SpecialFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%special_favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_id', 'user_id'], 'required'],
            [['special_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'special_favorite_id' => 'Special Favorite ID',
            'special_id' => 'Special ID',
            'user_id' => 'User ID',
        ];
    }
}

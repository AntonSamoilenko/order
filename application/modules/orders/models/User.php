<?php

namespace app\modules\orders\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }
}
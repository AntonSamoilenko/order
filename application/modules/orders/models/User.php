<?php

namespace app\modules\orders\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    public function getFullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
<?php

namespace app\modules\orders\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%services}}';
    }

    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['service_id' => 'id']);
    }
}
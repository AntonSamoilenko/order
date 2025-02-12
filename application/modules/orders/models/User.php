<?php

namespace app\modules\orders\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
//    /**
//     * @var string
//     */
//    private string $first_name;
//    /**
//     * @var string
//     */
//    private string $last_name;

    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    // Метод для объединения first_name и last_name
    public function getFullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
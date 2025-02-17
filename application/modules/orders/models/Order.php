<?php

namespace app\modules\orders\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%orders}}';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            ['status', 'in', 'range' => [0, 1, 2, 3, 4]],
            ['mode', 'in', 'range' => [0, 1]],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'user_id'       => Yii::t('app', 'User'),
            'link'          => Yii::t('app', 'Link'),
            'quantity'      => Yii::t('app', 'Quantity'),
            'service_id'    => Yii::t('app', 'Service'),
            'status'        => Yii::t('app', 'Status'),
            'created_at'    => Yii::t('app', 'Created At'),
            'mode'          => Yii::t('app', 'Mode'),
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}
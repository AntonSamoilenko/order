<?php

namespace app\modules\orders\models;

use app\modules\orders\query\ServicesQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Services extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return ServicesQuery
     */
    public static function find(): ServicesQuery
    {
        return new ServicesQuery(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Orders::class, ['service_id' => 'id']);
    }
}

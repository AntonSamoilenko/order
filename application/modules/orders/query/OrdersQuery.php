<?php

namespace app\modules\orders\query;

use app\modules\orders\models\Orders;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[Orders]].
 *
 * @see Orders
 */
class OrdersQuery extends ActiveQuery
{
    /**
     * @param $db
     * @return array|ActiveRecord[]
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param $db
     * @return Orders|array|null
     */
    public function one($db = null): Orders|array|null
    {
        return parent::one($db);
    }
}

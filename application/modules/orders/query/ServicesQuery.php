<?php

namespace app\modules\orders\query;

use app\modules\orders\models\Services;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[Services]].
 *
 * @see Services
 */
class ServicesQuery extends ActiveQuery
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
     * @return Services|array|null
     */
    public function one($db = null): Services|array|null
    {
        return parent::one($db);
    }
}

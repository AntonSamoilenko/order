<?php

namespace app\modules\orders\query;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[Users]].
 *
 * @see Users
 */
class UsersQuery extends ActiveQuery
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
     * @return array|ActiveRecord|null
     */
    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }
}

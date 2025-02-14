<?php

namespace app\modules\orders\repositories;

use app\modules\orders\models\Order;
use app\modules\orders\models\Service;
use app\modules\orders\models\User;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class OrderRepository
{
    public function setFilterByParams(ActiveQuery &$query, array $params): void
    {
        if (isset($params['status'])) {
            $query->andWhere(['o.status' => $params['status']]);
        }

        if (isset($params['mode'])) {
            $query->andWhere(['o.mode' => $params['mode']]);
        }

        if (!empty($params['service_id'])) {
            $serviceIds = array_map('intval', $params['service_id']);
            $query->andWhere(['in', 'o.service_id', $serviceIds]);
        }

        if (isset($params['search_type'])) {
            switch ((int) $params['search_type']) {
                case 0:
                    $orderIds = array_map('intval', explode(',', $params['search']));
                    $query->andWhere(['in', 'o.id', $orderIds]);
                    break;
                case 1:
                    $query->andWhere(['like', 'o.link', $params['search']]);
                    break;
                case 2:
                    $userName = explode(' ', $params['search']);
                    $query->leftJoin(User::tableName() . ' u', 'o.user_id = u.id')
                        ->andWhere([
                            'or',
                            ['like', 'u.first_name', $userName[0]],
                            ['like', 'u.last_name', $userName[0]]
                        ]);
                    if (!empty($userName[1])) {
                        $query->andWhere([
                            'or',
                            ['like', 'u.first_name', $userName[1]],
                            ['like', 'u.last_name', $userName[1]]
                        ]);
                    }
                    break;
            }
        }
    }

    public function getOrdersByParams(array $params): ActiveQuery
    {
        $query = Order::find()
            ->alias('o')
            ->orderBy(['o.id' => SORT_DESC]);

        $this->setFilterByParams($query, $params);

        return $query;
    }

    public function getData(array $params): ActiveDataProvider
    {
         return new ActiveDataProvider([
            'query' => $this->getOrdersByParams($params),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
    }

    public function getTotalCount(): int
    {
        return Order::find()->count();
    }

    public function getAvailableModes(): array
    {
        return Order::find()
            ->select('mode')
            ->distinct()
            ->column();
    }

    public function getService(array $params = []): array
    {
        $query = Order::find()
            ->select(['service_id', 's.name as name', 'COUNT(o.id) as count'])
            ->alias('o');

        unset($params['service_id']);
        $this->setFilterByParams($query, $params);

        $query->leftJoin(Service::tableName() . ' s', 'o.service_id = s.id')
            ->groupBy('o.service_id')
            ->orderBy(['count' => SORT_DESC]);

        $preparedServices = [];
        foreach ($query->asArray()->all() as $item) {
            $preparedServices[$item['service_id']] = $item;
        }
        return $preparedServices;
    }
}
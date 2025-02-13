<?php

namespace app\modules\orders\repositories;

use app\modules\orders\models\Order;
use app\modules\orders\models\Service;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class OrderRepository
{
    public function getOrdersByParams(array $params): ActiveQuery
    {
        $query = Order::find()
            ->alias('o')
            ->with(['user', 'service'])
            ->orderBy(['o.id' => SORT_DESC]);

        if (isset($params['status'])) {
            $query->andWhere(['o.status' => $params['status']]);
        }

        if (isset($params['mode'])) {
            $query->andWhere(['o.mode' => $params['mode']]);
        }

        if (isset($params['service_id'])) {
            $query->andWhere(['o.service_id' => $params['service_id']]);
        }

        if (!empty($params['search_id'])) {
            $query->andWhere(['o.id' => $params['search_id']]);
        }

        if (!empty($params['search_user'])) {
            $query->joinWith(['user u'])
                ->andWhere([
                    'or',
                    ['like', 'u.first_name', $params['search_user']],
                    ['like', 'u.last_name', $params['search_user']]
                ]);
        }

        if (!empty($params['search_link'])) {
            $query->andWhere(['like', 'o.link', $params['search_link']]);
        }

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

    public function getService(): array
    {
        $serviceCounts = Order::find()
            ->select(['service_id', 's.name as name', 'COUNT(o.id) as count'])
            ->alias('o')
            ->leftJoin(Service::tableName() . ' s', 'o.service_id = s.id')
            ->groupBy('o.service_id')
            ->orderBy(['count' => SORT_DESC])
            ->asArray()
            ->all();

        $services = [];
        foreach ($serviceCounts as $item) {
            $services[$item['service_id']] = $item;
        }
        return $services;
    }
}
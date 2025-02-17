<?php

namespace app\modules\orders\services\dataHandler;

use app\modules\orders\DTO\Orders;
use app\modules\orders\helpers\OrderHelper;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

class OrderHandler
{
    /**
     * @param ActiveDataProvider $dataProvider
     * @param array $services
     * @return void
     * @throws InvalidConfigException
     */
    public function handleActiveDataProvider(ActiveDataProvider &$dataProvider, array $services): void
    {
        $data = [];
        foreach ($dataProvider->getModels() as $model) {
            $data[] = new Orders(
                $model->id,
                $model->user->first_name . ' ' . $model->user->last_name,
                $model->link,
                $model->quantity,
                $services[$model->service_id]['count'],
                $model->service->name,
                OrderHelper::statuses()[$model->status] ?? 'Unknown',
                $model->mode ? OrderHelper::MODE_AUTO : OrderHelper::MODE_MANUAL,
                Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d H:i:s')
            );
        }
        $dataProvider->setModels($data);
    }
}
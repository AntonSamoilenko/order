<?php

namespace app\modules\orders\services\dataHandler;

use app\modules\orders\models\Orders as OrderModel;
use app\modules\orders\DTO\Orders;
use app\modules\orders\helpers\OrderHelper;
use stdClass;
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
        /** @var OrderModel $model */
        foreach ($dataProvider->getModels() as $model) {
            $user = $model->getUser()->one() ?? new stdClass();
            $userName = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '') ?: 'Unknown';

            $data[] = new Orders(
                $model->id,
                $userName,
                $model->link,
                $model->quantity,
                $services[$model->service_id]['count'],
                $services[$model->service_id]['name'],
                OrderHelper::statuses()[$model->status] ?? 'Unknown',
                $model->mode ? OrderHelper::MODE_AUTO : OrderHelper::MODE_MANUAL,
                Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d H:i:s')
            );
        }
        $dataProvider->setModels($data);
    }
}
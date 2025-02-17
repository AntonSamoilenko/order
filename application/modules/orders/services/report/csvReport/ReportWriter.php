<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\models\Orders;
use app\modules\orders\services\report\ReportWriterInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

class ReportWriter implements ReportWriterInterface
{
    /**
     * @param ActiveQuery $query
     * @return void
     * @throws InvalidConfigException
     */
    public function createReport(ActiveQuery &$query): void
    {
        $output = fopen('php://output', 'w');
        fputcsv($output, OrderHelper::getCSVFields(), ';');

        foreach ($query->batch(100) as $data) {
            /** @var Orders $order */
            foreach ($data as $order) {
                fputcsv($output, [
                    $order->id,
                    $order->getUser() ? $order->getUser()->first_name . ' ' . $order->getUser()->last_name : '',
                    $order->link,
                    $order->quantity,
                    $order->getService() ? $order->getService()->name : '',
                    OrderHelper::statusLabels()[$order->status] ?? '',
                    Yii::$app->formatter->asDatetime($order->created_at),
                    $order->mode === 0
                        ? Yii::t('app', 'Manual')
                        : Yii::t('app', 'Auto'),
                ], ';');
            }

            flush();
        }

        fclose($output);
    }
}
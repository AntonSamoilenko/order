<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\services\report\ReportWriterInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

class ReportWriter implements ReportWriterInterface
{
    /**
     * @throws InvalidConfigException
     */
    public function createReport(ActiveQuery &$query): void
    {
        $output = fopen('php://output', 'w');
        fputcsv($output, OrderHelper::statusLabels());

        foreach ($query->batch(100) as $data) {
            foreach ($data as $order) {
                fputcsv($output, [
                    $order->id,
                    $order->user ? $order->user->getFullName() : '',
                    $order->link,
                    $order->quantity,
                    $order->service ? $order->service->name : '',
                    OrderHelper::statusLabels()[$order->status] ?? '',
                    Yii::$app->formatter->asDatetime($order->created_at),
                    $order->mode === 0
                        ? Yii::t('app', 'Manual')
                        : Yii::t('app', 'Auto'),
                ]);
            }

            flush();
        }

        fclose($output);
    }
}
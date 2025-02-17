<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\models\Orders;
use app\modules\orders\services\report\ReportWriterInterface;
use stdClass;
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
                $user = $order->getUser()->one() ?? new stdClass();
                $userName = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '') ?: '';

                fputcsv($output, [
                    $order->id,
                    $userName,
                    $order->link,
                    $order->quantity,
                    ($order->getService()->one() ?? new stdClass())->name ?? '',
                    OrderHelper::statusLabels()[$order->status] ?? '',
                    Yii::$app->formatter->asDatetime($order->created_at),
                    $order->mode === 0
                        ? Yii::t('orders', 'mode.manual')
                        : Yii::t('orders', 'mode.auto'),
                ], ';');
            }
            ob_flush();
            flush();
        }

        fclose($output);
    }
}
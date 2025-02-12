<?php

namespace app\modules\orders\services\report;

use app\modules\orders\models\Order;
use Yii;
use yii\db\QueryInterface;

class CSVReport implements ReportInterface
{
    private QueryInterface $query;
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function createReport(): string
    {
        $filename = tempnam(sys_get_temp_dir(), 'csv');
        $output = fopen($filename, 'w');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, [
            'ID',
            'User',
            'Link',
            'Quantity',
            'Service',
            'Status',
            'Created At',
            'Mode',
        ]);

        foreach ($this->query->each() as $order) {
            /** @var Order $order */
            $statusLabels = [
                0 => Yii::t('app', 'Pending'),
                1 => Yii::t('app', 'In Progress'),
                2 => Yii::t('app', 'Completed'),
                3 => Yii::t('app', 'Canceled'),
                4 => Yii::t('app', 'Fail'),
            ];

            $modeLabel = $order->mode === 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto');

            fputcsv($output, [
                $order->id,
                $order->user ? $order->user->getFullName() : '',
                $order->link,
                $order->quantity,
                $order->service ? $order->service->name : '',
                $statusLabels[$order->status] ?? '',
                Yii::$app->formatter->asDatetime($order->created_at),
                $modeLabel,
            ]);
        }

        fclose($output);

        return $filename;
    }

    public function removeTemporaryFile(string $filename): void
    {
        unlink($filename);
    }
}
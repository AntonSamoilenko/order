<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\models\Order;
use app\modules\orders\services\report\ReportWriterInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

class ReportWriter implements ReportWriterInterface
{
    private ActiveQuery $query;

    public function setQuery(ActiveQuery $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @throws InvalidConfigException
     */
    public function createReport(): string
    {
        if (empty($this->query)) {
            return '';
        }

        $filename = tempnam(sys_get_temp_dir(), 'csv');
        $output = fopen($filename, 'w');
        fwrite($output, "\xEF\xBB\xBF");

        //todo надо закинуть в переводчик
        fputcsv($output, ['ID', 'User', 'Link', 'Quantity', 'Service', 'Status', 'Created At', 'Mode',]);

        foreach ($this->query->each() as $order) {
            /** @var Order $order */
            $statusLabels = OrderHelper::statusLabels();

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
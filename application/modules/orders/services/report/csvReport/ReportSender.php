<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\services\report\ReportSenderInterface;
use Yii;
use yii\base\ExitException;

class ReportSender implements ReportSenderInterface
{
    /**
     * @throws ExitException
     */
    public function sendReport(string $fileName): void
    {
        Yii::$app->response->headers->add('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        Yii::$app->response->headers->add('Pragma', 'no-cache');
        Yii::$app->response->headers->add('Expires', '0');
        Yii::$app->response->sendFile($fileName, 'orders_' . date('Y-m-d_H-i-s') . '.csv', [
            'mimeType' => 'application/octet-stream',
        ])->send();

        Yii::$app->end();
    }
}
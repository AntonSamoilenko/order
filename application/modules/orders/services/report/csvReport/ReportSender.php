<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\services\report\ReportSenderInterface;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\web\HeadersAlreadySentException;

class ReportSender implements ReportSenderInterface
{
    private ReportWriter $reportWriter;

    public function __construct(ReportWriter $reportWriter)
    {
        $this->reportWriter = $reportWriter;
    }

    /**
     * @throws HeadersAlreadySentException
     * @throws InvalidConfigException
     */
    public function sendReport(ActiveQuery &$query): void
    {
        if (headers_sent($file, $line)) {
            throw new HeadersAlreadySentException($file, $line);
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="export.csv"');
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $this->reportWriter->createReport($query);
    }
}
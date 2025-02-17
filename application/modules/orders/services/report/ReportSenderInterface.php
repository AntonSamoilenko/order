<?php

namespace app\modules\orders\services\report;

use yii\db\ActiveQuery;

interface ReportSenderInterface
{
    /**
     * @param ActiveQuery $query
     * @return void
     */
    public function sendReport(ActiveQuery &$query): void;
}
<?php

namespace app\modules\orders\services\report;

use yii\db\ActiveQuery;

interface ReportSenderInterface
{
    public function sendReport(ActiveQuery &$query): void;
}
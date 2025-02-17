<?php

namespace app\modules\orders\services\report;

use yii\db\ActiveQuery;

interface ReportWriterInterface
{
    public function createReport(ActiveQuery &$query): void;
}
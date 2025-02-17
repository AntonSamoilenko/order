<?php

namespace app\modules\orders\services\report;

use yii\db\ActiveQuery;

interface ReportWriterInterface
{
    /**
     * @param ActiveQuery $query
     * @return void
     */
    public function createReport(ActiveQuery &$query): void;
}
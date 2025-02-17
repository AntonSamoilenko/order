<?php

namespace app\modules\orders\services\report;

interface ReportInterface
{
    /**
     * @param array $params
     * @return void
     */
    public function buildReport(array $params): void;
}
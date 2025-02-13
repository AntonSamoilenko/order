<?php

namespace app\modules\orders\services\report;

interface ReportInterface
{
    public function buildReport(array $params): void;
}
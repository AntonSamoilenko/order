<?php

namespace app\modules\orders\services\report;

interface ReportSenderInterface
{
    public function sendReport(string $fileName): void;
}
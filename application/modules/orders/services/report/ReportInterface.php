<?php

namespace app\modules\orders\services\report;

interface ReportInterface
{
    /**
     * @return void
     */
    public function buildReport(): void;
}
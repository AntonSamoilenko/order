<?php

namespace app\modules\orders\services\report;

interface ReportInterface
{
    public function createReport(): string;

    public function removeTemporaryFile(string $filename): void;
}
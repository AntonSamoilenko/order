<?php

namespace app\modules\orders\services\report;

interface ReportWriterInterface
{
    public function createReport(): string;

    public function removeTemporaryFile(string $filename): void;
}
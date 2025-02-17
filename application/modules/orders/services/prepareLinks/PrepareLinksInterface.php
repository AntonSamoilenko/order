<?php

namespace app\modules\orders\services\prepareLinks;

interface PrepareLinksInterface
{
    public function prepareLinks(array $data, array $params): array;
}
<?php

namespace app\modules\orders\services\prepareLinks;

interface PrepareLinksInterface
{
    /**
     * @param array $data
     * @param array $params
     * @return array
     */
    public function prepareLinks(array $data, array $params): array;
}
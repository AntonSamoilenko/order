<?php

namespace app\modules\orders\services\prepareLinks;

use yii\helpers\Url;

class PrepareServiceLinks implements PrepareLinksInterface
{
    public function prepareLinks(array $data, array $params): array
    {
        $preparedServices = [];
        $serviceIds = $params['service_ids'] ?? [];
        unset($params['service_ids']);
        $params[] = '';

        foreach ($data as $service) {
            if ($service['count'] > 0) {
                $serviceIdsForLink = array_merge($serviceIds, [(int) $service['service_id']]);
                if (in_array((int) $service['service_id'], $serviceIds)) {
                    $serviceIdsForLink = array_diff($serviceIdsForLink, [(int) $service['service_id']]);
                }

                $params['service_ids'] = $serviceIdsForLink;
                $url = Url::to($params);
                $isActive = in_array((int) $service['service_id'], $serviceIds);

                $preparedServices[$service['service_id']] = [
                    'name' => $service['name'],
                    'count' => $service['count'],
                    'url' => $url,
                    'is_active' => $isActive,
                ];
            } else {
                $preparedServices[$service['service_id']] = [
                    'name' => $service['name'],
                    'count' => $service['count'],
                    'url' => null,
                    'is_active' => false,
                ];
            }
        }

        return $preparedServices;
    }
}
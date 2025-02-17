<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\prepareLinks\PrepareLinksInterface;
use app\modules\orders\services\report\ReportInterface;
use Yii;
use yii\web\Controller;

class OrderController extends Controller
{
    public function actionIndex(
        OrderRepository $orderRepository,
        PrepareLinksInterface $prepareServiceLinks,
        string $status = null
    ): string {
        $params = Yii::$app->request->queryParams;
        $params['status'] = OrderHelper::statusReversed()[$status] ?? null;

        return $this->render('index', [
            'dataProvider'  => $orderRepository->getOrder($params),
            'status'        => $status,
            'searchFields'  => OrderHelper::searchFields(),
            'statusLabels'  => OrderHelper::statusLabels(),
            'statuses'      => OrderHelper::statuses(),
            'modes'         => OrderHelper::modes(),
            'services'      => $prepareServiceLinks->prepareLinks(
                $orderRepository->getService($params),
                Yii::$app->request->queryParams
            ),
        ]);
    }

    public function actionExportCsv(ReportInterface $report): void
    {
        $params = Yii::$app->request->queryParams;

        $report->buildReport($params);
    }
}



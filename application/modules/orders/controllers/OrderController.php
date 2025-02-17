<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\dataHandler\OrderHandler;
use app\modules\orders\services\prepareLinks\PrepareLinksInterface;
use app\modules\orders\services\report\ReportInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;

class OrderController extends Controller
{
    /**
     * @param OrderRepository $orderRepository
     * @param PrepareLinksInterface $prepareServiceLinks
     * @param OrderHandler $orderHandler
     * @param string|null $status
     * @return string
     * @throws InvalidConfigException
     */
    public function actionIndex(
        OrderRepository $orderRepository,
        PrepareLinksInterface $prepareServiceLinks,
        OrderHandler $orderHandler,
        string $status = null
    ): string {
        $params = Yii::$app->request->queryParams;
        $params['status'] = OrderHelper::statusReversed()[$status] ?? null;

        $services = $prepareServiceLinks->prepareLinks(
            $orderRepository->getService($params),
            Yii::$app->request->queryParams
        );
        $dataProvider = $orderRepository->getOrder($params);

        $orderHandler->handleActiveDataProvider($dataProvider, $services);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'currentStatus' => $status,
            'searchFields' => OrderHelper::searchFields(),
            'statusLabels' => OrderHelper::statusLabels(),
            'statuses' => OrderHelper::statuses(),
            'modes' => OrderHelper::modes(),
            'currentParams' => $params,
            'services' => $services,
        ]);
    }

    /**
     * @param ReportInterface $report
     * @return void
     */
    public function actionExportCsv(ReportInterface $report): void
    {
        $params = Yii::$app->request->queryParams;

        $report->buildReport($params);
    }
}



<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\models\Order;
use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\report\ReportInterface;
use Yii;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;

class ListController extends Controller
{
    private const STATUS_MAP_REVERSED = [
        'pending' => 0,
        'in_progress' => 1,
        'completed' => 2,
        'canceled' => 3,
        'error' => 4,
    ];

    public function actionIndex(OrderRepository $orderRepository, ?string $status = null): string
    {
        $statusId = self::STATUS_MAP_REVERSED[$status] ?? null;
        $mode = Yii::$app->request->get('mode', []);
        $serviceId = Yii::$app->request->get('service_id', []);
        $search = Yii::$app->request->get('search', '');
        $searchType = Yii::$app->request->get('search_type', '');


        $params = Yii::$app->request->queryParams;
        $params['status'] = $statusId;

        return $this->render('index', [
            'dataProvider'  => $orderRepository->getData($params),
            'services'      => $orderRepository->getService($params),
            'searchFields'  => OrderHelper::searchFields(),
            'status'        => $status,
        ]);
    }

    /**
     * @throws ExitException
     * @throws InvalidConfigException
     */
    public function actionExportCsv(ReportInterface $report, OrderRepository $orderRepository): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="export.csv"');

        $params = Yii::$app->request->queryParams;
        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'User', 'Link', 'Quantity', 'Service', 'Status', 'Created At', 'Mode',]);

        $query = $orderRepository->getOrdersByParams($params);
        $batchSize = 100;
        $models = $query->batch($batchSize);

        $data = [];
        do {
            $data = $models->current();

            $statusLabels = OrderHelper::statusLabels();


            if ($data) {
                foreach ($data as $order) {
                    $modeLabel = $order->mode === 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto');

                    fputcsv($output, [
                        $order->id,
                        $order->user ? $order->user->getFullName() : '',
                        $order->link,
                        $order->quantity,
                        $order->service ? $order->service->name : '',
                        $statusLabels[$order->status] ?? '',
                        Yii::$app->formatter->asDatetime($order->created_at),
                        $modeLabel,
                    ]);
                }

                $models->next();

                flush();
            }
        } while ($data !== false);

        fclose($output);

        Yii::$app->end();






//        $params = Yii::$app->request->queryParams;
//
//        $report->buildReport($params);
    }
}
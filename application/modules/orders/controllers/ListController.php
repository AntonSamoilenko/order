<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\report\ReportInterface;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class ListController extends Controller
{
    private const STATUS_MAP = [
        'pending' => 0,
        'in_progress' => 1,
        'completed' => 2,
        'canceled' => 3,
        'fail' => 4,
    ];

    public function actionIndex(OrderRepository $orderRepository, ?string $status = null): string
    {
        $params = Yii::$app->request->queryParams;

        if ($status && isset(self::STATUS_MAP[$status])) {
            $params['status'] = self::STATUS_MAP[$status];
        }

        $urls = [];
        foreach (self::STATUS_MAP as $textStatus => $id) {
            $urls[$textStatus] = Url::to(['/orders/' . $textStatus]);
        }

        return $this->render('index', [
            'dataProvider' => $orderRepository->getData($params),
            'params' => $params,
            'totalCount' => $orderRepository->getTotalCount(),
            'services' => $orderRepository->getService(),
            'availableModes' => $orderRepository->getAvailableModes(),
            'urls' => $urls,
        ]);
    }

    public function actionExportCsv(ReportInterface $report, OrderRepository $orderRepository): void
    {
        ob_start();
        // Устанавливаем заголовки для скачивания CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="export.csv"');

        // Отключаем буферизацию вывода
        $params = Yii::$app->request->queryParams;
        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        // Создаем поток вывода для CSV
        $output = fopen('php://output', 'w');

        // Записываем заголовки CSV
        fputcsv($output, ['ID', 'User', 'Link', 'Quantity', 'Service', 'Status', 'Created At', 'Mode',]); // Замените на реальные названия столбцов

        // Выполняем запрос к базе данных
        $query = $orderRepository->getOrdersByParams($params); // Замените на ваш запрос
        $batchSize = 100; // Размер партии
        $models = $query->batch($batchSize); // Получаем генератор партий

        // Инициализация переменной для цикла
        $data = [];

        // Цикл do-while для обработки данных
        do {
            // Получаем следующую партию данных
            $data = $models->current();

            $statusLabels = OrderHelper::statusLabels();


            if ($data) {
                foreach ($data as $order) {
                    $modeLabel = $order->mode === 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto');
                    // Записываем данные в CSV
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

                // Переходим к следующей партии
                $models->next();

                // Принудительно отправляем данные в браузер
                flush();
            }
        } while ($data !== false);

        // Закрываем поток вывода
        fclose($output);

        // Завершаем выполнение скрипта
        Yii::$app->end();






//        $params = Yii::$app->request->queryParams;
//
//        $report->buildReport($params);
    }
}
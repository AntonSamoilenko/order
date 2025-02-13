<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\models\Order;
use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\report\ReportInterface;
use Yii;
use yii\data\ActiveDataProvider;
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
//        $this->layout = '@app/modules/orders/views/layouts/main';
        // Инициализация параметров поиска и фильтрации
        $query = Order::find()->joinWith(['user', 'service']);

        // Фильтр по статусу (если указан)
        if ($status !== null) {
            $query->andWhere(['orders.status' => $status]);
        }

        // Обработка других фильтров (mode和服务_id)
        $mode = Yii::$app->request->get('mode', []);
        $serviceId = Yii::$app->request->get('service_id', []);

        if (!empty($mode)) {
            $query->andWhere(['orders.mode' => $mode]);
        }

        if (!empty($serviceId)) {
            $query->andWhere(['orders.service_id' => $serviceId]);
        }

        // Поиск по нескольким полям
        $search = Yii::$app->request->get('search', '');
        if (!empty($search)) {
            $query->andFilterWhere([
                'or',
                ['like', 'orders.id', $search],
                ['like', 'CONCAT(users.first_name, " ", users.last_name)', $search],
                ['like', 'orders.link', $search],
            ]);
        }

        // Настройка пагинации
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'status' => $status,
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
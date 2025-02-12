<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\Order;
use app\modules\orders\services\report\CSVReport;
use Yii;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;

class ListController extends Controller
{
    public function actionIndex(): string
    {
        // Получаем текущие GET-параметры
        $params = Yii::$app->request->queryParams;

        // Основной запрос для данных
        $query = Order::find()
            ->alias('o') // Псевдоним для таблицы orders
            ->with(['user', 'service']) // Подгружаем связанные данные
            ->orderBy(['o.id' => SORT_DESC]);

        // Фильтрация по статусу
        if (isset($params['status'])) {
            $query->andWhere(['o.status' => $params['status']]);
        }

        // Фильтрация по mode
        if (isset($params['mode'])) {
            $query->andWhere(['o.mode' => $params['mode']]);
        }

        // Фильтрация по service_id
        if (isset($params['service_id'])) {
            $query->andWhere(['o.service_id' => $params['service_id']]);
        }

        // Поиск по ID заказа
        if (!empty($params['search_id'])) {
            $query->andWhere(['o.id' => $params['search_id']]);
        }

        // Поиск по имени пользователя
        if (!empty($params['search_user'])) {
            $query->joinWith(['user u'])
                ->andWhere([
                    'or',
                    ['like', 'u.first_name', $params['search_user']],
                    ['like', 'u.last_name', $params['search_user']]
                ]);
        }

        // Поиск по ссылке
        if (!empty($params['search_link'])) {
            $query->andWhere(['like', 'o.link', $params['search_link']]);
        }

        // Пагинация
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100, // Количество записей на странице
            ],
        ]);

        // Расчет каунтеров для фильтров
        $totalCount = Order::find()->count(); // Общее количество записей
        $serviceCounts = Order::find()
            ->select(['service_id', 'COUNT(*) as count'])
            ->groupBy('service_id')
            ->orderBy(['count' => SORT_DESC])
            ->asArray()
            ->all();

        // Формируем список сервисов с каунтерами
        $services = [];
        foreach ($serviceCounts as $item) {
            $services[$item['service_id']] = $item['count'];
        }

        // Отключаем недоступные фильтры
        $availableModes = Order::find()
            ->select('mode')
            ->distinct()
            ->column();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'params' => $params,
            'totalCount' => $totalCount,
            'services' => $services,
            'availableModes' => $availableModes,
        ]);
    }

    /**
     * @throws ExitException
     * @throws InvalidConfigException
     */
    public function actionExportCsv(): void
    {
        $params = Yii::$app->request->queryParams;

        $query = Order::find()
            ->alias('o')
            ->with(['user', 'service'])
            ->orderBy(['o.id' => SORT_DESC]);

        if (isset($params['status'])) {
            $query->andWhere(['o.status' => $params['status']]);
        }

        if (isset($params['mode'])) {
            $query->andWhere(['o.mode' => $params['mode']]);
        }

        if (isset($params['service_id'])) {
            $query->andWhere(['o.service_id' => $params['service_id']]);
        }

        if (!empty($params['search_id'])) {
            $query->andWhere(['o.id' => $params['search_id']]);
        }

        if (!empty($params['search_user'])) {
            $query->joinWith(['user u'])
                ->andWhere([
                    'or',
                    ['like', 'u.first_name', $params['search_user']],
                    ['like', 'u.last_name', $params['search_user']]
                ]);
        }

        if (!empty($params['search_link'])) {
            $query->andWhere(['like', 'o.link', $params['search_link']]);
        }

//        $filename = tempnam(sys_get_temp_dir(), 'csv');
//        $output = fopen($filename, 'w');
//        fwrite($output, "\xEF\xBB\xBF");
//        fputcsv($output, [
//            'ID',
//            'User',
//            'Link',
//            'Quantity',
//            'Service',
//            'Status',
//            'Created At',
//            'Mode',
//        ]);
//
//        foreach ($query->each() as $order) {
//            /** @var Order $order */
//            $statusLabels = [
//                0 => Yii::t('app', 'Pending'),
//                1 => Yii::t('app', 'In Progress'),
//                2 => Yii::t('app', 'Completed'),
//                3 => Yii::t('app', 'Canceled'),
//                4 => Yii::t('app', 'Fail'),
//            ];
//
//            $modeLabel = $order->mode === 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto');
//
//            fputcsv($output, [
//                $order->id,
//                $order->user ? $order->user->getFullName() : '',
//                $order->link,
//                $order->quantity,
//                $order->service ? $order->service->name : '',
//                $statusLabels[$order->status] ?? '',
//                Yii::$app->formatter->asDatetime($order->created_at),
//                $modeLabel,
//            ]);
//        }
//
//        fclose($output);

        $report = (new CSVReport($query));
        $filename = $report->createReport();

        // Отправляем файл пользователю
        Yii::$app->response->headers->add('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        Yii::$app->response->headers->add('Pragma', 'no-cache');
        Yii::$app->response->headers->add('Expires', '0');
        Yii::$app->response->sendFile($filename, 'orders_' . date('Y-m-d_H-i-s') . '.csv', [
            'mimeType' => 'application/octet-stream',
        ])->send();

        $report->removeTemporaryFile($filename);

        Yii::$app->end();
    }
}
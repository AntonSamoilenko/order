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

        // Пагинация
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $totalCount = Order::find()->count();
        $serviceCounts = Order::find()
            ->select(['service_id', 'COUNT(*) as count'])
            ->groupBy('service_id')
            ->orderBy(['count' => SORT_DESC])
            ->asArray()
            ->all();

        $services = [];
        foreach ($serviceCounts as $item) {
            $services[$item['service_id']] = $item['count'];
        }

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

        $report = (new CSVReport($query));
        $filename = $report->createReport();


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
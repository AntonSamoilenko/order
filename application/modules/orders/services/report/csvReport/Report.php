<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\helpers\OrderHelper;
use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\report\ReportInterface;
use app\modules\orders\services\report\ReportSenderInterface;
use Yii;

class Report implements ReportInterface
{
    /**
     * @var ReportSender|ReportSenderInterface
     */
    private ReportSender|ReportSenderInterface $reportSender;

    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    /**
     * @param ReportSenderInterface $reportSender
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        ReportSenderInterface $reportSender,
        OrderRepository $orderRepository
    ) {
        $this->reportSender = $reportSender;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return void
     */
    public function buildReport(): void
    {
        ob_start();

        try {
            $params = Yii::$app->request->queryParams;
            $params['status'] = isset($params['status'])
                ? (is_numeric($params['status'])
                    ? OrderHelper::statuses()[(int) $params['status']]
                    : OrderHelper::statusLabels()[$params['status']]
                ) : null;

            set_time_limit(300);

            $query = $this->orderRepository->getOrdersByParams($params);
            $this->reportSender->sendReport($query);

            exit;
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), 'export');
        } finally {
            Yii::info("Current output buffer level: " . ob_get_level(), 'export');
            if (ob_get_level() > 0) {
                Yii::info("Cleaning output buffer...", 'export');
                ob_end_clean();
            } else {
                Yii::info("No output buffer to clean.", 'export');
            }
        }
    }
}
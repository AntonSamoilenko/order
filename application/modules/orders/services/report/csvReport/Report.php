<?php

namespace app\modules\orders\services\report\csvReport;

use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\report\ReportInterface;
use app\modules\orders\services\report\ReportSenderInterface;
use app\modules\orders\services\report\ReportWriterInterface;
use yii\base\ExitException;
use yii\base\InvalidConfigException;

class Report implements ReportInterface
{
    private ReportSender $reportSender;
    private ReportWriter $reportWriter;

    private OrderRepository $orderRepository;

    public function __construct(
        ReportSenderInterface $reportSender,
        ReportWriterInterface $reportWriter,
        OrderRepository $orderRepository
    ) {
        $this->reportSender = $reportSender;
        $this->reportWriter = $reportWriter;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @throws ExitException
     * @throws InvalidConfigException
     */
    public function buildReport(array $params): void
    {
        $query = $this->orderRepository->getOrdersByParams($params);

        $fileName = $this->reportWriter
            ->setQuery($query)
            ->createReport();

        $this->reportSender->sendReport($fileName);

        $this->reportWriter->removeTemporaryFile($fileName);
    }
}
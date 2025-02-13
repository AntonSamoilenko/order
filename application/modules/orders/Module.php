<?php

namespace app\modules\orders;

use app\modules\orders\repositories\OrderRepository;
use app\modules\orders\services\report\csvReport\Report;
use app\modules\orders\services\report\csvReport\ReportSender;
use app\modules\orders\services\report\csvReport\ReportWriter;
use app\modules\orders\services\report\ReportWriterInterface;
use app\modules\orders\services\report\ReportInterface;
use app\modules\orders\services\report\ReportSenderInterface;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\orders\controllers';

    public function init()
    {
        parent::init();

        \Yii::$container->setDefinitions([
            ReportInterface::class => [
                'class' => Report::class,
            ],
            ReportSenderInterface::class => [
                'class' => ReportSender::class,
            ],
            ReportWriterInterface::class => [
                'class' => ReportWriter::class
            ],
            OrderRepository::class => [
                'class' => OrderRepository::class
            ]
        ]);

        $this->setLayoutPath('@app/modules/orders/views/layouts');
        $this->setViewPath('@app/modules/orders/views');
    }
}
<?php

namespace app\modules\orders\helpers;

use Yii;

class OrderHelper
{
    public static function getCSVFields(): array
    {
        return[
            Yii::t('app', 'ID'),
            Yii::t('app', 'User'),
            Yii::t('app', 'Link'),
            Yii::t('app', 'Quantity'),
            Yii::t('app', 'Service'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'Created At'),
            Yii::t('app', 'Mode'),
        ];
    }

    public static function statusLabels(): array
    {
        return [
            0 => Yii::t('app', 'Pending'),
            1 => Yii::t('app', 'In Progress'),
            2 => Yii::t('app', 'Completed'),
            3 => Yii::t('app', 'Canceled'),
            4 => Yii::t('app', 'Error'),
        ];
    }

    public static function statuses(): array
    {
        return [
            0 => 'pending',
            1 => 'in_progress',
            2 => 'completed',
            3 => 'canceled',
            4 => 'error',
        ];
    }

    public static function statusReversed(): array
    {
        return [
            'pending'       => 0,
            'in_progress'   => 1,
            'completed'     => 2,
            'canceled'      => 3,
            'error'         => 4,
        ];
    }

    public static function searchFields(): array
    {
        return [
            0 => Yii::t('app', 'Order ID'),
            1 => Yii::t('app', 'Link'),
            2 => Yii::t('app', 'Username'),
        ];
    }

    public static function modes(): array
    {
        return [
            'auto'      => 0,
            'manual'    => 1,
        ];
    }
}
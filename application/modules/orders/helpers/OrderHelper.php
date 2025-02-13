<?php

namespace app\modules\orders\helpers;

use Yii;

class OrderHelper
{
    public static function statusLabels(): array
    {
        return [
            0 => Yii::t('app', 'Pending'),
            1 => Yii::t('app', 'In Progress'),
            2 => Yii::t('app', 'Completed'),
            3 => Yii::t('app', 'Canceled'),
            4 => Yii::t('app', 'Fail'),
        ];

    }
}
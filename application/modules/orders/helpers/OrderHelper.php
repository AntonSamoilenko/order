<?php

namespace app\modules\orders\helpers;

use Yii;

class OrderHelper
{
    private const STATUS_PENDING_ID = 0;
    private const STATUS_PENDING = 'pending';
    private const STATUS_IN_PROGRESS_ID = 1;
    private const STATUS_IN_PROGRESS = 'in_progress';
    private const STATUS_COMPLETED_ID = 2;
    private const STATUS_COMPLETED = 'completed';
    private const STATUS_CANCELED_ID = 3;
    private const STATUS_CANCELED = 'canceled';
    private const STATUS_ERROR_ID = 4;
    private const STATUS_ERROR = 'error';

    private const SEARCH_FIELD_ID = 0;
    private const SEARCH_FIELD_LINK = 1;
    private const SEARCH_FIELD_USERNAME = 2;

    private const MODE_AUTO_ID = 0;
    private const MODE_AUTO = 'auto';
    private const MODE_MANUAL_ID = 1;
    private const MODE_MANUAL = 'manual';

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING_ID => Yii::t('app', 'Pending'),
            self::STATUS_IN_PROGRESS_ID => Yii::t('app', 'In Progress'),
            self::STATUS_COMPLETED_ID => Yii::t('app', 'Completed'),
            self::STATUS_CANCELED_ID => Yii::t('app', 'Canceled'),
            self::STATUS_ERROR_ID => Yii::t('app', 'Error'),
        ];
    }

    /**
     * @return string[]
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING_ID => self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS_ID => self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED_ID => self::STATUS_COMPLETED,
            self::STATUS_CANCELED_ID => self::STATUS_CANCELED,
            self::STATUS_ERROR_ID => self::STATUS_ERROR,
        ];
    }

    /**
     * @return int[]
     */
    public static function statusReversed(): array
    {
        return [
            self::STATUS_PENDING => self::STATUS_PENDING_ID,
            self::STATUS_IN_PROGRESS => self::STATUS_IN_PROGRESS_ID,
            self::STATUS_COMPLETED => self::STATUS_COMPLETED_ID,
            self::STATUS_CANCELED => self::STATUS_CANCELED_ID,
            self::STATUS_ERROR => self::STATUS_ERROR_ID,
        ];
    }

    /**
     * @return array
     */
    public static function searchFields(): array
    {
        return [
            self::SEARCH_FIELD_ID => Yii::t('app', 'Order ID'),
            self::SEARCH_FIELD_LINK => Yii::t('app', 'Link'),
            self::SEARCH_FIELD_USERNAME => Yii::t('app', 'Username'),
        ];
    }

    /**
     * @return int[]
     */
    public static function modes(): array
    {
        return [
            self::MODE_AUTO => self::MODE_AUTO_ID,
            self::MODE_MANUAL => self::MODE_MANUAL_ID,
        ];
    }
}
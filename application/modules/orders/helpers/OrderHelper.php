<?php

namespace app\modules\orders\helpers;

use Yii;

class OrderHelper
{
    public const MODE_MANUAL = 'manual';
    public const MODE_AUTO = 'auto';

    private const MODE_AUTO_ID = 0;
    private const MODE_MANUAL_ID = 1;
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

    /**
     * @return array
     */
    public static function getCSVFields(): array
    {
        return[
            Yii::t('orders', 'fields.id'),
            Yii::t('orders', 'fields.user'),
            Yii::t('orders', 'fields.link'),
            Yii::t('orders', 'fields.quantity'),
            Yii::t('orders', 'fields.service'),
            Yii::t('orders', 'fields.status'),
            Yii::t('orders', 'fields.created_at'),
            Yii::t('orders', 'fields.mode'),
        ];
    }

    /**
     * @return array
     */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING_ID => Yii::t('orders', 'labels_status.pending'),
            self::STATUS_IN_PROGRESS_ID => Yii::t('orders', 'labels_status.in_progress'),
            self::STATUS_COMPLETED_ID => Yii::t('orders', 'labels_status.completed'),
            self::STATUS_CANCELED_ID => Yii::t('orders', 'labels_status.canceled'),
            self::STATUS_ERROR_ID => Yii::t('orders', 'labels_status.error'),
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
            self::SEARCH_FIELD_ID => Yii::t('orders', 'search_field.order_id'),
            self::SEARCH_FIELD_LINK => Yii::t('orders', 'search_field.link'),
            self::SEARCH_FIELD_USERNAME => Yii::t('orders', 'search_field.username'),
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
<?php

use yii\db\Migration;

/**
 * Class m250217_061214_order
 */
class m250217_061214_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createIndex('idx_orders_service_id', '{{%orders}}', 'service_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropIndex('idx_orders_service_id', '{{%orders}}');
    }
}

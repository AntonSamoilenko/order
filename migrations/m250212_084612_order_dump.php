<?php

use yii\db\Migration;

/**
 * Class m250212_084612_order_dump
 */
class m250212_084612_order_dump extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $dumpFile = Yii::getAlias('@app/../sql_dump/test_db_data.sql');
        if (!file_exists($dumpFile)) {
            return true;
        }

        $sql = file_get_contents($dumpFile);
        try {
            $this->execute($sql);
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%users}}');
        $this->truncateTable('{{%orders}}');
        $this->truncateTable('{{%services}}');
    }
}

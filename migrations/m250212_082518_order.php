<?php

use yii\db\Migration;

/**
 * Class m250212_082518_order
 */
class m250212_082518_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->notNull(),
            'link' => 'VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci NOT NULL',
            'quantity' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->comment('0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail'),
            'created_at' => $this->integer()->notNull(),
            'mode' => $this->tinyInteger(1)->notNull()->comment('0 - Manual, 1 - Auto'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ROW_FORMAT=COMPACT ENGINE=InnoDB');

        $this->execute("ALTER TABLE {{%orders}} AUTO_INCREMENT = 100001;");

        $this->createTable('{{%services}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => 'VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL',
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ROW_FORMAT=COMPACT ENGINE=InnoDB');

        $this->execute("ALTER TABLE {{%services}} AUTO_INCREMENT = 18;");

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->unsigned(),
            'first_name' => 'VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL',
            'last_name' => 'VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL',
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ROW_FORMAT=COMPACT ENGINE=InnoDB');

        $this->execute("ALTER TABLE {{%users}} AUTO_INCREMENT = 101;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%users}}');
        $this->dropTable('{{%services}}');
        $this->dropTable('{{%orders}}');
    }
}

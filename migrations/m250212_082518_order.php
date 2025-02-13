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
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE {{%orders}} (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT(11) NOT NULL,
                `link` VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci NOT NULL,
                `quantity` INT(11) NOT NULL,
                `service_id` INT(11) NOT NULL,
                `status` TINYINT(1) NOT NULL COMMENT '0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail',
                `created_at` INT(11) NOT NULL,
                `mode` TINYINT(1) NOT NULL COMMENT '0 - Manual, 1 - Auto'
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ROW_FORMAT=COMPACT ENGINE=InnoDB AUTO_INCREMENT=100001;
        ");

        $this->execute("
            CREATE TABLE {{%services}} (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ROW_FORMAT=COMPACT ENGINE=InnoDB AUTO_INCREMENT=18;
        ");

        $this->execute("
            CREATE TABLE {{%users}} (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `first_name` VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                `last_name` VARCHAR(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ROW_FORMAT=COMPACT ENGINE=InnoDB AUTO_INCREMENT=101;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
        $this->dropTable('{{%services}}');
        $this->dropTable('{{%orders}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%hosts}}`.
 */
class m240312_145616_create_hosts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%hosts}}', [
            'id' => $this->primaryKey(),
            'host' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%hosts}}');
    }
}

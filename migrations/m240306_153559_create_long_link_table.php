<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%long_link}}`.
 */
class m240306_153559_create_long_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%long_link}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string()->notNull(),
            'active' => $this->boolean()->defaultValue(true),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%long_link}}');
    }
}

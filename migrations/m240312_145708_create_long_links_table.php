<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%long_links}}`.
 */
class m240312_145708_create_long_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%long_links}}', [
            'id' => $this->primaryKey(),
            'host_id' => $this->integer()->notNull(),
            'link' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-long_links-host_id',
            'long_links',
            'host_id',
            'hosts',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-long_links-host_id', 'long_links');
        $this->dropTable('{{%long_links}}');
    }
}

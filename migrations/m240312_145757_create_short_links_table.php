<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%short_links}}`.
 */
class m240312_145757_create_short_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%short_links}}', [
            'id' => $this->primaryKey(),
            'long_link_id' => $this->integer()->notNull(),
            'link' => $this->string()->notNull(),
            'active' => $this->boolean()->defaultValue(true),
        ]);

        $this->addForeignKey(
            'fk-short_links-long_link_id',
            'short_links',
            'long_link_id',
            'long_links',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-short_links-long_link_id', 'short_links');
        $this->dropTable('{{%short_links}}');
    }
}

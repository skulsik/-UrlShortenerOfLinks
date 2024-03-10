<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%short_link}}`.
 */
class m240306_153648_create_short_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%short_link}}', [
            'id' => $this->primaryKey(),
            'long_link_id' => $this->integer()->notNull(),
            'link' => $this->string()->notNull(),
            'active' => $this->boolean()->defaultValue(true),
        ]);

        $this->addForeignKey(
            'fk-short_link-long_link_id',
            'short_link',
            'long_link_id',
            'long_link',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-short_link-long_link_id', 'short_link');
        $this->dropTable('{{%short_link}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%short_link}}`.
 */
class m240306_153348_create_short_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%short_link}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%short_link}}');
    }
}

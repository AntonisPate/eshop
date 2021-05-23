<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_type}}`.
 */
class m210104_112258_create_user_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'description' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_type}}');
    }
}

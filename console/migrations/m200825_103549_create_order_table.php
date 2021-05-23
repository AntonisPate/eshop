<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m200825_103549_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'transmit_type' => $this->integer(),
            'pay_by' => $this->integer(),
            'status' => $this->integer(),
            'phone_number' => $this->string(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'address' => $this->string(),
            'city' => $this->string(),
            'postal_code' => $this->string(),
            'email' => $this->string(),
            'date' => $this->date(),
            'data' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}

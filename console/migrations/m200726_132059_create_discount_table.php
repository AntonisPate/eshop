<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%discount}}`.
 */
class m200726_132059_create_discount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%discount}}', [
            'id' => $this->primaryKey(),
            'product_category_id' => $this->integer(),
            'product_sub_category_id' => $this->integer(),
            'discount_percentance' => $this->integer(),
            'from' => $this->date(),
            'to' => $this->date(),
            'message' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%discount}}');
    }
}

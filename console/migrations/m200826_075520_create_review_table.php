<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m200826_075520_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'content' => $this->text(),
            'stars' => $this->integer(),
            'date' => $this->date(),
            'product_id' => $this->integer(),
            'user_fullname' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%review}}');
    }
}

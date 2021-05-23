<?php

use yii\db\Migration;

/**
 * Class m200805_222123_add_title_in_discount_table
 */
class m200805_222123_add_title_in_discount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%discount}}', 'title', $this->text());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%discount}}', 'title');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200805_222123_add_title_in_discount_table cannot be reverted.\n";

        return false;
    }
    */
}

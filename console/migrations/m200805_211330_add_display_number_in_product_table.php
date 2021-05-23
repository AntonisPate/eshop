<?php

use yii\db\Migration;

/**
 * Class m200805_211330_add_display_number_in_product_table
 */
class m200805_211330_add_display_number_in_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'display_number', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'display_number');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200805_211330_add_display_number_in_product_table cannot be reverted.\n";

        return false;
    }
    */
}

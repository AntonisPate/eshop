<?php

use yii\db\Migration;

/**
 * Class m200726_113909_add_sub_category_id_to_product_category_table
 */
class m200726_113909_add_sub_category_id_to_product_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_category}}', 'sub_category_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_category}}', 'sub_category_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200726_113909_add_sub_category_id_to_product_category_table cannot be reverted.\n";

        return false;
    }
    */
}

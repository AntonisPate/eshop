<?php

use yii\db\Migration;

/**
 * Class m200819_103633_add_english_fields_in_product_table
 */
class m200819_103633_add_english_fields_in_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'english_title', $this->text());
        $this->addColumn('{{%product}}', 'english_description', $this->text());
        $this->addColumn('{{%product}}', 'long_description', $this->text());
        $this->addColumn('{{%product}}', 'english_long_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'english_title');
        $this->dropColumn('{{%product}}', 'english_description');
        $this->dropColumn('{{%product}}', 'long_description');
        $this->dropColumn('{{%product}}', 'english_long_description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200819_103633_add_english_fields_in_product_table cannot be reverted.\n";

        return false;
    }
    */
}

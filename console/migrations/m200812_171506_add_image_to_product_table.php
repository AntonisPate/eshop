<?php

use yii\db\Migration;

/**
 * Class m200812_171506_add_image_to_product_table
 */
class m200812_171506_add_image_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'image', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200812_171506_add_image_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m200510_100200_create_product_category
 */
class m200510_100200_create_product_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_category}}', [
            'id' => $this->primaryKey(),
            'primary_name' => $this->string(),
            'shortname' => $this->string(),
            'discount_id' => $this->integer(),
            'description' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200510_100200_create_product_category cannot be reverted.\n";

        return false;
    }
    */
}

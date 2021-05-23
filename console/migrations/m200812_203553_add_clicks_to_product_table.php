<?php

use yii\db\Migration;

/**
 * Class m200812_203553_add_clicks_to_product_table
 */
class m200812_203553_add_clicks_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'clicks', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'clicks');
    }
}

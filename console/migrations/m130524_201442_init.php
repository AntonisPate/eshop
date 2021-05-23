<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}

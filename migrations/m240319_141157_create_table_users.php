<?php

use yii\db\Migration;

/**
 * Class m240319_141157_create_table_users
 */
class m240319_141157_create_table_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'login' => $this->string()->notNull()->unique(),
            'senha' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        
    }

    public function down()
    {
        
    }
    */
}

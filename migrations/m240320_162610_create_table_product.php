<?php

use yii\db\Migration;

/**
 * Class m240320_162610_create_table_product
 */
class m240320_162610_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%produto}}', [
            'id' => $this->primaryKey(),
            'id_cliente' => $this->integer()->notNull(),
            'nome' => $this->string()->notNull(),
            'preco' => $this->decimal(10, 2),
            'foto' => $this->string(),
          ]);
          $this->addForeignKey('fk_produto_cliente', 'produto', 'id_cliente', 'cliente', 'id', 'CASCADE');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_produto_cliente', 'produto');
        $this->dropTable('{{%produto}}');
    }

}

<?php

use yii\db\Migration;

/**
 * Class m240319_175006_create_table_client
 */
class m240319_175006_create_table_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cliente}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(),
            'cpf' => $this->string(14),
            'cep' => $this->string(),
            'logradouro' => $this->string(),
            'numero' => $this->string(),
            'cidade' => $this->string(),
            'estado' => $this->string(),
            'complemento' => $this->string(),
            'foto' => $this->string(),
            'sexo' => $this->string(2),
          ]);
          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cliente}}');
    }

}

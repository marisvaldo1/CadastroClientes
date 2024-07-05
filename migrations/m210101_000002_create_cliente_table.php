<?php

use yii\db\Migration;

class m210101_000002_create_cliente_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('cliente', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'cpf' => $this->string(11)->notNull()->unique(),
            'cep' => $this->string(8),
            'logradouro' => $this->string(),
            'numero' => $this->string(),
            'cidade' => $this->string(),
            'estado' => $this->string(),
            'complemento' => $this->string(),
            'foto' => $this->text(),
            'sexo' => $this->string(1),
            'criado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'atualizado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cliente');
    }
}

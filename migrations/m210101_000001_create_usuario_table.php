<?php

use yii\db\Migration;

class m210101_000001_create_usuario_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('usuario', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->notNull()->unique(),
            'senha' => $this->string()->notNull(),
            'nome' => $this->string()->notNull(),  // Adicionando a coluna 'nome'
            'chave_autenticacao' => $this->string(32)->notNull(),
            'token_acesso' => $this->string(32)->notNull(),
            'criado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'atualizado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('usuario');
    }
}

<?php

use yii\db\Migration;

class m210101_000003_create_produto_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('produto', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'preco' => $this->decimal(10, 2)->notNull(),
            'cliente_id' => $this->integer()->notNull(),
            'foto' => $this->text(),
            'criado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'atualizado_em' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Chave estrangeira
        $this->addForeignKey(
            'fk-produto-cliente_id',
            'produto',
            'cliente_id',
            'cliente',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('produto');
    }
}

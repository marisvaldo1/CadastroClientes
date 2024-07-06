<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Produto extends ActiveRecord
{
    public static function tableName()
    {
        return 'produto';
    }

    public function rules()
    {
        return [
            [['nome', 'preco', 'cliente_id'], 'required'],
            [['preco'], 'number'],
            [['cliente_id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['foto'], 'string', 'max' => 1024],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['cliente_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'preco' => 'Preço',
            'cliente_id' => 'Cliente',
            'foto' => 'Foto',
        ];
    }

    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'cliente_id']);
    }
}

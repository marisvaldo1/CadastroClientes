<?php

namespace app\models;

use yii\db\ActiveRecord;

class Produto extends ActiveRecord
{
    public static function tableName()
    {
        return 'produto';
    }

    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'cliente_id']);
    }
}

<?php

namespace app\models;

use yii\db\ActiveRecord;

class Cliente extends ActiveRecord
{
    public static function tableName()
    {
        return 'cliente';
    }
}

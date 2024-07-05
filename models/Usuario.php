<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuario extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'usuario';
    }

    public function rules()
    {
        return [
            [['login', 'senha', 'nome'], 'required'],
            [['login'], 'unique'],
            [['login', 'nome'], 'string', 'max' => 255],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token_acesso' => $token]);
    }

    public static function findByUsername($login)
    {
        return static::findOne(['login' => $login]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->chave_autenticacao;
    }

    public function validateAuthKey($authKey)
    {
        return $this->chave_autenticacao === $authKey;
    }

    public function validatePassword($senha)
    {
        return Yii::$app->security->validatePassword($senha, $this->senha);
    }
}

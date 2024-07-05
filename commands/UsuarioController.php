<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Usuario;
use Yii;

class UsuarioController extends Controller
{
    public function actionCriar($login, $senha, $nome)
    {
        $usuario = new Usuario();
        $usuario->login = $login;
        $usuario->senha = Yii::$app->security->generatePasswordHash($senha);
        $usuario->chave_autenticacao = Yii::$app->security->generateRandomString();
        $usuario->token_acesso = Yii::$app->security->generateRandomString();
        $usuario->generateAuthKey();
        $usuario->save();

        echo "Usuário {$nome} criado com sucesso.\n";
    }
}

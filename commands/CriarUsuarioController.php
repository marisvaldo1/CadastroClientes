<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Usuario;

class CriarUsuarioController extends Controller
{
    public function actionIndex($login, $senha, $nome)
    {
        $usuario = new Usuario();
        $usuario->login = $login;
        $usuario->senha = Yii::$app->security->generatePasswordHash($senha);
        $usuario->nome = $nome;
        $usuario->chave_autenticacao = Yii::$app->security->generateRandomString();
        $usuario->token_acesso = Yii::$app->security->generateRandomString();

        if ($usuario->save()) {
            echo "User {$login} created successfully.\n";
        } else {
            echo "Failed to create user:\n";
            foreach ($usuario->errors as $error) {
                echo "- $error\n";
            }
        }
    }
}

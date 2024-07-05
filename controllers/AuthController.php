<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Usuario;
use yii\web\Response;

class AuthController extends Controller
{
    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();

        $usuario = Usuario::findByUsername($request['login']);
        if ($usuario && $usuario->validatePassword($request['senha'])) {
            if (empty($usuario->token_acesso)) {
                $usuario->token_acesso = Yii::$app->security->generateRandomString();
                $usuario->save();
            }

            return [
                'token' => $usuario->token_acesso,
            ];
        }

        Yii::$app->response->statusCode = 401;
        return ['error' => 'Login ou senha inválidos'];
    }

    public function actionRegister()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();

        $usuario = new Usuario();
        $usuario->login = $request['login'];
        $usuario->senha = Yii::$app->security->generatePasswordHash($request['senha']);
        $usuario->nome = $request['nome'];
        $usuario->chave_autenticacao = Yii::$app->security->generateRandomString();
        $usuario->token_acesso = Yii::$app->security->generateRandomString();

        if ($usuario->save()) {
            return [
                'message' => 'User registered successfully',
            ];
        }

        Yii::$app->response->statusCode = 400;
        return [
            'error' => 'Failed to register user',
            'details' => $usuario->errors,
        ];
    }
}

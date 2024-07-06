<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Usuario;
use yii\web\Response;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\CompositeAuth::class,
            'except' => ['register', 'login', 'test'],
            'authMethods' => [
                \yii\filters\auth\HttpBearerAuth::class,
            ],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        Yii::info('Recebendo solicitação de login', __METHOD__);

        $rawBody = Yii::$app->request->getRawBody();
        Yii::info('Raw body: ' . $rawBody, __METHOD__);

        $request = json_decode($rawBody, true);
        Yii::info('Parsed request: ' . json_encode($request), __METHOD__);

        if (isset($request['login']) && isset($request['senha'])) {
            $usuario = Usuario::findByUsername($request['login']);
            Yii::info('Usuário encontrado: ' . json_encode($usuario), __METHOD__);

            if ($usuario && $usuario->validatePassword($request['senha'])) {
                Yii::info('Senha validada com sucesso', __METHOD__);
                // Gerar novo token de acesso
                $usuario->generateAccessToken();
                if ($usuario->save()) {
                    Yii::info('Token gerado e salvo com sucesso', __METHOD__);
                    return [
                        'token' => $usuario->token_acesso,
                    ];
                } else {
                    Yii::error('Falha ao salvar o token de acesso', __METHOD__);
                }
            } else {
                Yii::info('Senha inválida ou usuário não encontrado', __METHOD__);
            }
        } else {
            Yii::info('Dados de login ou senha ausentes', __METHOD__);
        }

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

        if ($usuario->save()) {
            return [
                'message' => 'Usuário registrado com sucesso',
            ];
        }

        return [
            'error' => 'Falha ao registrar usuário',
            'details' => $usuario->errors,
        ];
    }

    public function actionTest()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rawBody = Yii::$app->request->getRawBody();
        $request = json_decode($rawBody, true);
        return [
            'rawBody' => $rawBody,
            'request' => $request,
        ];
    }
}

<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Cliente;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ClienteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\CompositeAuth::class,
            'authMethods' => [
                \yii\filters\auth\HttpBearerAuth::class,
            ],
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();

        $cliente = new Cliente();
        $cliente->nome = $request['nome'];
        $cliente->cpf = $request['cpf'];
        $cliente->cep = $request['cep'];
        $cliente->logradouro = $request['logradouro'];
        $cliente->numero = $request['numero'];
        $cliente->cidade = $request['cidade'];
        $cliente->estado = $request['estado'];
        $cliente->complemento = $request['complemento'];
        $cliente->sexo = $request['sexo'];
        $cliente->foto = $request['foto'];

        if ($cliente->save()) {
            return [
                'message' => 'Cliente registrado com sucesso',
            ];
        }

        return [
            'error' => 'Falha ao registrar cliente',
            'details' => $cliente->errors,
        ];
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('per-page', 10);

        $dataProvider = new ActiveDataProvider([
            'query' => Cliente::find(),
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1, // As páginas no Yii começam em 0
            ],
        ]);

        $clientes = $dataProvider->getModels();

        return [
            'totalCount' => $dataProvider->getTotalCount(),
            'pageCount' => $dataProvider->getPagination()->getPageCount(),
            'currentPage' => $dataProvider->getPagination()->getPage() + 1,
            'perPage' => $dataProvider->getPagination()->getPageSize(),
            'clientes' => $clientes,
        ];
    }

    public function actionView($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cliente = Cliente::findOne($id);

        if ($cliente !== null) {
            return $cliente;
        } else {
            throw new NotFoundHttpException("Cliente não encontrado.");
        }
    }
}

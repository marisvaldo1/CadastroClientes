<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Produto;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ProdutoController extends Controller
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

        $produto = new Produto();
        $produto->nome = $request['nome'];
        $produto->preco = $request['preco'];
        $produto->cliente_id = $request['cliente_id'];
        $produto->foto = $request['foto'];

        if ($produto->save()) {
            return [
                'message' => 'Produto registrado com sucesso',
            ];
        }

        return [
            'error' => 'Falha ao registrar produto',
            'details' => $produto->errors,
        ];
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('per-page', 10);

        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find(),
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1, // As páginas no Yii começam em 0
            ],
        ]);

        $produtos = $dataProvider->getModels();

        return [
            'totalCount' => $dataProvider->getTotalCount(),
            'pageCount' => $dataProvider->getPagination()->getPageCount(),
            'currentPage' => $dataProvider->getPagination()->getPage() + 1,
            'perPage' => $dataProvider->getPagination()->getPageSize(),
            'produtos' => $produtos,
        ];
    }

    public function actionView($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $produto = Produto::findOne($id);

        if ($produto !== null) {
            return $produto;
        } else {
            throw new NotFoundHttpException("Produto não encontrado.");
        }
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();
        $produto = Produto::findOne($id);

        if ($produto === null) {
            throw new NotFoundHttpException("Produto não encontrado.");
        }

        $produto->nome = $request['nome'];
        $produto->preco = $request['preco'];
        $produto->cliente_id = $request['cliente_id'];
        $produto->foto = $request['foto'];

        if ($produto->save()) {
            return [
                'message' => 'Produto atualizado com sucesso',
            ];
        }

        return [
            'error' => 'Falha ao atualizar produto',
            'details' => $produto->errors,
        ];
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $produto = Produto::findOne($id);

        if ($produto === null) {
            throw new NotFoundHttpException("Produto não encontrado.");
        }

        if ($produto->delete()) {
            return [
                'message' => 'Produto deletado com sucesso',
            ];
        }

        return [
            'error' => 'Falha ao deletar produto',
        ];
    }

    public function actionListByCliente($cliente_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('per-page', 10);

        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find()->where(['cliente_id' => $cliente_id]),
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1, // As páginas no Yii começam em 0
            ],
        ]);

        $produtos = $dataProvider->getModels();

        return [
            'totalCount' => $dataProvider->getTotalCount(),
            'pageCount' => $dataProvider->getPagination()->getPageCount(),
            'currentPage' => $dataProvider->getPagination()->getPage() + 1,
            'perPage' => $dataProvider->getPagination()->getPageSize(),
            'produtos' => $produtos,
        ];
    }
}

<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Cliente;


class ClienteController extends ActiveController
{

    public $modelClass = 'app\models\Cliente';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
        'class' => \yii\filters\auth\HttpBearerAuth::class,
        ];
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function init()
    {
        parent::init();
    }
   
    
    public function actionIndex()
    {
        $page = Yii::$app->request->get('page', 1);
        $query = Cliente::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        if($query){
            $dataProvider->pagination->setPage($page - 1);
            $clientes = $dataProvider->getModels();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => true, 
                'data' => $clientes, 
                'pagination' => [
                    'page_count' => $dataProvider->pagination->getPageCount(),
                    'page' => $page,
                    'total' => $dataProvider->getTotalCount(),
                    'pageSize' => $dataProvider->pagination->getPageSize()
                
                ],
            ];
        }else{
            Yii::$app->response->statusCode = 404;
            return ['status' => false, 'data' => 'Nenhum cliente encontrado'];
        }
    }

    public function actionCreate()
    {
        $cliente = new Cliente();
        $cliente->load(Yii::$app->request->post(), '');
        $cliente->foto = \yii\web\UploadedFile::getInstanceByName('foto');
        if($cliente->save()){
            $filePath = 'uploads/' . $cliente->id . '.' . $cliente->foto->extension;
            $cliente->foto->saveAs($filePath);
            $cliente->foto = $filePath;
            $cliente->save(false);
            return ['status' => true, 'data' => 'Cliente cadastrado com sucesso'];
        }else{
            return ['status' => false, 'data' => $cliente->getErrors()];
        }
    }

    public function actionDelete($id)
    {
        $cliente = Cliente::findOne($id);
        if ($cliente === null) {
        return ['error' => 'Cliente não encontrado.'];
        }
        if ($cliente->delete()) {
        return ['status' => true, 'data' => "Cliente excluído com sucesso"];
        } else {
        return ['error' => 'Erro ao excluir cliente. Tente novamente.'];
        }
    }
}

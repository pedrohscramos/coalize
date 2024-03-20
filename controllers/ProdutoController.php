<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\Produto;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\Cliente;

class ProdutoController extends ActiveController
{
    public $modelClass = 'app\models\Produto';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
        'linksEnvelope' => 'links',
        'metaEnvelope' => 'meta',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
        ];
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    
    public function actionIndex()
    {
        
        $produtos = Produto::find();
            
        return [
            'success' => true,
            'data' => $produtos,
            
        ];
    }

    public function actionByCliente(){
        $nomeCliente = Yii::$app->request->post('nome');
       

        $cliente = Cliente::find()->where(['nome' => $nomeCliente])->one();
        if (!$cliente) {
            return ['error' => 'Cliente não encontrado'];
        }

        
        $produtos = Produto::find()
        ->select('produto.*')
        ->leftJoin('cliente', 'cliente.id = produto.id_cliente')
        ->where('cliente.nome' . ' LIKE ' . ':nome')
        ->addParams([':nome' => $nomeCliente])
        ->all();
        return [
            'success' => true,
            'data' => $produtos,
        ];
    }

    public function actionByIdCliente($id_cliente)
    {
        $cliente = Cliente::findOne($id_cliente);
        if (!$cliente) {
        return ['error' => 'Cliente não encontrado'];
        }
        $produtos = Produto::find()->where(['id_cliente' => $id_cliente])->all();
        return [
            'success' => true,
            'data' => $produtos,
            
        ];
    }

    public function actionCreate()
    {
        $produto = new Produto();
        $produto->load(Yii::$app->request->post(), '');
        $produto->foto = UploadedFile::getInstanceByName('foto');
        if ($produto->save()) {
            if ($produto->foto !== null) {
                $filePath = 'uploads/' . $produto->foto->baseName . '.' . $produto->foto->extension;
                $produto->foto->saveAs($filePath);
                $produto->foto = $filePath;
                $produto->save(false);
            }
            Yii::$app->response->statusCode = 201;
            return [
                'success' => true,
                'data' => $produto,
            ];
        } else {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'errors' => $produto->getErrors(),
            ];
        }
    }
}
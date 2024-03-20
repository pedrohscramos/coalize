<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\User;

class AuthController extends Controller
{
  public function behaviors()
  {
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
        'class' => \yii\filters\auth\HttpBearerAuth::class,
        'only' => ['logout'],
        ];

    return $behaviors;
  }

  
  public function actionLogin()
  {
    $login = Yii::$app->request->post('login');
    $senha = Yii::$app->request->post('senha');

    if (User::validateCredentials($login, $senha)) {

      $user = User::findByLogin($login);
      
      $token = User::generateAccessToken();
      $user->access_token = $token;
      $user->save();
      return ['access_token' => $user->access_token];
    } else {
      Yii::$app->response->statusCode = 401;
      return ['error' => 'Unauthorized'];
    }
  }

  public function actionLogout()
  {
    Yii::$app->user->logout(Yii::$app->request->getHeaders()->get('Authorization'));
    Yii::$app->response->format = Response::FORMAT_JSON;
    return ['message' => 'Logout successful'];
  }


  private function validateCredentials($login, $senha)
  {
    
    $user = User::findByLogin($login);

    
    if ($user !== null) {
      
      return Yii::$app->security->validatePassword($senha, $user->senha);
    }

    return false; 
  }

}
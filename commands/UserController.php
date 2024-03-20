<?php

namespace app\commands;

use Yii;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class UserController extends Controller
{

  
    public function actionCreate()
    {
        $nome = $this->prompt('Nome: ');
        $login = $this->prompt('Login: ');
        $senha = $this->prompt('Senha: ');
        
        
        $user = new User;
        $user->nome = $nome;
        $user->login = $login;
        $user->senha = Yii::$app->security->generatePasswordHash($senha);
        $user->access_token = Yii::$app->security->generateRandomString();
        
       
        if ($user->save()) {
            Console::output("Usuário criado com sucesso");
            return Console::output("access_token: " . $user->access_token);
        } else {
            Console::output("Erro ao criar usuário");
            foreach ($user->getErrors() as $error) {
                Console::output("- " . implode("\n- ", $error));
            }
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

   
}
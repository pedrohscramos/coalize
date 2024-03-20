<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\components\CpfHelper;

class Cliente extends ActiveRecord{


    public static function tableName()
    {
        return 'cliente';
    }

    public function rules()
    {
        return [
            [['nome', 'cep', 'logradouro', 'numero', 'cidade', 'estado', 'complemento'], 'string', 'max' => 255],
            [['cpf'], 'string', 'max' => 14],
            [['cpf'], CpfHelper::class],
            [['cpf'], 'unique'],
            [['foto'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png'],
            [['sexo'], 'in', 'range' => ['M', 'F']],
        ];
    }

   
}
<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Produto extends ActiveRecord
{
    public static function tableName()
    {
        return 'produto';
    }

    public function rules()
    {
        return [
            [['nome', 'preco'], 'required'],
            [['preco'], 'number'],
            [['id_cliente'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['foto'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png'],
        ];
    }
}
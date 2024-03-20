<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


class User extends ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['nome', 'login', 'senha'], 'required'],
            [['nome', 'login', 'senha'], 'string', 'max' => 255],
            [['login'], 'unique'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->senha = Yii::$app->security->generatePasswordHash($this->senha);
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset($id) ? static::findOne($id) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->access_token === $authKey;
    }

    public function validatePassword($senha)
    {
        return Yii::$app->security->validatePassword($senha, $this->senha);
    }

    public static function validateCredentials($login, $senha)
    {
        $user = static::findOne(['login' => $login]);
        if ($user && $user->validatePassword($senha)) {
            return Yii::$app->security->validatePassword($senha, $user->senha);
        }
        return false;
    }

    public static function generateAccessToken()
    {
        return Yii::$app->security->generateRandomString();
    }

    public function logout($access_token)
    {
        $user = static::findOne(['access_token' => $access_token]);
        if ($user) {
            $user->access_token = null;
            if ($user->save()) {
                return true;
            }else{
                Yii::error($user->getErrors());
            }
        }
        return false;
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Usuarios".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $nombre
 * @property string $perfil
 * @property string $accessToken
 * @property string $authKey
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $role;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'nombre', 'perfil'], 'required'],
            [['username', 'perfil'], 'string', 'max' => 50],
            [['password', 'accessToken', 'authKey'], 'string', 'max' => 255],
            [['nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'perfil' => 'Perfil',
            'accessToken' => 'Access Token',
            'authKey' => 'Auth Key',
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['accessToken'=>$token]);
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username'=>$username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    
    public static function isUserAdmin($id)
    {
       if (Usuarios::findOne(['id' => $id, 'perfil' => 'admin'])){
        return true;
       } else {

        return false;
       }

    }

    public static function isUserSimple($id)
    {
       if (Usuarios::findOne(['id' => $id, 'perfil' => 'user'])){
       return true;
       } else {

       return false;
       }
    }
}

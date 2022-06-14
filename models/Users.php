<?php

namespace app\models;

use Yii;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface

{
		
public $user = false;
 public $rememberMe = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
   public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 50],
           ['password', 'validatePassword'],
           // ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'firstname' => 'Имя',
        ];
    }


public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(!$this->getUser())
            {
           $this->addError($attribute, 'Неверный пароль');
            }
        }
    }

    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
	
	    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public static function 
    findIdentityByAccessToken($token, $type = null)
    {
      
    }
    
    public function getAuthKey()
    {
       
    }

    public function validateAuthKey($authKey)
    {
      
    }

    public function UserData($id)
    {
        $data = Yii::$app->db->createCommand("SELECT * FROM {{users}} WHERE [[id]] = '$id'")->queryAll();

        return $data;
    }

	public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }
	   public function getUser()
    {
     if ($this->user === false) {
 $this->user = Users::findOne(['username'=>$this->username, 
                               'password'=>$this->password]);
   }

  return $this->user;

	}
}

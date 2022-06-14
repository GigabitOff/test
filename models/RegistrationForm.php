<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;




/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $email;
    public $telefon;
    public $verifyCode;





    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','firstname','lastname','email','telefon'], 'required'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'username' => 'Никнейм',
            'password' => 'Password',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'email' => 'email',
            'telefon' => 'Телефон',
            'verifyCode' => 'Verifi Code',
        ];
    }

    }


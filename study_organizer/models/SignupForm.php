<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => Users::class, 'targetAttribute' => 'U_username'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Users();
        $user->U_username = $this->username;
        $user->U_password = $this->password;
        $user->U_role = 'user';

        return $user->save() ? $user : null;
    }
}

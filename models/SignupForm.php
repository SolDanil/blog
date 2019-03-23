<?php
namespace app\models;
use yii\base\Model;
class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $role_id;

    public function rules()
    {
        return [
            [['name','email','password','role_id'], 'required'],
            [['name'], 'string'],
            [['email'], 'email'],
            [['role_id'], 'integer'],
            [['email'], 'unique', 'targetClass'=>'app\models\User', 'targetAttribute'=>'email']
        ];
    }

    public function signup()
    {
        if($this->validate())
        {
            $user = new User();
            $user->attributes = $this->attributes;
            return $user->create();
        }
    }
}
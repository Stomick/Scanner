<?php

namespace models;

use models\User;
use Yii;
use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $email;
    public $company;
    public $surename;
    public $password;
    public $cpassword;
    public $address;
    public $city_id;
    public $_user;
    public $rememberMe = 1;

    public function rules()
    {
        return [
            [['username' , 'company' , 'surename', 'password', 'cpassword' , 'address' , 'city_id'] , 'string'],
            [['email', 'surename', 'password', 'cpassword' , 'address' ] , 'required'],
            ['email', 'email'],
            [ 'password', 'compare', 'compareAttribute' => 'cpassword', 'message' => 'Пароли не совпадают' ],
            [ 'cpassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают' ],
        ];
    }

    public function validateEmail($attribute, $params) {

        if (User::findByEmail($this->email)) {
            $this->addError('email', 'This email already exist.');
        }
    }
// rule for confirm password field

    public function attributeLabels()
    {

        return [
            'username' => "Имя",
            'surename' => 'Фамилия',
            'email' => "Почта",
            'type' => "Тип пользователя",
            'password' => 'Пароль',
            'cpassword' => 'Подтверждение' ,
            'address' => 'Адрес проживания',
            'phone' => 'Телефон',
            'bonus' => 'Бонусы'
        ];

    }

    public function saveToBase()
    {
        if(!User::findByEmail($this->email)) {
            $com = new Company();
            $user = new User();
            $user->role = 'partner';
            foreach ($this as $k => $v){
                if($k == 'company'){
                    $com->name = $v;
                    if($com->save()){
                        $user->company_id = $com->company_id;
                    }
                }elseif( $k != 'cpassword' && $k != 'rememberMe' && $k != '_user') {
                    $user->$k= $v;
                }elseif($k== 'city_id'){
                    $user->city_id=$v;
                    if($cit = City::findOne($v)){
                        $cit->status = 1;
                        $cit->update();
                    }
                }
            }

             if($user->save()) {
                 return true;
             }
             var_dump($user->errors);
             $com->delete();
             die();
             return false;

        }else{
            return false;
        }
    }

    public function login()
    {
        $this->rememberMe =  1;
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = \models\User::findByUsername($this->username);
        }

        return $this->_user;
    }
    public function updateToBase()
    {
        if($user = User::findByEmail($this->email)) {
            $user->type = $this->type;
            $user->email = $this->email;
            $user->update();
            if($user)
            {
                $prof = Profiles::findOne(['user_id' => $user->id]);
                $prof->address = $this->address;
                $prof->name = $this->name;
                $prof->surename = $this->surename;
                $prof->phone = $this->phone;
                $prof->user_id = $user->id;
                $prof->bonus = $this->bonus;
                return $prof->update();
            }else return false;
        }else{
            return false;
        }
    }
}
<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Login extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $email;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password' , 'email'], 'string'],
            [['password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        $this->rememberMe = true;

        if ($this->validate()) {
            if($user = $this->getUser()) {
                if($user->status == 5){
                    $user->verification_token = Yii::$app->security->generateRandomString(32);
                    if($user->update()) {
                        $user->SendActivEmail($user->verification_token);
                        Yii::$app->session->setFlash('success', 'Письмо для активации аккаунта отправленно на ваш емаил');
                        return false;
                    }
                }
                if($login = Yii::$app->user->login($user,  3600 * 24 * 30 )) {
                    $this->_user->ip = ip2long(Yii::$app->getRequest()->getUserIP());
                    $this->_user->save();
                    return true;
                }else{
                    return false;
                }
            }
        }
        Yii::$app->session->setFlash('success', 'Не верный пароль или почта');
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return \models\MUser
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = \models\MUser::findByEmail($this->email);
        }
        if($this->_user===null){
            Yii::$app->session->setFlash('success', 'Пользователь с таким емейлом не найден');
        }
        return $this->_user;
    }
}

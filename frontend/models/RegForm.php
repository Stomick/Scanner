<?php
namespace frontend\models;

use models\MUser;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class RegForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $cpassword;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\models\MUser', 'message' => 'Извините, емаил занят'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['cpassword', 'required'],
            ['cpassword', 'string', 'min' => 6],
            [ 'password', 'compare', 'compareAttribute' => 'cpassword', 'message' => 'Пароли не совпадают' ],
            [ 'cpassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают' ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }
        
        $user = new MUser();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        if($user->SendRegEmail($user->verification_token)) {
            $user->status = 0;
            return $user->save();
        }return false;

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom(['noreply@jobscanner.online'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}

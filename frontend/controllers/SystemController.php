<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\ChatMessages;
use models\ChatRoom;
use models\ChatUserRoom;
use models\MUser;
use models\Photos;
use models\Vacancies;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\RegForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SystemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionChat(){
        if(Yii::$app->user->id) {
                if ($room = ChatRoom::findOne(['type' => 'system', 'type_id' => Yii::$app->user->id])) {
                    return $this->render('/messages/system', ['type'=>'Системные сообщения', 'page_id' => $room->room_id]);
                }
            }
        return $this->redirect('/');
    }

}

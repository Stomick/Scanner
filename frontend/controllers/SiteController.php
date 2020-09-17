<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\Specialties;
use models\Vacancies;
use Yii;
use yii\base\InvalidArgumentException;
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
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'registration'],
                'rules' => [
                    [
                        'actions' => ['registration', 'login', 'index' , 'test'],
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
                    'logout' => ['get'],
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
    public function actionIndex($cord=null)
    {
        if( $cord == null && isset($_SESSION['lat']) && $_SESSION['lng']){
            $cord =  $_SESSION['lat'] . ',' . $_SESSION['lng'];
        }
        $this->view->title = 'Вакансии';
        $price = ['min'=>0, 'max'=>0];
        if(Yii::$app->user->isGuest || !Yii::$app->user->identity->type) {
            $price = Vacancies::find()->select('MIN(price) as min , MAX(price) as max')->where(['public' => 1,'tmp'=>0])->orderBy('price DESC')->asArray()->one();
            $mtype = 'vacancies';// = Vacancies::find()->where(['public' => 1])->orderBy('price DESC')->all();
            $mtitle = 'Вакансии';
        }else{
            $price = Specialties::find()->select('MIN(price) as min , MAX(price) as max')->where(['public' => 1,'tmp'=>0])->orderBy('price DESC')->asArray()->one();
            $mtitle = 'Работники';
            $mtype = 'specialties';// = Specialties::find()->where(['public' => 1])->orderBy('price DESC')->all();
        }
        return $this->render('index', ['mtype' => $mtype , 'mtitle'=>$mtitle , 'price' => $price , 'cord'=> $cord]);//$markers] );
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Login();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $model->password = '';
            return $this->redirect('/');
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/');
    }

    public function actionInfo($id)
    {
        $id = str_replace('ID' , '' , $id);
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRegistration()
    {
        $model = new RegForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию. Пожалуйста, проверьте свой почтовый ящик для подтверждения по электронной почте.');
            return $this->goHome();
        } else {
            if (count($model->errors)) {
                foreach ($model->errors as $k => $v) {
                    Yii::$app->session->setFlash('error', $v);
                }
            }
        }

        return $this->redirect('/');
    }

    public function actionTest()
    {

        foreach (Vacancies::find()->orderBy('price DESC')->where(['tmp'=>0])->all() as $k => $v) {
            $v->updated_at = strtotime('now');
            var_dump($v->save(false));
        }
        foreach (Specialties::find()->orderBy('price DESC')->where(['tmp'=>0])->all() as $k => $v) {
            $v->updated_at = strtotime('now');
            var_dump($v->save(false));
        }
        die();
    }
}

<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\MUser;
use models\Reviews;
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
class ReviewsController extends Controller
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
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMy()
    {
        return $this->render('index');
    }

    public function actionInfo($id=null)
    {
        $id = str_replace('ID', '', $id);
        if($rev = Reviews::findOne($id)){
            $user = MUser::findOne($rev->user_from);
            return $this->render('info' , ['rev'=>$rev , 'user' => $user]);
        }
        return $this->redirect('/');
    }

    public function actionUpdate(){
        if($rev = Yii::$app->request->getBodyParam('rev')){
            if(key_exists('id',$rev) && Reviews::findOne($rev['id'])){
                $reviews = Reviews::findOne($rev['id']);
                foreach ($rev as $k => $v){
                    $reviews->$k = trim(strip_tags($v));
                }
                if($reviews->update()){
                    $user = MUser::findOne($reviews->user_to);
                    return $this->redirect("/reviews/info/ID".$rev['answer'].".html");
                }
            }elseif (key_exists('answer',$rev) && Reviews::findOne($rev['answer'])){
                $revToAns = Reviews::findOne($rev['answer']);
                if(key_exists('id',$rev) && (int)$rev['id']){
                    $reviews = Reviews::findOne($rev['id']);
                }else{
                    $reviews = new Reviews();
                    $reviews->user_from = Yii::$app->user->id;
                    $reviews->type = $revToAns->type == 'worker' ? 'employer': 'worker';
                    $reviews->rating = 0;
                }
                foreach ($rev as $k => $v){
                    if ($v !='') {
                        $reviews->$k = trim(strip_tags($v));
                    }
                }
                if($reviews->save()){
                    return $this->redirect("/reviews/info/ID".$rev['answer'].".html");
                }
            }

        }
        return $this->redirect('/');
    }

    public function actionDelete($id=null)
    {
        $id = str_replace('ID', '', $id);
        if($rev = Reviews::findOne($id)){
            $userTo = $rev->user_to;
            if($rev->user_from == Yii::$app->user->id){
                $answ = $rev->answer;
                $rev->delete();
                return $this->redirect("/reviews/info/ID$answ.html");
            }
            return $this->redirect("/profile/reviews/ID$userTo.html");
        }
        return $this->redirect('/');
    }
}

<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\Orders;
use phpDocumentor\Reflection\Types\This;
use YandexCheckout\Client;
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
class PaymentController extends Controller
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
                        'actions' => ['signup' , 'payment' , 'make'],
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
        if (Yii::$app->user->isGuest){
            return $this->redirect('/');
        }
        if(Yii::$app->mobileDetect->isDesktop) {
            return $this->render('index');
        }else{
            return $this->render('mindex');
        }
    }

    public function actionMake()
    {
        $summ = \Yii::$app->request->getBodyParam('summ');
            if ((int)$summ > 10 && !Yii::$app->user->isGuest) {
                $user = Yii::$app->user->identity;
                $order = new Orders();
                $order->summ = $summ;
                $order->user_id = Yii::$app->user->id;
                if ($order->save()) {
                    $client = new Client();
                    $client->setAuth('717305', 'test_WCw0M5uYqSfMLPHoaP2cGlJ41JYtyAGYZUKnyjDOso4');

                    $payment = $client->createPayment(
                        array(
                            "amount" => array(
                                "value" => $summ,
                                "currency" => "RUB"
                            ),
                            "confirmation" => array(
                                "type" => "redirect",
                                "return_url" => "https://jobscanner.online/payment.html"
                            ),
                            'capture' => true,
                            "receipt" => array(
                                "customer" => array(
                                    "full_name" => $user->firstname . ' ' . $user->lastname,
                                    "phone" => str_replace(['+' , ')' , '(' , '-' , ''] , '',$user->phone),
                                ),
                                "items" => array(
                                    array(
                                        'description' => 'Пополнение баланса на сумму ' . $summ . '.00',
                                        "quantity" => "1.00",
                                        "amount" => array(
                                            "value" => $summ,
                                            "currency" => "RUB"
                                        ),
                                        "vat_code" => "2",
                                        "payment_mode" => "full_prepayment",
                                        "payment_subject" => "commodity"
                                    ),
                                )
                            )
                        ),
                        uniqid('', true)
                    );

                    if (isset($payment['_id'])) {
                        $order->payment_id = $payment['_id'];
                        $order->update();
                    }
                }
            }else{
                if((int)$summ < 10){
                    Yii::$app->session->setFlash('success', 'Сумма не может быть меньше 10 рублей');
                }
                return $this->redirect('https://jobscanner.online/payment.html');
            }
            return $this->redirect('https://money.yandex.ru/payments/external/confirmation?orderId=' . $payment['_id']);
    }

    public function actionCheckin(){
        die();
    }
}

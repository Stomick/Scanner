<?php

namespace backend\controllers;

use backend\components\RequestApi;
use models\Balance;
use YandexCheckout\Model\Notification\NotificationSucceeded;
use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->enableCsrfValidation = false;
        Yii::$app->request->enableCsrfValidation = false;
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'order-check' => ['post'],
                    'payment-notification' => ['post'],
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'order-check' => [
                'class' => 'app\components\yakassa\actions\CheckOrderAction',
                'beforeResponse' => function ($request) {
                    /**
                     * @var \yii\web\Request $request
                     */
                    $invoice_id = (int)$request->post('orderNumber');
                    Yii::warning("Кто-то хотел купить несуществующую подписку! InvoiceId: {$invoice_id}", Yii::$app->yakassa->logCategory);
                    return false;
                }
            ],
            'payment-notification' => [
                'class' => 'app\components\yakassa\actions\PaymentAvisoAction',
                'beforeResponse' => function ($request) {
                    /**
                     * @var \yii\web\Request $request
                     */
                }
            ],
        ];
    }

    public function actionConfirm()
    {
        try {
            $source = file_get_contents('php://input');
            $requestBody = json_decode($source,true);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/../../logs/pay-' . date('Y-m-d') . '.log', $source . "\r\n", FILE_APPEND);

            try {
                $notification = ($requestBody['event'] === \YandexCheckout\Model\NotificationEventType::PAYMENT_SUCCEEDED)
                    ? new NotificationSucceeded($requestBody)
                    : new NotificationWaitingForCapture($requestBody);
            } catch (\Exception $e) {
                file_put_contents('../../logs/pay_errors-' . date('Y-m-d') . '.log', $e->getMessage(), FILE_APPEND);
            }

            $payment = $notification->getObject();

            if ($ord = \models\Orders::findOne(['payment_id'=>$payment['_id']])) {
                $ord->status = $payment['status'];
                $ord->updated_at = strtotime('now');
                $ord->update(false);
                $balance = new Balance();
                $balance->type = 'Orders';
                $balance->type_id = $ord->id;
                $balance->name = 'Пополнение баланса';
                $balance->user_id = $ord->user_id;
                $balance->summ = $ord->summ;
                $balance->comment = 'Пополнение баланса';
                $balance->save();
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/../../logs/pay-' . date('Y-m-d') . '.log', json_encode($payment) . "\r\n", FILE_APPEND);
            }
        } catch (\Exception $g) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/../../logs/error-' . date('Y-m-d') . '.log', $g->getMessage() . "\r\n", FILE_APPEND);
        }
        die();
    }
    public function actionIndex()
    {
        $query = \models\Orders::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count() , 'pageSize' => 20]);
        $sort = new Sort([
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По айди',
                ],
                'price' => [
                    'asc' => ['summ' => SORT_ASC],
                    'desc' => ['summ' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По цене',
                ],
                'status' => [
                    'asc' => ['status' => SORT_ASC],
                    'desc' => ['status' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По статусу',
                ],
                'title' => [
                    'asc' => ['address' => SORT_ASC],
                    'desc' => ['address' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По адресу',
                ],
                'created' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По дате создания',
                ],
            ],
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy($sort->orders)
            ->all();
        return $this->render('../site/index', ['page' => 'order', 'action' => $this->action->id, 'ret' => $models ,  'pages' => $pages, 'sort' => $sort]);
    }
}

<?php

namespace backend\controllers;

use models\Company;
use models\Stock;
use models\StockModel;
use models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;

/**
 * Site controller
 */
class StockController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'edit', 'inprogress', 'add', 'update', 'ended', 'arhive', 'new', 'all',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        ];
    }

    public function actionAll($type = null)
    {
        $ret = [];
        $andWhere = 1;

        $select = [
            'stock.stock_id',
            'description',
            'tarif',
            'com.name',
            'com.url as logo',
            'photo',
            'status',
            'banner',
            'start_date as start',
            'end_date as end',
            'moder_rating',
            '(SELECT SUM(type) FROM `reviews` WHERE reviews.`stock_id`=stock.`stock_id`) as rating', 'stock.created_at'];
        $ret = Stock::find()
            ->select($select)
            ->where(['tarif' => $type])
            ->innerJoin('company com', 'com.company_id=stock.company_id')
            ->innerJoin('stock_category stk', 'stk.`stock_id`=stock.`stock_id`')
            ->andWhere($andWhere)
            ->asArray()
            ->orderBy('moder_rating , tarif desc , rating desc')
            ->all();

        return $this->render('../site/index', ['page' => 'stock', 'action' => 'index', 'ret' => $ret]);
    }

    public function actionInprogress()
    {
        $ret = [];
        $andWhere = 1;

        $select = [
            'stock.stock_id',
            'description',
            'tarif',
            'com.name',
            'com.url as logo',
            'photo',
            'status',
            'banner',
            'start_date as start',
            'end_date as end',
            'moder_rating',
            '(SELECT SUM(type) FROM `reviews` WHERE reviews.`stock_id`=stock.`stock_id`) as rating', 'stock.created_at'];
        $ret = Stock::find()
            ->select($select)
            ->where(['status' => 'inprogress'])
            ->innerJoin('company com', 'com.company_id=stock.company_id')
            ->innerJoin('stock_category stk', 'stk.`stock_id`=stock.`stock_id`')
            ->andWhere(['stock.company_id' => Yii::$app->user->identity->company_id])
            ->asArray()
            ->orderBy('moder_rating , tarif desc , rating desc')
            ->all();
        return $this->render('../site/index', ['page' => 'stock', 'action' => 'index', 'ret' => $ret]);
    }

    public function actionEnded()
    {
        $select = [
            'stock.stock_id',
            'description',
            'tarif',
            'com.name',
            'com.url as logo',
            'photo',
            'status',
            'banner',
            'start_date as start',
            'end_date as end',
            'moder_rating',
            '(SELECT SUM(type) FROM `reviews` WHERE reviews.`stock_id`=stock.`stock_id`) as rating', 'stock.created_at'];
        $ret = Stock::find()
            ->select($select)
            ->where(['status' => 'endet'])
            ->innerJoin('company com', 'com.company_id=stock.company_id')
            ->innerJoin('stock_category stk', 'stk.`stock_id`=stock.`stock_id`')
            ->andWhere(['stock.company_id' => Yii::$app->user->identity->company_id])
            ->asArray()
            ->orderBy('moder_rating , tarif desc , rating desc')
            ->all();
        return $this->render('../site/index', ['page' => 'stock', 'action' => 'index', 'ret' => $ret]);
    }

    public function actionArhive()
    {
        $select = [
            'stock.stock_id',
            'description',
            'tarif',
            'com.name',
            'com.url as logo',
            'photo',
            'status',
            'banner',
            'start_date as start',
            'end_date as end',
            'moder_rating',
            '(SELECT SUM(type) FROM `reviews` WHERE reviews.`stock_id`=stock.`stock_id`) as rating', 'stock.created_at'];
        $ret = Stock::find()
            ->select($select)
            ->where(['status' => 'arhive'])
            ->innerJoin('company com', 'com.company_id=stock.company_id')
            ->innerJoin('stock_category stk', 'stk.`stock_id`=stock.`stock_id`')
            ->andWhere(['stock.company_id' => Yii::$app->user->identity->company_id])
            ->asArray()
            ->orderBy('moder_rating , tarif desc , rating desc')
            ->all();
        return $this->render('../site/index', ['page' => 'stock', 'action' => 'index', 'ret' => $ret]);
    }

    public function actionEdit($id)
    {
        if ($stock = Stock::findOne($id)) {
            return $this->render('../site/index', ['page' => 'stock', 'action' => $this->action->id, 'stock' => $stock]);
        }
        return $this->render('../site/index', ['page' => 'stock', 'action' => $this->action->id]);
    }

    public function actionAdd()
    {
        if ($stock = new StockModel()) {
            if ($stock->load(Yii::$app->request->post())) {
                $stock->saveToBase(Company::findOne(Yii::$app->user->identity->company_id));
            }
            return $this->redirect('/');
        }
    }

    public function actionUpdate()
    {
        if ($stock = new StockModel()) {
            if ($stock->load(Yii::$app->request->post())) {
                if (Yii::$app->user->identity->role == 'partner') {
                    $stock->updateToBase();
                } elseif (Yii::$app->user->identity->role == 'admin' || Yii::$app->user->identity->role == 'super-admin') {
                    $stock->AdminUpdateToBase();
                }
            }
            return $this->redirect('/');
        }
    }

    public function actionNew()
    {
        $affiliates = \models\Affiliates::find()->where(['company_id' => Yii::$app->user->identity->company_id])->orderBy('main DESC')->all();

        return $this->render('../site/index', ['page' => 'stock', 'action' => $this->action->id, 'affiliates' => $affiliates]);
    }
}

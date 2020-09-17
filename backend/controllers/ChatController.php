<?php
namespace backend\controllers;

use models\Categories;
use models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;

/**
 * Site controller
 */
class ChatController extends Controller
{
    private $body;
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
                        'actions' => ['logout', 'index' , 'edit' , 'add' , 'list' , 'updatestat'],
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

    public function beforeAction($action)
    {
        if (Yii::$app->request->isPost) {
            if (!$this->body = Yii::$app->request->getBodyParams()) {
                return $this->afterAction($action, null);
            }
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex($id)
    {
        return $this->render('../site/index' , ['page' => 'users' , 'action' => 'chat' , 'page_id'=>$id]);
    }
}

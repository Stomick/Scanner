<?php

namespace backend\controllers;

use models\ChatRoom;
use models\ChatUserRoom;
use models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;

/**
 * Site controller
 */
class UsersController extends Controller
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
                        'actions' => ['logout', 'index', 'edit', 'add', 'delete', 'profile'],
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

    public function actionIndex()
    {
        return $this->render('../site/index', ['page' => 'users', 'action' => 'index']);
    }

    public function actionAdd()
    {
        $user = new User();
        if ($body = Yii::$app->request->getBodyParam('User')) {
            foreach ($body as $k => $v) {
                $user->$k = $v;
            }
            if (!User::findByEmail($user->email) && $user->save()) {
                return $this->redirect('/users');
            }
        }
        return $this->render('../site/index', ['page' => 'users', 'action' => 'add']);
    }

    public function actionEdit($id)
    {
        if ($user = User::findOne($id)) {
            return $this->render('../site/index', ['page' => 'users', 'action' => $this->action->id, 'user' => $user]);
        }
        return $this->render('../site/index', ['page' => 'users', 'action' => $this->action->id]);
    }

    public function actionProfile()
    {
        if ($user = User::findOne(Yii::$app->user->id)) {
            return $this->render('../site/index', ['page' => 'users', 'action' => $this->action->id, 'user' => $user]);
        }
        return $this->render('../site/index', ['page' => 'users', 'action' => $this->action->id]);
    }

    public function actionDelete($id)
    {
        if ($user = User::findOne($id)) {
            $user->delete();
        }
        return $this->redirect('/users');
    }


}

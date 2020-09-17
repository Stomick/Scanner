<?php
namespace backend\controllers;

use models\ChatRoom;
use models\ChatUserRoom;
use models\MUser;
use models\User;
use models\Vacancies;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;

/**
 * Site controller
 */
class MusersController extends Controller
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
                        'actions' => ['logout', 'index' , 'info' , 'add' , 'delete' , 'profile' , 'executer' , 'customer' , 'chat'],
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
        return $this->render('../site/index' , ['page' => 'users' , 'action' => 'index']);
    }

    public function actionExecuter()
    {
        $query = MUser::find()->where(['type' => 0])->andWhere('id!=1');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count() , 'pageSize' => 20]);
        $sort = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['firstname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По имени',
                ],
                'title' => [
                    'asc' => ['email' => SORT_ASC],
                    'desc' => ['email' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По email',
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
        return $this->render('../site/index' , [
            'page' => 'users' ,
            'action' => 'musers' ,
            'users' => $models,
            'pages' => $pages,
            'sort' => $sort]);
    }

    public function actionCustomer()
    {
        $query = MUser::find()->where(['type' => 1])->andWhere('id!=1');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count() , 'pageSize' => 20]);
        $sort = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['firstname' => SORT_ASC],
                    'desc' => ['firstname' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По имени',
                ],
                'title' => [
                    'asc' => ['email' => SORT_ASC],
                    'desc' => ['email' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По email',
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
        return $this->render('../site/index' , [
            'page' => 'users' ,
            'action' => 'musers' ,
            'users' => $models,
            'pages' => $pages,
            'sort' => $sort]);
    }

    public function actionInfo($id)
    {
        return $this->render('../site/index' , ['page' => 'users' , 'action' => $this->action->id , 'prof' => MUser::findOne($id)]);
    }
    public function actionChat($id = null)
    {
        if (!$room = ChatUserRoom::find()->innerJoin('chat_rooms cr' , 'chat_user_to_rooms.room_id=cr.room_id')->where(['cr.type'=>'system' , 'type_id'=>$id, 'chat_user_to_rooms.user_id'=>$id])->one()) {
            $room = new ChatRoom();
            $room->type = 'system';
            $room->type_id = $id;
            if ($room->save()) {
                $us1 = new ChatUserRoom();
                $us1->user_id = $id;
                $us1->room_id = $room->room_id;
                $us1->save();
                $us1 = new ChatUserRoom();
                $us1->user_id = 1;
                $us1->room_id = $room->room_id;
                $us1->save();
            }

        }
        return $this->render('../site/index', ['page' => 'users', 'action' => $this->action->id , 'info' => MUser::findOne($id) , 'page_id'=> $room->room_id]);
    }
}

<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\ChatMessages;
use models\ChatRoom;
use models\ChatUserRoom;
use models\Specialties;
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
class MessagesController extends Controller
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

    public function actionIndex($type = null)
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect('/');
        }
        $where = ['chutr.user_id' => Yii::$app->user->id];
        switch ($type){
            case 'vacancies':
                $where['chr.type'] = 'vacancies';
                break;
            case 'specialties':
                $where['chr.type'] = 'specialties';
                break;
            case 'system':
                $where['chr.type'] = 'system';
                break;
            case 'users':
            default:
        }
        $query = ChatUserRoom::find()
            ->from('chat_user_to_rooms chutr')
            ->select([
                'DISTINCT (`chutr`.`room_id`)',
                'chr.type',
                'chr.type_id',
                'user2.id as userId' ,
                'chmtr.text', 'chmtr.date', 'chmtr.id as mid' , 'CONCAT(musers.firstname , " " , musers.lastname) as name',
             'musers.logo',
             '(SELECT count(message_id) FROM chat_message_to_rooms WHERE room_id=chutr.room_id AND status=0 AND id !='.Yii::$app->user->id.') as newmess'
            ])
            ->innerJoin('chat_rooms as chr' , 'chr.room_id=chutr.room_id')
            ->innerJoin('chat_message_to_rooms chmtr' , 'chmtr.room_id=chutr.room_id AND chmtr.message_id=(SELECT max(message_id) FROM chat_message_to_rooms WHERE chat_message_to_rooms.room_id=chutr.room_id)')
            ->innerJoin('musers' , 'musers.id=chmtr.id')
            ->innerJoin('musers user2' , 'user2.id=(SELECT chat_user_to_rooms.user_id FROM chat_user_to_rooms WHERE chat_user_to_rooms.room_id=chutr.room_id AND chat_user_to_rooms.user_id!=3 LIMIT 0,1)')
            ->where($where);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count() , 'pageSize' => 20]);
        $sort = new Sort([
            'attributes' => [
                'date' => [
                    'asc' => ['chmtr.date' => SORT_ASC],
                    'desc' => ['chmtr.date' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По дате',
                ],
                'type' => [
                    'asc' => ['chr.type' => SORT_ASC],
                    'desc' => ['chr.type' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По типу',
                ],
                'new' => [
                    'asc' => ['newmess' => SORT_ASC],
                    'desc' => ['newmess' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По кол-ву новых',
                ],
            ],
        ]);
        $mess = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy($sort->orders)
            ->asArray()
            ->all();
        return $this->render('index' , ['messages' => $mess,'pages' => $pages,
            'sort' => $sort]);
    }

    public function actionDiscussion()
    {
        return $this->render('discussion');
    }

}

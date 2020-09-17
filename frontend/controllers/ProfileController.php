<?php

namespace frontend\controllers;

use backend\components\UploadImage;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\ChatMessages;
use models\ChatRoom;
use models\ChatUserRoom;
use models\MUser;
use models\Photos;
use models\Reviews;
use models\Specialties;
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
class ProfileController extends Controller
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
                        'actions' => ['signup', 'index', 'update', 'upload', 'reviews'],
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
        if ($user = MUser::findOne(Yii::$app->user->id)) {
            return $this->render('index', ['prof' => $user, 'page' => 'personal', 'li' => [
                [
                    'href' => '/profile.html',
                    'active' => true,
                    'title' => 'Личные данные'
                ], [
                    'href' => !$user->type ? '/profile/specialties.html' : '/profile/vacancies.html',
                    'active' => false,
                    'title' => !$user->type ? 'Специальности' : 'Вакансии',
                ], [
                    'href' => '/profile/arhive.html',
                    'active' => false,
                    'title' => 'Архив'
                ], [
                    'href' => '/profile/about.html',
                    'active' => false,
                    'title' => 'О себе'
                ]
            ]]);
        }
        return $this->redirect('/');
    }

    public function actionAbout()
    {
        if ($user = MUser::findOne(Yii::$app->user->id)) {
            return $this->render('index', ['prof' => $user, 'page' => 'about', 'li' => [
                [
                    'href' => '/profile.html',
                    'active' => false,
                    'title' => 'Личные данные'
                ], [
                    'href' => !$user->type ? '/profile/specialties.html' : '/profile/vacancies.html',
                    'active' => false,
                    'title' => !$user->type ? 'Специальности' : 'Вакансии',
                ], [
                    'href' => '/profile/arhive.html',
                    'active' => false,
                    'title' => 'Архив'
                ], [
                    'href' => '/profile/about.html',
                    'active' => true,
                    'title' => 'О себе'
                ]
            ]]);
        }
        return $this->redirect('/');
    }

    public function actionSpecialties($id=null)
    {
        if ($id) {
            $id = str_replace('ID', '', $id);
            $user = MUser::findOne($id);
            return $this->render('index', ['prof' => $user, 'page' => 'spec', 'spec' => Specialties::findAll(['muser_id' => $user->id,'tmp'=>0,'arhive'=>0]),
                'li' => [
                    [
                        'href' => "/profile/info/ID$id.html",
                        'active' => false,
                        'title' => 'Личные данные'
                    ], [
                        'href' => !$user->type ? "/profile/specialties/ID$id.html" : "/profile/vacancies/ID$id.html",
                        'active' => true,
                        'title' => !$user->type ? 'Специальности' : 'Вакансии',
                    ]
                ]
            ]);
        } elseif (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->id;
            $user = MUser::findOne($id);
            return $this->render('my', ['prof' => $user, 'page' => 'myspec', 'spec' => Specialties::findAll(['muser_id' => $user->id,'tmp'=>0,'arhive'=>0]),
                'li' => [
                    [
                        'href' => '/profile.html',
                        'active' => false,
                        'title' => 'Личные данные'
                    ], [
                        'href' => !$user->type ? '/profile/specialties.html' : '/profile/vacancies.html',
                        'active' => true,
                        'title' => !$user->type ? 'Специальности' : 'Вакансии',
                    ], [
                        'href' => '/profile/arhive.html',
                        'active' => false,
                        'title' => 'Архив'
                    ], [
                        'href' => '/profile/about.html',
                        'active' => false,
                        'title' => 'О себе'
                    ]
                ]
            ]);
        } else {
            return $this->redirect('/');
        }
    }

    public function actionVacancies($id = null)
    {
        if ($id) {
            $id = str_replace('ID', '', $id);
            $user = MUser::findOne($id);
            return $this->render('index', ['prof' => $user, 'page' => 'vacans', 'vacans' => Vacancies::find()->where(['muser_id' => $user->id,'tmp'=>0,'arhive'=>0])->all(),
                'li' => [
                    [
                        'href' => "/profile/info/ID$id.html",
                        'active' => false,
                        'title' => 'Личные данные'
                    ], [
                        'href' => !$user->type ? "/profile/specialties/ID$id.html" : "/profile/vacancies/ID$id.html",
                        'active' => true,
                        'title' => !$user->type ? 'Специальности' : 'Вакансии',
                    ]
                ]
            ]);
        } elseif (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->id;
            $user = MUser::findOne($id);
            return $this->render('my', ['prof' => $user, 'page' => 'myvacans', 'vacans' => Vacancies::find()->where(['muser_id' => $id,'tmp'=>0,'arhive'=>0])->all(),
                'li' => [
                    [
                        'href' => '/profile.html',
                        'active' => false,
                        'title' => 'Личные данные'
                    ], [
                        'href' => !$user->type ? '/profile/specialties.html' : '/profile/vacancies.html',
                        'active' => true,
                        'title' => !$user->type ? 'Специальности' : 'Вакансии',
                    ], [
                        'href' => '/profile/arhive.html',
                        'active' => false,
                        'title' => 'Архив'
                    ], [
                        'href' => '/profile/about.html',
                        'active' => false,
                        'title' => 'О себе'
                    ]
                ]
            ]);
        } else {
            return $this->redirect('/');
        }
    }

    public function actionArhive(){
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->id;
            $user = MUser::findOne($id);
            return $this->render('my', ['prof' => $user, 'page' => 'arhive',
                'title' => !$user->type ? 'Специальности' : 'Вакансии',
                'vacans' => $user->type ? Vacancies::find()->where(['muser_id' => $id,'tmp'=>0,'arhive'=> 1])->all() : Specialties::find()->where(['muser_id' => $id,'tmp'=>0 , 'arhive'=> 1])->all(),
                'li' => [
                    [
                        'href' => '/profile.html',
                        'active' => false,
                        'title' => 'Личные данные'
                    ], [
                        'href' => !$user->type ? '/profile/specialties.html' : '/profile/vacancies.html',
                        'active' => false,
                        'title' => !$user->type ? 'Специальности' : 'Вакансии',
                    ], [
                        'href' => '/profile/arhive.html',
                        'active' => true,
                        'title' => 'Архив'
                    ], [
                        'href' => '/profile/about.html',
                        'active' => false,
                        'title' => 'О себе'
                    ]
                ]
            ]);
        } else {
            return $this->redirect('/');
        }
    }

    public function actionInfo($id)
    {
        $id = str_replace('ID', '', $id);
        if ($user = MUser::findOne($id)) {
            $photo = Photos::findOne(['type' => 'logo', 'type_id' => $user->id]);
            $tag = [[
                'name' => 'description',
                'content' => $user->description
            ], [
                'name' => 'og:title',
                'content' => $user->firstname . ' ' . $user->lastname
            ], [
                'name' => 'og:type',
                'content' => 'profile'
            ], [
                'name' => 'og:url',
                'content' => 'https://jobscanner.online/profile/info/ID' . $user->id . '.html'
            ], [
                'name' => 'og:site_name',
                'content' => 'JobScanner'
            ], [
                'name' => 'og:image',
                'content' => $photo ? 'https://jobscanner.online/' . $photo->url : null
            ]];
            foreach ($tag as $t) {
                \Yii::$app->view->registerMetaTag($t);
            }

            if (!\Yii::$app->user->isGuest && !Yii::$app->user->identity->type) {
                $ret = Specialties::find()->where(['muser_id' => $user->id])->andWhere(['tmp'=>0])->asArray();
            } else {
                $ret = Vacancies::find()->where(['muser_id' => $user->id])->andWhere(['tmp'=>0])->asArray();
            }

            return $this->render('info', ['prof' => $user, 'ret' => $ret]);
        }
        return $this->redirect('/');
    }

    public function actionStatus()
    {
        $body = Yii::$app->request->getBodyParams();
        if ($user = MUser::findOne(Yii::$app->user->id)) {
            if (isset($body['proftype'])) {
                $user->type = intval($body['proftype']) ? 1 : 0;
            }
            if (isset($body['profstatus']) && $body['profstatus'] == 'on') {
                $user->public = 1;
            } else {
                $user->public = 0;
            }
            $user->update();
        }

        return $this->redirect('/');
    }

    public function actionReviews($id = null)
    {
        if (Yii::$app->user->isGuest && $id == null) {
            return $this->redirect('/');
        }
        $id = str_replace('ID', '', $id);
        if (Yii::$app->request->post()) {
            $rev = Yii::$app->request->getBodyParam('rev');
            if (!isset($rev['answer'])) {
                if (!$review = Reviews::findOne(['user_to' => $id, 'user_from' => Yii::$app->user->id])) {
                    $review = new Reviews();
                }
                $review->text = strip_tags($rev['text']);
                $review->rating = (int)$rev['rating'];
                $review->user_from = Yii::$app->user->id;
                $review->user_to = (int)$id;
                if ($review->save()) {
                    return $this->redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                if ($ans = Reviews::findOne($rev['answer'])) {
                    if (!$review = Reviews::findOne(['user_to' => $ans->user_from, 'user_from' => Yii::$app->user->id, 'answer' => $ans->id])) {
                        $review = new Reviews();
                    }
                    $review->text = strip_tags($rev['text']);
                    $review->rating = 0;
                    $review->answer = $ans->id;
                    $review->user_to = $ans->user_from;
                    $review->user_from = Yii::$app->user->id;
                    if ($review->save()) {
                        return $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }
        }
        $where = 1;
        if(\Yii::$app->user->isGuest){
            $where = 'user_from!=' . $id;
            $type = 'employer';
            if(!$user = MUser::findOne($id)) {
                return $this->redirect('/');
            }
        }else {
            if ($id== null && $id=!Yii::$app->user->id) {
                $type = Yii::$app->user->identity->type ? 'employer' : 'worker';
            } else {
                if($user = MUser::findOne($id)) {
                    $type = $user->type ? 'employer' : 'worker';
                }else{
                    return $this->redirect('/');
                }
            }
        }

        $query = Reviews::find()->where(['user_to' => $id ? $id : Yii::$app->user->id, 'answer' => 0, 'type' => $type])->andWhere($where);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $sort = new Sort([
            'attributes' => [
                'created' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По дате',
                ],
                'title' => [
                    'asc' => ['rating' => SORT_ASC],
                    'desc' => ['rating' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По рейтингу',
                ],
            ],
        ]);

        $models = [];
        if ($id && !Yii::$app->user->isGuest) {
            if ($r = Reviews::find()->where(['user_to' => $id, 'answer' => 0, 'type' => $type])->andWhere('user_from=' . Yii::$app->user->id)->one()) {
                $models[0] = $r;
            }
        }
        foreach ($query->offset($pages->offset)
                     ->limit($pages->limit)
                     ->orderBy($sort->orders)
                     ->all() as $k => $r) {
            $models[$k + 1] = $r;
        }
        return $this->render('../reviews/index', [
            'reviews' => $models,
            'user' => MUser::findOne($id ? $id : Yii::$app->user->id),
            'rating' => Reviews::getRating($id ? $id : Yii::$app->user->id, Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->type),
            'sumrating' => Reviews::getSumRating($id ? $id : Yii::$app->user->id, Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->type),
            'pages' => $pages,
            'sort' => $sort
        ]);
    }


    public function actionUpdate()
    {
        if ($user = MUser::findOne(Yii::$app->user->id)) {
            $body = Yii::$app->request->getBodyParam('Prof');
            foreach ($body as $k => $v) {
                if ($k != 'password') {
                    $user->$k = strip_tags(trim($v));
                }
            }
            $user->update();
            if ($photo = Yii::$app->request->getBodyParam('Photos')) {
                for ($i = 0; $i < 12; $i++) {
                    if ($i == count($photo)) {
                        break;
                    }/*
                    if ($img = UploadImage::save_image($photo[$i], rand(0, strtotime('now')), $_SERVER['DOCUMENT_ROOT'] . $dir)) {
                        $ph = new Photos();
                        $ph->type = 'profile';
                        $ph->type_id = $user->id;
                        $ph->url = $dir . $img;
                        $ph->user_id = $user->id;
                        $ph->save();
                    }*/
                };
            }
            return $this->redirect('/profile.html');
        }
        return $this->redirect('/');
    }

    public function actionUpload()
    {
        if ($user = MUser::findOne(Yii::$app->user->id)) {
            $dir = "/img/users/" . str_replace(['@', '.'], '_', $user->id . '/');
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                if (!mkdir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                    return null;
                }

            }
            $target_file = $dir . basename($_FILES["file"]["name"], true);
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                $ph = new Photos();
                $ph->type = 'profile';
                $ph->type_id = $user->id;
                $ph->user_id = $user->id;
                $ph->url = $target_file;
                $ph->save();
                $msg = json_encode(['id' => $ph->id]);
            } else {
                $msg = "Error while uploading";
            }
            echo $msg;
            exit;

        }
    }

    public function actionAnswers()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/');
        }
        $mess = [];
        $query = Yii::$app->user->identity->type ? Yii::$app->user->identity->getTakeAnswers() : Yii::$app->user->identity->getSendAnswers();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
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

        return $this->render('../messages/answers', ['messages' => $mess, 'pages' => $pages,
            'sort' => $sort]);
    }

    public function actionMessages()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/');
        }
        $mess = [];
        $query = !Yii::$app->user->identity->type ? Yii::$app->user->identity->getTakeAnswers('specialties') : Yii::$app->user->identity->getSendAnswers();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
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
        return $this->render('../messages/messages', ['messages' => $mess, 'pages' => $pages,
            'sort' => $sort]);
    }

    public function actionGetupload()
    {
        if ($user = MUser::findOne(Yii::$app->user->id)) {
            $dir = "/img/users/" . Yii::$app->user->identity->id . '/';
            $file_list = [];

            if ($photos = Photos::findAll(['type' => 'profile', 'type_id' => $user->id])) {
                foreach ($photos as $k => $ph) {
                    // File path
                    $file_path = $_SERVER['DOCUMENT_ROOT'] . $ph->url;
                    // Check its not folder
                    if (!is_dir($file_path)) {
                        $size = filesize($file_path);
                        array_push($file_list, array('name' => str_replace($dir, '', $ph->url), 'size' => $size, 'path' => $ph->url));
                    }
                }
            }

            echo json_encode($file_list);
            exit;
        }
    }

    public function actionSystem()
    {
        if (Yii::$app->user->id) {
            $id = Yii::$app->user->id;
            if (!$chatRoom = ChatRoom::findOne(['type' => 'system', 'type_id' => $id])) {
                $chatRoom = new ChatRoom();
                $chatRoom->type = 'system';
                $chatRoom->type_id = $id;
            }
            if ($chatRoom->save()) {
                $us1 = new ChatUserRoom();
                $us1->user_id = $id;
                $us1->room_id = $chatRoom->room_id;
                $us1->save();
                $us1 = new ChatUserRoom();
                $us1->user_id = 1;
                $us1->room_id = $chatRoom->room_id;
                $us1->save();
            }
            return $this->render('/messages/system', ['type' => 'Системные сообщения', 'page_id' => $chatRoom->room_id]);

        }
        return $this->redirect('/');
    }

    public function actionDelupload($file)
    {
        $img = "/img/users/" . Yii::$app->user->identity->id . '/' . $file;
        if ($photo = Photos::findOne(['user_id' => Yii::$app->user->id, 'url' => $img])) {
            $photo->delete();
        }
        if ($photo = Photos::findOne(['user_id' => Yii::$app->user->id, ['like', ['url' => urldecode($file)]]])) {
            $photo->delete();
        }
        die();
    }

    static public function cyrillicToLatin($text, $toLowCase)
    {
        $dictionary = array(
            'й' => 'i',
            'ц' => 'c',
            'у' => 'u',
            'к' => 'k',
            'е' => 'e',
            'н' => 'n',
            'г' => 'g',
            'ш' => 'sh',
            'щ' => 'shch',
            'з' => 'z',
            'х' => 'h',
            'ъ' => '',
            'ф' => 'f',
            'ы' => 'y',
            'в' => 'v',
            'а' => 'a',
            'п' => 'p',
            'р' => 'r',
            'о' => 'o',
            'л' => 'l',
            'д' => 'd',
            'ж' => 'zh',
            'э' => 'e',
            'ё' => 'e',
            'я' => 'ya',
            'ч' => 'ch',
            'с' => 's',
            'м' => 'm',
            'и' => 'i',
            'т' => 't',
            'ь' => '',
            'б' => 'b',
            'ю' => 'yu',

            'Й' => 'I',
            'Ц' => 'C',
            'У' => 'U',
            'К' => 'K',
            'Е' => 'E',
            'Н' => 'N',
            'Г' => 'G',
            'Ш' => 'SH',
            'Щ' => 'SHCH',
            'З' => 'Z',
            'Х' => 'X',
            'Ъ' => '',
            'Ф' => 'F',
            'Ы' => 'Y',
            'В' => 'V',
            'А' => 'A',
            'П' => 'P',
            'Р' => 'R',
            'О' => 'O',
            'Л' => 'L',
            'Д' => 'D',
            'Ж' => 'ZH',
            'Э' => 'E',
            'Ё' => 'E',
            'Я' => 'YA',
            'Ч' => 'CH',
            'С' => 'S',
            'М' => 'M',
            'И' => 'I',
            'Т' => 'T',
            'Ь' => '',
            'Б' => 'B',
            'Ю' => 'YU',

            '\-' => '-',
            '\s' => '-',

            '[^a-zA-Z0-9\-\_\.]' => '',

            '[-]{2,}' => '-',
        );

        foreach ($dictionary as $from => $to) {
            $text = mb_ereg_replace($from, $to, $text);
        }
        if ($toLowCase) {
            $text = mb_strtolower($text, Yii::$app->charset);
        }

        return trim($text, '-');
    }

    public function actionActivation($key = null)
    {
        if ($us = MUser::findOne(['verification_token' => $key])) {
            $us->status = 10;
            $us->update();
            if (Yii::$app->user->login($us, 3600 * 24 * 30)) {
                return $this->redirect('/profile.html');
            }
        } else {
            return $this->redirect('/');
        }
    }
}

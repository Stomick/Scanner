<?php

namespace frontend\controllers;

use backend\components\UploadImage;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\Categories;
use models\ChatMessages;
use models\ChatRoom;
use models\ChatUserRoom;
use models\MUser;
use models\Photos;
use models\Reviews;
use models\Specialties;
use models\ViewsSpec;
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
class SpecialtiesController extends Controller
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
                        'actions' => ['signup','list'],
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
    public function actionAll($id = null)
    {
        $id = str_replace('ID', '', $id);
        $specialties = [];
        $query = Specialties::find()->where(['muser_id' => $id ? $id : Yii::$app->user->id, 'arhive' => 0,'tmp'=>0]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);

        $sort = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По цене',
                ],
                'title' => [
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По названию',
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
        return $this->render('index', [
            'specialties' => $models,
            'pages' => $pages,
            'sort' => $sort
        ]);
    }

    public function actionArhive()
    {
        $specialties = [];
        $query = Specialties::find()->where(['muser_id' => Yii::$app->user->id, 'arhive' => 1,'tmp'=>0]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);

        $sort = new Sort([
            'attributes' => [
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По цене',
                ],
                'title' => [
                    'asc' => ['title' => SORT_ASC],
                    'desc' => ['title' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'По названию',
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
        return $this->render('arhive', [
            'specialties' => $models,
            'pages' => $pages,
            'sort' => $sort
        ]);
    }

    public function actionChat($id)
    {

        if(strpos ($id,'ID') !== false) {
            $id = str_replace('ID', '', $id);
            if (Yii::$app->user->id) {
                $spec = Specialties::findOne($id);
                if (!$room = ChatRoom::find()
                    ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chat_rooms.room_id AND cutr.user_id=' . $spec->muser_id)
                    ->innerJoin('chat_user_to_rooms cutr2', 'cutr2.room_id=chat_rooms.room_id AND cutr2.user_id=' . Yii::$app->user->id)
                    ->where(['chat_rooms.type' => 'specialties', 'chat_rooms.type_id' => $id])->one()) {
                    $room = new ChatRoom();
                    $room->type = 'specialties';
                    $room->type_id = $id;
                    if ($room->save()) {
                        $us1 = new ChatUserRoom();
                        $us1->user_id = Yii::$app->user->id;
                        $us1->room_id = $room->room_id;
                        $us1->save();
                        $us1 = new ChatUserRoom();
                        $us1->user_id = $spec->muser_id;
                        $us1->room_id = $room->room_id;
                        $us1->save();
                    }

                }
                $mess = '';
                if(!ChatMessages::find()->where(['room_id'=>$room->room_id])->count()){
                    $mess = 'Добрый день! У нас есть работа, которая могла бы Вас заинтересовать. Вы рассматриваете предложения о работе по специальности "' .
                    $spec->title . '"';
                }
                return $this->render('/messages/discussion', ['info' => $spec, 'type' => 'Специальность', 'page_id' => $room->room_id ,
                    'message' => $mess
                ]);
            }
        }elseif (strpos ($id,'CHAT') == 0) {
            $id = str_replace('CHAT', '', $id);
            if (Yii::$app->user->id) {
                $mess = '';
                if ($room = ChatRoom::find()
                    ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chat_rooms.room_id AND cutr.user_id!=' . Yii::$app->user->id)
                    ->where(['chat_rooms.room_id' => $id])->one()) {
                    $spec = Specialties::findOne($room->type_id);
                    return $this->render('/messages/discussion', ['info' => $spec , 'type' => 'Специальность', 'page_id' => $room->room_id,'message' => $mess]);
                }
            }
        }
        return $this->redirect('/');
    }

    public function actionAdd()
    {
        $us = Yii::$app->user->identity;
        if (!$us->phone || !$us->address || !$us->logo) {
            Yii::$app->session->setFlash('success', 'Перед созданием специальности, необходимо заполнить все поля в профиле');
            return $this->redirect('/profile.html');
        }

        if ($vacBody = Yii::$app->request->getBodyParam('Spec')) {
            if (isset($vacBody['id'])) {
                if (!$vac = Specialties::findOne(['id' => $vacBody['id'], 'muser_id' => Yii::$app->user->id])) {
                    return $this->redirect('/specialties/all.html');
                }
            } else {
                $vac = new Specialties();
                $vac->muser_id = Yii::$app->user->id;

            }
            foreach ($vac as $k => $v) {
                if (isset($vacBody[$k])) {
                    if ($k == 'team' || $k == 'public') {
                        $vac->$k = ($vacBody[$k] == 'on' ? 1 : 0);
                    } else {
                        $vac->$k = trim(strip_tags($vacBody[$k]));
                    }
                }
            }
            if (!isset($vacBody['public'])) {
                $vac->public = 0;
            }
            if (!isset($vacBody['team'])) {
                $vac->team = 0;
            }

            if ($vac->save()) {
                if (isset($vacBody['toGalery'])) {
                    return $this->redirect('/specialties/edit/ID' . $vac->id . '.html');
                } else {
                    return $this->redirect('/profile/specialties.html');
                }
            } else {
                return $this->redirect('/profile/specialties.html');
            }
        }else {
            if ($us->balance <= 10 && ($us->getCountSpec() + $us->getCountVacansies()) > 3) {
                Yii::$app->session->setFlash('success', 'Для создания дополнительной специальности, пожалуйста, пополните баланс!');
                return $this->redirect('/profile/specialties.html');
            }
            $spec = new Specialties();
            $spec->muser_id = Yii::$app->user->id;
            if ($spec->save()) {
                return $this->render('edit', ['vac' => $spec]);
            }
        }
        return $this->redirect('/specialties/all.html');
    }

    public function actionEdit($id)
    {
        $id = str_replace('ID', '', $id);
        $us = Yii::$app->user->identity;
        if (!$us->phone || !$us->address || !$us->logo) {
            Yii::$app->session->setFlash('success', 'Перед созданием вакансии, необходимо заполнить все поля в профиле');
            return $this->redirect('/profile.html');
        }
        if ($vac = Specialties::findOne(['id' => $id, 'muser_id' => Yii::$app->user->id]))
            return $this->render('edit', ['vac' => $vac]);
    }

    public function actionGallery($id)
    {
        $id = str_replace('ID', '', $id);
        return $this->render('gallery', ['vacId' => $id]);
    }

    public function actionInarhive($id)
    {
        $id = str_replace('ID', '', $id);
        if ($sp = Specialties::findOne(['id' => $id, 'muser_id' => Yii::$app->user->id])) {
            $sp->arhive = ($sp->arhive ? 0 : 1);
            $sp->public = 0;
            if ($sp->update()) {
                !$sp->arhive ? \Yii::$app->session->setFlash('success', 'Объявление восстановлено.') : \Yii::$app->session->setFlash('success', 'Объявление снято с публикации.');
                return $this->redirect('/profile/arhive.html');
            }
        }
        return $this->redirect('/profile/specialties.html');
    }

    public function actionInfo($id = null)
    {
        $id = str_replace('ID', '', $id);
        if ($id != null) {
            $spec = Specialties::findOne($id);
            $user = Photos::findOne(['type' => 'logo', 'type_id' => $spec->muser_id]);
            $tag = [[
                'name' => 'description',
                'content' => $spec->description
            ], [
                'name' => 'og:title',
                'content' => $spec->title
            ], [
                'name' => 'og:type',
                'content' => 'work'
            ], [
                'name' => 'og:url',
                'content' => 'https://jobscanner.online/specialties/info/ID' . $spec->id . '.html'
            ], [
                'name' => 'og:site_name',
                'content' => 'JobScanner'
            ], [
                'name' => 'og:image',
                'content' => $user ? 'https://jobscanner.online/' . $user->url : null
            ]];
            foreach ($tag as $t) {
                \Yii::$app->view->registerMetaTag($t);
            }
            $long = ip2long(Yii::$app->getRequest()->getUserIP());
            if ($vis = ViewsSpec::find()->where(['ip' => $long, 'spec_id' => $id])->andWhere(
                'created_at > ' . strtotime(date("Y-m-d"))
                . " AND created_at < " . strtotime(date("Y-m-d") . 1 . " day"))
                ->one()) {
                $vis->updated_at = 0;
                $vis->update(false);
            } else {
                if ($spec->muser_id != Yii::$app->user->id) {
                    $vis = new ViewsSpec();
                    $vis->ip = $long;
                    $vis->spec_id = $id;
                    $vis->save();
                }
            }
            return $this->render('info', ['vac' => $spec]);
        }
        return $this->redirect('/');
    }

    public function actionReviews($id = null)
    {
        $id = str_replace('ID', '', $id);
        if ($id != null) {
            return $this->render('reviews', ['vac' => Specialties::findOne($id)]);
        }
        return $this->redirect('/');
    }

    public function actionUpload($id)
    {
        $id = str_replace('ID', '', $id);
        if ($vac = Specialties::findOne(['id' => $id, 'muser_id' => Yii::$app->user->id])) {
            $dir = "/img/users/" . str_replace(['@', '.'], '_', Yii::$app->user->identity->id) . '/';
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                if (!mkdir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                    return null;
                }

            }

            //$dir = $dir . self::cyrillicToLatin($vac->title, true);
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                if (!mkdir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                    return null;
                }

            }
            $target_file = $dir . basename($_FILES["file"]["name"], true);
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                $ph = new Photos();
                $ph->type = 'Specialties';
                $ph->type_id = $vac->id;
                $ph->user_id = Yii::$app->user->id;
                $ph->url = $target_file;
                $ph->save();
                $msg = "Successfully uploaded";
            } else {
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                $msg = "Слишком большой размер фото";
            }
            echo $msg;
            exit;

        }
    }

    public function actionGetupload()
    {
        if ($vac = Specialties::findOne(['id' => Yii::$app->request->getBodyParam('id'), 'muser_id' => Yii::$app->user->id])) {
            $dir = "/img/users/" . str_replace(['@', '.'], '_', Yii::$app->user->identity->id . '/');
            $file_list = [];

            if ($photos = Photos::findAll(['type' => 'specialties', 'type_id' => $vac->id])) {
                foreach ($photos as $k => $ph) {
                    // File path
                    $file_path = $_SERVER['DOCUMENT_ROOT'] . $ph->url;
                    // Check its not folder
                    try {
                        if (!is_dir($file_path)) {
                            //$size = filesize($file_path);
                            array_push($file_list, array('name' => str_replace($dir, '', $ph->url), 'size' => 5000, 'path' => $ph->url));
                        }
                    }catch (\Exception $e){
                        var_dump($e->getMessage());
                    }
                }
            }

            echo json_encode($file_list);
            exit;
        }
    }

    public function actionDelupload($file)
    {
        $img = "/img/users/" . str_replace(['@', '.'], '_', Yii::$app->user->identity->id) . "/specialties/" . $file;
        if ($photo = Photos::findOne(['user_id' => Yii::$app->user->id, 'url' => $file])) {
            $photo->delete();
        }
        var_dump($img);
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

    function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return $kilometers;
    }

    public function actionList()
    {
        $param = Yii::$app->request->getBodyParams();
        $vac = [];
        $idv = [];
        $type = [
            'hour' => '/ час',
            'day' => '/ день',
            'month' => '/ месяц',
            'piecework' => 'Договорная'
        ];
        $curr = [
            'RUB' => "₽",
            'EUR' => "€",
            'USD' => "$"
        ];

        if (isset($param['lat']) && isset($param['lng']) && isset($param['z'])) {
            $where = '1';
            if (isset($param['f']) && is_array($param['f'])) {
                foreach ($param['f'] as $k => $v) {
                    if ($v['value'] != '') {

                        switch ($v['name']) {
                            case 'speccat':
                                $where .= ' AND specialties.category_id=' . $v['value'];
                                break;
                            case 'price[min]':
                                if (intval($v['value']) != 0) {
                                    $where .= ' AND specialties.price >=' . $v['value'];
                                }
                                break;
                            case 'price[max]':
                                if (intval($v['value']) != 0) {
                                    $where .= ' AND specialties.price <=' . ((int)$v['value'] + 1);
                                }
                                break;
                            case 'speccur':
                                $where .= ' AND specialties.currency="' . $v['value'] . '"';
                                break;
                            case 'speccurtype':
                                $where .= ' AND specialties.type="' . $v['value'] . '"';
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
            if (isset($_SESSION['lat']) && isset($_SESSION['lng'])) {
                $_SESSION['km'] = $this->getDistanceBetweenPointsNew($param['lat'], $param['lng'], $_SESSION['lat'], $_SESSION['lng']);
            } else {
                $_SESSION['lat'] = $param['lat'];
                $_SESSION['lng'] = $param['lng'];
                $_SESSION['km'] = 25;
            }
            //"SELECT  FROM vacancies HAVING distance < 1000 ORDER BY distance";
            // if ($_SESSION['km'] >= 25) {
            $_SESSION['lat'] = $param['lat'];
            $_SESSION['lng'] = $param['lng'];
            $price = ['min' => 9999, 'max' => 0];
            foreach (Specialties::find()->select([
                'specialties.*',
                'musers.logo',
                '' .
                '(SELECT COUNT(ip) FROM `views_spec` WHERE spec_id=specialties.id) as cvid',
                '3956 * 2 * ASIN(SQRT(POWER(SIN((' . $param['lat'] . ' - abs(specialties.lat)) * pi()/180 / 2), 2)
                  + COS(' . $param['lat'] . ' * pi()/180 ) * COS(abs(specialties.lat) * pi()/180)
                  * POWER(SIN((' . $param['lng'] . ' - specialties.lot) * pi()/180 / 2), 2) )) as  distance'])
                         ->innerJoin('musers', 'musers.id=specialties.muser_id AND musers.public=1')
                         ->where($where)
                         ->andWhere(['arhive' => 0, 'specialties.public' => 1, 'tmp'=>0])
                         ->having('distance < 75')
                         ->orderBy('cvid DESC ,distance')
                         ->asArray()->all() as $k => $v) {
                $idv[$k] = 'vac' . $v['id'];
                $v['price'] = (int)$v['price'];
                if ($price['min'] >= (int)$v['price']) {
                    $price['min'] = (int)$v['price'];
                }
                if ($price['max'] <= (int)$v['price']) {
                    $price['max'] = (int)$v['price'];
                }
                $vac[$k] = [
                    "id" => $v['id'],
                    "title" => $v['title'],
                    "prof" => 'ID' . $v['muser_id'],
                    "price" => ($v['type'] == 'piecework' ? $type[$v['type']] : $v['price'] . ' ' . $curr[$v['currency']] . ' ' . $type[$v['type']]),
                    "description" => mb_substr(str_replace(["\n", "\r"], '', $v['description']), 0, 60) . '...',
                    "phone" => $v['phone'],
                    "lat" => $v['lat'],
                    "lot" => $v['lot'],
                    "marker" => $v['marker'] . '?v=' . $v['updated_at']
                ];
                $ph = MUser::find()->select('type, firstname, lastname, id, logo')->where(['id' => $v['muser_id']])->one();
                $vac[$k]['photo'] = $ph->logo;
                if (!Yii::$app->user->isGuest && Yii::$app->user->id !=$v['muser_id']) {
                    $vac[$k]['send'] = '<a style="margin-top: 5px; display: block;" href="/specialties/info/ID' . $v['id'] . '.html">Предложить работу</a>';
                }else{
                    $vac[$k]['send'] = '';
                }
                if (!Yii::$app->user->isGuest && Yii::$app->user->id != $v['muser_id']) {
                    if ($ch = ChatRoom::find()
                        ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chat_rooms.room_id AND cutr.user_id=' . $v['muser_id'])
                        ->innerJoin('chat_user_to_rooms cutr2', 'cutr2.room_id=chat_rooms.room_id AND cutr2.user_id=' . Yii::$app->user->id)
                        ->where(['chat_rooms.type' => 'specialties', 'chat_rooms.type_id' => $v['id']])->one()) {
                        $vac[$k]['send'] = '<a style="margin-top: 5px; display: block;" href="/specialties/chat/ID' . $v['id'] . '.html">См. переписку</a>';
                    }
                }
                $vac[$k]['name'] = $ph->lastname . ' ' . mb_substr($ph->firstname, 0, 1) . '.';
                $vac[$k]['rating'] = 20 * (int)$ph->myRating();
            }
            //}
        }
        header('Content-Type: application/json');
        return json_encode(['km' => $_SESSION['km'], 'id' => $idv, 'vac' => $vac, 'price' => $price]);
    }

}

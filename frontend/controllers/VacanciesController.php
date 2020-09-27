<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use models\ChatMessages;
use models\ChatRoom;
use models\ChatUserRoom;
use models\MUser;
use models\Photos;
use models\Vacancies;
use models\ViewsSpec;
use models\ViewsVac;
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
class VacanciesController extends Controller
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
        $query = Vacancies::find()->where(['muser_id' => $id ? $id : Yii::$app->user->id, 'arhive' => 0]);
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
            'vacancies' => $models,
            'pages' => $pages,
            'sort' => $sort
        ]);
    }

    public function actionArhive()
    {
        $query = Vacancies::find()->where(['muser_id' => Yii::$app->user->id, 'arhive' => 1]);
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
            'vacancies' => $models,
            'pages' => $pages,
            'sort' => $sort
        ]);
    }

    public function actionChat($id)
    {
        if(strpos ($id,'ID') !== false) {
            $id = str_replace('ID', '', $id);
            if (Yii::$app->user->id) {
                if ($vac = Vacancies::findOne($id)) {
                    if (!$room = ChatRoom::find()
                        ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chat_rooms.room_id AND cutr.user_id=' . $vac->muser_id)
                        ->innerJoin('chat_user_to_rooms cutr2', 'cutr2.room_id=chat_rooms.room_id AND cutr2.user_id=' . Yii::$app->user->id)
                        ->where(['chat_rooms.type' => 'vacancies', 'chat_rooms.type_id' => $id])->one()) {
                        $room = new ChatRoom();
                        $room->type = 'vacancies';
                        $room->type_id = $id;
                        if ($room->save()) {
                            $us1 = new ChatUserRoom();
                            $us1->user_id = Yii::$app->user->id;
                            $us1->room_id = $room->room_id;
                            $us1->save();
                            $us1 = new ChatUserRoom();
                            $us1->user_id = (Vacancies::findOne($id))->muser_id;
                            $us1->room_id = $room->room_id;
                            $us1->save();
                        }

                    }
                    $mess = '';
                    if(!ChatMessages::find()->where(['room_id'=>$room->room_id])->count()){
                        $mess = 'Добрый день, заинтересовала вакансия по специальности "' . $vac->title . '". Расскажите, пожалуйста подробнее о работе';
                    }
                    return $this->render('/messages/discussion', ['info' => $vac, 'type' => 'Вакансия', 'page_id' => $room->room_id,
                        'message'=> $mess
                        ]);
                }
            }
        }

        if(strpos ($id,'CHAT') == 0) {
            $id = str_replace('CHAT', '', $id);
            if (Yii::$app->user->id) {
                $mess = '';
                    if ($room = ChatRoom::find()
                        ->innerJoin('chat_user_to_rooms cutr2', 'cutr2.room_id=chat_rooms.room_id AND cutr2.user_id=' . Yii::$app->user->id)
                        ->where(['chat_rooms.room_id' => $id])->one()) {
                        $vac = Vacancies::findOne($room->type_id);
                    return $this->render('/messages/discussion', ['info' => $vac, 'type' => 'Вакансия', 'page_id' => $room->room_id,'message' => $mess]);
                }
            }
        }
        return  $this->redirect('/');

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
        $price = ['min' => 9999, 'max' => 0];

        if (isset($param['lat']) && isset($param['lng']) && isset($param['z'])) {
            $where = '1';
            if (isset($param['f']) && is_array($param['f'])) {
                foreach ($param['f'] as $k => $v) {
                    if ($v['value'] != '') {
                        switch ($v['name']) {
                            case 'speccat':
                                $where .= ' AND vacancies.category_id=' . $v['value'];
                                break;
                            case 'price[min]':
                                $where .= ' AND vacancies.price >=' . $v['value'];
                                break;
                            case 'price[max]':
                                $where .= ' AND vacancies.price <' . ((double)$v['value'] + 1);
                                break;
                            case 'speccur':
                                $where .= ' AND vacancies.currency="' . $v['value'] . '"';
                                break;
                            case 'speccurtype':
                                $where .= ' AND vacancies.type="' . $v['value'] . '"';
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
            foreach (Vacancies::find()->select([
                'vacancies.*',
                '(SELECT COUNT(ip) FROM `views_vac` WHERE vac_id=vacancies.id) as cvid',
                '3956 * 2 * ASIN(SQRT(POWER(SIN((' . $param['lat'] . ' - abs(lat)) * pi()/180 / 2), 2)
                  + COS(' . $param['lat'] . ' * pi()/180 ) * COS(abs(lat) * pi()/180)
                  * POWER(SIN((' . $param['lng'] . ' - lot) * pi()/180 / 2), 2) )) as  distance'])
                         ->innerJoin('musers', 'musers.id=vacancies.muser_id AND musers.public=1')
                         ->having('distance < 75')
                         ->where($where)
                         ->andWhere(['arhive' => 0, 'vacancies.public' => 1 , 'tmp'=>0])
                         ->orderBy('cvid DESC, distance')
                         ->asArray()->all() as $k => $v) {
                $idv[$k] = 'vac' . $v['id'];
                if ($price['min'] >= (int)$v['price']) {
                    $price['min'] = (int)$v['price'];
                }
                if ($price['max'] <= (int)$v['price']) {
                    $price['max'] = (int)$v['price'];
                }
                $size = getimagesize($_SERVER['DOCUMENT_ROOT'] . $v['marker']);
                $vac[$k] = [
                    "id" => $v['id'],
                    "prof" => 'ID' . $v['muser_id'],
                    "title" => $v['title'],
                    "price" => ($v['type'] == 'piecework' ? $type[$v['type']] : $v['price'] . ' ' . $curr[$v['currency']] . ' ' . $type[$v['type']]),
                    "description" => mb_substr(str_replace(["\n", "\r"], '', $v['description']), 0, 60) . '...',
                    "phone" => $v['phone'],
                    "lat" => $v['lat'],
                    "lot" => $v['lot'],
                    "marker" => $v['marker'] . '?v=' . $v['updated_at'],
                    "size" => ['width'=>$size[0],'height'=> $size[1]]
                ];
                $l0go = MUser::find()->select('comp_logo as url')->where(['id' => $v['muser_id']])->asArray()->all();
                if (!Yii::$app->user->isGuest && Yii::$app->user->id !=$v['muser_id']) {
                    $vac[$k]['send'] = '<a style="margin-top: 5px; display: block;" href="/vacancies/info/ID' . $v['id'] . '.html">Откликнуться</a>';
                }else{
                    $vac[$k]['send'] = '';
                }

                if (!Yii::$app->user->isGuest && Yii::$app->user->id != $v['muser_id']) {
                    if ($ch = ChatRoom::find()
                        ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chat_rooms.room_id AND cutr.user_id=' . $v['muser_id'])
                        ->innerJoin('chat_user_to_rooms cutr2', 'cutr2.room_id=chat_rooms.room_id AND cutr2.user_id=' . Yii::$app->user->id)
                        ->where(['chat_rooms.type' => 'vacancies', 'chat_rooms.type_id' => $v['id']])->one()) {
                        $vac[$k]['send'] = '<a style="margin-top: 5px; display: block;" href="/vacancies/chat/ID' . $v['id'] . '.html">См. переписку</a>';
                    }
                }
                $long = ip2long(Yii::$app->getRequest()->getUserIP());
                $vac[$k]['vstat'] = !ViewsVac::find()->where(['ip' => $long, 'vac_id' => $v['id']])->one() ? '<a style="margin-top: 5px; display: block;" href="/vacancies/info/ID' . $v['id'] . '.html">Новое</a>' : '';
                $vac[$k]['photos'] = $l0go;
                $vac[$k]['test'] = $v['muser_id'] . '  ' . Yii::$app->user->id;
                $vac[$k]['logo'] = $l0go[0]['url'];
            }
            // }
        }
        header('Content-Type: application/json');
        return json_encode(['km' => $_SESSION['km'], 'id' => $idv, 'vac' => $vac, 'price' => $price]);
    }

    public function actionAdd()
    {
        $us = Yii::$app->user->identity;
        if (!$us->phone || !$us->address || !$us->comp_logo || !$us->company) {
            Yii::$app->session->setFlash('success', 'Перед созданием вакансии, необходимо заполнить все поля в профиле');
            return $this->redirect('/profile.html');
        }

        if ($vacBody = Yii::$app->request->getBodyParam('Vac')) {
            if (isset($vacBody['id'])) {
                if (!$vac = Vacancies::findOne(['id' => $vacBody['id'], 'muser_id' => Yii::$app->user->id])) {
                    return $this->redirect('/profile/vacancies.html');
                }
            } else {
                $vac = new Vacancies();
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
                    return $this->redirect('/vacancies/edit/ID' . $vac->id . '.html');
                } else {
                    ///Yii::$app->session->setFlash('success', "Вакансия \"{$vac->title}\" изменена");
                    return $this->redirect('/profile/vacancies.html');
                }
            } else {
                return $this->redirect('/profile/vacancies.html');
            }
        }else {
            if ((($us->balance <= 10 && ($us->getCountVacansies() + $us->getCountSpec()) > 3))) {
                Yii::$app->session->setFlash('success', 'Для создания дополнительной вакансии, пожалуйста, пополните баланс!');
                return $this->redirect('/profile/vacancies.html');
            }
            $spec = new Vacancies();
            $spec->muser_id = Yii::$app->user->id;
            if ($spec->save()) {
                return $this->render('edit', ['vac' => $spec]);
            }
        }
        return $this->render('/');
    }

    public function actionEdit($id = null)
    {
        $id = str_replace('ID', '', $id);
        if ($vac = Vacancies::findOne(['id' => $id, 'muser_id' => Yii::$app->user->id]))
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
        if ($sp = Vacancies::findOne(['id' => $id, 'muser_id' => Yii::$app->user->id])) {
            $sp->arhive = ($sp->arhive ? 0 : 1);
            $sp->public = 0;
            if ($sp->update()) {
                return $this->redirect('/profile/arhive.html');
            }
        }
        return $this->redirect('/profile/vacancies.html');
    }

    public function actionInfo($id = null)
    {
        $id = str_replace('ID', '', $id);
        if ($id != null) {
            $spec = Vacancies::findOne($id);
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
                'content' => 'https://jobscanner.online/vacancies/info/ID' . $spec->id . '.html'
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
            if ($vis = ViewsVac::find()->where(['ip' => $long, 'vac_id' => $id])->andWhere(
                'created_at > ' . strtotime(date("Y-m-d"))
                . " AND created_at < " . strtotime(date("Y-m-d") . 1 . " day"))
                ->one()) {
                $vis->updated_at = 0;
                $vis->update(false);
            } else {
                if ($spec->muser_id != Yii::$app->user->id) {
                    $vis = new ViewsVac();
                    $vis->ip = $long;
                    $vis->vac_id = $id;
                    $vis->save();
                }
            }
            return $this->render('info', ['vac' => $spec]);
        }
        return $this->redirect('/');
    }

    public function actionUpload($id)
    {
        $id = str_replace('ID', '', $id);
        if ($vac = Vacancies::findOne(['id' => $id, 'muser_id' => Yii::$app->user->id])) {
            $dir = "/img/users/" . str_replace(['@', '.'], '_', Yii::$app->user->identity->id) . '/';
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                if (!mkdir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                    return null;
                }

            }

            //$dir = $dir . self::cyrillicToLatin($vac->title , true);
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                if (!mkdir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                    return null;
                }

            }
            try{
                $target_file = $dir . basename($_FILES["file"]["name"]);
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                    $ph = new Photos();
                    $ph->type = 'vacancies';
                    $ph->type_id = $vac->id;
                    $ph->user_id = Yii::$app->user->id;
                    $ph->url = $target_file;
                    $ph->save();
                    $msg = "Successfully uploaded";
                } else {
                    $msg = "Error while uploading";
                }
            }catch (\Exception $e){
                var_dump($e->getMessage());
                die();
            }
            echo $msg;
            exit;

        }
    }

    public function actionGetupload()
    {
        if ($vac = Vacancies::findOne(['id' => Yii::$app->request->getBodyParam('id'), 'muser_id' => Yii::$app->user->id])) {
            $dir = "/img/users/" . Yii::$app->user->identity->id . '/';
            $file_list = [];

            if ($photos = Photos::findAll(['type' => 'vacancies', 'type_id' => $vac->id])) {
                foreach ($photos as $k => $ph) {
                    // File path
                    $file_path = $_SERVER['DOCUMENT_ROOT'] . $ph->url;
                    // Check its not folder
                    if (!is_dir($file_path)) {
                        //$size = filesize($file_path);
                        array_push($file_list, array('name' => str_replace($dir, '', $ph->url), 'size' => 5000, 'path' => $ph->url));
                    }
                }
            }

            echo json_encode($file_list);
            exit;
        }
    }

    public function actionDelupload($file)
    {
        $img = "/img/users/" . str_replace(['@', '.'], '_', Yii::$app->user->identity->id) . "/vacancies/" . $file;
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
}

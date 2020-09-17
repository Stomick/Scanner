<?php
/**
 * Created by PhpStorm.
 * User: Stomick
 * Date: 23.04.2018
 * Time: 23:01
 */

namespace models;

use backend\components\UploadImage;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

class MUser extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%musers}}';
    }


    static public function findByPhone($phone)
    {
        if (Sms::findOne(['phone' => $phone, ['!=', ['muser_id' => 0]]])) {
            return true;
        }
        return false;
    }

    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->token = \Yii::$app->security->generateRandomString();
    }


    public function afterSave($insert, $changedAttributes)
    {
        \Yii::$app->session->setFlash('success', 'Данные пользователя успешно изменены');
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    static public function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->logo == null) {
            $this->logo = '/img/users/profile.svg';
        } else {
            $dir = "/img/users/" . str_replace(['@', '.'], '_', $this->id . '/');
            if ($img = UploadImage::save_image($this->logo, 'logo' . $this->id, $_SERVER['DOCUMENT_ROOT'] . $dir)) {
                if ($ph = Photos::findOne(['type' => 'logo', 'type_id' => $this->id])) {
                    $ph->deleteAll();
                }
                $ph = new Photos();
                $ph->type = 'logo';
                $ph->type_id = $this->id;
                $ph->url = $dir . $img;
                $ph->user_id = $this->id;
                $ph->save();
            }
        }

        if ($this->comp_logo == null) {
            $this->comp_logo = '/img/users/profile.svg';
        } else {
            $dir = "/img/users/" . str_replace(['@', '.'], '_', $this->id . '/');
            if ($img = UploadImage::save_image($this->comp_logo, 'comp_logo' . $this->id, $_SERVER['DOCUMENT_ROOT'] . $dir)) {
                if ($ph = Photos::findAll(['type' => 'comp_logo', 'type_id' => $this->id])) {
                    $ph->deleteAll();
                }
                $ph = new Photos();
                $ph->type = 'comp_logo';
                $ph->type_id = $this->id;
                $ph->url = $dir . $img;
                $ph->user_id = $this->id;
                $ph->save();
            }
        }

        if ($this->getAuthKey()) {
            $this->generateAuthKey();
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    public function generateEmailVerificationToken()
    {
        $this->verification_token = \Yii::$app->security->generateRandomString(32);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->token;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function myRating($type = null)
    {
        return Reviews::getSumRating(self::getId(), $type ? $type : $this->type);
    }

    private function getPeriod($date1, $date2)
    {
        $interval = date_diff($date1, $date2);
        $y = '';
        $m = '';
        $d = '';
        $year = $interval->y - (int)($interval->y / 10) * 10;
        if ($interval->y > 0) {
            if ($year > 4)
                $y .= $interval->y . ' лет';
            else if ($year == 1)
                $y .= $interval->y . ' год';
            else
                $y .= $interval->y . ' года';
        }

        return $y;
    }

    public function getBirthday()
    {
        $dateNow = new \DateTime(date('Y-m-d', strtotime('now')));
        $dateBirthday = new \DateTime($this->birthday ? $this->birthday : date('Y-m-d', strtotime('now')));
        return $this->getPeriod($dateNow, $dateBirthday);
    }

    public function getSendAnswers($type = 'vacancies')
    {
        return \models\ChatMessages::find()
            ->from('chat_message_to_rooms cmtr')
            ->select([
                'DISTINCT(chr.room_id)',
                'chr.type',
                'chr.type_id',
                'user2.id as userId',
                'chmtr.text',
                'chmtr.photo',
                'chmtr.date',
                'chmtr.id as mid',
                'CONCAT(user2.firstname , " " , user2.lastname) as name',
                'user2.company',
                'user2.logo',
                'vsp.title',
                '(SELECT count(message_id) FROM chat_message_to_rooms WHERE room_id=chr.room_id AND status=0 AND chat_message_to_rooms.id !=' . $this->id . ') as newmess'
            ])
            ->innerJoin('chat_rooms chr', 'cmtr.room_id=chr.room_id AND chr.type="' . (!$this->type ? "vacancies" : "specialties") . '"')
            ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chr.room_id AND cutr.user_id!=' . $this->id)
            ->innerJoin('musers user2', 'user2.id=cutr.user_id')
            ->innerJoin((!$this->type ? "vacancies" : "specialties") . ' vsp', 'chr.type_id=vsp.id')
            ->innerJoin('chat_message_to_rooms chmtr', 'chmtr.room_id=cutr.room_id AND chmtr.message_id=(SELECT max(message_id) FROM chat_message_to_rooms WHERE chat_message_to_rooms.room_id=chr.room_id)')
            ->where(['cmtr.id' => $this->id, 'cmtr.type' => "answer"]);
    }

    public function getTakeAnswers($type = 'vacancies')
    {
        return \models\Vacancies::find()
            ->from($type . ' vsp')
            ->select([
                'DISTINCT(chr.room_id)',
                'chr.type',
                'chr.type_id',
                'user2.id as userId',
                'chmtr.text',
                'chmtr.photo',
                'chmtr.date',
                'chmtr.id as mid',
                'CONCAT(user2.firstname , " " , user2.lastname) as name',
                'user2.company',
                'user2.logo',
                'vsp.title',
                '(SELECT count(message_id) FROM chat_message_to_rooms WHERE room_id=chr.room_id AND status=0 AND chat_message_to_rooms.id !=' . $this->id . ') as newmess'
            ])
            ->innerJoin('chat_rooms chr', 'chr.type_id=vsp.id AND chr.type="' . ($this->type ? "vacancies" : "specialties") . '"')
            ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chr.room_id AND cutr.user_id!=' . $this->id)
            ->innerJoin('musers user2', 'user2.id=cutr.user_id')
            ->innerJoin('chat_message_to_rooms chmtr', 'chmtr.room_id=cutr.room_id AND chmtr.message_id=(SELECT max(message_id) FROM chat_message_to_rooms WHERE chat_message_to_rooms.room_id=chr.room_id)')
            ->where(['vsp.muser_id' => $this->id]);
    }

    public function getMessages($type = 'vacancies')
    {
        return \models\ChatRoom::find()
            ->from('chat_rooms chr')
            ->select([
                'DISTINCT(chr.room_id)',
                'chr.type',
                'chr.type_id',
                'user2.id as userId',
                'chmtr.text',
                'chmtr.date',
                'chmtr.id as mid',
                'CONCAT(user2.firstname , " " , user2.lastname) as name',
                'vsp.title',
                'user2.logo',
                'user2.company',
                'chmtr.photo',
                '(SELECT count(message_id) FROM chat_message_to_rooms WHERE room_id=chr.room_id AND status=0 AND chat_message_to_rooms.id !=' . $this->id . ') as newmess'
            ])
            ->innerJoin($type . ' as vcsp', 'vcsp.id=chr.type_id AND vcsp.muser_id' . (!$this->type ? '=' . $this->id : '!=' . $this->id))
            ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chr.room_id AND cutr.user_id=' . $this->id)
            ->innerJoin('chat_message_to_rooms chtr', 'chtr.room_id=chr.room_id AND chtr.type="answer"')
            ->innerJoin('musers user2', 'user2.id=' . ($this->type ? 'vcsp.muser_id' : 'chtr.id'))
            ->innerJoin((!$this->type ? "vacancies" : "specialties") . ' vsp', 'chr.type_id=vsp.id')
            ->innerJoin('chat_message_to_rooms chmtr', 'chmtr.room_id=cutr.room_id AND chmtr.message_id=(SELECT max(message_id) FROM chat_message_to_rooms WHERE chat_message_to_rooms.room_id=chr.room_id)')
            ->where(['chr.type' => $type]);
    }

    public function getSendMessages($type = 'vacancies')
    {
        return \models\ChatRoom::find()
            ->from('chat_rooms chr')
            ->select([
                'DISTINCT(chr.room_id)',
                'chr.type',
                'chr.type_id',
                'user2.id as userId',
                'chmtr.text',
                'chmtr.date',
                'chmtr.id as mid',
                'CONCAT(user2.firstname , " " , user2.lastname) as name',
                'user2.logo',
                '(SELECT count(message_id) FROM chat_message_to_rooms WHERE room_id=chr.room_id AND status=0 AND chat_message_to_rooms.id !=' . $this->id . ') as newmess'
            ])
            ->innerJoin($type . ' as vcsp', 'vcsp.id=chr.type_id AND vcsp.muser_id' . (!$this->type ? '=' . $this->id : '!=' . $this->id))
            ->innerJoin('chat_user_to_rooms cutr', 'cutr.room_id=chr.room_id AND cutr.user_id=' . $this->id)
            ->innerJoin('chat_message_to_rooms chtr', 'chtr.room_id=chr.room_id AND chtr.type="answer"')
            ->innerJoin('musers user2', 'user2.id=' . ($this->type ? 'vcsp.muser_id' : 'chtr.id'))
            ->innerJoin('chat_message_to_rooms chmtr', 'chmtr.room_id=cutr.room_id AND chmtr.message_id=(SELECT max(message_id) FROM chat_message_to_rooms WHERE chat_message_to_rooms.room_id=chr.room_id)')
            ->where(['chr.type' => $type]);
    }

    public function getCountVacansies()
    {
        return Vacancies::find()->where(['muser_id' => $this->id, 'arhive' => 0, 'tmp' => 0])->count();
    }

    public function getCountArhiveVacansies()
    {
        return Vacancies::find()->where(['muser_id' => $this->id, 'arhive' => 1, 'tmp' => 0])->count();
    }

    public function getCountPayVacansies()
    {
        $p = $this->getCountVacansies();
        return $p - 3 > 0 ? $p - 3 : 0;
    }

    public function getCountSpec()
    {
        return Specialties::find()->where(['muser_id' => $this->id, 'arhive' => 0, 'tmp' => 0])->count();
    }


    public function getCountArhiveSpec()
    {
        return Specialties::find()->where(['muser_id' => $this->id, 'arhive' => 1, 'tmp' => 0])->count();
    }

    public function getCountPaySpec()
    {
        $p = $this->getCountSpec();
        return $p - 3 > 0 ? $p - 3 : 0;
    }

    public function SendRegEmail($key = '')
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Jobscanner <noreply@jobscanner.online>' . "\r\n";

        $text = '<h3>Для активации аккаунта, пожалуйста, перейдите по ссылке ниже</h3>';
        $text .= '<br/>Вы указали данный электронный адрес для регистрации в качестве Пользователя на сайте <a href="https://jobscanner.online">JOBSCANNER.ONLINE</a>' .
                 '<br/>' . 'Для завершения регистрации перейдите, пожалуйста, по ссылке ';
        $text .= '<br><a href="https://jobscanner.online/profile/activation.html?key=' . $key . '">Активировать</a>';

        return mail($this->email, 'Активация аккаунта на jobscanner.online', $text, $headers);
    }

    public function SendCloseVacEmail($key = '')
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Jobscanner <noreply@jobscanner.online>' . "\r\n";

        $text = '<h3>Вакансия "' . $key . '" снята с публикации из за низкого баланса</h3>';
        return mail($this->email, 'Вакансия "' . $key . '" на jobscanner.online', $text, $headers);
    }

    public function SendCloseSpecEmail($key = '')
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Jobscanner <noreply@jobscanner.online>' . "\r\n";

        $text = '<h3>Специальность "' . $key . '" снята с публикации из за низкого баланса</h3>';
        return mail($this->email, 'Специальность "' . $key . '" на jobscanner.online', $text, $headers);
    }


}
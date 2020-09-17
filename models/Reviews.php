<?php
/**
 * Created by PhpStorm.
 * User: Stomick
 * Date: 23.04.2018
 * Time: 23:01
 */

namespace models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Reviews extends ActiveRecord {

    public static function tableName()
    {
        return '{{%reviews}}';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function getRating($userId , $type = 0){

        if(\Yii::$app->user->isGuest){
            $type = 'employer';
        }else {
            if (\Yii::$app->user->id == $userId) {
                $type = \Yii::$app->user->identity->type ? 'employer' : 'worker';
            } else {
                $type = $type ? 'employer' : 'worker';
            }
        }

        return [
            self::find()->where(['user_to' => $userId , 'rating'=>1, 'answer' => 0, 'type' => $type])->count(),
            self::find()->where(['user_to' => $userId , 'rating'=>2, 'answer' => 0, 'type' => $type])->count(),
            self::find()->where(['user_to' => $userId , 'rating'=>3, 'answer' => 0, 'type' => $type])->count(),
            self::find()->where(['user_to' => $userId , 'rating'=>4, 'answer' => 0, 'type' => $type])->count(),
            self::find()->where(['user_to' => $userId , 'rating'=>5, 'answer' => 0, 'type' => $type])->count(),
        ];
    }

    public static function getAllRating($userId, $type =0){

        if(\Yii::$app->user->isGuest){
            $type = 'employer';
        }else {
            if (\Yii::$app->user->id == $userId) {
                $type = \Yii::$app->user->identity->type ? 'employer' : 'worker';
            } else {
                $type = $type ? 'employer' : 'worker';
            }
        }

        return self::find()->where(['user_to' => $userId , 'answer' => 0, 'type' => $type])->count();
    }

    public static function getSumRating($userId , $type = 0 ){

        if(\Yii::$app->user->isGuest){
            $type = 'employer';
        }else {
            if (\Yii::$app->user->id == $userId) {
                $type = \Yii::$app->user->identity->type ? 'employer' : 'worker';
            } else {
                $type = $type ? 'employer' : 'worker';
            }
        }

        $sum = self::find()->select(['SUM(rating) / COUNT(id) as sum'])->where(['user_to' => $userId , 'answer' => 0, 'type' => $type])->asArray()->one();
        return $sum['sum'] ;//== 0 ? 1 : $sum['sum'];
    }

    // 0 - worker
    // 1 - employer

    public function beforeSave($insert)
    {
        if($us = MUser::findOne($this->user_from)){
            $this->type = !$us->type ? 'employer' : 'worker';
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if(count($changedAttributes)==0){
            if (!$chatRoom = ChatRoom::findOne(['type' => 'system', 'type_id' => $this->user_to])) {
                $chatRoom = new ChatRoom();
                $chatRoom->type = 'system';
                $chatRoom->type_id = $this->user_to;
            }
            if ($chatRoom->save()) {
                $us1 = new ChatUserRoom();
                $us1->user_id = $this->user_to;
                $us1->room_id = $chatRoom->room_id;
                $us1->save();
                $us1 = new ChatUserRoom();
                $us1->user_id = 1;
                $us1->room_id = $chatRoom->room_id;
                $us1->save();
            }
            $mess = new ChatMessages();
            if ($user = MUser::findOne($this->user_from)) {
                $mess->text = $this->answer ? 'Пользователь "' . $user->firstname . ' ' . $user->lastname . '" ответил на ваш отзыв' : 'Пользователь "' . $user->firstname . ' ' . $user->lastname . '" оставил о ВАС отзыв';
                $mess->room_id = $chatRoom->room_id;
                $mess->id = 1;
                $mess->status = 0;
                $mess->save();
            }
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function delete()
    {
        if($ans = self::findOne(['answer'=>$this->id])){
            $ans->delete();
        }
        return parent::delete(); // TODO: Change the autogenerated stub
    }
}
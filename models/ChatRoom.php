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

class ChatRoom extends ActiveRecord {

    public static function tableName()
    {
        return '{{%chat_rooms}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    static public function getRooms($id, $type){
        if (!$chatRoom = self::findOne(['type' => $type, 'type_id' => $id])) {
            $chatRoom = new self();
            $chatRoom->type = $type;
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
        return $chatRoom->room_id;
    }
}
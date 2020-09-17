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

class ChatMessages extends ActiveRecord {

    public static function tableName()
    {
        return '{{%chat_message_to_rooms}}';
    }

}
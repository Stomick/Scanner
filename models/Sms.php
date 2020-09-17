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

class Sms extends ActiveRecord {

    public static function tableName()
    {
        return '{{%smscentr}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}
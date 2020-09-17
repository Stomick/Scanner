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

class Company extends ActiveRecord {

    public static function tableName()
    {
        return '{{%company}}';
    }


    static public function getName($id){
        if($com = self::findOne($id)){
            return $com->name;
        }
        return null;

    }
    static public function getBalans($id){
        if($com = self::findOne($id)){
            return $com->balance;
        }
        return null;
    }

    static public function getLogo($id){
        if($com = self::findOne($id)){
            return $com->url;
        }
        return null;
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}
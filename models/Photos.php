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

class Photos extends ActiveRecord {

    public static function tableName()
    {
        return '{{%photos}}';
    }

    public function afterDelete()
    {
        if (is_file($_SERVER['DOCUMENT_ROOT'].$this->url)) {
            unlink($_SERVER['DOCUMENT_ROOT'].$this->url);
        }
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }
}
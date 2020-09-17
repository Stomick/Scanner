<?php

namespace models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use models\UserOptions;

class Balance extends ActiveRecord
{
    public static function tableName()
    {
        return '{{balance}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}
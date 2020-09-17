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

class Stock extends ActiveRecord {

    public static function tableName()
    {
        return '{{%stock}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getAffilate($id){
        $ret = [];
        foreach (StockAffilate::find()
                     ->select(['address' , 'lot' , 'lat' , 'phone' , 'email' , 'main'])
                     ->innerJoin('affiliates afl' , 'afl.affiliate_id=stock_affiliate.affiliate_id')
                     ->where(['stock_affiliate.stock_id' => $id])
                     ->asArray()
                     ->all() as $k => $affl){
                $ret[$k] = [
                    "address"=> $affl['address'],
                "lot"=> doubleval($affl["lot"]),
                "lat"=> doubleval($affl["lat"]),
                "phone"=> $affl["phone"],
                "email"=> $affl['email'],
                "main"=> boolval($affl['main'])
                ];
        }
        return $ret;
    }
}
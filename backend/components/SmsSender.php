<?php
/**
 * Created by PhpStorm.
 * User: Stomick
 * Date: 20.06.2019
 * Time: 22:41
 */

namespace backend\components;


use linslin\yii2\curl\Curl;

class SmsSender
{
    private $key = 'DC76371C-2BF9-E7FD-7879-50CB2F091491';

    public function sendSms($number , $text){
        $curl = new Curl();
        //return 'https://sms.ru/sms/send?api_id=DC76371C-2BF9-E7FD-7879-50CB2F091491&to='.$number.'&msg=' . $text. '&json=1';
        try {
            $response = $curl
                ->get('https://sms.ru/sms/send?api_id=DC76371C-2BF9-E7FD-7879-50CB2F091491&to='.$number.'&msg=' . $text. '&json=1');
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
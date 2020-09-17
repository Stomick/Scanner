<?php


namespace backend\components;

use linslin\yii2\curl\Curl;

class Request1C
{
    private $login = 'admin';
    private $passwd = '2233';
    private $baseUrl = 'http://1c.daedaworld.ru/RT/ru/';

    public function GetPoints($url  , $type = 'get'){
        $curl = new Curl();
        try {
            $response = $curl
                ->setHeaders([
                    'Content-Type:application/json',
                    'Authorization: Basic '. base64_encode($this->login . ":" . $this->passwd)
                ])
                ->$type($this->baseUrl . $url );
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
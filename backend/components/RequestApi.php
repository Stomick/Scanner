<?php
/**
 * Created by PhpStorm.
 * User: Stomick
 * Date: 27.05.2019
 * Time: 19:13
 */

namespace backend\components;

use linslin\yii2\curl\Curl;

class RequestApi
{

    private function getLogin(){
        return 'DaedaCin';
    }
    private function getKey(){
        return 'Daeda123';
    }
    private function getIdKey(){
        //return '6960a8e6-8087-11e9-80dd-d8d385655247';
        return '1597dc3d-8642-11e9-80dd-d8d385655247';
    }

    private $login = 'admin';
    private $passwd = '2233';
    private $baseUrl = '';

    public function GetFrom1C($url  , $type = 'get'){
        $curl = new Curl();
        try {
            $response = $curl
                ->setHeaders([
                    //'Content-Type' => 'application/json',
                    'Authorization' => 'Basic '. base64_encode( "od:l;0yGtnhjdbx1")
                ])
                ->get('http://1c.daedaworld.ru/RT/odata/standard.odata/' . $url );
            return json_decode($response ,true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    static public function GetToken($login , $passwd){
        $curl = new Curl();
        try {
            $response = $curl->get('https://iiko.biz:9900/api/0/auth/access_token?user_id='.$login.'&user_secret=' . $passwd );
            return str_replace('"' , '' , $response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    static public function GetOrganization($token , $timeout){
        $curl = new Curl();
        try {
            $response = $curl->setHeaders([
                'Content-Type' => 'application/json',
            ])->get('https://iiko.biz:9900/api/0//organization/list?access_token='.$token.'&request_timeout='.$timeout , true);
            return  json_decode($response,true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    static public function GetProducts($token , $idOrg){
        $curl = new Curl();
        try {
            $response = $curl->get('https://iiko.biz:9900/api/0/nomenclature/'. $idOrg.'?access_token=' . $token, true);
            return json_decode($response,true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static public function GetDiscount($token , $idOrg){
        $curl = new Curl();
        try {
            $response = $curl->get('https://iiko.biz:9900/api/0/deliverySettings/deliveryDiscounts?organization='. $idOrg.'&access_token=' . $token, true);
            return json_decode($response,true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static public function GetPayTypes($token , $idOrg){
        $curl = new Curl();
        try {
            $response = $curl->get('https://iiko.biz:9900/api/0/rmsSettings/getPaymentTypes?organization='. $idOrg.'&access_token=' . $token, true);
            return json_decode($response,true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static public function GetStreet($token, $idOrg){
        $curl = new Curl();
        try {
            $response = $curl->get('https://iiko.biz:9900/api/0/streets/streets?organization='. $idOrg.'&access_token=' . $token . '&city=b090de0b-8550-6e17-70b2-bbba152bcbd3', true);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    static public function GetCities($token, $idOrg){
        $curl = new Curl();
        try {
            $response = $curl->get('https://iiko.biz:9900/api/0/cities/citiesList?organization='. $idOrg.'&access_token=' . $token, true);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static public function GetStatus($token , $timeout){
        $curl = new Curl();
        try {
            $response = $curl
                ->setHeaders([
                    'Content-Length' => '1'
                ])
                ->post('https://iiko.biz:9900/api/0/orders/checkCreate?access_token=' . $token ."&requestTimeout=" . $timeout);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static public function MakeOrder($token , $order , $timeout){
        $curl = new Curl();
        try {
            $response = $curl
                ->setPostParams($order)
                ->post('https://iiko.biz:9900/api/0/orders/add?access_token=' . $token . "&requestTimeout=" . $timeout, true);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static function Request($url, $param, $head = null, $type)
    {
        //$curl = new Client(['baseUrl' => 'https://api-stage.mapisacard.com/']);
        $curl = new Curl();
        try {
            $response = $curl->setPostParams($param)
                ->$type($url, true);
            return $response;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        /*
        try {
            $response = $curl->createRequest()
                ->setMethod($type)
                ->addHeaders($head)
                ->setUrl($url)
                ->setData($param)
                ->send();
            if ($response->isOk) {
                return $response->data;
            }else{
                return $response;
            }
        }catch (\Exception $e)
        {
            return $e->getMessage();
        }*/
    }
}
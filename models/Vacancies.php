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

class Vacancies extends ActiveRecord {

    function __construct($config = [])
    {
        //Vacancies::deleteAll(['tmp'=>1, 'muser_id'=>\Yii::$app->user->id]);
        parent::__construct($config);
    }

    public static function tableName()
    {
        return '{{%vacancies}}';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
   public function beforeSave($insert)
   {
       if($this->price != null) {
           $this->getPngPrice();
           if ($this->pay_date == null) {
               $this->pay_date = strtotime('now');
           }
           if ($this->phone == null) {
               $this->phone = (MUser::findOne($this->muser_id))->phone;
           }
           $this->tmp = 0;
       }
       $user = MUser::findOne($this->muser_id);
       if ($this->address != null ) {
           $get = 'https://maps.google.com/maps/api/geocode/json?key=AIzaSyByhJmeIT6_V5-3Pu869xHCGC-mSJ6Qcq0';
           $s = json_decode(file_get_contents($get . '&address=' . urlencode($user->address)), true);
           if (isset($s['results'][0]['geometry']['location'])) {
               $coor = $s['results'][0]['geometry']['location'];
               $this->lat = $coor['lat'];
               $this->lot = $coor['lng'];
           } else {
               $this->lat = 0;
               $this->lot = 0;
           }
       } else {
           $this->address = 'Адрес не указан';
           $this->lat = 0;
           $this->lot = 0;
       }
       $casse = 0;
       for ($i = 0; $i < self::find()->asArray()->count(); $i++) {
           if (self::findOne(['lat' => $this->lat, 'lot' => $this->lot])) {
               switch ($casse) {
                   case 0:
                       $this->lat += 0.00001;
                       $this->lot += 0.00001;
                       break;
                   case 1:
                       $this->lat -= 0.00001;
                       $this->lot += 0.00001;
                       break;
                   case 2:
                       $this->lat -= 0.00001;
                       $this->lot -= 0.00001;
                       break;
                   case 3:
                       $this->lat += 0.00001;
                       $this->lot -= 0.00001;
                       break;
               }
               $casse == 4 ? $casse = 0 : $casse++;
           } else {
               break;
           }
       }
       $maker = $user->getCountVacansies();
       if ($this->public){
           if($maker <= 3) {
               \Yii::$app->session->setFlash('success', 'Опубликовано бесплатное  объявление. Доступно еще ' . (3 - (int)$maker) . ' бесплатных публикаций.');
           }else{
               \Yii::$app->session->setFlash('success', 'Опубликовано платное объявление.');
           }
       }
       return parent::beforeSave($insert); // TODO: Change the autogenerated stub
   }

   public function delete()
   {
       foreach (Photos::findAll(['type' => 'vacancies', 'type_id' => $this->id]) as $k => $p) {
           $p->delete();
       }
       return parent::delete(); // TODO: Change the autogenerated stub
   }


    public function getPngPrice()
    {
        setlocale(LC_MONETARY, 'ru_RU');
        $type = [
            'hour' => 'час',
            'day' => 'день',
            'month' => 'месяц',
            'piecework' => 'договорная'
        ];
        $curr = [
            'RUB' => "₽",
            'EUR' => "€",
            'USD' => "$"
        ];

        $img = array();
        $price = ($this->type == 'piecework' ? $type[$this->type] : (number_format($this->price, 0, ',', ' ')) . ' ' . $curr[$this->currency] . ' / ' . $type[$this->type]);

        list($img['background'], $img['color'], $img['width'], $img['height']) = array('F', '#000000', (strlen($price)) * 8, 35);
        $background = explode(",", $this->hex2rgb($img['background']));
        $color = explode(",", $this->hex2rgb($img['color']));
        $width = empty($img['width']) ? 100 : $img['width'];
        $height = empty($img['height']) ? 100 : $img['height'];
        $string = $price;
        $image = @imagecreate($width, $height);

        $background_color = imagecolorallocate($image, $background[0], $background[1], $background[2]);
        $text_color = imagecolorallocate($image, $color[0], $color[1], $color[2]);

        //imagefilledrectangle($image, 0, 0, $width, $height, $text_color);
        //imagefilledrectangle($image, 1, 1, $width - 2, $height - 2, $background_color);
        $dir = "/img/price/";
        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . $dir)) {
                return null;
            }

        }
       // header("Content-type: image/png");

        $file = $dir . "price" . $this->price .$this->type .$this->currency. ".png";
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$file)) {
            unlink($_SERVER['DOCUMENT_ROOT'] .$file);
        }
        ImageTTFText($image, 12, 0, 22, 24, $text_color, '/home/jobscaner/www/test/frontend/web/fonts/Roboto-Bold.ttf', $price);
        // imagestring($image, 5, 5, 5, iconv(mb_detect_encoding($string), "UTF-8", $string), $text_color);
        imagepng($image, $_SERVER['DOCUMENT_ROOT'] . $file);
        imagedestroy($image);
        $this->marker = $file;
        var_dump($file);
    }

    function iso2uni ($s) {
       // $s = convert_cyr_string($s,'w','i'); //  win1251 -> iso8859-5
        //  iso8859-5 -> unicode:


        return iconv(mb_detect_encoding($s), "UTF-8", $s);
    }
    function hex2rgb($hex) {
        // Copied
        $hex = str_replace("#", "", $hex);

        switch (strlen($hex)) {
            case 1:
                $hex = $hex.$hex;
            case 2:
                $r = hexdec($hex);
                $g = hexdec($hex);
                $b = hexdec($hex);
                break;

            case 3:
                $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                break;

            default:
                $r = hexdec(substr($hex,0,2));
                $g = hexdec(substr($hex,2,2));
                $b = hexdec(substr($hex,4,2));
                break;
        }

        $rgb = array($r, $g, $b);
        return implode(",", $rgb);
    }

}
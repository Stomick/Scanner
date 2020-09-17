<?php
/**
 * Created by PhpStorm.
 * User: Stomick
 * Date: 29.04.2018
 * Time: 8:45
 */

namespace models;

use backend\components\UploadImage;
use models\Company;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class StockModel extends Model
{
    public $tarif;
    public $stock_id;
    public $category = [];
    public $description;
    public $status;
    public $full_description;
    public $banner;
    public $photo = [];
    public $affiliate = [];
    public $date;
    public $tags;
    public $promo;
    public $youtube;


    public function rules()
    {
        return [
            [['tarif', 'description', 'full_description', 'date', 'banner', 'tags', 'status' , 'promo', 'youtube'], 'string'],
            [['category', 'affiliate'], 'each', 'rule' => ['integer']],
            [['stock_id'] , 'integer'],
            [['photo',], 'each', 'rule' => ['string']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFiles' => 'Фото товара',
            'name' => 'Название товара',

        ];
    }

    public function saveToBase($comp)
    {
        if ($stock = new Stock()) {
            $stock->company_id = $comp->company_id;
            foreach ($this as $k => $item) {
                if ($k != 'category' && $k != 'affiliate' && $k != 'photo' && $k != 'banner' && $k != 'date') {
                    $stock->$k = $item;
                } elseif ($k == 'date') {
                    $date = explode('-', $item);
                    if (is_array($date)) {
                        $stock->start_date = strtotime(trim($date[0]));
                        $stock->end_date = strtotime(trim($date[1]));
                    }
                }
            }
            $stock->status = 'modern';
            if ($stock->save()) {
                foreach ($this->category as $k) {
                    $stk = new StockCatgory();
                    $stk->category_id = $k;
                    $stk->stock_id = $stock->stock_id;
                    $stk->save();
                }
                foreach ($this->affiliate as $k) {
                    $stk = new StockAffilate();
                    $stk->affiliate_id = $k;
                    $stk->stock_id = $stock->stock_id;
                    $stk->save();
                }
            }
            $dir = '/img/company/' . $comp->company_id . '/stok_' . $stock->stock_id . '/';

            if ($this->tarif == 'pro' || $this->tarif == 'enterprise') {
                $stock->promo = $this->promo;
                $stock->youtube = $this->youtube;
                $src = [];
                foreach ($this->photo as $k => $p) {
                    if($p != '') {
                        $saveDir = __DIR__ . '/../backend/web' . $dir;
                        $img = 'photo_' . Yii::$app->security->generateRandomString(6);
                        array_push($src ,$dir . UploadImage::save_image($p, $img, $saveDir));
                    }
                }
                $stock->photo = json_encode($src);
            }
            if ($this->tarif == 'enterprise') {
                $saveDir = __DIR__ . '/../backend/web' . $dir;
                $img = 'banner_' . Yii::$app->security->generateRandomString(6);
                $stock->banner = $dir . UploadImage::save_image($this->banner, $img, $saveDir);
            }

            return $stock->update();
        } else {
            return false;
        }
    }

    public function AdminUpdateToBase(){
        if($stok = Stock::findOne($this->stock_id)){
            foreach ($this as $k => $v){
                if($v){
                    $stok->$k = $v;
                }
            }
            return $stok->update();
        }
    }

    public function uploadImg($comp)
    {
        $dir = '/img/company/' . $comp->company_id . '/';
        $saveDir = __DIR__ . '/../backend/web' . $dir;

        try {

            if ($this->dirs($saveDir)) {
                foreach ($this->imageFiles as $file) {
                    if ($file->saveAs($saveDir . $file->baseName . '.' . $file->extension)) {
                        //$file->saveAs($_SERVER['DOCUMENT_ROOT'] . $dir . $file->baseName . '.' . $file->extension);
                        $comp->logo = $dir . $file->baseName . '.' . $file->extension;
                    }
                }
            }

        } catch (\Exception $e) {
            return var_dump($e->getMessage());
        }
    }


    public function dirs($patch)
    {
        var_dump($patch);
        if (!is_dir($patch)) {
            return mkdir($patch);
        }
        return true;
    }

    static public function cyrillicToLatin($text, $toLowCase)
    {
        $dictionary = array(
            'й' => 'i',
            'ц' => 'c',
            'у' => 'u',
            'к' => 'k',
            'е' => 'e',
            'н' => 'n',
            'г' => 'g',
            'ш' => 'sh',
            'щ' => 'shch',
            'з' => 'z',
            'х' => 'h',
            'ъ' => '',
            'ф' => 'f',
            'ы' => 'y',
            'в' => 'v',
            'а' => 'a',
            'п' => 'p',
            'р' => 'r',
            'о' => 'o',
            'л' => 'l',
            'д' => 'd',
            'ж' => 'zh',
            'э' => 'e',
            'ё' => 'e',
            'я' => 'ya',
            'ч' => 'ch',
            'с' => 's',
            'м' => 'm',
            'и' => 'i',
            'т' => 't',
            'ь' => '',
            'б' => 'b',
            'ю' => 'yu',

            'Й' => 'I',
            'Ц' => 'C',
            'У' => 'U',
            'К' => 'K',
            'Е' => 'E',
            'Н' => 'N',
            'Г' => 'G',
            'Ш' => 'SH',
            'Щ' => 'SHCH',
            'З' => 'Z',
            'Х' => 'X',
            'Ъ' => '',
            'Ф' => 'F',
            'Ы' => 'Y',
            'В' => 'V',
            'А' => 'A',
            'П' => 'P',
            'Р' => 'R',
            'О' => 'O',
            'Л' => 'L',
            'Д' => 'D',
            'Ж' => 'ZH',
            'Э' => 'E',
            'Ё' => 'E',
            'Я' => 'YA',
            'Ч' => 'CH',
            'С' => 'S',
            'М' => 'M',
            'И' => 'I',
            'Т' => 'T',
            'Ь' => '',
            'Б' => 'B',
            'Ю' => 'YU',

            '\-' => '-',
            '\s' => '-',

            '[^a-zA-Z0-9\-]' => '',

            '[-]{2,}' => '-',
        );

        foreach ($dictionary as $from => $to) {
            $text = mb_ereg_replace($from, $to, $text);
        }
        if ($toLowCase) {
            $text = mb_strtolower($text, Yii::$app->charset);
        }

        return trim($text, '-');
    }

}
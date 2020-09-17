<?php
/**
 * Created by PhpStorm.
 * User: Stomick
 * Date: 29.04.2018
 * Time: 8:45
 */

namespace models;

use models\Company;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class CompModel extends Model
{
    public $imageFiles;
    public $image;
    public $name;

    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 10, 'extensions' => 'png, jpg, JPG, jpeg'],
            [['name' ], 'string'],
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
        if ($comp) {
            $this->imageFiles = UploadedFile::getInstances($this, 'image');
            var_dump($this->imageFiles);
            $this->uploadImg($comp);
            die();
            return $comp->update();
        }else{
            return false;
        }
    }

    public function uploadImg($comp)
    {
        $dir = '/img/company/' . $comp->company_id . '/';
        $saveDir =__DIR__ . '/../backend/web'. $dir;

        try {

            if ($this->dirs(  $saveDir)) {
                foreach ($this->imageFiles as $file) {
                    if ($file->saveAs( $saveDir . $file->baseName . '.' . $file->extension)) {
                        //$file->saveAs($_SERVER['DOCUMENT_ROOT'] . $dir . $file->baseName . '.' . $file->extension);
                        $comp->logo =  $dir . $file->baseName . '.' . $file->extension;
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
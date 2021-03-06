<?php
namespace backend\controllers;

use models\Article;
use models\Categories;
use models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;

/**
 * Site controller
 */
class ArticleController extends Controller
{
    private $body;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index' , 'edit' , 'add' , 'list' , 'updatestat' , 'del'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (Yii::$app->request->isPost) {
            if (!$this->body = Yii::$app->request->getBodyParams()) {
                return $this->afterAction($action, null);
            }
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        return $this->render('../site/index' , ['page' => 'article' , 'action' => 'index']);
    }

    public function actionUpdatestat(){
        if(isset($this->body['category'])){

            foreach ($this->body['category'] as $k => $cat){
                $v = Categories::findOne($cat['id']);
                if(isset($cat['status'])){
                    $v->status = (int)$cat['status'];
                    
                    $v->update();
                }
            }
        };
        die();
    }
    public function actionList(){
        if(isset($this->body['category'])){
            foreach ($this->body['category'] as $k => $cat){
                $v = Categories::findOne($cat['id']);
                if(!isset($cat['children'])){
                        $v->sub_id = 0;
                }else{
                    foreach ($cat['children'] as $t => $child){
                        if($subcat = Categories::findOne($child['id'])){
                            $subcat->sub_id = $cat['id'];
                            $subcat->sort = $t;
                            $subcat->update();
                        };
                    }
                }
                $v->sort = intval($k);
                $v->update();
            }
        };
        die();
    }

    public function actionAdd()
    {
        if(isset($this->body['Article'])){
            $cats = $this->body['Article'];
            $cat = new Article();
            $cat->url = $this->cyrillicToLatin($cats['title'],true);
            $cat->sort = intval($cats['sort']);
            $cat->text = $cats['text'];
            $cat->colum = $cats['colum'];
            $cat->title = $cats['title'];
            if($cat->save()){
                return $this->redirect('/article');
            }
        }
        return $this->render('../site/index' , ['page' => 'article' , 'action' => 'add']);
    }

    public function actionEdit($id)
    {
        if($cat = Article::findOne($id)) {
            if(isset($this->body['Article'])){
                $cats = $this->body['Article'];
                $cat->url = $this->cyrillicToLatin($cats['title'],true);
                $cat->sort = intval($cats['sort']);
                $cat->text = $cats['text'];
                $cat->colum = $cats['colum'];
                $cat->title = $cats['title'];
                if($cat->save()){
                    return $this->redirect('/article');
                }
            }
            return $this->render('../site/index', ['page' => 'article', 'action' => $this->action->id , 'cat' => $cat]);
        }
        return $this->render('../site/index', ['page' => 'article', 'action' => $this->action->id]);
    }

    public function actionDel($id)
    {
        if($cat = Article::findOne($id)) {
            if($cat->delete()){
               return $this->redirect('/article');
            }
            return $this->render('../site/index', ['page' => 'article', 'action' => $this->action->id , 'cat' => $cat]);
        }
        return $this->render('../site/index', ['page' => 'article', 'action' => $this->action->id]);
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

            '[^a-zA-Z0-9\-\_\.]' => '',

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

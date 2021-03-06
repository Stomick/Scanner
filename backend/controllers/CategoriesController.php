<?php
namespace backend\controllers;

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
class CategoriesController extends Controller
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
                        'actions' => ['logout', 'index' , 'edit' , 'add' , 'list' , 'updatestat'],
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
        return $this->render('../site/index' , ['page' => 'categories' , 'action' => 'index']);
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
        if(isset($this->body['Category'])){
            $cats = $this->body['Category'];
            $cat = new Categories();
            $cat->name = mb_substr(mb_strtoupper($cats['name'], 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($cats['name'], 'utf-8'), 1, mb_strlen($cats['name'])-1, 'utf-8');
            $cat->sub_id = intval($cats['sub']);
            $cat->icon = $cats['icon'];
            if($cat->save()){
                return $this->redirect('/categories');
            }
        }
        return $this->render('../site/index' , ['page' => 'categories' , 'action' => 'add']);
    }

    public function actionEdit($id)
    {
        if($cat = Categories::findOne($id)) {
            if(isset($this->body['Category'])){
                $cats = $this->body['Category'];
                $cat->name = mb_substr(mb_strtoupper($cats['name'], 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($cats['name'], 'utf-8'), 1, mb_strlen($cats['name'])-1, 'utf-8');
                $cat->sub_id = intval($cats['sub']);
                $cat->icon = $cats['icon'];
                if($cat->update()){
                    return $this->redirect('/categories');
                }
            }
            return $this->render('../site/index', ['page' => 'categories', 'action' => $this->action->id , 'cat' => $cat]);
        }
        return $this->render('../site/index', ['page' => 'categories', 'action' => $this->action->id]);
    }
}

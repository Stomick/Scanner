<?php
namespace backend\controllers;

use backend\components\UploadImage;
use models\CompModel;
use models\Affiliates;
use models\Company;
use models\Stock;
use models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Login;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class CompanyController extends Controller
{
    private $body;
    private $imageFiles;
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
                        'actions' => ['logout', 'address'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
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


    public function actionAddress()
    {
        $company = Company::findOne(Yii::$app->user->identity->company_id);
        if($this->body){
            $affill = [];
            $del = [];
            $main = [];
            $compModel = new CompModel();
            if(isset($this->body['logo'])){
                $dir = '/img/company/' . $company->company_id . '/';
                $saveDir =__DIR__ . '/../web'. $dir;
                $img = Yii::$app->security->generateRandomString(16);
                $src = UploadImage::save_image($this->body['logo'],$img,$saveDir);
                $company->url = $dir.$src;
                $company->update();
            }

            if(isset($this->body['Affiliates'])) {
                foreach ($this->body['Affiliates'] as $k => $v) {
                    if ($k == 'delete') {
                        array_push($del, $v);
                    } elseif ($k == 'main') {
                        array_push($main, $v);
                    } else {
                        foreach ($v as $t => $val) {
                            $affill[$t][$k] = $val;
                        }
                    }
                }


                foreach ($affill as $k => $t) {
                    if (!$aff = Affiliates::findOne($t['affiliate_id'])) {
                        $aff = new Affiliates();
                    }
                    $aff->main = 0;
                    $aff->company_id = Yii::$app->user->identity->company_id;
                    foreach ($t as $v => $i) {
                        $aff->$v = $i;
                    }
                    $aff->save();

                }
                foreach ($del as $k => $item) {
                    $aff = Affiliates::findOne($item);
                    $aff->delete();
                }
                foreach ($main as $k => $item) {
                    if ($aff = Affiliates::findOne($item)) {
                        $aff->main = 1;
                        $aff->update();
                    }
                }
            };
        /*

        */
        return $this->redirect('/company/address');
        }
        if($company) {
            return $this->render('../site/index', ['page' => 'company', 'action' => $this->action->id , 'company' => $company]);
        }
        return $this->render('../site/index', ['page' => 'company', 'action' => $this->action->id]);
    }

    public function actionAdd()
    {
        if($stock = new Stock()) {
            $stock->company_id = Yii::$app->user->identity->company_id;
            return $this->render('../site/index', ['page' => 'stock', 'action' => $this->action->id , 'model' => $stock]);
        }
        return $this->render('../site/index', ['page' => 'stock', 'action' => $this->action->id]);
    }
}

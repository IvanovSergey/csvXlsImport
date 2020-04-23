<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\data\ArrayDataProvider;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MerchantProducts;
use PhpOffice\PhpSpreadsheet\Reader;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Базовый метод используеться для отображения главной страницы, обработки загрузки файла и сохранения данных в таблицу.
     *
     * @return string
     */
    public function actionIndex()
    {   
        $file = UploadedFile::getInstanceByName('file');
        //Если файл загружен то обрабатываем его
        if(!empty($file)){
            $ext = pathinfo($file->name, PATHINFO_EXTENSION);
            //Определение типа файла
            switch ($ext) {
                case 'csv':
                    $reader = new Reader\Csv();
                    break;
                case 'xls':
                    $reader = new Reader\Xls();
                    break;
                case 'xlsx':
                    $reader = new Reader\Xlsx();
                    break;
                default:
                    Yii::$app->session->setFlash('error', "Допустимы только xls, xlsx, csv форматы");
                    return $this->refresh();
                    break;
            }
            //Загрузка файла и преобразование его в массив
            $spreadsheet = $reader->load($file->tempName);     
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            
            $dataProvider = new ArrayDataProvider([
                'allModels' => $sheetData,
                'pagination' => [
                    'pageSize' => 20000,
                ],
            ]); 
            //Получение всех полей таблицы merchant_products
            $model = new MerchantProducts();
            $arrFields = array_keys($model->attributes);
            
            return $this->render('grid', [
                'dataProvider' => $dataProvider,
                'arrFields' => array_diff($arrFields, array('id', 'created_at'))
            ]);
        //Если это аякс запрос
        } else if(Yii::$app->request->isAjax){
            $columns = json_decode(Yii::$app->request->post()['columns']);
            $data = json_decode(Yii::$app->request->post()['data']);           
            //Форматирование данных в удобный для сохраенния формат
            $columns = array_flip(array_filter($columns));            
            foreach($columns as $key=>$value){
                foreach($data as $k=>$item){
                    $parsed_data[$k][$value] = $item[$value];
                }                
            }            
            $parsed_data = array_map(function ($el) { $el[] = time(); return $el; }, $parsed_data);            
            $columns['created_at'] = 0;
            //Сохранение данных
            Yii::$app->db
                ->createCommand()
                ->batchInsert('merchant_products', array_keys($columns),$parsed_data)
                ->execute();
        }
        
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}

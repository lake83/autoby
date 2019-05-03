<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\AdminLoginForm;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\BuyCarForm;
use app\components\SiteHelper;
use app\models\News;
use app\models\Pages;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'news' => News::find()->select(['name', 'slug', 'image', 'intro_text', 'created_at'])
                ->where(['is_active' => 1])->orderBy('created_at DESC')->limit(10)->asArray()->all()
        ]);
    }     

    /**
     * Login admin action.
     *
     * @return string
     */
    public function actionAdmin()
    {
        $this->layout = '@app/modules/admin/views/layouts/main-login';
        
        if (!Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $model = new AdminLoginForm;
        
        if ($model->load(Yii::$app->request->post()) && $status = $model->login()){
            return $this->redirect(SiteHelper::redirectByRole($status));
        }
        return $this->render('@app/modules/admin/views/admin/login', ['model' => $model]);
    }
    
    /**
     * Страница входа
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'light';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm;
        $request = Yii::$app->request;
        
        if ($request->isAjax && $model->load($request->post())){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($request->isAjax && ($phone = $request->post('phone'))) {
            return $model->sendSms($phone);
        }
        if ($model->load($request->post()) && ($status = $model->login())) {
            return $this->redirect(SiteHelper::redirectByRole($status));
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])){
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    
    /**
     * Контентная страница
     *
     * @return string
     */
    public function actionPage($slug)
    {
        if (!$model = Pages::findOne(['slug' => $slug, 'is_active' => 1])){
            throw new NotFoundHttpException('Страница не найдена.');
        }
        return $this->render('page', ['model' => $model]);
    }
    
    /**
     * Страница выкупа авто
     *
     * @return string
     */
    public function actionBuyCar()
    {
        $model = new BuyCarForm;
        if ($model->load(Yii::$app->request->post()) && $model->offer(Yii::$app->params['adminEmail'])){
            Yii::$app->session->setFlash('buyCarFormSubmitted');

            return $this->refresh();
        }
        return $this->render('buy-car', [
            'model' => $model
        ]);
    }
}
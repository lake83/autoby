<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Ads;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\components\SiteHelper;
use yii\helpers\FileHelper;

class ClientController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [$this->action->id],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-image' => ['post'],
                    'sort-image' => ['post']
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
            'delete' => [
                'class' => 'app\modules\admin\controllers\actions\Delete',
                'model' => 'app\models\Ads',
                'redirect' => ['client/cabinet']
            ]
        ];
    }
    
    /**
     * Страница создания объявления
     * 
     * @param object $model
     * @return string
     */
    public function actionCreate($model = null)
    {
        if (is_null($model)) {
            $model = new Ads(['scenario' => 'client']);
            $model->user_id = Yii::$app->user->id;
        }
        $request = Yii::$app->request;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['cabinet']);
        }
        return $this->render('create', ['model' => $model]);
    }
    
    /**
     * Редактирование объявления
     * 
     * @param integer $id
     * @return string
     */
    public function actionUpdate($id)
    {
        if (!$model = Ads::findOne(['id' => $id, 'is_active' => 1])) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        $model->scenario = 'client';
        
        if ($model->image) {
            $images = [];
            foreach ($model->image as $key => $image) {
                $images['urls'][] = SiteHelper::resized_image($image, 200);
                $images['config'][] = ['caption' => end(explode('/', $image)), 'key' => $image];
            }
            $model->image = $images;
        }
        return $this->actionCreate($model);
    }
    
    /**
     * Личный кабинет пользователя
     * 
     * @return string
     */
    public function actionCabinet()
    {
        return $this->render('cabinet', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Ads::find()->select(['id', 'catalog_id', 'issue_year', 'price', 'image'])->where(['user_id' => Yii::$app->user->id, 'is_active' => 1])->orderBy('created_at DESC'),
                'pagination' => [
                    'defaultPageSize' => 5,
                    'pageSize' => 5
                ]
            ])
        ]);
    }
    
    /**
     * Удаление изображения в объявлении
     * 
     * @param integer $ad_id
     * @return string
     */
    public function actionDeleteImage($ad_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (!$model = Ads::findOne(['id' => $ad_id, 'is_active' => 1])) {
            return ['error' => 'Объявление не найдено.'];
        }
        $image = Yii::$app->request->post('key');
        $images = $model->image;
        if (($key = array_search($image, $images)) !== false){
            unset($images[$key]);
            
            $model->image = implode(',', $images);
            if ($model->save()) {
                foreach (FileHelper::findDirectories(Yii::$app->basePath . '/web/images/uploads/', ['recursive' => false]) as $dir) {
                    FileHelper::unlink($dir . '/' . $image);
                }
                return ['success' => true];
            } else {
                return ['error' => $model->errors];
            }
        }
        return ['error' => 'Не удалось удалить изображение.'];
    }
    
    /**
     * Изменение позиции изображения в объявлении
     * 
     * @param integer $ad_id
     * @return string
     */
    public function actionSortImage($ad_id)
    {
        if ($model = Ads::findOne(['id' => $ad_id, 'is_active' => 1])) {
            $model->image = Yii::$app->request->post('images');
            if ($model->save()) {
                return true;
            }
        }
        return false;
    }
}
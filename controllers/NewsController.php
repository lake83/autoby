<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class NewsController extends Controller
{
    /**
     * Страница всех новостей
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => News::find()->select(['name', 'slug', 'image', 'intro_text', 'created_at'])->where(['is_active' => 1])->orderBy('created_at DESC')->asArray(),
                'pagination' => [
                    'defaultPageSize' => 5,
                    'pageSize' => 5
                ]
            ])
        ]);
    }
    
    /**
     * Страница новости
     *
     * @return string
     */
    public function actionView($slug)
    {
        if (!$model = News::findOne(['slug' => $slug, 'is_active' => 1])) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        return $this->render('view', ['model' => $model]);
    }
}
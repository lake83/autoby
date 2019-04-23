<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Ads;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class CarsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }
    
    /**
     * Страница Автомобили
     *
     * @return string
     */
    public function actionAll()
    {
        $query = Ads::find()->select(['id', 'catalog_id', 'issue_year', 'capacity', 'type', 'price', 'engine_type', 'mileage', 'transmission', 'drive_type',
            'color', 'image', 'city'])->where(['is_active' => 1])->orderBy('created_at DESC');
        
        return $this->render('all', [
            'dataProvider' => new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => 6,
                    'pageSize' => 6
                ]
            ])
        ]);
    }
    
    /**
     * Страница объявления
     *
     * @return string
     */
    public function actionView($id)
    {
        if (!$model = Ads::findOne(['id' => $id, 'is_active' => 1])) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        return $this->render('view', ['model' => $model]);
    } 
}
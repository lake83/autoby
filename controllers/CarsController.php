<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Ads;
use app\components\SiteHelper;
use app\models\Catalog;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;

class CarsController extends Controller
{
    /**
     * Страница Автомобили
     * Если передана строка параметров запроса $queryParams возвращает число найденых объявлений
     *
     * @param string $queryParams
     * @return string|integer
     */
    public function actionAll($queryParams = false)
    {
        $request = Yii::$app->request;
        
        $query = Ads::find()->select(['id', 'catalog_id', 'issue_year', 'capacity', 'type', 'price', 'engine_type', 'mileage', 'transmission', 'drive_type',
            'color', 'image', 'city_id'])->where(['is_active' => 1]);
        
        $query->orderBy($request->get('sort') ? str_replace('-', ' ', $request->get('sort')) : 'created_at DESC');
        
        $params = $queryParams ? SiteHelper::queryStringToArray($queryParams) : $request->queryParams;
        
        if (!isset($params['auto_model']) && isset($params['brand']) && ($model = Catalog::findOne($params['brand']))) {
            $query->andFilterWhere(['catalog_id' => $model->children()->andWhere(['depth' => 3])->select(['id'])->column()]);
        }
        if (!isset($params['generation']) && isset($params['auto_model']) && ($model = Catalog::findOne($params['auto_model']))) {
            $query->andFilterWhere(['catalog_id' => $model->children()->andWhere(['depth' => 3])->select(['id'])->column()]);
        }
        if (isset($params['generation'])) {
            $query->andFilterWhere(['catalog_id' => $params['generation']]);
        }
        unset($params['brand'], $params['auto_model'], $params['generation']);
        
        $this->from_to_query($query, $params, 'issue_year', 'year');
        $this->from_to_query($query, $params, 'capacity', 'capacity');
        $this->from_to_query($query, $params, 'mileage', 'mileage');
        $this->from_to_query($query, $params, 'price', 'price');
        
        $locations = isset($params['locations']) ? $params['locations'] : (isset($_COOKIE['locations']) ? $_COOKIE['locations'] : null); 
        if ($locations) {
            $query->andFilterWhere(['city_id' => explode(',', urldecode(Html::encode($locations)))]);
        }
        $query->andFilterWhere([
            'type' => $params['type'],
            'engine_type' => $params['engine'],
            'transmission' => $params['transmission'],
            'drive_type' => $params['drive'],
        ]);
        
        if ($queryParams) {
            return $query->count();
        }
        return $this->render('all', [
            'dataProvider' => new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'route' => $request->pathInfo,
                    'params' => $params,
                    'defaultPageSize' => 6,
                    'pageSize' => 6
                ]
            ])
        ]);
    }
    
    /**
     * Страница объявления
     *
     * @param integer $id
     * @return string
     */
    public function actionView($id)
    {
        if (!$model = Ads::findOne(['id' => $id, 'is_active' => 1])) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        return $this->render('view', ['model' => $model]);
    }
    
    /**
     * Добавление условий запроса между заданными значениями
     *
     * @param object $query
     * @param array $params
     * @param string $field
     * @param string $name
     * @return object
     */
    private function from_to_query(\yii\db\ActiveQuery $query, $params, $field, $name)
    {
        if (isset($params[$name . '_from'])) {
            $query->andFilterWhere(['>=', $field, $params[$name . '_from']]);
        }
        if (isset($params[$name . '_to'])) {
            $query->andFilterWhere(['<=', $field, $params[$name . '_to']]);
        }
        return $query;
    }
}
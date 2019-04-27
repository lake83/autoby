<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\City;
use app\models\Catalog;
use app\models\Modifications;
use yii\web\Response;
use app\components\SiteHelper;

class FilterController extends Controller
{
    private $fail = ['output' => '', 'selected' => ''];
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    $this->action->id => ['post']
                ]
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }
    
    /**
     * Возвращает данные для зависимого списка городов по заданой области
     * 
     * @return string
     */
    public function actionCity()
    {
        if ($_POST['depdrop_parents'][0]) {
            return $this->getList(City::find()->select(['id', 'name'])->where(['region_id' => $_POST['depdrop_parents'][0], 'is_active' => 1])->asArray()->all());
        }
        return $this->fail;
    }
    
    /**
     * Возвращает данные для зависимого списка моделей по бренду авто
     * 
     * @param integer $selected
     * @return string
     */
    public function actionModels($selected = '')
    {
        if ($_POST['depdrop_parents'][0] && ($model = Catalog::findOne(['id' => $_POST['depdrop_parents'][0], 'is_active' => 1]))) {
            return $this->getList($model->children(1)->select(['id', 'name'])->andWhere(['is_active' => 1])->asArray()->all(), $selected);
        }
        return $this->fail;
    }
    
    /**
     * Возвращает данные для зависимого списка годов выпуска по модели авто
     * 
     * @return string
     */
    public function actionIssueYear()
    {
        if ($_POST['depdrop_parents'][1] &&
            ($model = Catalog::find()->select(['year_from', 'year_to'])->where(['id' => $_POST['depdrop_parents'][1], 'is_active' => 1])->asArray()->one()) &&
            !empty($model['year_from']) && !empty($model['year_to'])
        ) {
            if ($model['year_to'] == 'н.в.') {
                $model['year_to'] = date('Y');
            }
            if ($model['year_from'] <= $model['year_to']) {
                if ($model['year_from'] == $model['year_to']) {
                    return $this->getList([['id' => $model['year_from'], 'name' => $model['year_to']]]);
                } else {
                    $years = [['id' => $model['year_from'], 'name' => $model['year_from']]];
                    do {
                        $model['year_from']++;
                        $years[] = ['id' => $model['year_from'], 'name' => $model['year_from']];
                    } while ($model['year_from'] < $model['year_to']);
                    return $this->getList($years);
                }
            }
        }
        return $this->fail;
    }
    
    /**
     * Возвращает данные для зависимого списка поколения автомобиля по годам выпуска
     * 
     * @return string
     */
    public function actionCar()
    {
        if ($_POST['depdrop_parents'][1] && $_POST['depdrop_parents'][2] &&
            ($model = Catalog::find()->where(['id' => $_POST['depdrop_parents'][1], 'is_active' => 1])->one())
        ) {
            return $this->getList($model->children(1)->select(['id', 'name'])
                ->andWhere(['is_active' => 1])
                ->andWhere(['<=', 'year_from', $_POST['depdrop_parents'][2]])
                ->andWhere(['>=', 'year_to', $_POST['depdrop_parents'][2]])
                ->asArray()->all());
        }
        return $this->fail;
    }
    
    /**
     * Возвращает данные для зависимого списка тип кузова
     * 
     * @param integer $selected
     * @return string
     */
    public function actionType($selected = '')
    {
        $catalog_id = $_POST['depdrop_all_params']['catalog_id'] ? $_POST['depdrop_all_params']['catalog_id'] :
            ($_POST['depdrop_all_params']['generation'] ? $_POST['depdrop_all_params']['generation'] : false);
            
        if ($catalog_id &&
           ($model = Modifications::find()->select(['name'])->where(['catalog_id' => $catalog_id, 'is_active' => 1])->column())
        ) {
            $data = [];
            $type = Yii::$app->params['car_body_type']['options'];
            foreach (array_unique($model) as $one) {
                $data[] = ['id' => $one, 'name' => $type[$one]];
            }
            return $this->getList($data, $selected);
        }
        return $this->fail;
    }
    
    /**
     * Возвращает данные для зависимого списка поколений по модели авто
     * 
     * @param integer $selected
     * @return string
     */
    public function actionGenerations($selected = '')
    {
        if ($_POST['depdrop_parents'][1] && ($model = Catalog::findOne(['id' => $_POST['depdrop_parents'][1], 'is_active' => 1]))) {
            return $this->getList($model->children()->select(['id', 'name'])->andWhere(['is_active' => 1])->asArray()->all(), $selected);
        }
        return $this->fail;
    }
    
    /**
     * Построение списка в фильтре
     * 
     * @return string
     */
    public function actionSelectList()
    {
        if ($data = Catalog::findOne(Yii::$app->request->post('id'))->children(1)->select(['id', 'name'])->andWhere(['is_active' => 1])->indexBy('id')->asArray()->all()) {
            $count = [];
            foreach ($data as $item) {
                $count[$item['id']] = Catalog::getCountAds($item['id'], 1);
            }
            return $this->renderPartial('/site/_select_list', ['data' => $data, 'count' => $count]);
        }
        return false;
    }
    
    /**
     * Подсчет объявлений по заданным в фильтре параметрам
     * 
     * @return integer
     */
    public function actionAdsCount()
    {
        return ($sum = Yii::$app->runAction('/cars/all', ['queryParams' => Yii::$app->request->post('params')])) ?
            Yii::t('app', 'Показать <span>{n, plural, =0{#</span> предложений} =1{#</span> предложене} one{#</span> предложене} few{#</span> предложения} many{#</span> предложений} other{#</span> предложений}}',
            ['n' => $sum]) : 0;
    }       
    
    /**
     * Преобразование URL фильтра
     * 
     * @return string
     */
    public function actionSlug()
    {
        $url = '/cars/';
        $params = SiteHelper::queryStringToArray(Yii::$app->request->post('params'));
        $session = Yii::$app->session;
        
        if (isset($params['brand']) && ($brand = Catalog::find()->select(['slug'])->where(['id' => $params['brand'], 'is_active' => 1])->scalar())) {
            $url.= $brand;
            $session[$brand] = $params['brand'];
            unset($params['brand']);
        }
        if (isset($params['auto_model']) && ($model = Catalog::find()->select(['slug'])->where(['id' => $params['auto_model'], 'is_active' => 1])->scalar())) {
            $url.= '/' . $model;
            $session[$model] = $params[$params['auto_model']];
            unset($params['auto_model']);
        }
        if (isset($params['generation'])) {
            $url.= '/' . $params['generation'];
            unset($params['generation']);
        }
        if ($params) {
            $url.= '?' . http_build_query($params);
        }           
        return $url;
    }
    
    /**
     * Преобразование URL каталога
     * 
     * @return string
     */
    public function actionCatalogSlug()
    {
        $url = '/catalog/specifications/';
        $params = SiteHelper::queryStringToArray(Yii::$app->request->post('params'));
        
        if (isset($params['brand']) && ($brand = Catalog::find()->select(['slug'])->where(['id' => $params['brand'], 'is_active' => 1])->scalar())) {
            $url.= $brand;
            unset($params['brand']);
        }
        if (isset($params['auto_model']) && ($model = Catalog::find()->select(['slug'])->where(['id' => $params['auto_model'], 'is_active' => 1])->scalar())) {
            $url.= '/' . $model;
            unset($params['auto_model']);
        }
        if (isset($params['generation'])) {
            $url.= '/' . $params['generation'];
            unset($params['generation']);
        }
        if (isset($params['type'])) {
            $url.= '/' . $params['type'];
            unset($params['type']);
        }
        if ($params) {
            $url.= '?' . http_build_query($params);
        }          
        return $url;
    }
    
    /**
     * Создание списка из данних
     * 
     * @param array $data
     * @param integer $selected
     * @return string
     */
    private function getList($data, $selected = '')
    {
        $out = [];
        foreach ($data as $item) {
            $out[] = ['id' => $item['id'], 'name' => $item['name']];
        }
        return ['output' => $out, 'selected' => $selected];
    }
}
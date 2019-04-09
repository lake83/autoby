<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\City;
use app\models\Catalog;
use app\models\Modifications;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * AdsController implements the CRUD actions for Ads model.
 */
class AdsController extends AdminController
{
    public $modelClass = 'app\models\Ads';
    public $searchModelClass = 'app\models\AdsSearch';
    
    /**
     * Возвращает данные для зависимого списка городов по заданой области
     * 
     * @return string
     */
    public function actionCity()
    {
        if ($this->checkData($_POST['depdrop_parents'][0])) {
            return $this->getList(City::find()->select(['id', 'name'])->where(['region_id' => $_POST['depdrop_parents'][0], 'is_active' => 1])->asArray()->all());
        }
    }
    
    /**
     * Возвращает данные для зависимого списка моделей по бренду авто
     * 
     * @return string
     */
    public function actionModels()
    {
        if ($this->checkData($_POST['depdrop_parents'][0]) && ($model = Catalog::findOne(['id' => $_POST['depdrop_parents'][0], 'is_active' => 1]))) {
            return $this->getList($model->children(1)->select(['id', 'name'])->andWhere(['is_active' => 1])->asArray()->all());
        }
    }
    
    /**
     * Возвращает данные для зависимого списка годов выпуска по модели авто
     * 
     * @return string
     */
    public function actionIssueYear()
    {
        if ($this->checkData($_POST['depdrop_parents'][1]) &&
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
    }
    
    /**
     * Возвращает данные для зависимого списка поколения автомобиля по годам выпуска
     * 
     * @return string
     */
    public function actionCar()
    {
        if ($this->checkData($_POST['depdrop_parents'][1]) && $this->checkData($_POST['depdrop_parents'][2]) &&
            ($model = Catalog::find()->where(['id' => $_POST['depdrop_parents'][1], 'is_active' => 1])->one())
        ) {
            return $this->getList($model->children(1)->select(['id', 'name'])
                ->andWhere(['is_active' => 1])
                ->andWhere(['<=', 'year_from', $_POST['depdrop_parents'][2]])
                ->andWhere(['>=', 'year_to', $_POST['depdrop_parents'][2]])
                ->asArray()->all());
        }
    }
    
    /**
     * Возвращает данные для зависимого списка тип кузова
     * 
     * @return string
     */
    public function actionType()
    {
        if ($this->checkData($_POST['depdrop_parents'][3]) &&
           ($model = Modifications::find()->select(['name'])->where(['catalog_id' => $_POST['depdrop_parents'][3], 'is_active' => 1])->column())
        ) {
            $data = [];
            $type = Yii::$app->params['car_body_type']['options'];
            foreach (array_unique($model) as $one) {
                $data[] = ['id' => $one, 'name' => $type[$one]];
            }
            return $this->getList($data);
        }
    }
    
    /**
     * Проверка полученных данных
     * 
     * @param array $data
     * @return string|boolean
     */
    private function checkData($data)
    {
        if (isset($data) && $data != null) {
            return true;
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['output' => '', 'selected' => ''];
        }
    }
    
    /**
     * Создание списка из данних
     * 
     * @param array $data
     * @return string
     */
    private function getList($data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        foreach ($data as $item) {
            $out[] = ['id' => $item['id'], 'name' => $item['name']];
        }
        return ['output' => $out, 'selected' => ''];
    }
}
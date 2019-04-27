<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Modifications;
use app\models\Specifications;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    /**
     * Страница каталога
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Страница характеристик
     *
     * @param integer $generation
     * @param integer $type
     * @return string
     */
    public function actionView($generation, $type)
    {
        if (!$model = Modifications::findOne(['catalog_id' => $generation, 'name' => $type, 'is_active' => 1])) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        $result = [];
        $params = Yii::$app->params;
        $request = Yii::$app->request;
        foreach ($model->specifications as $key => $item){
            $item['capacity'] = (strpos($item['capacity'], '.') === false ? $item['capacity'] . '.0' : $item['capacity']) .
                ' ' . $params['transmission']['short'][$item['transmission']];
            $item['transmission'] = mb_strtolower($params['transmission']['options'][$item['transmission']]);
            $item['drive'] = $item['drive'] == 3 ? '4x4' : '';
            
            $result[$params['engine']['options'][$item['engine']]][$key] = $item;
            unset($result[$params['engine']['options'][$item['engine']]][$key]['engine']);
        }
        $query = Specifications::find()->where(['is_active' => 1])->asArray();
        
        if ($request->isAjax && ($id = $request->post('id'))) {
            return $this->renderPartial('_specification', ['model' => $query->andWhere(['id' => $id])->one()]);
        }    
        return $this->render('view', ['model' => $result, 'specification' => $query->andWhere(['id' => $model->specifications[0]['id']])->one()]);
    }
}
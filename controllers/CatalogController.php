<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Modifications;
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
        return $this->render('view', ['model' => $model]);
    }
}
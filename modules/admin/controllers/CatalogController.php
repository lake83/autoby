<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Catalog;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class CatalogController extends AdminController
{
    public $modelClass = 'app\models\Catalog';
    public $searchModelClass = 'app\models\CatalogSearch';
    
    /**
     * Создание первого элемента каталога если его нет.
     * 
     * @return string
     */
    public function actionFirst()
    {
        if (!Catalog::find()->where(['slug' => 'catalog'])->exists()) {
            $main = new Catalog(['name' => 'Каталог', 'slug' => 'catalog']);
            if ($main->makeRoot()) {
                Yii::$app->session->setFlash('success', 'Запись добавлена.');
                return $this->redirect(['index']);
            }
        }
    }
    
    /**
     * Добавить элемент после указаного.
     * 
     * @param integer $id ID элемента после которого добавится новый
     * @return string
     */
    public function actionAdd($id)
    {
        $model = new Catalog;
        
        if ($model->load(Yii::$app->request->post())) {
            if (($catalog = Catalog::findOne($id)) && $model->appendTo($catalog)) {
                Yii::$app->session->setFlash('success', 'Запись добавлена.');
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }
    
    /**
     * Перемещение элементов каталога.
     * 
     * @return string
     */
    public function actionMove($id, $target, $position)
    {
        $model = Catalog::findOne($id);

        $t = Catalog::findOne($target);

        switch ($position) {
            case 0:
                $model->insertBefore($t);
                break;

            case 1:
                $model->appendTo($t);
                break;
            
            case 2:
                $model->insertAfter($t);
                break;
        }
    }
}
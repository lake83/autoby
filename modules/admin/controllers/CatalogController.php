<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Catalog;
use app\models\CatalogSearch;
use app\models\Specifications;
use app\models\CatalogSpecification;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;
use yii\web\NotFoundHttpException;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class CatalogController extends AdminController
{
    public function actions()
    {
        $redirect = ($brand = Yii::$app->request->get('brand')) ? ['models', 'brand' => $brand] : ['index'];
        
        return [
            'index' => [
                'class' => 'app\modules\admin\controllers\actions\Index',
                'search' => 'app\models\CatalogSearch'
            ],
            'create' => [
                'class' => 'app\modules\admin\controllers\actions\Create',
                'model' => 'app\models\Catalog',
                'redirect' => $redirect
            ],
            'update' => [
                'class' => 'app\modules\admin\controllers\actions\Update',
                'model' => 'app\models\Catalog',
                'redirect' => $redirect
            ],
            'delete' => [
                'class' => 'app\modules\admin\controllers\actions\Delete',
                'model' => 'app\models\Catalog',
                'redirect' => $redirect
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => 'app\models\Catalog',
                'attribute' => 'is_active'
            ]
        ];
    }
    
    /**
     * Вывод подкатегорий марки авто
     * 
     * @return string
     */
    public function actionModels($brand)
    {
        $searchModel = new CatalogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('models', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    
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
     * Добавить марку автомобиля.
     * 
     * @param integer $id ID элемента после которого добавится новый
     * @return string
     */
    public function actionAddBrand($id)
    {
        $model = new Catalog;
        
        if ($model->load(Yii::$app->request->post())) {
            if (($catalog = Catalog::findOne($id)) && $model->insertAfter($catalog)) {
                Yii::$app->session->setFlash('success', 'Запись добавлена.');
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }
    
    /**
     * Добавить элемент после указаного.
     * 
     * @param integer $id ID элемента после которого добавится новый
     * @param string $brand
     * @return string
     */
    public function actionAdd($id, $brand)
    {
        $model = new Catalog;
        
        if ($model->load(Yii::$app->request->post())) {
            if (($catalog = Catalog::findOne($id)) && $model->appendTo($catalog)) {
                Yii::$app->session->setFlash('success', 'Запись добавлена.');
                return $this->redirect(['models', 'brand' => $brand]);
            }
        }
        return $this->render('create', ['model' => $model]);
    }
    
    /**
     * Перемещение элементов каталога.
     * 
     * @param integer $id
     * @param integer $target
     * @param integer $position
     * @param boolean $index
     * @return string
     */
    public function actionMove($id, $target, $position, $index = false)
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
        if ($index) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    
    /**
     * Характеристики элемента каталога
     * 
     * @param integer $id
     * @param string $brand
     * @return string
     */
    public function actionSpecifications($id, $brand = '')
    {
        if (($title = Catalog::find()->select(['name'])->where(['id' => $id, 'is_active' => 1])->scalar()) && 
            ($specifications = Specifications::find()->select(['id', 'name', 'is_options'])->where(['is_active' => 1])->with(['specificationOptions'])->indexBy('id')->all())
        ) {
            $values = ArrayHelper::map(CatalogSpecification::find()->select(['specification_id', 'value'])->where(['catalog_id' => $id])->all(), 'specification_id', 'value');
            foreach ($specifications as $specification) {
                $fields['field' . $specification->id] = isset($values[$specification->id]) ? $values[$specification->id] : '';
            }
            $model = new DynamicModel($fields);
            $model->addRule(array_keys($fields), 'safe');
        } else {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        if ($model->load(Yii::$app->request->post())) {
            foreach ($model->attributes as $key => $attribute) {
                $specification_id = str_replace('field', '', $key);
                if ($opt = CatalogSpecification::findOne(['catalog_id' => $id, 'specification_id' => $specification_id])) {
                    if (!empty($attribute)) {
                        $opt->value = $attribute;
                        $opt->save();
                    } else {
                        $opt->delete();
                    }
                } else {
                    $opt = new CatalogSpecification;
                    $opt->catalog_id = $id;
                    $opt->specification_id = $specification_id;
                    $opt->value = $attribute;
                    $opt->save();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->redirect($brand ? ['models', 'brand' => $brand] : ['index']);
        }
        return $this->render('specifications', ['model' => $model, 'specifications' => $specifications, 'title' => $title]);
    }
}
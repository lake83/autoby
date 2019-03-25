<?php

use yii\helpers\Html;
use dkhlystov\widgets\NestedTreeGrid;
use app\components\SiteHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatalogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модели марки ' . ($brand = Yii::$app->request->get('brand'));

Pjax::begin(['id' => 'catalog_items', 'timeout' => false]);

echo NestedTreeGrid::widget([
    'id' => 'catalog-tree',
    'dataProvider' => $dataProvider,
    'lazyLoad' => false,
    'moveAction' => ['move'],
    'showRoots' => false,
    'columns' => [
        'name',
        'slug',
        SiteHelper::is_active($searchModel),

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{add}{specifications}{update}{delete}',
            'buttons' => [
                'add' => function ($url, $model, $key) use ($brand) {
                    return Html::a('<span class="glyphicon glyphicon-plus"></span> ', ['add', 'id' => $model->id, 'brand' => $brand],
                        ['title' => 'Добавить', 'data-pjax' => 0]);
                },
                'specifications' => function ($url, $model, $key) use ($brand) {
                    return $model->depth == 3 ? Html::a('<span class="glyphicon glyphicon-th-list"></span> ', ['specifications', 'id' => $model->id, 'brand' => $brand],
                        ['title' => 'Характеристики', 'data-pjax' => 0]) : '';
                },
                'update' => function ($url, $model, $key) use ($brand) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id' => $model->id, 'brand' => $brand],
                        ['title' => 'Редактировать', 'data-pjax' => 0]);
                },
                'delete' => function ($url, $model, $key) use ($brand) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'brand' => $brand], ['title' => 'Удалить', 'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                        'method' => 'post'
                    ]]);
                }
            ]
        ]
    ]
]);

Pjax::end(); ?>
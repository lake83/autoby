<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модификации';
$names = Yii::$app->params['car_body_type']['options'];
?>

<p><?= Html::a('Создать модификацию', ['create', 'catalog_id' => ($catalog_id = Yii::$app->request->get('catalog_id'))], ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'filter' => false,
                'value' => function ($model, $index, $widget) {
                    return Html::img(SiteHelper::resized_image($model->image[0], 120, 100), ['width' => 70]);
                }
            ],
            [
                'attribute' => 'name',
                'filter' => Html::activeDropDownList($searchModel, 'name', $names, ['class' => 'form-control', 'prompt' => '- выбрать -']),
                'value' => function ($model, $index, $widget) use ($names) {
                    return $names[$model->name];
                }
            ],
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{specifications} {update} {delete}',
                'buttons' => [
                    'specifications' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['specifications/index', 'modification_id' => $model->id], ['title' => 'Характеристики', 'data-pjax' => 0]);
                    },
                    'update' => function ($url, $model, $key) use ($catalog_id){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id, 'catalog_id' => $catalog_id], ['title' => 'Редактировать', 'data-pjax' => 0]);
                    },
                    'delete' => function ($url, $model, $key) use ($catalog_id){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'catalog_id' => $catalog_id], ['title' => 'Удалить', 'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'method' => 'post'
                        ]]);
                    }
                ]
            ]
        ]
    ]);

?>
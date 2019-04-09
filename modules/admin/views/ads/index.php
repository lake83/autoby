<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;
use app\models\Catalog;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объявления';

$listOptions = ['class' => 'form-control', 'prompt' => '- выбрать -'];
$type = Yii::$app->params['car_body_type']['options'];
?>

<p><?= Html::a('Создать объявление', ['create'], ['class' => 'btn btn-success']) ?></p>

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
                'attribute' => 'catalog_id',
                'filter' => Html::activeDropDownList($searchModel, 'catalog_id', Catalog::getBrands(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return Catalog::getCar($model->catalog_id);
                }
            ],
            [
                'attribute' => 'type',
                'filter' => Html::activeDropDownList($searchModel, 'type', $type, $listOptions),
                'value' => function ($model, $index, $widget) use ($type) {
                    return $type[$model->type];
                }
            ],
            'price',
            [
                'attribute' => 'currency',
                'filter' => Html::activeDropDownList($searchModel, 'currency', $searchModel::getСurrency(), $listOptions),
                'value' => function ($model, $index, $widget) {
                    return $model->getСurrency($model->currency);
                }
            ],
            SiteHelper::is_active($searchModel),
            SiteHelper::created_at($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'options' => ['width' => '50px']
            ]
        ]
    ]);
?>
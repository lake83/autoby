<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SpecificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Характеристики';
?>

<p><?= Html::a('Создать характеристику', ['create'], ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            'name',
            'is_options:boolean',
            SiteHelper::is_active($searchModel),

            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{options}{update}{delete}',
            'buttons' => [
                'options' => function ($url, $model, $key) {
                    return $model->is_options ? Html::a('<span class="glyphicon glyphicon-th-list"></span>', $url, ['title' => 'Опции', 'data-pjax' => 0]) : '';
                }
            ]
        ]
        ]
    ]);
?>
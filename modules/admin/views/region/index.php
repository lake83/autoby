<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Области';
?>

<p><?= Html::a('Создать область', ['create'], ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            'name',
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{city}{update}{delete}',
                'buttons' => [
                    'city' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['city/index', 'region_id' => $model->id], ['title' => 'Города', 'data-pjax' => 0]);
                    }
                ]
            ]
        ]
    ]);

?>
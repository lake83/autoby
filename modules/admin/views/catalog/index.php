<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\components\SiteHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatalogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
?>

<p>
<?php if ($dataProvider->count == 0) {
    echo Html::a('Создать корневой элемент', ['first'], ['class' => 'btn btn-success']);
} ?>
</p>

<?= GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        
        'name',
        'slug',
        SiteHelper::is_active($searchModel),

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{models}{add-brand}{up}{down}{update}{delete}',
            'buttons' => [
                'models' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-list-alt"></span> ', ['models', 'brand' => $model->slug], ['title' => 'Модели', 'data-pjax' => 0]);
                },
                'add-brand' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-plus"></span> ', $url, ['title' => 'Добавить', 'data-pjax' => 0]);
                },
                'up' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-up"></span> ', $url, ['title' => 'Вверх', 'data-pjax' => 0]);
                },
                'down' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-down"></span> ', $url, ['title' => 'Вниз', 'data-pjax' => 0]);
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) use ($dataProvider) {
                $keys = array_keys($dataProvider->models);
                if ($action === 'up') {
                    return Url::to(['move', 'id' => $key, 'target' => $index > 0 ? $keys[$index-1] : $model->prev, 'position' => 0, 'index' => true]);
                } elseif ($action === 'down') {
                    return Url::to(['move', 'id' => $key, 'target' => $index !== 19 ? $keys[$index+1] : $model->next, 'position' => 2, 'index' => true]);
                } else {
                    return Url::to([$action, 'id' => $model->id]);
                }
            },
            'visibleButtons' => [
                'up' => function ($model, $key, $index) use ($dataProvider) {
                    return !($index == 0 && $dataProvider->pagination->page == 0);
                },
                'down' => function ($model, $key, $index) use ($dataProvider) {
                    return !($index == count($dataProvider->models)-1 && $dataProvider->pagination->page == $dataProvider->pagination->pageCount-1);
                }
            ]
        ]
    ]
]);

?>
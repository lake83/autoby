<?php

use yii\helpers\Html;
use dkhlystov\widgets\NestedTreeGrid;
use app\components\SiteHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatalogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCss('#catalog_items td span {padding-right:10px;}');

$this->title = 'Каталог';
?>

<p>
<?php if ($dataProvider->count == 0) {
    echo Html::a('Создать корневой элемент', ['first'], ['class' => 'btn btn-success']);
} ?>
</p>

<?php Pjax::begin(['id' => 'catalog_items', 'timeout' => false]);

echo NestedTreeGrid::widget([
    'id' => 'catalog-tree',
    'dataProvider' => $dataProvider,
    'lazyLoad' => false,
    'moveAction' => ['move'],
    'showRoots' => $dataProvider->count == 1 ? true : false,
    'columns' => [
        'name',
        'slug',
        SiteHelper::is_active($searchModel),

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{add}{update}{delete}',
            'buttons' => [
                'add' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['title' => 'Добавить']);
                }
            ]
        ]
    ]
]);

Pjax::end(); ?>
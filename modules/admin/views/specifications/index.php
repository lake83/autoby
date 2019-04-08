<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SpecificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Характеристики';
$params = Yii::$app->params;
$transmissions = $params['transmission']['options'];
$drives = $params['drive']['options'];
$engines = $params['engine']['options'];
$listOptions = ['class' => 'form-control', 'prompt' => '- выбрать -'];
?>

<p><?= Html::a('Создать характеристики', ['create', 'modification_id' => ($modification_id = Yii::$app->request->get('modification_id'))], ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            'capacity',
            'power',
            [
                'attribute' => 'transmission',
                'filter' => Html::activeDropDownList($searchModel, 'transmission', $transmissions, $listOptions),
                'value' => function ($model, $index, $widget) use ($transmissions) {
                    return $transmissions[$model->transmission];
                }
            ],
            [
                'attribute' => 'drive',
                'filter' => Html::activeDropDownList($searchModel, 'drive', $drives, $listOptions),
                'value' => function ($model, $index, $widget) use ($drives) {
                    return $drives[$model->drive];
                }
            ],
            [
                'attribute' => 'engine',
                'filter' => Html::activeDropDownList($searchModel, 'engine', $engines, $listOptions),
                'value' => function ($model, $index, $widget) use ($engines) {
                    return $engines[$model->engine];
                }
            ],
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) use ($modification_id){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id, 'modification_id' => $modification_id], ['title' => 'Редактировать', 'data-pjax' => 0]);
                    },
                    'delete' => function ($url, $model, $key) use ($modification_id){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'modification_id' => $modification_id], ['title' => 'Удалить', 'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'method' => 'post'
                        ]]);
                    }
                ],
                'options' => ['width' => '50px']
            ]
        ]
    ]);

?>
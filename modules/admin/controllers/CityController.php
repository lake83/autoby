<?php

namespace app\modules\admin\controllers;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends AdminController
{
    public function actions()
    {
        $redirect = ['index', 'region_id' => \Yii::$app->request->get('region_id')];
        
        return [
            'index' => [
                'class' => 'app\modules\admin\controllers\actions\Index',
                'search' => 'app\models\CitySearch'
            ],
            'create' => [
                'class' => 'app\modules\admin\controllers\actions\Create',
                'model' => 'app\models\City',
                'redirect' => $redirect
            ],
            'update' => [
                'class' => 'app\modules\admin\controllers\actions\Update',
                'model' => 'app\models\City',
                'redirect' => $redirect
            ],
            'delete' => [
                'class' => 'app\modules\admin\controllers\actions\Delete',
                'model' => 'app\models\City',
                'redirect' => $redirect
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => 'app\models\City',
                'attribute' => 'is_active'
            ]
        ];
    }
}
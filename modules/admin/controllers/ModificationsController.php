<?php

namespace app\modules\admin\controllers;

/**
 * ModificationsController implements the CRUD actions for Modifications model.
 */
class ModificationsController extends AdminController
{
    public function actions()
    {
        $redirect = ['index', 'catalog_id' => \Yii::$app->request->get('catalog_id')];
        
        return [
            'index' => [
                'class' => 'app\modules\admin\controllers\actions\Index',
                'search' => 'app\models\ModificationsSearch'
            ],
            'create' => [
                'class' => 'app\modules\admin\controllers\actions\Create',
                'model' => 'app\models\Modifications',
                'redirect' => $redirect
            ],
            'update' => [
                'class' => 'app\modules\admin\controllers\actions\Update',
                'model' => 'app\models\Modifications',
                'redirect' => $redirect
            ],
            'delete' => [
                'class' => 'app\modules\admin\controllers\actions\Delete',
                'model' => 'app\models\Modifications',
                'redirect' => $redirect
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => 'app\models\Modifications',
                'attribute' => 'is_active'
            ]
        ];
    }
}
<?php

namespace app\modules\admin\controllers;

/**
 * SpecificationsController implements the CRUD actions for Specifications model.
 */
class SpecificationsController extends AdminController
{
    public function actions()
    {
        $redirect = ['index', 'modification_id' => \Yii::$app->request->get('modification_id')];
        
        return [
            'index' => [
                'class' => 'app\modules\admin\controllers\actions\Index',
                'search' => 'app\models\SpecificationsSearch'
            ],
            'create' => [
                'class' => 'app\modules\admin\controllers\actions\Create',
                'model' => 'app\models\Specifications',
                'redirect' => $redirect
            ],
            'update' => [
                'class' => 'app\modules\admin\controllers\actions\Update',
                'model' => 'app\models\Specifications',
                'redirect' => $redirect
            ],
            'delete' => [
                'class' => 'app\modules\admin\controllers\actions\Delete',
                'model' => 'app\models\Specifications',
                'redirect' => $redirect
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => 'app\models\Specifications',
                'attribute' => 'is_active'
            ]
        ];
    }
}
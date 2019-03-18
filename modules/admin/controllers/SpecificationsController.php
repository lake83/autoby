<?php

namespace app\modules\admin\controllers;

/**
 * SpecificationsController implements the CRUD actions for Specifications model.
 */
class SpecificationsController extends AdminController
{
    use actions\MultipleTraite;
    
    public $modelClass = 'app\models\Specifications';
    public $searchModelClass = 'app\models\SpecificationsSearch';
    
    public function actions()
    {
        return parent::actions() + [
            'options' => [
                'class' => 'app\modules\admin\controllers\actions\UpdateMultiple',
                'model' => 'app\models\Specifications',
                'models' => 'app\models\SpecificationOptions',
                'owner' => 'specification_id',
                'view' => 'options'
            ]
        ];
    }
}
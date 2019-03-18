<?php

namespace app\modules\admin\controllers;

/**
 * RegionController implements the CRUD actions for Region model.
 */
class RegionController extends AdminController
{
    public $modelClass = 'app\models\Region';
    public $searchModelClass = 'app\models\RegionSearch';
}
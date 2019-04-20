<?php

namespace app\modules\admin\controllers;

/**
 * AdsController implements the CRUD actions for Ads model.
 */
class AdsController extends AdminController
{
    public $modelClass = 'app\models\Ads';
    public $searchModelClass = 'app\models\AdsSearch';
}
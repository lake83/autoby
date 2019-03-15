<?php

namespace app\modules\admin\controllers;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends AdminController
{
    public $modelClass = 'app\models\News';
    public $searchModelClass = 'app\models\NewsSearch';
}
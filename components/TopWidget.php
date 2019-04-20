<?php

namespace app\components;

use yii\base\Widget;
use app\models\Region;

class TopWidget extends Widget
{
    public function run()
    {
        return $this->render('/widgets/top', ['regions' => Region::getAllWithCities()]);
    }
}
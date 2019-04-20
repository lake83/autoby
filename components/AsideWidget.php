<?php

namespace app\components;

use yii\base\Widget;

class AsideWidget extends Widget
{
    public function run()
    {
        return $this->render('/widgets/aside');
    }
}
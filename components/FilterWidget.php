<?php

namespace app\components;

use yii\base\Widget;
use app\models\FilterForm;
use app\models\Catalog;

class FilterWidget extends Widget
{
    public function run()
    {
        $filter = new FilterForm;
        
        $years = range(date('Y'), 1950);
        $capacity = array_merge(range(0.2, 3, 0.2), range(3, 6, 0.5), range(6, 10));
        
        return $this->render('/widgets/filter', [
            'filter' => $filter,
            'cars' => Catalog::getBrands(),
            'ads_count' => Catalog::getAdsCount(),
            'years' => array_combine($years, $years),
            'capacity' => array_combine($capacity, $capacity)
        ]);
    }
}
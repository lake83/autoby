<?php

namespace app\components;

use yii\base\Widget;
use app\models\FilterForm;
use app\models\Catalog;

class FilterWidget extends Widget
{
    public $catalog = false;
    
    public function run()
    {
        if ($this->catalog) {
            return $this->render('/widgets/filter_catalog', ['filter' => new FilterForm, 'cars' => Catalog::getBrands()]);
        } else {
            $years = range(date('Y'), 1950);
            $capacity = array_merge(range(0.2, 3, 0.2), range(3, 6, 0.5), range(6, 10));
        
            return $this->render($this->catalog ? '/widgets/filter_catalog' : '/widgets/filter', [
                'filter' => new FilterForm,
                'cars' => Catalog::getBrands(),
                'ads_count' => Catalog::getAdsCount(),
                'years' => array_combine($years, $years),
                'capacity' => array_combine($capacity, $capacity)
            ]);
        }
    }
}
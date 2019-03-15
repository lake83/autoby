<?php

namespace app\components;

class CatalogQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            \creocoder\nestedsets\NestedSetsQueryBehavior::className()
        ];
    }
}
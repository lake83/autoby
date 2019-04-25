<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use app\models\Catalog;

class CarsUrlRule extends BaseObject implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    public function parseRequest($manager, $request)
    {
        if (strpos($request->pathInfo, 'cars') !== false) {
            $session = \Yii::$app->session;
            $pathInfo = explode('/', $request->pathInfo);
            
            if (isset($pathInfo[1])) {
                if ($brand = $session[$pathInfo[1]]) {
                    $params['brand'] = $brand;
                } else {
                    $params['brand'] = Catalog::find()->select(['id'])->where(['slug' => $pathInfo[1], 'is_active' => 1])->scalar();
                    $session[$pathInfo[1]] = $params['brand'];
                }
            }    
            if (isset($pathInfo[2])) {
                if ($auto_model = $session[$pathInfo[2]]) {
                    $params['auto_model'] = $auto_model;
                } else {
                    $params['auto_model'] = Catalog::find()->select(['id'])->where(['slug' => $pathInfo[2], 'is_active' => 1])->scalar();
                    $session[$pathInfo[2]] = $params['auto_model'];
                }
            }
            if (isset($pathInfo[3])) {
                $params['generation'] = $pathInfo[3];
            } 
            return ['cars/all', $params];
        }
        return false;
    }
}
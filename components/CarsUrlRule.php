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
        if ($route === 'catalog/index') {
            $url = '/catalog';
            if (isset($params['brand'])) {
                $url.= '/' . $params['brand'];
                unset($params['brand']);
            }
            if (isset($params['auto_model'])) {
                $url.= '/' . $params['auto_model'];
                unset($params['auto_model']);
            }
            if (isset($params['generation'])) {
                $url.= '/' . $params['generation'];
                unset($params['generation']);
            }
            if ($params) {
                $url.= '?' . http_build_query($params);
            }
            return $url;
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        if (strpos($request->pathInfo, 'cars') !== false) {
            $session = \Yii::$app->session;
            $pathInfo = explode('/', $request->pathInfo);
            $params = [];
            
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
        if (!$request->isAjax && strpos($request->pathInfo, 'admin') === false && strpos($request->pathInfo, 'catalog/') !== false) {
            $pathInfo = explode('/', $request->pathInfo);
            $params = [];
            
            if (isset($pathInfo[1])) {
                $params['brand'] = Catalog::find()->select(['id'])->where(['slug' => $pathInfo[1], 'depth' => 1, 'is_active' => 1])->scalar();
            }
            if (isset($pathInfo[2])) {
                $params['auto_model'] = Catalog::find()->select(['id'])->where(['slug' => $pathInfo[2], 'depth' => 2, 'is_active' => 1])->scalar();
            }
            if (isset($pathInfo[3])) {
                $params['generation'] = $pathInfo[3];
            }
            if (isset($pathInfo[4])) {
                $params['type'] = $pathInfo[4];
            }
            return ['catalog/index', $params];
        }
        return false;
    }
}
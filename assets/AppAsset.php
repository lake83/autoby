<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/media.css'
    ];
    public $js = [
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'cinghie\fontawesome\FontAwesomeMinifyAsset'        
    ];
    
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);
        
        $manager = $view->getAssetManager();
        $view->registerJsFile($manager->getAssetUrl($this, 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'), ['condition' => 'lte IE9', 'position' => View::POS_HEAD]);
        $view->registerJsFile($manager->getAssetUrl($this, 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js'), ['condition' => 'lte IE9', 'position' => View::POS_HEAD]);
    }
}
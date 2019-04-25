<?php

namespace app\assets;

use yii\web\AssetBundle;

class LightGalleryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/lightgallery.min.css'
    ];
    public $js = [
        'js/lightgallery-all.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
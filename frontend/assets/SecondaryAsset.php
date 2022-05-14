<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class SecondaryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/secondary.css'
    ];

    public $js = [
        'js/secondary.js'
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
<?php

namespace backend\assets;

use yii\web\AssetBundle;

class RecipeAsset extends AssetBundle
{
    public $js = [
        'js/recipe.js'
    ];

    public $depends = [
        AppAsset::class,
    ];
}
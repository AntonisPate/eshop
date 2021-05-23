<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/_custom.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',
        "https://unpkg.com/vue-observe-visibility/dist/vue-observe-visibility.min.js",
        "https://unpkg.com/vue-star-rating/dist/VueStarRating.umd.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}

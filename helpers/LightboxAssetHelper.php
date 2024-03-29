<?php

namespace app\helpers;

use yii\web\AssetBundle;

class LightboxAssetHelper extends AssetBundle {

    public $sourcePath = '@bower/lightbox2';

    public $js = [
        'js/lightbox.min.js',
    ];

    public $css = [
        'css/lightbox.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}


<?php

namespace app\modules\orders\assets;

use yii\web\AssetBundle;
use yii\web\View;

class OrdersAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/orders/web';

    public $css = [
        'css/bootstrap.min.css',
        'css/custom.css',
    ];

    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    public $depends = [];
}
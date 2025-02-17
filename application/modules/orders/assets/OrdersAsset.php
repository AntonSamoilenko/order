<?php

namespace app\modules\orders\assets;

use yii\web\AssetBundle;
use yii\web\View;

class OrdersAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/orders/web';

    /**
     * @var string[]
     */
    public $css = [
        'css/bootstrap.min.css',
        'css/custom.css',
    ];

    /**
     * @var string[]
     */
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
    ];

    /**
     * @var array
     */
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    /**
     * @var array
     */
    public $depends = [];
}
<?php

namespace app\modules\orders\assets;

use yii\web\AssetBundle;

class OrdersAsset extends AssetBundle
{
//    public $sourcePath = '@web'; // Путь к корневому каталогу web/
//    public $sourcePath = '@app/modules/orders/assets';

    public $sourcePath = '@app/modules/orders/assets';
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [
        'css/bootstrap.min.css',
        'css/custom.css',
    ];

    public $js = [
        'js/bootstrap.min.js',
    ];

    public $depends = [];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV, // Копировать файлы при разработке
    ];
}